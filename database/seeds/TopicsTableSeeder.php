<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::all()->modelKeys();
        $categoryIds = Category::all()->modelKeys();
        $topics = factory(Topic::class)
            ->times(1000)
            ->make()
            ->each(function($topic) use ($userIds, $categoryIds) {
                $topic->user_id = Arr::random($userIds);
                $topic->category_id = Arr::random($categoryIds);
            })
            ->toArray();

        Topic::query()->insert($topics);
    }
}
