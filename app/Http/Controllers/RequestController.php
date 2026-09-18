<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRequest;
use App\Models\User;

class RequestController extends Controller
{
    // get_requests.php
    public function getRequests()
    {
        $requests = UserRequest::with('user')->get();
        return response()->json(['status' => 'success', 'data' => $requests]);
    }

    public function getUserRequests(Request $request)
    {
        // Login ဝင်ထားသော user ရဲ့ id (သို့) request ထဲပါလာသော id ကို ယူမည်
        $userId = $request->user()?->id ?? $request->user_id;
        
        $requests = UserRequest::where('userId', $userId)->get();
        
        // Frontend မှ decodedData.requests သို့မဟုတ် decodedData ကို လက်ခံနိုင်ရန် 
        // requests key ထဲထည့်ပေးခြင်း
        return response()->json([
            'status' => 'success', 
            'requests' => $requests 
        ]);
    }

    

    public function submitRequest(Request $request)
    {
        // transactionId ပါလာပြီးသားဆိုလျှင် ဇယားထဲတွင် ရှိပြီးသားလား စစ်ဆေးမည်
        if (!empty($request->transaction_id)) {
            $existingTransaction = UserRequest::where('transactionId', $request->transaction_id)->first();
            if ($existingTransaction) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ဤ Transaction ID ဖြင့် ငွေသွင်းတောင်းဆိုထားပြီးဖြစ်ပါသည်။'
                ], 422);
            }
        }

        // ဝင်လာသော user_id သို့မဟုတ် auth ထဲက id ကို ရှာမည်၊ မရှိပါက phone ဖြင့် users ဇယားမှ id ကို ရှာယူမည်
        $userId = $request->user_id ?? $request->user()?->id;
        
        if (empty($userId) && !empty($request->phone)) {
            $existingUser = User::where('phone', $request->phone)->first();
            if ($existingUser) {
                $userId = $existingUser->id;
            }
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'အသုံးပြုသူ အချက်အလက် ရှာမတွေ့ပါ။'
            ], 404);
        }

        // ငွေထုတ်မည့် (withdraw) အချိန်တွင် လက်ကျန်ငွေထက် ပိုမိုထုတ်ယူခြင်း ရှိမရှိ စစ်ဆေးခြင်း
        if (strtolower($request->type) === 'withdraw') {
            if ($user->balance < $request->amount) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'သင့်အကောင့်တွင် လက်ကျန်ငွေ မလုံလောက်ပါ။'
                ], 422);
            }
        }

        $newRequest = UserRequest::create([
            'userId' => $userId ?? 0,
            'userName' => $request->user_name ?? '',
            'phone' => $request->phone ?? '',
            'payment' => $request->payment ?? '',
            'type' => $request->type,
            'amount' => $request->amount,
            'transactionId' => $request->transaction_id ?? '',
            'status' => 'Pending'
        ]);

        // Withdraw တတင်ချင်း User အကောင့်လက်ကျန်ငွေထဲမှ ချက်ချင်းနုတ်ယူပြီး save လုပ်ရန်
        if (strtolower($request->type) === 'withdraw') {
            $user->balance -= $request->amount;
            $user->save();
        }

        return response()->json(['status' => 'success', 'data' => $newRequest]);
    }

    public function approveRequest(Request $request)
    {
        $req = UserRequest::findOrFail($request->request_id);
        $req->status = 'approved';
        
        if ($request->has('transaction_id') && !empty($request->transaction_id)) {
            $req->transactionId = $request->transaction_id;
        }
        
        $req->save();

        // payment_requests ထဲရှိ userId ကို သုံး၍ User ကို ရှာမည်
        $user = User::find($req->userId);
        if ($user) {
            if ($req->type == 'deposit') {
                $user->increment('balance', $req->amount);
            } elseif ($req->type == 'withdraw') {
                $user->decrement('balance', $req->amount);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Request approved successfully']);
    }

    public function rejectRequest(Request $request)
    {
        $userRequest = UserRequest::find($request->request_id);

        if (!$userRequest) {
            return response()->json([
                'status' => 'error',
                'message' => 'တောင်းဆိုမှုကို ရှာမတွေ့ပါ။'
            ], 404);
        }

        // status ကို reject အဖြစ် ပြောင်းလဲခြင်း
        $userRequest->status = 'reject';
        $userRequest->save();

        return response()->json([
            'status' => 'success',
            'message' => 'တောင်းဆိုမှုကို ပယ်ချလိုက်ပါပြီ။'
        ]);
    }

}