<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\TwodController;


// ၁။ Login စာမျက်နှာအတွက် GET Route
Route::get('/login', function () {
    if (session('is_logged_in')) {
        return redirect()->route('welcome');
    }
    return view('auth.login');
})->name('login');

// ၂။ Register Screen အသစ်အတွက် GET Route (Flutter ဖိုင်မှပြောင်းထားသော view)
Route::get('/register-screen', function () {
    return view('auth.register_screen');
})->name('register.screen');

// မူလ Home ( / ) အတွက်
Route::get('/', function () {
    if (session('is_logged_in')) {
        return redirect()->route('welcome');
    }
    return redirect()->route('login');
});


// ၃. Login Form မှ POST ဖြင့် တင်လိုက်လျှင် စစ်ဆေးရန်
Route::post('/admin/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    // .env ထဲက အချက်အလက်များနှင့် တိုက်စစ်ခြင်း
    if (($username === env('ADMIN_USER') || $username === env('ADMIN_EMAIL')) && $password === env('ADMIN_PASS')) {
        
        $adminUser = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'name' => 'Admin',
                'password' => bcrypt(env('ADMIN_PASS')),
                'phone' => '09' . rand(10000000, 99999999),
            ]
        );

        $token = $adminUser->createToken('admin_token')->plainTextToken;

        session([
            'is_logged_in' => true,
            'auth_token' => $token
        ]);

        return redirect()->route('admin.dashboard');
    }

    return back()->with('error', 'Username သို့မဟုတ် Password မှားယွင်းနေပါသည်။');
})->name('login.post');




Route::get('/welcome', function () {
    $users = User::all();
    return view('welcome', compact('users'));
})->name('welcome');

Route::get('/', function () {
    return redirect()->route('welcome');
});

Route::get('/admin/login', function () {
    if (session('is_logged_in')) {
        return redirect()->route('welcome');
    }
    return view('auth.login');
})->name('admin.login'); // Route name ကို admin.login သို့ ပြောင်းပါ

// မူလ Home ( / ) သို့မဟုတ် /login ဝင်လာပါက /admin/login သို့ ပို့ပေးရန်
Route::get('/login', function () {
    return redirect()->route('admin.login');
});
Route::get('/admin', function () {
    return redirect()->route('admin.login');
});

// Admin Dashboard (Login ဝင်ထားမှသာ ကြည့်လို့ရမည်၊ ကျော်ဝင်၍ မရပါ)
Route::get('/admin/dashboard', function () {
    if (!session('is_logged_in')) {
        return redirect()->route('admin.login');
    }

    $users = User::all();
    return view('admin.dashboard', compact('users'));
})->name('admin.dashboard');

Route::get('/game-home', function () {
    return view('game_home'); 
});

Route::get('/towd', function () {
    return view('two_d_screen'); 
})->name('towd');

Route::get('/football', function () {
    return view('football_screen'); 
})->name('football');

Route::get('/wallet', function () {
    return view('wallet_history'); 
})->name('wallet');

// Session Status Route ကို web.php တွင် ထည့်သွင်းပါ
Route::get('/config/session-status', [ConfigController::class, 'getSessionStatus']);

// ၅. Logout ထွက်ရန်
Route::match(['get', 'post'], '/logout', function (Request $request) {
    $request->session()->flush();
    return redirect()->route('login');
})->name('logout');

Route::match(['get', 'post'], '/logout', function (Request $request) {
    $request->session()->flush();
    return redirect()->route('admin.login');
})->name('logout');