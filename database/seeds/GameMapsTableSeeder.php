<?php

use Illuminate\Database\Seeder;
use App\Models\GameMap;

class GameMapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = factory(GameMap::class)->times(100)->make();
        GameMap::query()->insert($data->toArray());
    }
}
