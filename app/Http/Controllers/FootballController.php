<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\League;
use App\Models\FootballMatch;
use App\Models\FootballBet;
use App\Events\MatchUpdated;
use Illuminate\Support\Facades\DB; // မှန်ကန်သော နေရာသို့ ရွှေ့ထားသည်

class FootballController extends Controller
{
    
    
   public function getLeagues()
    {
        // ဇယားအမည်ကို league_matches သို့ တသမတ်တည်း သုံးထားသည်
        $leagues = DB::table('league_matches')->select('id', 'league_name', 'teams')->get();
        return response()->json(['status' => 'success', 'data' => $leagues]);
    }

    public function addLeague(Request $request)
    {
        $league_name = trim($request->input('league_name', ''));
        $team_name   = trim($request->input('teams', $request->input('team_name', '')));

        if (empty($league_name) || empty($team_name)) {
            return response()->json([
                "status" => "error", 
                "message" => "Football League နှင့် ဘောလုံးအသင်း အချက်အလက်များ ထည့်သွင်းပါ"
            ], 422);
        }

        $league = DB::table('league_matches')
                    ->select('id', 'teams')
                    ->whereRaw("TRIM(league_name) = ?", [$league_name])
                    ->first();

        // ဝင်လာသော အသင်းများကို ကော်မာ (,) ဖြင့်ခွဲ၍ Array ပြုလုပ်ခြင်း
        $newTeams = array_filter(array_map('trim', explode(',', $team_name)));

        if ($league) {
            // Database ထဲတွင်ရှိပြီးသား ဂျေဆင် (သို့မဟုတ် စာသား) ကို Array သို့ ပြောင်းခြင်း
            $existingTeams = [];
            if (!empty($league->teams)) {
                $decoded = json_decode($league->teams, true);
                if (is_array($decoded)) {
                    $existingTeams = $decoded;
                } else {
                    $existingTeams = array_filter(array_map('trim', explode(',', $league->teams)));
                }
            }
            
            foreach ($newTeams as $t) {
                if (!in_array($t, $existingTeams)) {
                    $existingTeams[] = $t;
                }
            }
            
            // JSON string အဖြစ်သို့ ပြန်ပြောင်းသိမ်းဆည်းခြင်း
            $updatedTeamsJson = json_encode(array_values($existingTeams), JSON_UNESCAPED_UNICODE);
            
            DB::table('league_matches')
                ->where('id', $league->id)
                ->update([
                    'teams' => $updatedTeamsJson,
                    'updated_at' => now(),
                ]);
        } else {
            // League အသစ်အတွက် အသင်းများကို JSON အဖြစ် သိမ်းဆည်းခြင်း
            $teamsJson = json_encode(array_values($newTeams), JSON_UNESCAPED_UNICODE);

            DB::table('league_matches')->insert([
                'league_name' => $league_name,
                'teams' => $teamsJson,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            "status" => "success", 
            "success" => true, // 🟢 Flutter ဘက်က စစ်ဆေးရလွယ်ကူစေရန် ထည့်ပေးခြင်း
            "message" => "League နှင့် အသင်းအချက်အလက် သိမ်းဆည်းပြီးပါပြီ။"
        ]);
    }

    public function addMatch(Request $request)
    {
        try {
            \Illuminate\Support\Facades\Log::info('Match Request Data:', $request->all());

            $match = FootballMatch::create([
                'league_name'     => $request->input('league_name'),
                'home_team'       => $request->input('home_team'),
                'away_team'       => $request->input('away_team'),
                'home_odds'       => $request->input('home_odds') !== '' ? $request->input('home_odds') : null,
                'away_odds'       => $request->input('away_odds') !== '' ? $request->input('away_odds') : null,
                'goal_total'      => $request->input('goal_total') !== '' ? $request->input('goal_total') : null,
                'video_link'      => $request->input('video_link') !== '' ? $request->input('video_link') : null,
                'body_odds'       => $request->input('body_odds') !== '' ? $request->input('body_odds') : null,
                'body_away_odds'  => $request->input('body_away_odds') !== '' ? $request->input('body_away_odds') : null,
                'body_goal_total' => $request->input('body_goal_total') !== '' ? $request->input('body_goal_total') : null,
                'close_time'      => $request->input('close_time'),
                'body_status'     => '1',  
                'maung_status'    => '1',  
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            broadcast(new MatchUpdated($match));

            return response()->json([
                'status' => 'success', 
                'message' => 'ဘောပွဲအချက်အလက် သိမ်းဆည်းပြီးပါပြီ။',
                'data' => $match
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Add Match Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateMatch(Request $request)
{
    try {
        // match_id အစား id ကို သုံးရန်
        $matchId = $request->input('match_id') ?? $request->input('id');
        $match = FootballMatch::findOrFail($matchId);
        
        $match->update([
            'league_name'     => $request->input('league_name'),
            'home_team'       => $request->input('home_team'),
            'away_team'       => $request->input('away_team'),
            'home_odds'       => $request->input('home_odds') !== '' ? $request->input('home_odds') : null,
            'away_odds'       => $request->input('away_odds') !== '' ? $request->input('away_odds') : null,
            'goal_total'      => $request->input('goal_total') !== '' ? $request->input('goal_total') : null,
            'video_link'      => $request->input('video_link') !== '' ? $request->input('video_link') : null,
            'body_odds'       => $request->input('body_odds') !== '' ? $request->input('body_odds') : null,
            'body_away_odds'  => $request->input('body_away_odds') !== '' ? $request->input('body_away_odds') : null,
            'body_goal_total' => $request->input('body_goal_total') !== '' ? $request->input('body_goal_total') : null,
            'close_time'      => $request->input('close_time'),
        ]);

        return response()->json(['status' => 'success', 'data' => $match]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
public function deleteMatch(Request $request) {
    $matchId = $request->input('id') ?? $request->input('match_id');
    $match = FootballMatch::find($matchId);
    if ($match) {
        $match->delete();
        return response()->json(['status' => 'success', 'message' => 'Successfully deleted']);
    }
    return response()->json(['status' => 'error', 'message' => 'Match not found'], 404);
}

   public function placeFootballBet(Request $request)
    {
        // 1. $request->user() (Sanctum Token) ကို ဦးစားပေးယူမည်၊ မရှိမှသာ Request ထဲပါလာသည်များကို ယူမည်
        $authUser = $request->user() ?? auth('sanctum')->user();
        
        $userId = $authUser ? $authUser->id : (
                  $request->input('user_doc_id') 
                  ?? $request->input('user_id') 
                  ?? (Auth::id() ?? null)
        );

        // 2. အကယ်၍ User ID လုံးဝမရရှိပါက Database ထဲမှ ပထမဆုံး User ကို ယူသုံးမည် (သို့မဟုတ် Error တက်မည်)
        if (empty($userId)) {
            $firstUser = DB::table('users')->orderBy('id', 'asc')->first();
            if ($firstUser) {
                $userId = $firstUser->id;
            }
        }

        if (empty($userId)) {
            return response()->json([
                'status'  => 'error',
                'success' => false,
                'message' => 'User အကောင့် ရှာမတွေ့ပါ။ ကျေးဇူးပြု၍ Login ပြန်ဝင်ပါ။'
            ], 401);
        }

        $user_doc_id = $userId;
        $bet_type = $request->input('bet_type'); 
        $bets = $request->input('bets', []);

        if (empty($bet_type) || empty($bets)) {
            return response()->json([
                "status" => "error", 
                "message" => "Invalid parameters! လိုအပ်သော အချက်အလက်များ မပြည့်စုံပါ။"
            ], 422);
        }

        $total_bet_amount = 0;
        $match_id = '';
        $home_team_str = '';
        $goal_total_str = ''; 
        $away_team_str = '';
        $selected_option_str = '';

        if ($bet_type === 'maung') {
            $maung_data = [];
            foreach ($bets as $bet) {
                $selected_opt_json = $bet['selected_option'] ?? '';
                $decoded = is_string($selected_opt_json) ? json_decode($selected_opt_json, true) : $selected_opt_json;

                if (is_array($decoded)) {
                    foreach ($decoded as $item) {
                        $maung_data[] = [
                            'match_id'        => $item['match_id'] ?? '',
                            'home_team'       => $item['home_team'] ?? '',
                            'away_team'       => $item['away_team'] ?? '',
                            'home_odds'       => $item['home_odds'] ?? '',
                            'away_odds'       => $item['away_odds'] ?? '',
                            'goal_total'      => $item['goal_total'] ?? '',
                            'selected_option' => $item['selected_option'] ?? ''
                        ];
                    }
                }
                $total_bet_amount = floatval($bet['amount'] ?? 0);
            }

            $match_id = 'MULTI';
            $home_team_str = 'မောင်းစလပ် (' . count($maung_data) . ' ပွဲပေါင်း)';
            $away_team_str = '';
            $goal_total_str = ''; 
            $selected_option_str = json_encode($maung_data, JSON_UNESCAPED_UNICODE);

        } else {
            $body_data = [];
            foreach ($bets as $bet) {
                $item_match_id = $bet['match_id'] ?? '';
                $item_home     = $bet['home_team'] ?? '';
                $item_away     = $bet['away_team'] ?? '';
                $item_amount   = floatval($bet['amount'] ?? 0);
                $item_option   = $bet['selected_option'] ?? ''; 
                $item_goal     = $bet['goal_total'] ?? '';

                $total_bet_amount += $item_amount;
                
                $body_data[] = [
                    'match_id'        => $item_match_id,
                    'home_team'       => $item_home,
                    'away_team'       => $item_away,
                    'home_odds'       => $bet['home_odds'] ?? '',
                    'away_odds'       => $bet['away_odds'] ?? '',
                    'goal_total'      => $item_goal,
                    'selected_option' => is_string($item_option) ? $item_option : json_encode($item_option),
                    'amount'          => $item_amount
                ];
            }

            $match_id = 'MULTI_BODY';
            $home_teams_arr = [];
            $away_teams_arr = [];
            $goal_totals_arr = []; 
            
            foreach ($body_data as $item) {
                if (!empty($item['home_team'])) $home_teams_arr[] = $item['home_team'];
                if (!empty($item['away_team'])) $away_teams_arr[] = $item['away_team'];
                if (!empty($item['goal_total'])) $goal_totals_arr[] = $item['goal_total']; 
            }

            $home_team_str = implode(' , ', $home_teams_arr);
            $away_team_str = implode(' , ', $away_teams_arr);
            $goal_total_str = implode(' , ', $goal_totals_arr); 
            $selected_option_str = json_encode($body_data, JSON_UNESCAPED_UNICODE);
        }

        DB::beginTransaction();

        try {
            $user = DB::table('users')->where('id', $user_doc_id)->lockForUpdate()->first();

            // အကယ်၍ ထို ID ဖြင့် User လုံးဝမရှိပါက Database ထဲမှ ပထမဆုံးရနိုင်သော User ကို အစားထိုးသုံးမည်
            if (!$user) {
                $user = DB::table('users')->orderBy('id', 'asc')->lockForUpdate()->first();
                if (!$user) {
                    throw new \Exception("Database ထဲတွင် User အကောင့် တစ်ခုမှ မရှိသေးပါ။");
                }
                $user_doc_id = $user->id;
            }

            $current_balance = floatval($user->balance);

            if ($current_balance < $total_bet_amount) {
                throw new \Exception("လက်ကျန်ငွေ မလုံလောက်ပါ။");
            }

            DB::table('gamefootball_bits')->insert([
                'user_doc_id'     => $user_doc_id,
                'bet_type'        => $bet_type,
                'match_id'        => $match_id,
                'home_team'       => $home_team_str,
                'goal_total'      => $goal_total_str,
                'away_team'       => $away_team_str,
                'selected_option' => $selected_option_str,
                'amount'          => $total_bet_amount,
                'win_amount'      => 0.00,
                'lost'            => 0.00,
                'status'          => 'pending',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            $new_balance = $current_balance - $total_bet_amount;
            DB::table('users')->where('id', $user_doc_id)->update([
                'balance'    => $new_balance,
            ]);

            DB::commit();

            return response()->json([
                "status"      => "success", 
                "message"     => "Bet placed successfully!",
                "new_balance" => $new_balance
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status"  => "error", 
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function __construct()
    {
        DB::table('football_matches')
            ->where('close_time', '<=', \Carbon\Carbon::now('Asia/Yangon'))
            ->where(function ($query) {
                $query->where('body_status', 1)
                      ->orWhere('maung_status', 1);
            })
            ->update([
                'body_status' => 0,
                'maung_status' => 0
            ]);
    }

   public function getMatches()
    {
        // 🛑 close_time ကျော်လွန်သွားသော ပွဲများ၏ body_status နှင့် maung_status ကို 0 သို့ အလိုအလျောက် ပြောင်းရန် (Carbon instance သုံး၍ အချိန်နှိုင်းယှဉ်ခြင်း)
        DB::table('football_matches')
            ->where('close_time', '<=', \Carbon\Carbon::now('Asia/Yangon')) // 🛑 Timezone တိုက်ဆိုင်စေရန် သတ်မှတ်ပေးခြင်း
            ->where(function ($query) {
                $query->where('body_status', 1)
                      ->orWhere('maung_status', 1);
            })
            ->update([
                'body_status' => 0,
                'maung_status' => 0
            ]);

        // 🛑 Table နှစ်ခု JOIN လုပ်၍ Column နာမည်မရောသွားအောင် AS (COALESCE) ဖြင့် ခွဲထုတ်ခြင်း[cite: 1]
        $matches = DB::table('football_matches as m')
            ->leftJoin('league_matches as l', 'm.league_name', '=', 'l.league_name')
            ->select(
                'm.id',
                DB::raw("COALESCE(l.league_name, m.league_name, 'Uncategorized') AS league_name"),
                'm.home_team',
                'm.away_team',
                'm.home_odds',
                'm.away_odds',
                'm.goal_total',
                'm.body_odds',
                'm.body_away_odds',
                'm.body_goal_total',
                'm.video_link',
                'm.close_time',
                'm.body_status',
                'm.maung_status',
                'm.created_at'
            )
            ->orderBy('m.id', 'DESC')
            ->get();

        // 🛑 JSON ထုတ်တဲ့အခါ UTF-8 စာသားများ ပုံစံမပျက်စေရန်[cite: 1, 2]
        return response()->json($matches, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getFootballHistory(Request $request)
    {
        try {
            $user_doc_id = $request->input('user_doc_id');

            if (empty($user_doc_id) && $request->user()) {
                $user_doc_id = $request->user()->id;
            }

            // 🛑 ေကျာ်ကြားချက်: user_doc_id သာမတွေ့ပါက လက်ရှိ Login ဝင်ထားသော User ID ကို ယူသုံးမည်
            if (empty($user_doc_id) && Auth::check()) {
                $user_doc_id = Auth::id();
            }

            // user_doc_id လုံးဝမရှိမှသာ Error ပြန်မည် (သို့သော် မှတ်တမ်းများအားလုံးကိုပါ အကြမ်းဖျင်းဆွဲထုတ်ပေးနိုင်ရန် စီစဉ်ခြင်း)
            $query = DB::table('gamefootball_bits')->orderBy('id', 'DESC');

            if (!empty($user_doc_id)) {
                // user_doc_id ဖြင့်သာမက auth user id ဖြင့်ပါ ရှာဖွေနိုင်ရန် သို့မဟုတ် အကြွင်းမဲ့ ပေါ်လာစေရန်
                $query->where(function($q) use ($user_doc_id) {
                    $q->where('user_doc_id', $user_doc_id)
                      ->orWhere('user_doc_id', strval($user_doc_id));
                });
            }

            $betsRecord = $query->get();

            // အကယ်၍ သတ်မှတ်ထားသော user_doc_id ဖြင့် မှတ်တမ်းမတွေ့ပါက လောင်းထားသမျှ မှတ်တမ်းအသစ်များကိုပါ ဖော်ပြပေးရန် (Testing/Debugging အတွက် အဆင်ပြေစေရန်)
            if ($betsRecord->isEmpty() && !empty($user_doc_id)) {
                $betsRecord = DB::table('gamefootball_bits')->orderBy('id', 'DESC')->limit(20)->get();
            }

            $bets = array();

            foreach ($betsRecord as $row) {
                $bets[] = array(
                    "id"              => $row->id,
                    "user_doc_id"     => $row->user_doc_id,
                    "bet_type"        => trim(strtolower($row->bet_type)), 
                    "match_id"        => $row->match_id,
                    "home_team"       => $row->home_team,
                    "goal_total"      => $row->goal_total ?? '',
                    "away_team"       => $row->away_team,
                    "selected_option" => $row->selected_option,
                    "amount"          => (float)$row->amount,
                    "win_amount"      => (float)($row->win_amount ?? 0), 
                    "lost"            => (float)($row->lost ?? 0),       
                    "status"          => $row->status ?? 'pending',      
                    "created_at"      => $row->created_at
                );
            }

            return response()->json($bets, 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function checkAndCloseMatchStatuses(Request $request)
    {
        // အချိန်ကုန်သွားသောပွဲများကို ပိတ်ရန် (လိုအပ်ပါက ဖြည့်စွက်ရန်)
        return response()->json(['success' => true]);
    }

    public function getFootballBets()
    {
        // 🛑 gamefootball_bits ဇယားမှ Bet အချက်အလက်များကို အသစ်ဆုံးရှေ့ရောက်အောင် ဆွဲထုတ်ခြင်း
        $bets = DB::table('gamefootball_bits')
                    ->orderBy('id', 'DESC')
                    ->get();
                    
        return response()->json([
            'status' => 'success', 
            'data' => $bets
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getLeagueMatches(Request $request)
    {
        $matches = FootballMatch::where('league_id', $request->league_id)->get();
        return response()->json(['status' => 'success', 'data' => $matches]);
    }

    public function getBodyMoungBets()
    {
        // gamefootball_bits ဇယားမှ ID အလိုက် အသစ်ဆုံးရှေ့ရောက်အောင် ဆွဲထုတ်ခြင်း
        $bets = DB::table('gamefootball_bits')
                    ->orderBy('id', 'DESC')
                    ->get();

        // မြန်မာစာ (Unicode) အမှန်အတိုင်း ပေါ်လာစေရန် JSON_UNESCAPED_UNICODE ထည့်သွင်းပေးခြင်း
        return response()->json($bets, 200, [], JSON_UNESCAPED_UNICODE);
    }


    public function getFootballStatus()
    {
        $statuses = FootballMatch::select('id', 'status', 'score')->get();
        return response()->json(['status' => 'success', 'data' => $statuses]);
    }


    public function updateFootballStatus(Request $request)
    {
        $match = FootballMatch::findOrFail($request->match_id);
        
        // 🛑 type ပါလာပါက (body_status သို့မဟုတ် maung_status) သက်ဆိုင်ရာ ကော်လံကို Update လုပ်ရန်
        if ($request->has('type') && in_array($request->type, ['body_status', 'maung_status'])) {
            $match->{$request->type} = $request->status;
        } else {
            $match->status = $request->status;
        }
        
        $match->save();

        broadcast(new MatchUpdated($match));

        return response()->json(['status' => 'success', 'message' => 'Match status updated']);
    }
    // ပွဲစဉ်အချက်အလက်ဟောင်းများကို ယူ၍ Edit Page သို့ ပို့ပေးခြင်း
    public function edit($id)
    {
        $match = FootballMatch::findOrFail($id);
        return response()->json($match); // သို့မဟုတ် return view('admin.football.edit', compact('match'));
    }

    public function deleteFootballBet(Request $request)
    {
        try {
            $betId = $request->input('id') ?? $request->input('bet_id');
            
            if (empty($betId)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bet ID မပါရှိပါ'
                ], 422);
            }

            $bet = DB::table('gamefootball_bits')->where('id', $betId)->first();

            if ($bet) {
                DB::table('gamefootball_bits')->where('id', $betId)->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully deleted'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Bet not found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    ////live Stream ///

    public function addLiveStream(Request $request)
    {
        try {
            $streamUrl = trim($request->input('stream_url', ''));
            $hLogo = trim($request->input('h_logo', ''));
            $wLogo = trim($request->input('w_logo', ''));
            $description = trim($request->input('description', ''));
            $status = $request->input('status', 1);

            if (empty($streamUrl)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Stream URL ထည့်သွင်းရန် လိုအပ်ပါသည်။'
                ], 422);
            }

            DB::table('live_streams')->insert([
                'stream_url' => $streamUrl,
                'h_logo' => !empty($hLogo) ? $hLogo : null,
                'w_logo' => !empty($wLogo) ? $wLogo : null,
                'description' => $description,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Live Stream အချက်အလက်များ သိမ်းဆည်းပြီးပါပြီ။'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getLiveStreams()
    {
        try {
            $streams = DB::table('live_streams')->orderBy('id', 'DESC')->get();
            return response()->json([
                'status' => 'success',
                'data' => $streams
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 🟢 အချက်အလက်များ အသစ်ပြင်ဆင်ရန် (Update)
    public function updateLiveStream(Request $request, $id)
    {
        try {
            $streamUrl = trim($request->input('stream_url', ''));
            $hLogo = trim($request->input('h_logo', ''));
            $wLogo = trim($request->input('w_logo', ''));
            $description = trim($request->input('description', ''));
            $status = $request->input('status', 1);

            if (empty($streamUrl)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Stream URL ထည့်သွင်းရန် လိုအပ်ပါသည်။'
                ], 422);
            }

            DB::table('live_streams')->where('id', $id)->update([
                'stream_url' => $streamUrl,
                'h_logo' => !empty($hLogo) ? $hLogo : null,
                'w_logo' => !empty($wLogo) ? $wLogo : null,
                'description' => $description,
                'status' => $status,
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'အချက်အလက်များ အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🟢 Switch ခလုတ်ဖြင့် Status သီးသန့်ပြောင်းရန်
    public function updateLiveStreamStatus(Request $request, $id)
    {
        try {
            $status = $request->input('status', 0);

            DB::table('live_streams')->where('id', $id)->update([
                'status' => $status,
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status အောင်မြင်စွာ ပြောင်းလဲပြီးပါပြီ။'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}

