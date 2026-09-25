<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Bet;

class BetController extends Controller
{
    
    // Animal Game အတွက် ထိုးငွေများကို လက်ခံသိမ်းဆည်းခြင်း (place_bets)
    public function placeAnimalBet(Request $request)
    {
        // Sanctum မှတဆင့် ဝင်ရောက်ထားသော User ၏ ID ကို တိုက်ရိုက်ရယူမည်
        $userId = $request->user()->id ?? $request->input('userId');
        $userName = $request->user()->name ?? $request->input('userName', '');
        $bets = $request->input('bets', []);

        if (empty($userId) || empty($bets) || !is_array($bets)) {
            return response()->json([
                "status" => "error", 
                "message" => "Invalid or missing required fields"
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            foreach ($bets as $bet) {
                $totalAmount += (float)($bet['amount'] ?? 0);
            }

            if ($totalAmount <= 0) {
                throw new \Exception("Invalid bet amount", 400);
            }

            // User ၏ လက်ကျန်ငွေကို စစ်ဆေးခြင်း
            $user = DB::table('users')->where('id', $userId)->lockForUpdate()->first();

            if (!$user) {
                throw new \Exception("User not found", 404);
            }

            $currentBalance = (float)$user->balance;

            if ($currentBalance < $totalAmount) {
                throw new \Exception("Insufficient balance to place bet", 400);
            }

            $newBalance = $currentBalance - $totalAmount;

            DB::table('users')->where('id', $userId)->update([
                'balance' => $newBalance,
                'updated_at' => now()
            ]);

            $betsJsonString = json_encode($bets, JSON_UNESCAPED_UNICODE);

            date_default_timezone_set('Asia/Yangon');
            
            DB::table('game_bets')->insert([
                'userid' => $userId,
                'userName' => $userName,
                'bets_json' => $betsJsonString,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'winAmount' => 0.00,
                'luckyAnimal' => '',
                'time' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();

            return response()->json([
                "status" => "success",
                "message" => "Bets placed successfully as a single row",
                "remaining_balance" => $newBalance
            ], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            DB::rollBack();
            $statusCode = ($e->getCode() >= 100 && $e->getCode() <= 599) ? $e->getCode() : 500;
            return response()->json([
                "status" => "error", 
                "message" => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE);
        }
    }
    

    public function triggerLuckyDraw(Request $request)
{
    // တိရစ္ဆာန် ၃၆ ကောင် စာရင်း[cite: 18]
    $animals = ['မြင်း', 'တော', 'ရွှေနဂါး', 'လိပ်ပြာ', 'ဆတ်', 'မြွေ', 'မျောက်', 'ပင့်ကူ', 'ဗျိုင်း', 'သီလ', 'ငန်း', 'ခရု', 'ဆင်', 'ရွှေငါး', 'ကြက်', 'လိပ်', 'ကျီး', 'ငှက်', 'ကျား', 'ဝက်', 'ဒေါင်း', 'ယုန်', 'ခွေး', 'ပုစွန်', 'နဂါး', 'ဆိတ်', 'နွား', 'အိမ်', 'တီ', 'ငွေငါး', 'ခို', 'ဖား', 'ပျား', 'ကျောက်', 'ကြွက်', 'ရှဉ့်'];

    // ၁။ တိရစ္ဆာန် တစ်ကောင်ချင်းစီအတွက် စုစုပေါင်းထိုးငွေများကို တွက်ချက်ရန်[cite: 18]
    $animalTotals = [];
    foreach ($animals as $animal) {
        $animalTotals[$animal] = 0;
    }

    // game_bets ဇယားအတွင်း pending ဖြစ်နေသော bets_json ထဲမှ ထိုးငွေများကို စုစုပေါင်းပေါင်းရန် (status ကို lowercase ဖြင့် စစ်ဆေးရန်)[cite: 18]
    $resAll = DB::table('game_bets')->where('status', 'pending')->get();
    foreach ($resAll as $rowAll) {
        $decoded = json_decode($rowAll->bets_json, true);
        if (is_array($decoded)) {
            foreach ($decoded as $b) {
                // animal_name ကို အသုံးပြုရန် (Frontend မှ animal_name ဖြင့် ပို့ထားပါသည်)[cite: 17, 18]
                $bAnimal = trim($b['animal_name'] ?? ($b['animal'] ?? ''));
                $bAmount = floatval($b['amount'] ?? 0);
                if (array_key_exists($bAnimal, $animalTotals)) {
                    $animalTotals[$bAnimal] += $bAmount;
                }
            }
        }
    }

    // ၂။ ငွေပမာဏ (၀) ရှိသော တိရစ္ဆာန်များကို စုဆောင်းရန်[cite: 18]
    $zeroAnimals = [];
    foreach ($animalTotals as $animal => $total) {
        if ($total == 0) {
            $zeroAnimals[] = $animal;
        }
    }

    $luckyAnimal = '';

    if (count($zeroAnimals) > 0) {
        // အကယ်၍ (၀) ရှိသောကောင်များထဲမှ ကျပန်း တစ်ကောင်ရွေးရန်[cite: 18]
        $luckyAnimal = $zeroAnimals[array_rand($zeroAnimals)];
    } else {
        // (၀) မရှိပါက ငွေပမာဏ အနည်းဆုံးဖြစ်သော ကောင်ကို ရှာရန်[cite: 18]
        $minAmount = min($animalTotals);
        $minAnimals = [];
        foreach ($animalTotals as $animal => $total) {
            if ($total == $minAmount) {
                $minAnimals[] = $animal;
            }
        }
        // အနည်းဆုံးငွေပမာဏတူနေပါက ထိုထဲမှ ကျပန်း တစ်ကောင်ရွေးရန်[cite: 18]
        $luckyAnimal = $minAnimals[array_rand($minAnimals)];
    }

    // ဆက်တင်ဇယားတွင် luckyAnimal ကို သိမ်းဆည်းရန်[cite: 18]
    DB::table('settings')->updateOrInsert(
        ['config_key' => 'luckyAnimal'],
        ['config_value' => $luckyAnimal]
    );

    $userId = $request->input('userId', '');
    $isWin = false;
    $winnings = 0;

    // သက်ဆိုင်ရာ User ၏ pending ဖြစ်နေသော bet များကို စစ်ဆေး၍ အနိုင်/အရှုံး တွက်ချက်ရန်[cite: 18]
    $res = DB::table('game_bets')->where('status', 'pending')->get();
    
    foreach ($res as $row) {
        $betId = $row->id;
        $betsJson = $row->bets_json;
        $totalWinAmountForThisRow = 0;
        $rowHasWon = false;

        if (!empty($betsJson)) {
            $decodedBets = json_decode($betsJson, true);
            if (is_array($decodedBets)) {
                foreach ($decodedBets as &$singleBet) {
                    $betAnimal = trim($singleBet['animal_name'] ?? ($singleBet['animal'] ?? ''));
                    $betAmount = floatval($singleBet['amount'] ?? 0);

                    if ($betAnimal !== '' && $betAnimal === $luckyAnimal) {
                        $rowHasWon = true;
                        $isWin = true;
                        $winForThisAnimal = $betAmount * 27; // မူလထိုးငွေ၏ ၂၇ ဆ တွက်ပေးရန်[cite: 18]
                        $totalWinAmountForThisRow += $winForThisAnimal;
                        
                        $singleBet['status'] = 'Win';
                        $singleBet['winAmount'] = $winForThisAnimal;
                    } else {
                        $singleBet['status'] = 'Lost';
                        $singleBet['winAmount'] = 0;
                    }
                    $singleBet['luckyAnimal'] = $luckyAnimal;
                }
                unset($singleBet);
                
                $updatedBetsJson = json_encode($decodedBets, JSON_UNESCAPED_UNICODE);
                $newStatus = $rowHasWon ? 'Win' : 'Lost';
                
                // ဇယားအတွင်း Status၊ winAmount၊ luckyAnimal နှင့် bets_json ကို Update လုပ်ရန်[cite: 18]
                DB::table('game_bets')->where('id', $betId)->update([
                    'status' => $newStatus,
                    'winAmount' => $totalWinAmountForThisRow,
                    'luckyAnimal' => $luckyAnimal,
                    'bets_json' => $updatedBetsJson
                ]);
                
                if ($rowHasWon) {
                    $winnings += $totalWinAmountForThisRow;
                    // User ၏ လက်ကျန်ငွေ (balance) သို့ ပေါင်းထည့်ရန်[cite: 18]
                    DB::table('users')->where('id', $row->userid)->increment('balance', $totalWinAmountForThisRow);
                }
            }
        }
    }

    return response()->json([
        "status" => "success",
        "luckyAnimal" => $luckyAnimal,
        "isWin" => $isWin,
        "winnings" => $winnings
    ], 200, [], JSON_UNESCAPED_UNICODE);
}

    public function getAnimalHistory(Request $request)
    {
        try {
            // Request မှလာသော userId ကို ယူမည် (မပါလျှင် Sanctum auth user id ကို ယူမည်၊ နှစ်ခုစလုံးမရှိလျှင် 0 ဟု သတ်မှတ်မည်)
            $userId = $request->input('userId') ?? ($request->user()->id ?? 0);

            $query = DB::table('game_bets');
            
            if (!empty($userId) && is_numeric($userId) && intval($userId) > 0) {
                $query->where('userid', intval($userId));
            }

            $rows = $query->orderBy('id', 'desc')->get();

            $bets = [];

            foreach ($rows as $row) {
                $decodedBets = [];
                if (!empty($row->bets_json)) {
                    $decoded = json_decode($row->bets_json, true);
                    if (is_array($decoded)) {
                        $decodedBets = $decoded;
                    }
                }
                
                $luckyAnimalStr = trim($row->luckyAnimal ?? '');
                $hasWon = false;
                $calculatedWinAmount = 0;

                foreach ($decodedBets as &$singleBet) {
                    $betAnimal = trim($singleBet['animal_name'] ?? ($singleBet['animal'] ?? ''));
                    $betAmount = floatval($singleBet['amount'] ?? 0);
                    
                    if ($luckyAnimalStr !== '') {
                        if ($betAnimal !== '' && $betAnimal === $luckyAnimalStr) {
                            $hasWon = true;
                            $singleBet['status'] = 'Win';
                            $winAmountForBet = $betAmount * 27;
                            $singleBet['winAmount'] = $winAmountForBet;
                            $calculatedWinAmount += $winAmountForBet;
                        } else {
                            $singleBet['status'] = 'Lost';
                            $singleBet['winAmount'] = 0;
                        }
                    } else {
                        $singleBet['status'] = 'Pending';
                        $singleBet['winAmount'] = 0;
                    }
                    
                    $singleBet['luckyAnimal'] = $luckyAnimalStr;
                }
                unset($singleBet);
                
                if ($luckyAnimalStr !== '') {
                    $rowStatus = $hasWon ? 'Win' : 'Lost';
                } else {
                    $rowStatus = 'Pending';
                }
                
                $bets[] = [
                    "id" => intval($row->id ?? 0),
                    "userId" => intval($row->userid ?? 0), 
                    "userName" => $row->userName ?? '',
                    "bets_json" => $decodedBets,
                    "total_amount" => floatval($row->total_amount ?? 0),
                    "status" => $rowStatus,
                    "winAmount" => $calculatedWinAmount,
                    "luckyAnimal" => $luckyAnimalStr,
                    "time" => $row->time ?? ''
                ];
            }

            return response()->json([
                "status" => "success", 
                "data" => $bets
            ], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "error", 
                "message" => "Database error: " . $e->getMessage()
            ], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }


    // bet.php / place_bets.php
    public function placeBet(Request $request)
    {
        $bet = Bet::create([
            'user_id' => $request->user()->id,
            'amount' => $request->amount,
            'type' => $request->type,
            'details' => json_encode($request->details),
            'status' => 'pending'
        ]);

        return response()->json(['status' => 'success', 'data' => $bet]);
    }

    // get_user_bets.php
    public function getUserBets(Request $request)
    {
        $bets = Bet::where('user_id', $request->user_id)->get();
        return response()->json(['status' => 'success', 'data' => $bets]);
    }

    // update_bet_status.php
    public function updateBetStatus(Request $request)
    {
        $bet = Bet::findOrFail($request->bet_id);
        $bet->status = $request->status;
        $bet->save();

        return response()->json(['status' => 'success', 'message' => 'Bet status updated']);
    }

    // update_win_bet.php
    public function updateWinBet(Request $request)
    {
        $bet_id = $request->input('bet_id');
        $user_doc_id = $request->input('user_doc_id');
        $match_id = $request->input('match_id');
        $win_amount = $request->input('win_amount', 0);

        if (!$bet_id || !$user_doc_id) {
            return response()->json([
                "success" => false, 
                "message" => "အချက်အလက် မပြည့်စုံပါ။"
            ], 422, [], JSON_UNESCAPED_UNICODE);
        }

        DB::beginTransaction();

        try {
            $bet = DB::table('gamefootball_bits')->where('id', $bet_id)->first();
            
            if (!$bet) {
                throw new \Exception("ရှာမတွေ့သော Bet ID ဖြစ်ပါသည်။");
            }

            $bet_type = strtolower(trim($bet->bet_type));
            $is_maung = ($bet_type === 'maung' || strpos($bet_type, 'မောင်း') !== false);
            
            $total_credit_amount = 0;

            if (!$is_maung && !empty($match_id)) {
                $options = json_decode($bet->selected_option, true);
                $match_bet_amount = 0;
                $found_match = false;
                
                if (is_array($options)) {
                    foreach ($options as &$opt) {
                        $optMatchId = isset($opt['match_id']) ? (string)$opt['match_id'] : '';
                        if ($optMatchId === (string)$match_id) {
                            $found_match = true;
                            // 🛑 ဤ သီးသန့် match_id တွင်သာ status ရှိပြီးသားဆိုလျှင် တားမြစ်ရန်
                            if (isset($opt['status']) && in_array($opt['status'], ['win', 'lose', 'lost'])) {
                                throw new \Exception("အများအသုံး့ရှိသည် (Match ID: {$match_id}): ဤပွဲစဉ် (match_id: {$match_id}) မှာ ပြီးပြတ်ပြီးဖြစ်၍ ထပ်မံလုပ်ဆောင်၍မရပါ။");
                            }
                            $match_bet_amount = floatval($opt['amount'] ?? 0);
                            $opt['win_amount'] = floatval($win_amount);
                            $opt['status'] = 'win';
                            break; // တွေ့ပြီးပါက loop ကို ရပ်မည် (အခြား match_id များကို မထိခိုက်စေရန်)
                        }
                    }
                }

                if (!$found_match) {
                    throw new \Exception("ရွေးချယ်ထားသော match_id ကို ဤ Bet ထဲတွင် မတွေ့ရှိပါ။");
                }

                $updated_json = json_encode($options, JSON_UNESCAPED_UNICODE);

                //$total_credit_amount = floatval($win_amount) + $match_bet_amount;
                

                DB::table('gamefootball_bits')
                    ->where('id', $bet_id)
                    ->update([
                        'selected_option' => $updated_json,
                        'win_amount' => DB::raw("win_amount + " . floatval($win_amount)),
                        'updated_at' => now()
                    ]);

                $refreshedBet = DB::table('gamefootball_bits')->where('id', $bet_id)->first();
                $all_options = json_decode($refreshedBet->selected_option, true);
                $is_all_completed = true;
                
                if (is_array($all_options)) {
                    foreach ($all_options as $opt) {
                        $opt_status = $opt['status'] ?? '';
                        if (!in_array($opt_status, ['win', 'lose', 'lost'])) {
                            $is_all_completed = false;
                            break;
                        }
                    }
                }
                
                if ($is_all_completed) {
                    DB::table('gamefootball_bits')
                        ->where('id', $bet_id)
                        ->update(['status' => 'completed']);
                }
            } else {
                $total_credit_amount = floatval($win_amount);
                DB::table('gamefootball_bits')
                    ->where('id', $bet_id)
                    ->update([
                        'win_amount' => DB::raw("win_amount + " . floatval($win_amount)),
                        'status' => 'win',
                        'updated_at' => now()
                    ]);
            }

            $user = DB::table('users')->where('id', $user_doc_id)->lockForUpdate()->first();
            if ($user) {
                $new_balance = floatval($user->balance) + $total_credit_amount;
                DB::table('users')->where('id', $user_doc_id)->update([
                    'balance' => $new_balance,
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                "success" => true,
                "status" => "success",
                "message" => "ငွေရှင်းလင်းမှု အောင်မြင်ပါသည်။"
            ], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "status" => "error",
                "message" => $e->getMessage()
            ], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function updateLostBet(Request $request)
    {
        $bet_id = $request->input('bet_id');
        $user_doc_id = $request->input('user_doc_id');
        $match_id = $request->input('match_id');
        $amount = $request->input('amount', 0);

        if (!$bet_id || !$user_doc_id) {
            return response()->json([
                "success" => false, 
                "message" => "အချက်အလက် မပြည့်စုံပါ။"
            ], 422, [], JSON_UNESCAPED_UNICODE);
        }

        DB::beginTransaction();

        try {
            $bet = DB::table('gamefootball_bits')->where('id', $bet_id)->lockForUpdate()->first();
            
            if (!$bet) {
                throw new \Exception("ရှာမတွေ့သော Bet ID ဖြစ်ပါသည်။");
            }

            $bet_type = strtolower(trim($bet->bet_type ?? ''));
            $is_maung = ($bet_type === 'maung' || strpos($bet_type, 'မောင်း') !== false);

            if (!$is_maung && !empty($match_id)) {
                $options = json_decode($bet->selected_option, true);
                $match_bet_amount = 0;
                $found_match = false;
                
                if (is_array($options)) {
                    foreach ($options as &$opt) {
                        $optMatchId = isset($opt['match_id']) ? (string)$opt['match_id'] : '';
                        if ($optMatchId === (string)$match_id) {
                            $found_match = true;
                            // 🛑 ဤ သီးသန့် match_id တွင်သာ status ရှိပြီးသားဆိုလျှင် တားမြစ်ရန်
                            if (isset($opt['status']) && in_array($opt['status'], ['win', 'lose', 'lost'])) {
                                throw new \Exception("အများအသုံး့ရှိသည် (Match ID: {$match_id}): ဤပွဲစဉ် (match_id: {$match_id}) မှာ ပြီးပြတ်ပြီးဖြစ်၍ ထပ်မံလုပ်ဆောင်၍မရပါ။");
                            }
                            $match_bet_amount = floatval($opt['amount'] ?? 0);
                            $opt['status'] = 'lose';
                            break; // တွေ့ပြီးပါက loop ကို ရပ်မည် (အခြား match_id များကို မထိခိုက်စေရန်)
                        }
                    }
                }

                if (!$found_match) {
                    throw new \Exception("ရွေးချယ်ထားသော match_id ကို ဤ Bet ထဲတွင် မတွေ့ရှိပါ။");
                }

                $updated_json = json_encode($options, JSON_UNESCAPED_UNICODE);
                $lost_addition = ($amount > 0) ? floatval($amount) : $match_bet_amount;

                DB::table('gamefootball_bits')
                    ->where('id', $bet_id)
                    ->update([
                        'selected_option' => $updated_json,
                        'lost' => DB::raw("lost + " . $lost_addition),
                        'updated_at' => now()
                    ]);

                $refreshedBet = DB::table('gamefootball_bits')->where('id', $bet_id)->lockForUpdate()->first();
                $all_options = json_decode($refreshedBet->selected_option, true);
                $is_all_completed = true;
                
                if (is_array($all_options)) {
                    foreach ($all_options as $opt) {
                        $opt_status = $opt['status'] ?? '';
                        if (!in_array($opt_status, ['win', 'lose', 'lost'])) {
                            $is_all_completed = false;
                            break;
                        }
                    }
                }
                
                if ($is_all_completed) {
                    DB::table('gamefootball_bits')
                        ->where('id', $bet_id)
                        ->update(['status' => 'completed']);
                }
            } else {
                if ($bet->status === 'win' || $bet->status === 'lost' || $bet->status === 'completed') {
                    throw new \Exception("ဤစလပ်အတွက် ငွေရှင်းပြီးဖြစ်၍ ထပ်မံလုပ်ဆောင်၍မရပါ။");
                }
                
                $lost_val = ($amount > 0) ? floatval($amount) : floatval($bet->amount);

                DB::table('gamefootball_bits')
                    ->where('id', $bet_id)
                    ->update([
                        'status' => 'lost',
                        'lost' => DB::raw("lost + " . $lost_val),
                        'updated_at' => now()
                    ]);
            }

            DB::commit();
            return response()->json([
                "success" => true, 
                "message" => "ပွဲရှုံးစာရင်း အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။"
            ], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception$e) {
            DB::rollBack();
            return response()->json([
                "success" => false, 
                "message" => $e->getMessage()
            ], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getAdminAnimalHistory(Request $request)
    {
        try {
            // ဒေတာဝင်ရောက်မှုကို စစ်ဆေးရန် Laravel Log တွင် မှတ်တမ်းတင်မည်
            \Illuminate\Support\Facades\Log::info('getAdminAnimalHistory called successfully.', [
                'query_params' => $request->all(),
                'user' => $request->user() ? $request->user()->id : 'Unauthenticated'
            ]);

            $query = DB::table('game_bets');

            if ($request->has('status') && !empty($request->input('status'))) {
                $query->where('status', $request->input('status'));
            }

            if ($request->has('date') && !empty($request->input('date'))) {
                $query->whereDate('time', $request->input('date'));
            }

            $rows = $query->orderBy('id', 'desc')->get();

            \Illuminate\Support\Facades\Log::info('Fetched game_bets rows count: ' . $rows->count());

            $bets = [];

            foreach ($rows as $row) {
                $decodedBets = [];
                if (!empty($row->bets_json)) {
                    $decoded = json_decode($row->bets_json, true);
                    if (is_array($decoded)) {
                        $decodedBets = $decoded;
                    }
                }
                
                $bets[] = [
                    "id" => intval($row->id ?? 0),
                    "userId" => intval($row->userid ?? 0), 
                    "userName" => $row->userName ?? '',
                    "bets_json" => $decodedBets,
                    "total_amount" => floatval($row->total_amount ?? 0),
                    "status" => $row->status ?? 'pending',
                    "winAmount" => floatval($row->winAmount ?? 0),
                    "luckyAnimal" => trim($row->luckyAnimal ?? ''),
                    "time" => $row->time ?? ''
                ];
            }

            return response()->json([
                "status" => "success", 
                "data" => $bets
            ], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in getAdminAnimalHistory: ' . $e->getMessage());
            return response()->json([
                "status" => "error", 
                "message" => "Database error: " . $e->getMessage()
            ], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Animal Bet မှတ်တမ်းများကို ဖျက်ရန် Method
     */
    public function deleteAnimalHistory(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids) || !is_array($ids)) {
                return response()->json([
                    "status" => "error",
                    "message" => "ဖျက်ရန် ID များ မပါရှိပါ။"
                ], 400, [], JSON_UNESCAPED_UNICODE);
            }

            DB::beginTransaction();

            // game_bets ဇယားမှ သက်ဆိုင်ရာ ID များကို ဖျက်ခြင်း
            DB::table('game_bets')->whereIn('id', $ids)->delete();

            DB::commit();

            return response()->json([
                "status" => "success",
                "success" => true,
                "message" => "အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။"
            ], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error",
                "message" => "Error: " . $e->getMessage()
            ], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }
    
}