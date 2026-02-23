<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;

class ActivityLogger
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);

        try {
            $response = $next($request);
        } catch (\Throwable $e) {
            $this->log($request, 500, microtime(true) - $start, [
                'exception' => [
                    'class' => get_class($e),
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ],
            ]);

            throw $e;
        }

        $status = method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null;
        $this->log($request, $status, microtime(true) - $start);

        return $response;
    }

    private function log(Request $request, ?int $statusCode, float $durationSeconds, array $extraProperties = []): void
    {
        if (!$request->route()) {
            return;
        }

        $routeName = $request->route()->getName();
        if (!$routeName) {
            return;
        }

        if (str_starts_with($routeName, 'admin.settings.activity-logs.')) {
            return;
        }

        $inputs = $request->except([
            'password',
            'password_confirmation',
            '_token',
        ]);

        ActivityLog::create([
            'user_id' => optional($request->user())->id,
            'action' => 'http.request',
            'subject_type' => 'route',
            'subject_id' => null,
            'properties' => array_merge([
                'route_name' => $routeName,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'path' => $request->path(),
                'status_code' => $statusCode,
                'duration_ms' => (int) round($durationSeconds * 1000),
                'inputs' => $inputs,
            ], $extraProperties),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);
    }
}
