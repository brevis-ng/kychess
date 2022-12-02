<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pid',
        'title',
        'icon',
        'href',
        'target',
        'level',
        'status',
        'action',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * Get the permission's title.
     *
     * @param  string  $value
     * @return string
     */
    public function getTitleAttribute($value)
    {
        return trans('home.' . $value);
    }

    /**
     * The roles that belong to the permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public const VIEWANY = 'permission.viewAny';
    public const VIEW = 'permission.view';
    public const CREATE = 'permission.create';
    public const UPDATE = 'permission.update';
    public const DESTROY = 'permission.destroy';
}
