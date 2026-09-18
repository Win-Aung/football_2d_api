<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    // Model guarded မလုပ်ရန်
    protected $guarded = [];

    // Table ထဲတွင် created_at, updated_at မပါပါက false လုပ်ပေးရပါမည်
    public $timestamps = false;

    // Laravel default password column အစား pass column ကို သုံးရန်
    public function getAuthPassword()
    {
        return $this->pass;
    }
    public function dashboard()
    {
        $users = User::all(); // သို့မဟုတ် လိုအပ်သော query
        return view('welcome', compact('users'));
    }
}