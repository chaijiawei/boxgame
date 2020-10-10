<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMap extends Model
{
    protected $fillable = [
        'level', 'map_data'
    ];

    protected $casts = [
        'map_data' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function(GameMap $gameMap) {
            if( $gameMap->level &&
                $gameMap->isDirty('level') &&
                static::query()
                ->where('level', $gameMap->level)
                ->where('id', '<>', $gameMap->id)
                ->exists()) {
                abort(403, '关卡已经存在');
            }
        });
    }
}
