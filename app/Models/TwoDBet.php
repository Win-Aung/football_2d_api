<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


    class TwoDBet extends Model
{
    protected $table = 'twod_bets';

    protected $fillable = [
        'userId',
        'userName',
        'session',
        'bets',
        'total_amount',
        'number',
        'amount',
        'status',
        'open_time',
        'close_time',
        'time',
        'isArchived',
        'is_open',
    ];

    protected $casts = [
        'bets' => 'array', // JSON ကို Array အဖြစ် အလိုအလျောက် ပြောင်းပေးရန်
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}

