<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameKey;
use App\Models\GamePlatform;
use Illuminate\Http\Request;

class GameKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = GameKey::query();

        if($request->filled('game')){
            $query->whereHas('gamePlatform', function($query) use($request){
                $query->where('game_id', $request->game);
            });
        }

        if($request->filled('status')){
            $query->where('status', $request->status);
        }

        $keys = $query->latest()->get();

        $games = Game::orderBy('title')->get();

        return view('admin.keys.index', compact('keys', 'games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gamePlatforms = GamePlatform::with(['game', 'platform'])
            ->where('active', true)
            ->whereHas('game')
            ->whereHas('platform')
            ->get();

        return view('admin.keys.create', compact('gamePlatforms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'game_platform_id' => 'required|exists:game_platforms,id',
            'code' => 'required|max:255|unique:game_keys,code',
        ];

        $request->validate($rules);

        GameKey::create([
            'game_platform_id' => $request->game_platform_id,
            'code' => $request->code,
            'status' => 'available',
        ]);

        return redirect()->route('admin.keys.index')->with('success', 'Game key created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GameKey $key)
    {
        if($key->status != 'available' && $key->status != 'revoked') {
            return back()->with('error', 'Only available or revoked game keys can be edited.');
        }

        $gamePlatforms = GamePlatform::with(['game', 'platform'])
            ->where('active', true)
            ->whereHas('game')
            ->whereHas('platform')
            ->get();

        return view('admin.keys.edit', compact('gamePlatforms', 'key'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GameKey $key)
    {
        if($key->status != 'available' && $key->status != 'revoked') {
            return back()->with('error', 'Only available or revoked game keys can be edited.');
        }

        $rules = [
            'game_platform_id' => 'required|exists:game_platforms,id',
            'code' => 'required|max:255|unique:game_keys,code,' .$key->id,
            'status' => 'required|in:available,revoked',
        ];

        $request->validate($rules);

        $key->update([
            'game_platform_id' => $request->game_platform_id,
            'code' => $request->code,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.keys.index')->with('success', 'Game key updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameKey $key)
    {
        if($key->status != 'available'){
            return back()->with('error', 'This key cannot be deleted.');
        }

        $key->delete();
        return redirect()->route('admin.keys.index')->with('success', 'Game key deleted.');
    }

}
