<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'unique:users,username', 'min:4', 'max:32'],
            'password' => ['required', 'min:8']
        ]);

        $user = User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password'])
        ]);

        return response([
                'result' => 'Registration successful.',
                'token' => $user->createToken($data['username'])->plainTextToken
        ]);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => ['sometimes', 'unique:users,username', 'min:4', 'max:32'],
            'password' => ['sometimes', 'min:8']
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response(["result" => "User was successfully updated."]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response(["result" => "User was successfully deleted."]);
    }
}
