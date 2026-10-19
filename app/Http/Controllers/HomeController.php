<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GamePlatform;
use App\Models\Platform;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $trendingGames = GamePlatform::with(['game.categories', 'platform'])->withSum([
           'saleItems as recent_sales' => function ($query) {
            $query->whereHas('sale', function ($q) {
                $q->where('status', 'paid')->where('created_at', '>=', now()->subDays(30));
            });
           }
        ], 'quantity')->where('active', true)
        ->orderByDesc('recent_sales')
        ->take(4)
        ->get();

        $featuredGame = GamePlatform::with(['game', 'platform'])
            ->where('active', true)
            ->whereHas('gameKeys', function ($query) {
                $query->where('status', 'available');
            })
            ->whereNotNull('old_price')
            ->whereColumn('old_price', '>', 'price')
            ->first();

        if ($featuredGame) {
            $featuredGame->discount_percentage = round(
                (($featuredGame->old_price - $featuredGame->price) / $featuredGame->old_price) * 100
            );
        }

        $bestSellers = GamePlatform::with(['game', 'platform'])
            ->withSum([
                'saleItems as total_sales' => function ($query) {
                    $query->whereHas('sale', function ($q) {
                        $q->where('status', 'paid');
                    });
                }
            ], 'quantity')
            ->where('active', true)
            ->orderByDesc('total_sales')
            ->take(6)
            ->get();

        $topCategories = Category::with(['games' => function ($query) {
            $query->take(1);
        }])
            ->withCount('games')
            ->orderByDesc('games_count')
            ->take(5)
            ->get();

        $topPlatforms = Platform::withCount('gamePlatforms')
            ->orderByDesc('game_platforms_count')
            ->take(4)
            ->get();

        return view('home', compact('trendingGames', 'featuredGame', 'bestSellers', 'topCategories', 'topPlatforms'));
    }
}
