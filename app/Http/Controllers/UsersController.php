<?php
/*
 * @Author: DanceLynx
 * @Description: 用户控制器
 * @Date: 2020-06-21 14:48:50
 */

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $userRequest, User $user, ImageUploadHandler $imageUploadHandler)
    {
        $this->authorize('update', $user);
        $data = $userRequest->all();
        if ($userRequest->avatar) {
            $result = $imageUploadHandler->save($userRequest->avatar, 'avatars', $user->id, 200);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return response()->redirectToRoute('users.show', $user->id)->with('success', '修改成功');
    }
}
