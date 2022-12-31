<?php

namespace App\Models;

use App\Traits\Logable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory, Logable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'operator',
        'meta_key',
        'meta_value',
        'meta_desc',
        'created_at',
        'updated_at'
    ];

    public const SHORTCUT = 'shortcut.viewAny';
    public const LOG = 'log.viewAny';
    public const IPWHITELIST = 'whitelist.viewAny';
    public const ANNOUNCEMENT = 'announcement.viewAny';
}
