<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OnChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The type of activity
     * 
     * @var string|null 
     */
    public $type;

    /**
     * The description of activity
     * 
     * @var string|null 
     */
    public $description;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($type, $desc)
    {
        $this->type = $type;
        $this->description = $desc;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
