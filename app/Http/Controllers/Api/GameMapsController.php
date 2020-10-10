<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameMap;
use App\Http\Resources\GameMapResource;

class GameMapsController extends Controller
{
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'map_data'  => ['required', 'json'],
        ]);
        $data['map_data'] = json_decode($data['map_data'], true);

        $gameMap = GameMap::query()->create($data);

        return new GameMapResource($gameMap);
    }

    public function show(GameMap $gameMap)
    {
        return new GameMapResource($gameMap);
    }

    public function level($level)
    {
        $gameMap = GameMap::query()->where('level', $level)->firstOrFail();

        return new GameMapResource($gameMap);
    }
}
