<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Models\Bet;
use App\Models\LuckyDraw;
use App\Models\UserRequest; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{
    public function getDashboardData(Request $request)
    {
        try {
            $allBets = Bet::orderBy('id', 'desc')->get();
            $allRequests = UserRequest::orderBy('id', 'desc')->get();

            $now = Carbon::now();
            
            // 🟢 Request မှ လ (Month) ပါလာပါက ၎င်းကို သုံးမည်၊ မပါပါက လက်ရှိလကို ယူမည် (Format: YYYY-MM)
            $selectedMonth = $request->query('month', $now->format('Y-m'));

            $dailyTotalWin = 0;
            $dailyTotalLoss = 0;
            $monthlyTotalWin = 0;
            $monthlyTotalLoss = 0;

            $dailyTotalDeposit = 0;
            $dailyTotalWithdraw = 0;
            $monthlyTotalDeposit = 0;
            $monthlyTotalWithdraw = 0;

            foreach ($allBets as $doc) {
                $status = strtolower(trim($doc->status ?? 'pending'));
                if ($status === 'pending') continue;

                $amount = floatval($doc->total_amount ?? $doc->amount ?? 0);
                $winAmount = floatval($doc->winAmount ?? 0);

                $timeSource = $doc->time ?? $doc->created_at ?? null;
                if (!$timeSource) continue;

                try {
                    $betTime = Carbon::parse($timeSource);
                } catch (\Exception $e) {
                    continue;
                }

                $isToday = $betTime->isSameDay($now);
                // 🟢 ရွေးချယ်ထားသော လနှင့် တိုက်ဆိုင်မှု ရှိမရှိ စစ်ဆေးခြင်း
                $isTargetMonth = $betTime->format('Y-m') === $selectedMonth;

                if ($isToday) {
                    if ($status === 'win' || strtolower($status) === 'won') {
                        $dailyTotalWin += ($winAmount > 0 ? $winAmount : $amount);
                    } else if ($status === 'lost' || $status === 'loss') {
                        $dailyTotalLoss += $amount;
                    }
                }

                if ($isTargetMonth) {
                    if ($status === 'win' || strtolower($status) === 'won') {
                        $monthlyTotalWin += ($winAmount > 0 ? $winAmount : $amount);
                    } else if ($status === 'lost' || $status === 'loss') {
                        $monthlyTotalLoss += $amount;
                    }
                }
            }

            foreach ($allRequests as $doc) {
                $reqStatus = strtolower(trim($doc->status ?? 'pending'));
                if ($reqStatus !== 'approved') continue;

                $type = strtolower(trim($doc->type ?? ''));
                $amount = floatval($doc->amount ?? 0);

                $timeSource = $doc->time ?? $doc->created_at ?? null;
                if (!$timeSource) continue;

                try {
                    $reqTime = Carbon::parse($timeSource);
                } catch (\Exception $e) {
                    continue;
                }

                $isToday = $reqTime->isSameDay($now);
                // 🟢 ရွေးချယ်ထားသော လနှင့် တိုက်ဆိုင်မှု ရှိမရှိ စစ်ဆေးခြင်း
                $isTargetMonth = $reqTime->format('Y-m') === $selectedMonth;

                if ($isToday) {
                    if ($type === 'deposit') $dailyTotalDeposit += $amount;
                    else if ($type === 'withdraw') $dailyTotalWithdraw += $amount;
                }

                if ($isTargetMonth) {
                    if ($type === 'deposit') $monthlyTotalDeposit += $amount;
                    else if ($type === 'withdraw') $monthlyTotalWithdraw += $amount;
                }
            }

            $dailyNet = $dailyTotalLoss - $dailyTotalWin;
            $monthlyNet = $monthlyTotalLoss - $monthlyTotalWin;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'daily' => [
                        'win' => $dailyTotalWin,
                        'loss' => $dailyTotalLoss,
                        'deposit' => $dailyTotalDeposit,
                        'withdraw' => $dailyTotalWithdraw,
                        'net' => $dailyNet
                    ],
                    'monthly' => [
                        'win' => $monthlyTotalWin,
                        'loss' => $monthlyTotalLoss,
                        'deposit' => $monthlyTotalDeposit,
                        'withdraw' => $monthlyTotalWithdraw,
                        'net' => $monthlyNet
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Dashboard Data Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // trigger_lucky_draw.php
    public function triggerLuckyDraw(Request $request)
    {
        $winner = User::inRandomOrder()->first();
        $draw = LuckyDraw::create([
            'winner_id' => $winner->id,
            'prize_amount' => $request->prize_amount ?? 0,
            'draw_date' => now()
        ]);

        return response()->json(['status' => 'success', 'winner' => $winner, 'draw' => $draw]);
    }

    
    // စကားပြောဆိုထားသော User များစာရင်းကို ရယူရန်
    public function getChatUsers()
    {
        // ဇယားနှစ်ခုကို Join ပြီး Chat ရှိသော User များကို တိုက်ရိုက်ဆွဲထုတ်ခြင်း
        $users = User::whereIn('id', function($query) {
            $query->select('user_id')->from('chats')->distinct();
        })->get();

        return response()->json([
            'status' => 'success', 
            'users' => $users
        ]);
    }

    // သတ်မှတ်ထားသော User တစ်ဦးချင်းစီ၏ မက်ဆေ့ဂျ်များကို ရယူရန်
    public function getChatMessages($userId)
    {
        $chats = Chat::where('user_id', $userId)->orderBy('created_at', 'asc')->get();
        return response()->json(['status' => 'success', 'chats' => $chats]);
    }

    // Admin မှ User ထံသို့ စာပြန်ပို့ရန်
    public function sendAdminMessage(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $chat = Chat::create([
            'user_id' => $request->user_id,
            'message' => $request->message,
            'sender_type' => 'admin', // Admin မှ ပို့သည်ဟု သတ်မှတ်ရန်
        ]);

        return response()->json(['status' => 'success', 'chat' => $chat]);
    }

    // Slider နှင့် ပုံများကို သိမ်းဆည်းရန်
    public function storeSlider(Request $request)
    {
        try {
            $request->validate([
                'title' => 'nullable|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/sliders'), $filename);
                $imagePath = 'uploads/sliders/' . $filename;
            }

            \DB::table('sliders')->insert([
                'title' => $request->title,
                'image' => $imagePath,
                'description' => $request->description,
                'status' => 1, // 🟢 ပုံအသစ်ထည့်လျှင် Active (1) အဖြစ် စတင်မည်
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Slider / ပုံကို အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    // Slider ကို ပြင်ဆင်ရန် (Update)
    public function updateSlider(Request $request, $id)
    {
        try {
            $slider = \DB::table('sliders')->where('id', $id)->first();
            if (!$slider) {
                return response()->json(['status' => 'error', 'message' => 'Slider မတွေ့ရှိပါ။'], 404);
            }

            $request->validate([
                'title' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
            ]);

            // 🟢 ပုံအသစ် တင်လာခြင်း ရှိမရှိ စစ်ဆေးပြီး မပါလာလျှင် မူလပုံဟောင်းကို ဆက်လက်ထိန်းသိမ်းမည်
            $imagePath = $slider->image;
            if ($request->hasFile('image')) {
                // ပုံဟောင်း ရှိလျှင် public folder ထဲမှ ဖျက်ပစ်ရန်
                if ($slider->image && file_exists(public_path($slider->image))) {
                    unlink(public_path($slider->image));
                }

                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/sliders'), $filename);
                $imagePath = 'uploads/sliders/' . $filename;
            }

            \DB::table('sliders')->where('id', $id)->update([
                'title' => $request->title,
                'image' => $imagePath, // ပုံအသစ်မပါလျှင် မူလပုံဟောင်းအတိုင်း ဆက်ရှိနေမည်
                'description' => $request->description,
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Slider ကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Slider ၏ Active / Inactive အခြေအနေကို ပြောင်းလဲရန်
    public function updateSliderStatus(Request $request, $id)
    {
        try {
            $slider = \DB::table('sliders')->where('id', $id)->first();
            if (!$slider) {
                return response()->json(['status' => 'error', 'message' => 'Slider မတွေ့ရှိပါ။'], 404);
            }

            $newStatus = $request->status; // 1 (Active) သို့မဟုတ် 0 (Inactive)

            \DB::table('sliders')->where('id', $id)->update([
                'status' => $newStatus,
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Slider အခြေအနေကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Slider ကို ဖျက်ရန် (Delete)
    public function deleteSlider($id)
    {
        try {
            $slider = \DB::table('sliders')->where('id', $id)->first();
            if (!$slider) {
                return response()->json(['status' => 'error', 'message' => 'Slider မတွေ့ရှိပါ။'], 404);
            }

            // ပုံဖိုင်ပါ ရှိလျှင် public folder ထဲမှ ဖျက်ပစ်ရန်
            if ($slider->image && file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }

            \DB::table('sliders')->where('id', $id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Slider ကို အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}