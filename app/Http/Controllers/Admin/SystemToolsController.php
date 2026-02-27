<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SystemToolsController extends Controller
{
    private function readTail(string $path, int $maxLines = 500): array
    {
        if (!is_file($path) || !is_readable($path)) {
            return [];
        }

        $fp = fopen($path, 'rb');
        if ($fp === false) {
            return [];
        }

        $pos = -1;
        $lines = [];
        $buffer = '';

        fseek($fp, 0, SEEK_END);
        $size = ftell($fp);
        if ($size === 0) {
            fclose($fp);
            return [];
        }

        while (count($lines) < $maxLines && -$pos <= $size) {
            fseek($fp, $pos, SEEK_END);
            $char = fgetc($fp);
            if ($char === false) {
                break;
            }

            if ($char === "\n") {
                $line = strrev($buffer);
                $buffer = '';
                if ($line !== '') {
                    $lines[] = $line;
                }
            } else {
                $buffer .= $char;
            }

            $pos--;
        }

        if ($buffer !== '' && count($lines) < $maxLines) {
            $lines[] = strrev($buffer);
        }

        fclose($fp);

        return array_reverse($lines);
    }

    public function systemLogs(Request $request)
    {
        $level = strtoupper((string) $request->query('level', ''));
        $q = (string) $request->query('q', '');
        $limit = (int) $request->query('limit', 500);
        if ($limit < 50) $limit = 50;
        if ($limit > 2000) $limit = 2000;

        $path = storage_path('logs/laravel.log');
        $lines = $this->readTail($path, $limit);

        $filtered = collect($lines)->filter(function ($line) use ($level, $q) {
            if ($level !== '' && stripos($line, ".{$level}:") === false && stripos($line, " {$level} ") === false) {
                return false;
            }
            if ($q !== '' && stripos($line, $q) === false) {
                return false;
            }
            return true;
        })->values();

        $stats = [
            'total_lines' => count($lines),
            'shown' => $filtered->count(),
            'file_exists' => is_file($path),
            'file_size' => is_file($path) ? filesize($path) : 0,
            'path' => $path,
        ];

        return view('admin.settings.system-tools.logs', [
            'lines' => $filtered,
            'stats' => $stats,
            'level' => $level,
            'q' => $q,
            'limit' => $limit,
        ]);
    }

    public function systemLogsDownload()
    {
        $path = storage_path('logs/laravel.log');
        abort_unless(is_file($path), 404);

        return response()->download($path, 'laravel.log');
    }

    public function userActivity(Request $request)
    {
        $userId = $request->query('user_id');
        $action = (string) $request->query('action', '');
        $start = (string) $request->query('start', '');
        $end = (string) $request->query('end', '');

        $query = ActivityLog::query()->with('user')->latest();

        if (!empty($userId)) {
            $query->where('user_id', $userId);
        }
        if (!empty($action)) {
            $query->where('action', 'like', '%' . $action . '%');
        }
        if (!empty($start)) {
            $query->whereDate('created_at', '>=', $start);
        }
        if (!empty($end)) {
            $query->whereDate('created_at', '<=', $end);
        }

        $logs = $query->paginate(40)->withQueryString();

        $users = User::query()->orderBy('name')->limit(500)->get();

        $stats = [
            'total' => (clone $query)->count(),
        ];

        return view('admin.settings.system-tools.user-activity', compact('logs', 'users', 'stats', 'userId', 'action', 'start', 'end'));
    }

    public function userActivityExportCsv(Request $request)
    {
        $userId = $request->query('user_id');
        $action = (string) $request->query('action', '');
        $start = (string) $request->query('start', '');
        $end = (string) $request->query('end', '');

        $query = ActivityLog::query()->with('user')->latest();

        if (!empty($userId)) {
            $query->where('user_id', $userId);
        }
        if (!empty($action)) {
            $query->where('action', 'like', '%' . $action . '%');
        }
        if (!empty($start)) {
            $query->whereDate('created_at', '>=', $start);
        }
        if (!empty($end)) {
            $query->whereDate('created_at', '<=', $end);
        }

        $rows = $query->limit(5000)->get();

        $csv = implode(',', [
            'time',
            'user',
            'action',
            'subject',
            'ip',
            'route_name',
            'method',
            'status_code',
            'duration_ms',
        ]) . "\n";

        foreach ($rows as $log) {
            $csv .= implode(',', [
                '"' . $log->created_at->format('Y-m-d H:i:s') . '"',
                '"' . str_replace('"', '""', (string) ($log->user->name ?? 'System')) . '"',
                '"' . str_replace('"', '""', (string) $log->action) . '"',
                '"' . str_replace('"', '""', (string) (class_basename((string) $log->subject_type) . ($log->subject_id ? ' #' . $log->subject_id : ''))) . '"',
                '"' . str_replace('"', '""', (string) $log->ip_address) . '"',
                '"' . str_replace('"', '""', (string) data_get($log->properties, 'route_name')) . '"',
                '"' . str_replace('"', '""', (string) data_get($log->properties, 'method')) . '"',
                '"' . str_replace('"', '""', (string) data_get($log->properties, 'status_code')) . '"',
                '"' . str_replace('"', '""', (string) data_get($log->properties, 'duration_ms')) . '"',
            ]) . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="user-activity.csv"');
    }

    public function integrations()
    {
        $paymentRules = SystemSetting::getValue('payment_rules', []);
        $notificationRules = SystemSetting::getValue('notification_rules', []);

        $stats = [
            'mail_driver' => (string) config('mail.default'),
            'queue_driver' => (string) config('queue.default'),
        ];

        return view('admin.settings.system-tools.integrations', compact('paymentRules', 'notificationRules', 'stats'));
    }

    public function backup()
    {
        $disk = Storage::disk(config('filesystems.default'));
        $paths = [];

        if ($disk->exists('backups')) {
            $paths = collect($disk->files('backups'))
                ->sortDesc()
                ->values()
                ->all();
        }

        return view('admin.settings.system-tools.backup', compact('paths'));
    }

    public function backupRun(Request $request)
    {
        $ok = true;
        $output = '';

        try {
            Artisan::call('backup:run');
            $output = Artisan::output();
        } catch (\Throwable $e) {
            $ok = false;
            $output = $e->getMessage();
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'system.backup.run',
            'subject_type' => 'system',
            'properties' => [
                'ok' => $ok,
                'output' => substr((string) $output, 0, 5000),
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with($ok ? 'success' : 'error', $ok ? 'Backup started successfully.' : 'Backup failed: ' . $output);
    }

    public function backupDownload(Request $request)
    {
        $path = (string) $request->query('path');
        abort_unless($path !== '' && str_starts_with($path, 'backups/'), 403);

        $disk = Storage::disk(config('filesystems.default'));
        abort_unless($disk->exists($path), 404);

        return $disk->download($path);
    }

    public function maintenance()
    {
        $down = app()->isDownForMaintenance();

        $payload = [];
        $downFile = storage_path('framework/down');
        if (is_file($downFile)) {
            $json = @file_get_contents($downFile);
            if ($json !== false) {
                $payload = json_decode($json, true) ?: [];
            }
        }

        return view('admin.settings.system-tools.maintenance', compact('down', 'payload'));
    }

    public function maintenanceEnable(Request $request)
    {
        $validated = $request->validate([
            'message' => 'nullable|string|max:255',
            'retry' => 'nullable|integer|min:0|max:3600',
            'secret' => 'nullable|string|max:255',
        ]);

        $args = [];
        if (!empty($validated['message'])) $args['--message'] = $validated['message'];
        if (!empty($validated['retry'])) $args['--retry'] = (int) $validated['retry'];
        if (!empty($validated['secret'])) $args['--secret'] = $validated['secret'];

        Artisan::call('down', $args);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'system.maintenance.enable',
            'subject_type' => 'system',
            'properties' => $args,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'Maintenance mode enabled.');
    }

    public function maintenanceDisable(Request $request)
    {
        Artisan::call('up');

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'system.maintenance.disable',
            'subject_type' => 'system',
            'properties' => [],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'Maintenance mode disabled.');
    }
}
