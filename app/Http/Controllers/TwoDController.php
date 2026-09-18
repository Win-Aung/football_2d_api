<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TwoDBet;
use App\Models\User;
use App\Models\TwoDResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SessionStatus;
use Exception;
use Illuminate\Support\Facades\Http;

class TwoDController extends Controller
{
        public function getProxyLiveResult()
    {
        try {
            $response = Http::timeout(10)->get('https://luke.2dboss.com/api/luke/twod-result-live');
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getLiveResult()
    {
        try {
            // Timeout နှင့် SSL Verification ထည့်သွင်းခြင်း
            $response = Http::timeout(10)->withoutVerifying()->get('https://luke.2dboss.com/api/luke/twod-result-live');
            
            if ($response->successful()) {
                return response()->json($response->json());
            }
            
            return response()->json(['status' => 'error', 'message' => 'Failed to fetch from external API'], 500);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function placeTwoDBet(Request $request)
    {
        // Login ဝင်ထားသည့် user ထံမှ (သို့မဟုတ်) request ထံမှ user_id ကို ယူမည်
        $user = $request->user();
        $userId = $request->input('user_id') ?? ($user ? $user->id : null);
        $userName = $request->input('user_name') ?? ($user ? $user->name : 'Unknown');
        
        $session = $request->input('session');
        $bets = $request->input('bets');

        if (empty($userId) || empty($session) || empty($bets) || !is_array($bets)) {
            return response()->json([
                "status" => "error", 
                "message" => "အချက်အလက် မပြည့်စုံပါ။ (User ID လိုအပ်ပါသည်)"
            ], 400);
        }

        DB::beginTransaction();

        try {
            $user = User::where('id', $userId)->lockForUpdate()->first();

            if (!$user) {
                DB::rollBack();
                return response()->json([
                    "status" => "error", 
                    "message" => "User မတွေ့ရှိပါ။"
                ], 404);
            }

            $currentBalance = floatval($user->balance);
            $totalBetAmount = 0;

            foreach ($bets as $bet) {
                $totalBetAmount += floatval($bet['amount'] ?? 0);
            }

            if ($currentBalance < $totalBetAmount) {
                DB::rollBack();
                return response()->json([
                    "status" => "error", 
                    "message" => "လက်ကျန်ငွေ မလုံလောက်ပါ။"
                ], 400);
            }

            $user->balance = $currentBalance - $totalBetAmount;
            $user->save();

            $formattedBets = [];
            foreach ($bets as $bet) {
                $formattedBets[] = [
                    'number' => (string)$bet['number'],
                    'amount' => floatval($bet['amount'])
                ];
            }

            $firstBetNumber = $bets[0]['number'] ?? '';
            $firstBetAmount = $bets[0]['amount'] ?? 0;

            TwoDBet::create([
                'userId'       => $userId,
                'userName'     => $userName,
                'session'      => $session,
                'bets'         => json_encode($formattedBets),
                'total_amount' => $totalBetAmount,
                'number'       => (string)$firstBetNumber,
                'amount'       => $firstBetAmount,
                'status'       => 0, 
            ]);
            DB::commit();

            return response()->json([
                "status" => "success", 
                "message" => "2D ထိုးခြင်း အောင်မြင်ပါသည်။"
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error", 
                "message" => "Error: " . $e->getMessage()
            ], 500);
        }
        
    }

    

        public function getAdminTwoDBets()
    {
        try {
            $bets = TwoDBet::with('user')->orderBy('id', 'desc')->get();
            return response()->json([
                "status" => "success",
                "bets" => $bets
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function update2DBetStatus(Request $request)
    {
        $betId = $request->input('bet_id');
        $status = $request->input('status');

        $bet = TwoDBet::find($betId);
        if (!$bet) {
            return response()->json(["status" => "error", "message" => "Bet မတွေ့ရှိပါ။"], 404);
        }

        $bet->status = $status;
        $bet->save();

        return response()->json([
            "status" => "success",
            "message" => "2D Bet အခြေအနေကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။"
        ]);
    }

    public function declareTwoDResult(Request $request)
    {
        $request->validate([
            'number' => 'required|string|size:2',
            'session' => 'required|string',
            'multiplier' => 'nullable|numeric',
        ]);

        $winningNumber = trim($request->input('number'));
        $session = trim($request->input('session'));
        $multiplier = $request->input('multiplier', 80);

        DB::beginTransaction();
        try {
            $bets = DB::table('twod_bets')
                    ->whereRaw('LOWER(TRIM(session)) = ?', [strtolower($session)])
                    ->where(function($query) {
                        $query->where('status', 0)
                            ->orWhereNull('status');
                    })
                    ->get();

            if ($bets->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ဤ Session အတွက် ရှင်းလင်းရန် Bet များ မရှိပါ သို့မဟုတ် Session အမည် မမှန်ပါ။'
                ], 404);
            }

            foreach ($bets as $bet) {
                $betsJson = $bet->bets;
                $decodedBets = json_decode($betsJson, true);
                
                if (is_string($decodedBets)) {
                    $decodedBets = json_decode($decodedBets, true);
                }

                if (!is_array($decodedBets)) {
                    continue;
                }

                $isWin = false;
                $totalWinForThisBet = 0;
                $totalLostForThisBet = 0;

                foreach ($decodedBets as &$singleBet) {
                    $betNum = trim((string)($singleBet['number'] ?? ''));
                    $betAmt = floatval($singleBet['amount'] ?? 0);

                    if ($betNum === $winningNumber) {
                        $payout = $betAmt * $multiplier;
                        $singleBet['status'] = 'win';
                        $singleBet['win_amount'] = $payout;
                        $totalWinForThisBet += $payout;
                        $isWin = true;
                    } else {
                        $singleBet['status'] = 'lose';
                        $singleBet['lost'] = $betAmt;
                        $totalLostForThisBet += $betAmt;
                    }
                }
                unset($singleBet);

                $user = User::find($bet->userId);

                if ($isWin) {
                    if ($user) {
                        $user->balance = floatval($user->balance) + $totalWinForThisBet;
                        $user->save();
                    }

                    DB::table('twod_bets')->where('id', $bet->id)->update([
                        'status' => 1, 
                        'win_amount' => $totalWinForThisBet,
                        'lost' => 0.00,
                        'bets' => json_encode($decodedBets),
                        'isArchived' => $winningNumber
                    ]);
                } else {
                    DB::table('twod_bets')->where('id', $bet->id)->update([
                        'status' => 2, 
                        'win_amount' => 0.00,
                        'lost' => $totalLostForThisBet,
                        'bets' => json_encode($decodedBets),
                        'isArchived' => $winningNumber
                    ]);
                }
            }

            DB::table('twod_bets')
                ->whereRaw('LOWER(TRIM(session)) = ?', [strtolower($session)])
                ->update(['is_open' => 0]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'ငွေရှင်းလင်းခြင်း အောင်မြင်ပါသည်။',
                'winning_number' => $winningNumber
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

        public function updateSessionSettings(Request $request)
    {
        $request->validate([
            'session_name' => 'required_without:session|string',
            'session'      => 'required_without:session_name|string',
            'open_time'    => 'required',
            'close_time'   => 'required',
        ]);

        $session = trim($request->input('session_name') ?? $request->input('session'));
        $openTime = $request->input('open_time');
        $closeTime = $request->input('close_time');

        try {
            DB::table('session_status')->updateOrInsert(
                ['session_name' => $session],
                [
                    'open_time'  => $openTime,
                    'close_time' => $closeTime,
                ]
            );

            return response()->json([
                'status'  => 'success',
                'success' => true,
                'message' => 'Session ၏ ဖွင့်ပိတ်ချိန်များကို အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getTwoDHistory(Request $request)
    {
        $userId = $request->input('userId') ?? $request->input('user_id') ?? $request->query('userId') ?? $request->query('user_id');

        if (empty($userId) && $request->user()) {
            $userId = $request->user()->id;
        }

        if (empty($userId)) {
            return response()->json([
                "status" => "error",
                "message" => "UserId မပါရှိပါ။"
            ], 400);
        }

        try {
            $bets = DB::table('twod_bets')->where('userId', $userId)->orderBy('id', 'desc')->get();

            $history = [];
            foreach ($bets as $bet) {
                $decodedBets = json_decode($bet->bets, true);
                if (is_string($decodedBets)) {
                    $decodedBets = json_decode($decodedBets, true);
                }

                // bets ထဲမှ win_amount များကို စလပ်(slab) မှန်ကန်စွာ စစ်ဆေးပြီး ပေါင်းစုတွက်ချက်ခြင်း
                $winAmount = 0.00;
                if (is_array($decodedBets)) {
                    foreach ($decodedBets as $bItem) {
                        if (is_array($bItem) && isset($bItem['win_amount'])) {
                            $winAmount += (float) $bItem['win_amount'];
                        }
                    }
                }
                
                // အကယ်၍ bets ထဲတွင် win_amount မရှိပါက database ကော်လံမှ win_amount ကို ဆက်လက်စစ်ဆေးရန်
                if ($winAmount == 0 && isset($bet->win_amount) && $bet->win_amount > 0) {
                    $winAmount = (float) $bet->win_amount;
                }

                // status = 0 ဖြစ်လျှင် pending ဟု သတ်မှတ်ရန်
                $statusVal = $bet->status;
                if ((string)$statusVal === '0' || $statusVal === 0) {
                    $statusStr = 'pending';
                } else {
                    $statusStr = (string) $statusVal;
                }

                $history[] = [
                    'id'             => $bet->id,
                    'userId'         => $bet->userId,
                    'userName'       => $bet->userName,
                    'session'        => $bet->session,
                    'bets'           => $decodedBets ?? [],
                    'total_amount'   => $bet->total_amount,
                    'number'         => $bet->number,
                    'amount'         => $bet->amount,
                    'win_amount'     => $winAmount,
                    'lost'           => $bet->lost ?? 0.00,
                    'status'         => $statusStr,
                    'winning_number' => $bet->isArchived,
                    'time'           => $bet->time ?? $bet->created_at
                ];
            }

            return response()->json([
                "status" => "success",
                "data" => $history
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Error: " . $e->getMessage()
            ], 500);
        }
    }
   
}