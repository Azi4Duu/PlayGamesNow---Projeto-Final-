<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function show(Request $request){

        return new UserResource($request->user());
    }

    public function update(Request $request){
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => new UserResource($user)
        ]);
    }

    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if(!Hash::check($request->current_password, $user->password)){
            throw ValidationException::withMessages(['current_password' => ['Your current password is incorrect.']]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }
}
