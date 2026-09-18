<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // get_user_info.php
    public function getUserInfo(Request $request)
    {
        $userId = $request->input('user_id');
        if (!empty($userId)) {
            $user = User::find($userId);
            if ($user) {
                return response()->json(['status' => 'success', 'user' => $user]);
            }
        }
        return response()->json(['status' => 'success', 'user' => $request->user()]);
    }

    // get_users.php
  public function getUsers()
{
    $users = User::select('id', 'name', 'phone', 'balance', 'payment')
                 ->orderBy('id', 'DESC')
                 ->get();
                 
    return response()->json($users, 200, [], JSON_UNESCAPED_UNICODE);
}

    // update_user.php
    // update_user.php
    public function updateUser(Request $request)
    {
        $userId = $request->input('userId') ?? $request->input('id');
        $name = $request->input('name');
        $phone = $request->input('phone');
        $pass = $request->input('pass');
        $balance = $request->input('balance', 0);
        $payment = $request->input('payment', 'KBZPay');

        if (!empty($userId)) {
            $user = User::find($userId);
            if ($user) {
                $data = [
                    'name' => $name,
                    'phone' => $phone,
                    'balance' => $balance,
                    'payment' => $payment,
                ];

                if (!empty($pass)) {
                    $data['pass'] = $pass; 
                }

                $user->update($data);

                return response()->json(["status" => "success"], 200, [], JSON_UNESCAPED_UNICODE);
            }
        }

        return response()->json(["status" => "error", "message" => "User not found"], 404);
    }

    // delete_user.php
    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->delete();

        return response()->json(['status' => 'success', 'message' => 'User deleted successfully']);
    }
}