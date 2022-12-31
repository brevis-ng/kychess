<?php

namespace App\Models;

use App\Traits\Logable;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, Logable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'menu',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'menu' => AsArrayObject::class,
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The permissons that belong to the role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Get the role's menu be translated.
     *
     * @param  string  $value
     * @return string
     */
    public function getMenuAttribute($value)
    {
        $value = json_decode($value, true);

        foreach ( $value['menuInfo'] as $key => $menu ) {
            $value['menuInfo'][$key]['title'] = trans('home.' . $menu['title']);
            if ( array_key_exists('child', $menu) ) {
                foreach ( $menu['child'] as $key1 => $child ) {
                    $value['menuInfo'][$key]['child'][$key1]['title'] = trans('home.' . $child['title']);
                    if ( array_key_exists('child', $child) ) {
                        foreach ($child['child'] as $key2 => $item) {
                            $value['menuInfo'][$key]['child'][$key1]['child'][$key2]['title'] = trans('home.' . $item['title']);
                        }
                    }
                }
            }
        }

        return $value;
    }

    public const VIEWANY = 'roles.viewAny';
    public const VIEW = 'roles.view';
    public const CREATE = 'roles.create';
    public const UPDATE = 'roles.update';
    public const DESTROY = 'roles.destroy';
}
