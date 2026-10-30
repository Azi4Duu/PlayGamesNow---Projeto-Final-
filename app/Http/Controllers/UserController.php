<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if($request->search){
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if($request->role){
            $query->where('role', $request->role);
        }

        if($request->filled('active')){
            $query->where('active', $request->active);
        }

        $users = $query->orderByRaw('id = ? DESC', [auth()->id()])->latest()->paginate(6)->withQueryString();

        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'active' => 'required'
        ];
        $messages = [
            'name.required' => 'Name is required.',
            'username.required' => 'Username is required.',
            'username.unique' => 'Username is already taken.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email.',
            'email.unique' => 'Email already exists.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'role.required' => 'Role is required.',
            'active.required' => 'Active is required.',
        ];
        $request->validate($rules, $messages);
        if($user=User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'active' => $request->active
        ])){
            $user->assignRole($user->role);
            $user->sendEmailVerificationNotification();
            return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
        }
        return back()->withInput(['name', 'username', 'email'])->with('error', 'Something went wrong while creating the user.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $userauth=auth()->user();
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles' , 'userauth'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $userauth=auth()->user();

        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username,'. $user->id,
            'email' => 'required|email|unique:users,email,'. $user->id,
        ];
        $messages = [
            'name.required' => 'Name is required.',
            'username.required' => 'Username is required.',
            'username.unique' => 'Username is already taken.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email.',
            'email.unique' => 'Email already exists.',
        ];

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        if($userauth->id != $user->id){

            $rules['role'] = 'required';
            $rules['active'] = 'required';

            $messages['role.required'] = 'Role is required.';
            $messages['active.required'] = 'Active is required.';

            $data['role'] = $request->role;
            $data['active'] = $request->active;
        }

        if($userauth->id == $user->id){
            $rules['password'] = 'nullable|min:6|confirmed';

            $messages['password.min'] = 'Password must be at least 6 characters.';
            $messages['password.confirmed'] = 'Password confirmation does not match.';
        }

        $request->validate($rules, $messages);

        if($userauth->id == $user->id && $request->filled('password')){
            $data['password'] = Hash::make($request->password);
        }
        if($user->update($data)){
            if ($userauth->id != $user->id) {
                $user->syncRoles([$request->role]);
            }
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
        }
        return back()->withInput(['name', 'username', 'email'])->with('error', 'Something went wrong while updating the user.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function trashed(Request $request){
        $query = User::onlyTrashed();

        if($request->search){
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if($request->role){
            $query->where('role', $request->role);
        }

        if($request->filled('active')){
            $query->where('active', $request->active);
        }

        $users = $query->latest('deleted_at')->paginate(6)->withQueryString();

        $roles = Role::all();

        return view('admin.users.trashed', compact('users', 'roles'));
    }

    public function restore($id){
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.users.trashed')->with('success', 'User restored successfully.');
    }
}
