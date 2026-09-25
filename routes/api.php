<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\FootballController;
use App\Http\Controllers\TwoDController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ChatController;


    // Public Routes (Auth)
    Route::post('/register', [AuthController::class, 'register']); 
    Route::post('/login', [AuthController::class, 'login']);       

    Route::get('/proxy/twod-live', [TwoDController::class, 'getProxyLiveResult']);
    Route::get('/twod-result-live', [TwoDController::class, 'getLiveResult']);
    Route::get('/api/twod-result-live', [TwoDController::class, 'getLiveResult']);
    
    
Route::middleware(['auth:sanctum'])->group(function () {


    // Dashboard & Special Feature Routes
    Route::get('/admin/dashboard', [AdminController::class, 'getDashboardData']);  
    Route::get('/api/admin/dashboard', [AdminController::class, 'getDashboardData']);       
    Route::post('/admin/trigger-lucky-draw', [AdminController::class, 'triggerLuckyDraw']);
    
    // User Management Routes
    Route::get('/user/info', [UserController::class, 'getUserInfo']);        
    Route::get('/users', [UserController::class, 'getUsers']);              
    Route::post('/user/update', [UserController::class, 'updateUser']);      
    Route::delete('/user/delete', [UserController::class, 'deleteUser']);    

    // Request & Approval Routes
    Route::get('/requests', [RequestController::class, 'getRequests']);                     
    Route::get('/user/requests', [RequestController::class, 'getUserRequests']);           
    Route::post('/submit-request', [RequestController::class, 'submitRequest']);           
    Route::post('/request/approve', [RequestController::class, 'approveRequest']);         
    Route::post('/request/reject', [RequestController::class, 'rejectRequest']); 
    Route::delete('/request/delete', [RequestController::class, 'deleteRequest']);
    Route::delete('/api/request/delete', [RequestController::class, 'deleteRequest']);          

    // General Bet Routes
    Route::post('/bet/place', [BetController::class, 'placeBet']);                 
    Route::get('/bet/user-bets', [BetController::class, 'getUserBets']);           
    Route::post('/bet/update-status', [BetController::class, 'updateBetStatus']);   
    Route::post('/bet/update-win', [BetController::class, 'updateWinBet']);        
    Route::post('/bet/update-lost', [BetController::class, 'updateLostBet']);
    Route::post('/api/bet/update-win', [FootballController::class, 'updateWinBet']);        
    Route::post('/api/bet/update-lost', [FootballController::class, 'updateLostBet']);
    
    //Animal Bet Routes
    Route::post('/place-bets', [BetController::class, 'placeAnimalBet']);
    Route::post('/trigger-lucky-draw', [BetController::class, 'triggerLuckyDraw']); 
    Route::post('/api/trigger-lucky-draw', [BetController::class, 'triggerLuckyDraw']);
    Route::get('/trigger-lucky-draw', [BetController::class, 'triggerLuckyDraw']);
    Route::get('/animal/history', [BetController::class, 'getAnimalHistory']);
    Route::get('/api/animal/history', [BetController::class, 'getAdminAnimalHistory']);
    Route::get('/animal/history', [BetController::class, 'getAdminAnimalHistory']);
    Route::get('/api/animal/history', [BetController::class, 'getAdminAnimalHistory']);

    Route::post('/animal/history/delete', [BetController::class, 'deleteAnimalHistory']);
    Route::post('/api/animal/history/delete', [BetController::class, 'deleteAnimalHistory']);

    // Football Betting Routes
    Route::post('/football/add-league', [FootballController::class, 'addLeague']);
    Route::post('/api/football/add-league', [FootballController::class, 'addLeague']);
    
    Route::get('/leagues', [FootballController::class, 'getLeagues']);
    Route::get('/api/leagues', [FootballController::class, 'getLeagues']);
    
    Route::post('/football/add-match', [FootballController::class, 'addMatch']);
    Route::post('/api/football/add-match', [FootballController::class, 'addMatch']);

    Route::get('/football/body-moung-bets', [FootballController::class, 'getBodyMoungBets']);           
    Route::get('/api/football/body-moung-bets', [FootballController::class, 'getBodyMoungBets']);
    
    Route::get('/football/match/{id}/edit', [FootballController::class, 'edit'])->name('football.edit');
    Route::put('/football/match/{id}', [FootballController::class, 'update'])->name('football.update');

    Route::delete('/football/match/delete', [FootballController::class, 'deleteMatch']);
    Route::delete('/api/football/match/delete', [FootballController::class, 'deleteMatch']);
    
    Route::post('/football/update-match', [FootballController::class, 'updateMatch']);
    Route::post('/api/football/update-match', [FootballController::class, 'updateMatch']);
    
    Route::get('/payment-config', [ConfigController::class, 'getPaymentConfig']);
    Route::get('/football-matches', [FootballController::class, 'getMatches']);
    Route::get('/api/football-matches', [FootballController::class, 'getMatches']);
    Route::post('/football/update-status', [FootballController::class, 'updateFootballStatus']); 
    Route::post('/api/football/update-status', [FootballController::class, 'updateFootballStatus']); 
    Route::get('/football/status', [FootballController::class, 'getFootballStatus']);              
    Route::get('/api/football/status', [FootballController::class, 'getFootballStatus']);
    Route::post('/football-matches/check-and-close', [FootballController::class, 'checkAndCloseMatchStatuses']);
    Route::post('/api/football-matches/check-and-close', [FootballController::class, 'checkAndCloseMatchStatuses']); 
    Route::post('/football/place-bet', [FootballController::class, 'placeFootballBet']); 
    Route::post('/api/football/place-bet', [FootballController::class, 'placeFootballBet']);          
    Route::get('/football/history', [FootballController::class, 'getFootballHistory']);
    Route::get('/api/football/history', [FootballController::class, 'getFootballHistory']);
    Route::delete('/football/bet/delete', [FootballController::class, 'deleteFootballBet']);
    Route::delete('/api/football/bet/delete', [FootballController::class, 'deleteFootballBet']);

    Route::post('/place-twod-bets', [TwoDController::class, 'placeTwoDBet']);
    Route::post('/twod/place-bet', [TwoDController::class, 'placeTwoDBet']);    

    Route::get('/twod/history', [TwoDController::class, 'getTwoDHistory']);
    Route::post('/twod/history', [TwoDController::class, 'getTwoDHistory']);
    Route::get('/api/twod/history', [TwoDController::class, 'getTwoDHistory']);
    Route::post('/api/twod/history', [TwoDController::class, 'getTwoDHistory']);
           
    Route::get('/football/matches', [FootballController::class, 'getMatches']);           
    Route::get('/api/football/matches', [FootballController::class, 'getMatches']);                    
    
    Route::get('/football/league-matches', [FootballController::class, 'getLeagueMatches']);  
    Route::get('/api/football/league-matches', [FootballController::class, 'getLeagueMatches']);  
    
    // 2D Lottery Routes              
    Route::get('/admin/2d-user-bets', [TwoDController::class, 'getAdminTwoDBets']);
    Route::post('/admin/2d-user-bets/update', [TwoDController::class, 'update2DBetStatus']);                      
    Route::post('/twod/declare-result', [TwoDController::class, 'declareTwoDResult']);
    Route::post('/api/twod/declare-result', [TwoDController::class, 'declareTwoDResult']);
    Route::post('/twod/session-settings/update', [TwoDController::class, 'updateSessionSettings']); 
    Route::post('/api/admin/2d-session-settings', [TwoDController::class, 'updateSessionSettings']);
    Route::delete('/admin/2d-user-bets/delete', [TwoDController::class, 'deleteAdminTwoDBet']);
    Route::delete('/api/admin/2d-user-bets/delete', [TwoDController::class, 'deleteAdminTwoDBet']);
    Route::get('/api/twod/session-statuses', [ConfigController::class, 'getSessionStatus']);
    Route::get('/twod/session-statuses', [ConfigController::class, 'getSessionStatus']);
    Route::post('/twod/session-statuses', [ConfigController::class, 'updateSessionStatus']); 
    

    // Configurations & Status Routes (Error ဖြစ်နေသော နေရာအတွက် လမ်းကြောင်းများ အစုံအလင်ထည့်သွင်းထားသည်)
    Route::get('/config/session-status', [ConfigController::class, 'getSessionStatus']);     
    Route::post('/config/session-status/update', [ConfigController::class, 'updateSessionStatus']);
    Route::get('/config/payment', [ConfigController::class, 'getPaymentConfig']);
    Route::post('/config/payment/update', [ConfigController::class, 'updatePaymentConfig']);
    Route::get('/config/timer', [ConfigController::class, 'getTimerConfig']);
    Route::post('/config/timer/update', [ConfigController::class, 'updateTimerConfig']);


    Route::get('/chat/messages', [ChatController::class, 'fetchMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);

    Route::get('/admin/chat/users', [AdminController::class, 'getChatUsers']);
    Route::post('/admin/chat/send', [AdminController::class, 'sendAdminMessage']);
    Route::post('/api/admin/chat/send', [AdminController::class, 'sendAdminMessage']);
    Route::get('/api/admin/chat/users', [AdminController::class, 'getChatUsers']);

    // 🟢 ဤ Route အသစ်ကို ထည့်ပေးရန် (404 Error ဖြေရှင်းရန်)
    Route::get('/admin/chat/messages/{userId}', [AdminController::class, 'getChatMessages']);
    Route::get('/api/admin/chat/messages/{userId}', [AdminController::class, 'getChatMessages']); 

    Route::get('/api/admin/chats', [AdminController::class, 'getChatUsers']);

  

   // Admin Live Stream Routes
    Route::post('/admin/livestream/store', [FootballController::class, 'addLiveStream']);
    Route::get('/admin/livestream/list', [FootballController::class, 'getLiveStreams']);
    Route::get('/api/admin/livestream/list', [FootballController::class, 'getLiveStreams']);
    
    Route::post('/admin/livestream/update/{id}', [FootballController::class, 'updateLiveStream']);
    Route::post('/api/admin/livestream/update/{id}', [FootballController::class, 'updateLiveStream']);
    
    Route::post('/admin/livestream/update-status/{id}', [FootballController::class, 'updateLiveStreamStatus']);
    Route::post('/api/admin/livestream/update-status/{id}', [FootballController::class, 'updateLiveStreamStatus']);

    Route::post('/admin/slider/store', [AdminController::class, 'storeSlider']);
    Route::post('/api/admin/slider/store', [AdminController::class, 'storeSlider']);
    Route::post('/admin/slider/update/{id}', [AdminController::class, 'updateSlider']);
    Route::post('/api/admin/slider/update/{id}', [AdminController::class, 'updateSlider']);
    Route::delete('/admin/slider/delete/{id}', [AdminController::class, 'deleteSlider']);
    Route::delete('/api/admin/slider/delete/{id}', [AdminController::class, 'deleteSlider']);
    Route::post('/admin/slider/update-status/{id}', [AdminController::class, 'updateSliderStatus']);
    Route::post('/api/admin/slider/update-status/{id}', [AdminController::class, 'updateSliderStatus']);

});