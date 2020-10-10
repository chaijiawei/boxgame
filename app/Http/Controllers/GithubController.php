<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function login()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();

        $githubId = $githubUser->getId();
        $user = User::query()->where('github_id', $githubId)->first();
        if(! $user) {
            $user = User::query()->create([
                'name' => $githubUser->getNickname(),
                'github_id' => $githubId,
            ]);
        }

        Auth::login($user, true);
        return redirect('/');
    }
}
