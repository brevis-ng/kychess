<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'forms',
        'poster',
        'content',
        'sort',
        'repeatable',
        'repetition_name',
        'active',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'repeatable' => 'boolean',
        'active' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the tickets for the activity.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public const VIEWANY = 'activity.viewAny';
    public const VIEW = 'activity.view';
    public const CREATE = 'activity.create';
    public const UPDATE = 'activity.update';
    public const DESTROY = 'activity.destroy';
}
