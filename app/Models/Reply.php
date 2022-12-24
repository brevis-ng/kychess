<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'created_at',
        'updated_at'
    ];

    public const VIEWANY = 'reply.viewAny';
    public const VIEW = 'reply.view';
    public const CREATE = 'reply.create';
    public const UPDATE = 'reply.update';
    public const DESTROY = 'reply.destroy';
}
