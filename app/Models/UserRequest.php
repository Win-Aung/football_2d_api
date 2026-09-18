<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{

    //protected $table = 'user_requests';
    //public $timestamps = false;
    //protected $guarded = [];

    protected $table = 'payment_requests';

    protected $fillable = [
        'userId',
        'userName',
        'phone',
        'payment',
        'type',
        'amount',
        'transactionId',
        'status',
        'time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}