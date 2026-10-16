<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GamePlatformResource;
use App\Models\GamePlatform;
use Illuminate\Http\Request;

class GamePlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = GamePlatform::with('game', 'platform')->where('active', true);

        if($request->filled('search')) {
            $query->whereHas('game', function ($q) use ($request) {
               $q->where('title', 'like', '%' . $request->search . '%');
            });
        }

        if($request->filled('platform')) {
            $query->where('platform_id', $request->platform);
        }

        if($request->filled('category')) {
            $query->whereHas('game.categories', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        $gamePlatforms = $query->get();

        return GamePlatformResource::collection($gamePlatforms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GamePlatform $gamePlatform)
    {
        $gamePlatform->load(['game', 'platform']);
        return new GamePlatformResource($gamePlatform);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
