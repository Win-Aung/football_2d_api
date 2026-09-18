<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoDResult extends Model
{
    use HasFactory;

    protected $table = 'twod_results';
    public $timestamps = false;
    protected $guarded = [];
}