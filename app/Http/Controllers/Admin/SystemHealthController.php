<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SystemHealthController extends Controller
{
    public function index()
    {
        $checks = [];

        $checks[] = [
            'label' => 'App Environment',
            'status' => config('app.env'),
            'ok' => true,
        ];

        $dbOk = true;
        $dbStatus = 'Connected';
        try {
            DB::connection()->getPdo();
        } catch (\Throwable $e) {
            $dbOk = false;
            $dbStatus = 'Disconnected';
        }

        $checks[] = [
            'label' => 'Database',
            'status' => $dbStatus,
            'ok' => $dbOk,
        ];

        $storageOk = true;
        $storageStatus = 'OK';
        try {
            Storage::disk(config('filesystems.default'))->exists('/');
        } catch (\Throwable $e) {
            $storageOk = false;
            $storageStatus = 'Error';
        }

        $checks[] = [
            'label' => 'Storage',
            'status' => $storageStatus,
            'ok' => $storageOk,
        ];

        $checks[] = [
            'label' => 'Mail Driver',
            'status' => config('mail.default'),
            'ok' => true,
        ];

        $checks[] = [
            'label' => 'Queue Driver',
            'status' => config('queue.default'),
            'ok' => true,
        ];

        return view('admin.settings.system-health.index', compact('checks'));
    }
}
