<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)
            ->times(10)
            ->make()
            ->makeVisible(['password', 'remember_token'])
            ->toArray();

        User::query()->insert($users);

        $user = User::query()->find(1);
        $user->email = 'jiawei_chai@126.com';
        $user->name = 'cjw';
        $user->save();
    }
}
