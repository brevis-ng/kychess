<?php

namespace App\Events;

use App\Models\Permission;
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
     * The affected roles
     * 
     * @var array|null $role_ids
     */
    public $role_ids = [];

    /**
     * Create a new event instance.
     *
     * @param int|array|null $permission_ids
     * @param int|array|null $role_ids
     * 
     * @return void
     */
    public function __construct($permission_ids, $role_ids)
    {
        if ( $permission_ids ) {
            $ids = is_array($permission_ids) ? $permission_ids : [$permission_ids];

            $records = Permission::whereIn('id', $ids)->whereIn('pid', $ids, 'or')->pluck('id')->toArray();
            $records = Permission::whereIn('id', $records)->whereIn('pid', $records, 'or')->get();

            foreach ( $records as $record ) {
                if ( $record->level < 1 ) { continue; }
                foreach ( $record->roles()->pluck('roles.id')->toArray() as $id ) {
                    if ( in_array($id, $this->role_ids) ) { continue; }
                    $this->role_ids[] = $id;
                }
            }
        } elseif ( $role_ids ) {
            $this->role_ids = is_array($role_ids) ? $role_ids : [$role_ids];
        }
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
