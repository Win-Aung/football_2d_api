<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

  public function register(Request $request)
   {
       try {
           // PHP ဖိုင်ထဲကအတိုင်း လိုအပ်သော input များကို ယူမည်[cite: 3, 37]
           $name = $request->input('name') ?? $request->input('username');
           $phone = $request->input('phone');
           $pass = $request->input('pass') ?? $request->input('password');
           $payment = $request->input('payment') ?? 'KBZPay';

           // အချက်အလက်အားလုံး ဖြည့်စွက်ထားခြင်း ရှိမရှိ စစ်ဆေးခြင်း[cite: 3, 37]
           if (empty($name) || empty($phone) || empty($pass)) {
               return response()->json([
                   "status" => "error", 
                   "message" => "အချက်အလက်အားလုံး ဖြည့်စွက်ပေးပါ။"
               ], 200);
           }

           // ဖုန်းနံပါတ် ရှိပြီးသားလား စစ်ဆေးခြင်း[cite: 3, 37]
           $existingUser = User::where('phone', $phone)->first();
           if ($existingUser) {
               return response()->json([
                   "status" => "error", 
                   "message" => "ဤဖုန်းနံပါတ်ဖြင့် အကောင့်ဖွင့်ပြီးသား ဖြစ်ပါသည်။"
               ], 200);
           }

           // User အသစ်ဖန်တီးခြင်း (balance ကို 0.00 ဖြင့် သတ်မှတ်သည်၊ pass ကို Hash ဖြင့် သိမ်းမည်)[cite: 2, 3, 37]
           $user = User::create([
               'name' => $name,
               'phone' => $phone,
               'pass' => Hash::make($pass), 
               'balance' => 0.00,
               'payment' => $payment,
           ]);

           // Sanctum Token ထုတ်ပေးခြင်း[cite: 2, 37]
           $token = $user->createToken('auth_token')->plainTextToken;

           return response()->json([
               'status' => 'success', 
               'message' => 'Registration Successful',
               'user' => $user, 
               'token' => $token
           ], 200);

       } catch (\Exception $e) {
           return response()->json([
               'status' => 'error',
               'message' => 'Error: ' . $e->getMessage()
           ], 200); 
       }
   }

   public function login(Request $request)
{
    // Flutter မှ username သို့မဟုတ် phone ဖြင့် ပို့လာသည်များကို လက်ခံခြင်း[cite: 37]
    $phone = $request->input('username') ?? $request->input('phone');
    $pass = $request->input('password') ?? $request->input('pass');

    if (empty($phone) || empty($pass)) {
        return response()->json([
            'status' => 'error',
            'message' => 'အချက်အလက် မပြည့်စုံပါ။'
        ], 200);
    }
    

    // Phone ဖြင့် User ရှာမည်[cite: 37]
    $user = User::where('phone', $phone)->first();

    if ($user) {
        // Table ထဲရှိ Hash လုပ်ထားသော pass နှင့် ဝင်လာသော pass ကို Hash::check ဖြင့် စစ်ဆေးမည်[cite: 37]
        if (Hash::check($pass, $user->pass) || ($user->pass === $pass) || (isset($user->password) && Hash::check($pass, $user->password))) {
            
            // Sanctum Token ထုတ်ပေးခြင်း[cite: 37]
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'user' => $user,
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Password မှားယွင်းနေပါသည်'
            ], 200);
        }
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'ဤအကောင့် မရှိပါ။'
        ], 200);
    }
}
}