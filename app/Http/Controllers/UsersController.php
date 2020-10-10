<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(User $user, UsersRequest $request, ImageUploadHandler $imageUploadHandler)
    {
        $data = $request->validated();
        if(isset($data['avatar']) && $data['avatar']) {
            $data['avatar'] = $imageUploadHandler->save($data['avatar'], 'avatars', $user->id, 200);
        }

        $user->update($data);
        return redirect('/')->with('success', '更新成功');
    }
}
