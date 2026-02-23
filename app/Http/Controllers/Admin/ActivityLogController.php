<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::query()->with('user')->latest()->paginate(30);
        return view('admin.settings.activity-logs.index', compact('logs'));
    }

    public function show(ActivityLog $log)
    {
        $log->load('user');
        return view('admin.settings.activity-logs.show', compact('log'));
    }
}
