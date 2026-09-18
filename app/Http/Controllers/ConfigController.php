<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    // get_payment_config.php
    public function getPaymentConfig()
{
    $qrUrl = Setting::where('config_key', 'qrUrl')->value('config_value');
    $phone = Setting::where('config_key', 'phone')->value('config_value');

    return response()->json([
        'qrUrl' => $qrUrl,
        'phone' => $phone
    ]);
}

    // update_payment_config.php
    public function updatePaymentConfig(Request $request)
{
    $qrUrl = $request->input('qrUrl');
    $phone = $request->input('phone');

    if ($qrUrl !== null) {
        Setting::updateOrCreate(
            ['config_key' => 'qrUrl'], 
            ['config_value' => $qrUrl]
        );
    }

    if ($phone !== null) {
        Setting::updateOrCreate(
            ['config_key' => 'phone'], 
            ['config_value' => $phone]
        );
    }

    return response()->json(['status' => 'success', 'message' => 'Payment config updated successfully']);
}
    

    // get_timer_config.php
    // get_timer_config.php
    public function getTimerConfig()
    {
        $durationSeconds = Setting::where('config_key', 'durationSeconds')->value('config_value');
        $endTime = Setting::where('config_key', 'endTime')->value('config_value');

        return response()->json([
            'status' => 'success',
            'data' => [
                'durationSeconds' => $durationSeconds,
                'endTime' => $endTime
            ]
        ]);
    }

    // update_timer_config.php
    public function updateTimerConfig(Request $request)
    {
        $durationSeconds = $request->input('durationSeconds');
        $endTime = $request->input('endTime');

        if ($durationSeconds !== null) {
            Setting::updateOrCreate(
                ['config_key' => 'durationSeconds'], 
                ['config_value' => $durationSeconds]
            );
        }

        if ($endTime !== null) {
            Setting::updateOrCreate(
                ['config_key' => 'endTime'], 
                ['config_value' => $endTime]
            );
        }

        return response()->json(['status' => 'success', 'message' => 'Timer config updated successfully']);
    }

    // get_session_status.php
    public function getSessionStatus(Request $request)
    {
        try {
            if (!Schema::hasTable('session_status')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'session_status table does not exist in database'
                ], 404);
            }

            $statuses = DB::table('session_status')->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $statuses
            ]);
        } catch (\Exception $e) {
            Log::error('Session Status Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // update_session_status.php
    public function updateSessionStatus(Request $request)
    {
        $sessionName = $request->input('session_name');
        $isOpen = $request->input('is_open');

        // session_status ဇယားကို update လုပ်ရန် DB Facade ကို သုံးပါ
        DB::table('session_status')->updateOrInsert(
            ['session_name' => $sessionName],
            ['is_open' => $isOpen]
        );

        $config = DB::table('session_status')->where('session_name', $sessionName)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Session status updated successfully',
            'data' => $config
        ]);
    }
    
}