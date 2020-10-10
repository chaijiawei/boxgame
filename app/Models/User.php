<?php

namespace App\Models;

use App\Handlers\ImageUploadHandler;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'github_id', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute($value)
    {
        if(! $value) {
            $value = asset('images/avatar.jpg');
        }

        if(! URL::isValidUrl($value)) {
            $value = Storage::disk('public')->url($value);
        }

        return $value;
    }

    public function setAvatarAttribute($value)
    {
        if(Str::startsWith($value, 'images')) {
            (new ImageUploadHandler())->resizeImg($value, 200, config('admin.upload.disk'));
        }
        $this->attributes['avatar'] = $value;
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
