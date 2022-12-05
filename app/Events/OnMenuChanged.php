<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OnMenuChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The id of permission be changed
     * 
     * @var int|null
     */
    public $permission_id;

    /**
     * The id of role be changed
     * 
     * @var int|null
     */
    public $role_id;

    /**
     * Create a new event instance.
     *
     * @param int|null $permission_id
     * @param int|null $role_id
     * 
     * @return void
     */
    public function __construct($permission_id = null, $role_id = null)
    {
        $this->permission_id = $permission_id;
        $this->role_id = $role_id;
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
