<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class EnsureUserIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($this->canCheckUrl() &&
            $user &&
            ! $this->isGithubUser($user) &&
            ! $this->isVerifiedEmail($user)
            ) {
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::route('verification.notice');
        }

        return $next($request);
    }

    protected function isVerifiedEmail($user)
    {
        return $user instanceof MustVerifyEmail &&
                $user->hasVerifiedEmail();
    }

    protected function canCheckUrl()
    {
        $noCheckUrls = [
            'admin',
            'admin/*',
            'email/*',
            'logout',
        ];
        return ! Request::is($noCheckUrls);
    }

    protected function isGithubUser($user)
    {
        return !empty($user->github_id);
    }
}
