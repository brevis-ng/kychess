<?php

namespace App\Traits;

use App\Models\Log;

/**
 * Operating log
 */
trait Logable
{
    public function logable_relationship()
    {
        return $this->morphMany(Log::class, 'logable');
    }

    public static function createLog($model, $event)
    {
        if ( auth()->guest() ) {
            return;
        }

        $user = auth()->user();

        // $instance = app( App\Model\User::class );
        // if ( ! ($user instanceof $instance) ) {
        //     return;
        // }

        $model->logable_relationship()->create([
            'user_id' => $user->id,
            'type' => $event,
            'old_data' => $model->getOriginal(),
            'new_data' => $model,
        ]);
    }

    protected static function bootLogable()
    {
        self::created(function($model) {
            self::createLog($model, 'create');
        });    
    
        self::updated(function($model) {
            self::createLog($model, 'edit');
        });    
    
        self::deleted(function($model) {
            self::createLog($model, 'delete');
        });
    }
}
