<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $matches;

    public function __construct($matches)
    {
        $this->matches = $matches;
    }

    public function broadcastOn()
    {
        return new Channel('football-channel');
    }
}