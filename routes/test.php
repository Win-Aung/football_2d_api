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

    // Public Routes (Auth)
    Route::post('/register', [AuthController::class, 'register']); // 1. register.php
    Route::post('/login', [AuthController::class, 'login']);       // 2. login.php
    Route::get('/payment-config', [ConfigController::class, 'getPaymentConfig']);
    Route::get('/football-matches', [FootballController::class, 'getMatches']);
    Route::get('/api/football-matches', [FootballController::class, 'getMatches']);
    Route::post('/football/update-status', [FootballController::class, 'updateFootballStatus']); 
    Route::post('/api/football/update-status', [FootballController::class, 'updateFootballStatus']); 
    Route::get('/football/status', [FootballController::class, 'getFootballStatus']);              
    Route::get('/api/football/status', [FootballController::class, 'getFootballStatus']);
    Route::post('/api/football-matches/check-and-close', [FootballController::class, 'checkAndCloseMatchStatuses']); 
    Route::post('/football/place-bet', [FootballController::class, 'placeFootballBet']); 
    Route::post('/api/football/place-bet', [FootballController::class, 'placeFootballBet']);          
    Route::get('/football/history', [FootballController::class, 'getFootballHistory']);
    Route::get('/api/football/history', [FootballController::class, 'getFootballHistory']);

    Route::post('/place-twod-bets', [TwoDController::class, 'placeTwoDBet']);
    Route::post('/twod/place-bet', [TwoDController::class, 'placeTwoDBet']);
    Route::get('/config/session-status', [ConfigController::class, 'getSessionStatus']);

    Route::get('/twod/history', [TwoDController::class, 'getTwoDHistory']);
    Route::post('/twod/history', [TwoDController::class, 'getTwoDHistory']);
    Route::get('/api/twod/history', [TwoDController::class, 'getTwoDHistory']);
    Route::post('/api/twod/history', [TwoDController::class, 'getTwoDHistory']);


Route::middleware(['auth:sanctum'])->group(function () {
    
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

    // General Bet Routes
    Route::post('/bet/place', [BetController::class, 'placeBet']);                 
    Route::get('/bet/user-bets', [BetController::class, 'getUserBets']);           
    Route::post('/bet/update-status', [BetController::class, 'updateBetStatus']);   
    Route::post('/bet/update-win', [BetController::class, 'updateWinBet']);        
    Route::post('/bet/update-lost', [BetController::class, 'updateLostBet']);
    Route::post('/api/bet/update-win', [FootballController::class, 'updateWinBet']);        
    Route::post('/api/bet/update-lost', [FootballController::class, 'updateLostBet']);      

    // Football Betting Routes (API Prefix နှစ်မျိုးလုံးအတွက် တွဲဖက်ပေးထားသည်)
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

    
    Route::get('/football/body-moung-bets', [FootballController::class, 'getBodyMoungBets']);           
    Route::get('/api/football/body-moung-bets', [FootballController::class, 'getBodyMoungBets']);           
    
    Route::post('/football/update-match', [FootballController::class, 'updateMatch']);
    Route::post('/api/football/update-match', [FootballController::class, 'updateMatch']);
    
    //Route::post('/football/place-bet', [FootballController::class, 'placeFootballBet']); 

           
    
    Route::get('/football/matches', [FootballController::class, 'getMatches']);           
    Route::get('/api/football/matches', [FootballController::class, 'getMatches']);                    
    
    Route::get('/football/league-matches', [FootballController::class, 'getLeagueMatches']);  
    Route::get('/api/football/league-matches', [FootballController::class, 'getLeagueMatches']);  
    
    // 2D Lottery Routes              
    Route::get('/admin/2d-user-bets', [TwoDController::class, 'getAdminTwoDBets']);
    Route::post('/admin/2d-user-bets/update', [TwoDController::class, 'update2DBetStatus']);                      
    //Route::get('/twod/history', [TwoDController::class, 'getTwoDHistory']);                
    Route::post('/twod/declare-result', [TwoDController::class, 'declareTwoDResult']);
    Route::post('/api/twod/declare-result', [TwoDController::class, 'declareTwoDResult']);
    Route::post('/twod/session-settings/update', [TwoDController::class, 'updateSessionSettings']); 
    Route::post('/api/admin/2d-session-settings', [TwoDController::class, 'updateSessionSettings']);
    Route::get('api/twod/session-statuses', [ConfigController::class, 'getSessionStatus']);
    Route::post('/twod/session-statuses', [ConfigController::class, 'updateSessionStatus']); 

    // Configurations & Status Routes    
    //Route::get('/config/session-status', [ConfigController::class, 'getSessionStatus']);       
    Route::post('/config/session-status/update', [ConfigController::class, 'updateSessionStatus']);
    Route::get('/config/payment', [ConfigController::class, 'getPaymentConfig']);
    Route::post('/config/payment/update', [ConfigController::class, 'updatePaymentConfig']);
    Route::get('/config/timer', [ConfigController::class, 'getTimerConfig']);
    Route::post('/config/timer/update', [ConfigController::class, 'updateTimerConfig']);
    
    // Dashboard & Special Feature Routes
    Route::get('/admin/dashboard', [AdminController::class, 'getDashboardData']);         
    Route::post('/admin/trigger-lucky-draw', [AdminController::class, 'triggerLuckyDraw']);
    
});