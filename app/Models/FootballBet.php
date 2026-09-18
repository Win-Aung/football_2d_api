<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballBet extends Model
{
    use HasFactory;

    protected $table = 'gamefootball_bits';

    protected $fillable = [
        'user_doc_id',
        'bet_type',
        'match_id',
        'home_team',
        'goal_total',
        'away_team',
        'selected_option',
        'amount',
        'win_amount',
        'lost',
        'status',
        'created_at',
        
    ];
}