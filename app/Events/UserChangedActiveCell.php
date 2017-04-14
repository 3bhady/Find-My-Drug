<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Event;

class UserChangedActiveCell  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rowIndex;
    public $columnIndex;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($rowIndex,$columnIndex)
    {
        $this->$rowIndex=$rowIndex;
        $this->$columnIndex=$columnIndex;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['clicked-cell-channel'];
       // return new PrivateChannel('channel-name');
    }
}
