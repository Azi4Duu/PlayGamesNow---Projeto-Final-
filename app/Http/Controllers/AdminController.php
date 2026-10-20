<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showDashboard(){
        $users = count(User::all());
        $games = count(Game::all());
        $sales = count(Sale::all());

        $revenue = Sale::where('status', 'paid')->sum('total');

        $recentSales = Sale::with('user')->latest()->take(6)->get();

        return view('admin.dashboard',compact('users' , 'games', 'sales', 'revenue', 'recentSales'));
    }
}
