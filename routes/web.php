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
Route::post('/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    // Admin စစ်ဆေးခြင်း
    if ($username === 'admin' && $password === 'admin123') {
        $adminUser = User::where('email', 'admin123@gmail.com')->first();

        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Admin',
                'email' => 'admin123@gmail.com',
                'password' => bcrypt('admin123'), // Hash ဖြင့်သိမ်းရန် (သို့) Plain text
            ]);
        }

        $token = $adminUser->createToken('admin_token')->plainTextToken;

        session([
            'is_logged_in' => true,
            'auth_token' => $token
        ]);

        return redirect()->route('welcome');
    }

    return back()->with('error', 'Username သို့မဟုတ် Password မှားယွင်းနေပါသည်။');
})->name('login.post');

// ၄. Login ဝင်ပြီးမှသာ ကြည့်လို့ရမည့် Welcome / Dashboard Page
Route::get('/welcome', function () {
    if (!session('is_logged_in')) {
        return redirect()->route('login');
    }
    
    $users = User::all();
    return view('welcome', compact('users')); 
})->name('welcome');

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