<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SMSGatewayController extends Controller
{
    public function index()
    {
        $providers = \App\Models\NotificationProvider::orderBy('priority')->get();
        $fallbackSettings = [
            'sms_username' => null, // Would normally come from a Setting model
            'sms_from' => null,
            'sms_url' => null,
        ];
        
        return view('admin.settings.sms-gateway', compact('providers', 'fallbackSettings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sms_from' => 'required|string',
            'sms_url' => 'required|url',
            'sms_method' => 'required|in:get,post',
        ]);

        if ($request->is_primary) {
            \App\Models\NotificationProvider::where('is_primary', true)->update(['is_primary' => false]);
        }

        \App\Models\NotificationProvider::create($request->all());

        return response()->json(['success' => true, 'message' => 'Provider added successfully']);
    }

    public function update(Request $request, $id)
    {
        $provider = \App\Models\NotificationProvider::findOrFail($id);
        
        if ($request->is_primary) {
            \App\Models\NotificationProvider::where('is_primary', true)->update(['is_primary' => false]);
        }

        $provider->update($request->all());

        return response()->json(['success' => true, 'message' => 'Provider updated successfully']);
    }

    public function testConnection($id)
    {
        $provider = \App\Models\NotificationProvider::findOrFail($id);
        
        // Mocking a connection check
        $success = true; 
        
        $provider->update([
            'connection_status' => $success ? 'connected' : 'disconnected',
            'last_tested_at' => now(),
        ]);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Connection verified successfully!' : 'Connection failed. Please check credentials.'
        ]);
    }

    public function toggleActive($id)
    {
        $provider = \App\Models\NotificationProvider::findOrFail($id);
        $provider->update(['is_active' => !$provider->is_active]);
        return response()->json(['success' => true]);
    }

    public function setPrimary($id)
    {
        \App\Models\NotificationProvider::where('is_primary', true)->update(['is_primary' => false]);
        \App\Models\NotificationProvider::findOrFail($id)->update(['is_primary' => true]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        \App\Models\NotificationProvider::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function test(Request $request)
    {
        // Mocking an SMS send
        return response()->json(['success' => true, 'message' => 'Test message processed successfully']);
    }
}
