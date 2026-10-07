<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(){
        $user = auth()->user();
        $names = explode(' ', trim($user->name));
        if(count($names) > 1){
            $initials = strtoupper(substr($names[0], 0,1).substr($names[count($names) - 1], 0,1));
        }
        else{
            $initials = strtoupper(substr($names[0], 0,1));
        }
        return view('profile.index', compact('user', 'initials', 'names'));
    }

    public function edit(){
        $user= auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request){
        $user= auth()->user();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' .$user->id,
            'username' => 'required|unique:users,username,'.$user->id,
        ];
        $messages = [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email is invalid',
            'username.required' => 'Username is required',
            'username.unique' => 'Username already exists',
        ];
        $request->validate($rules, $messages);

        if($user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username]))
        {
            return redirect()->route('customer.profile.show')->with('success', 'Profile updated successfully');
        }
        return back()->withInput();
    }

    public function changePassword(){
        return view('profile.change-password');
    }

    public function updatePassword(Request $request){
        $user= auth()->user();
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
        $messages = [
            'current_password.required' => 'Current Password is required',
            'new_password.required' => 'New Password is required',
            'new_password.min' => 'New Password must be at least 6 characters',
            'confirm_password.required' => 'Confirm Password is required',
            'confirm_password.same' => 'Confirm Password and Password does not match',
        ];

        $request->validate($rules, $messages);

        if(Hash::check($request->current_password, $user->password)){
            $user->update(['password' => Hash::make($request->new_password)]);
            return redirect()->route('customer.profile.show')->with('success', 'Password updated successfully');
        }

        return back()->withErrors([
            'current_password' => 'Current Password is incorrect',
        ]);
    }
}
