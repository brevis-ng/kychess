<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'activity_id',
        'data',
        'bonus',
        'ip_address',
        'feedback',
        'status',
        'handler_id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => AsArrayObject::class,
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the handler that handle the ticket.
     */
    public function handler()
    {
        return $this->belongsTo(User::class, 'handler_id');
    }

    /**
     * Get the handler that handle the ticket.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public const VIEWPENDING = 'tickets.viewPending';
    public const VIEWAUDITED = 'tickets.viewAudited';
    public const VIEWCHART = 'tickets.viewChart';
    public const UPDATE = 'tickets.update';
    public const pending = 'pendding';
    public const ACCEPTED = 'accepted';
    public const REJECTED = 'rejected';
}
