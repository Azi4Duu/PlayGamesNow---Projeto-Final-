<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showDashboard(){
        $users=count(User::all());
        $games=count(Game::all());
        return view('admin.dashboard',compact('users' , 'games'));
    }
}
