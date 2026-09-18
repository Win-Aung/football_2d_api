<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballMatch extends Model
{
    use HasFactory;

    protected $table = 'football_matches';
    

    // 🟢 Mass Assignment အလုပ်လုပ်ရန် ဤသို့ ထည့်ပေးပါ
    protected $guarded = []; 
}