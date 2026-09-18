<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    protected $fillable = ['league_name', 'teams'];

    protected $casts = [
        'teams' => 'array', // teams ကို Array အဖြစ် အလိုအလျောက် ပြောင်းပေးရန်
    ];
}