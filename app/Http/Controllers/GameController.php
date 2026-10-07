<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Game;
use App\Models\GamePlatform;
use App\Models\Platform;
use App\Models\Publisher;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Game::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('publisher')) {
            $query->where('publisher_id', $request->publisher);
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        if ($request->filled('platform')) {
            $query->whereHas('gamePlatforms', function ($q) use ($request) {
                $q->where('platform_id', $request->platform);
            });
        }

        $games = $query->get();

        $publishers = Publisher::all();
        $categories = Category::all();
        $platforms = Platform::all();

        foreach ($games as $game) {
            if ($game->image_path) {
                $game->display_image = asset($game->image_path);
            }
            elseif ($game->image_url) {
                $game->display_image = $game->image_url;
            }
            else{
                $game->display_image = null;
            }
        }

        return view('admin.games.index', compact('games', 'publishers', 'categories', 'platforms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $publishers = Publisher::all();
        $platforms = Platform::all();
        return view('admin.games.create', compact('publishers', 'platforms', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255|unique:games,title',
            'publisher_id' => 'required',
            'release_date' => 'required|date',
            'description' => 'required',
            'image_url' => 'nullable|url',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'platforms' => 'required|array',
            'platforms.*.price' => 'nullable|numeric|min:0',
            'platforms.*.old_price' => 'nullable|numeric|min:0',
        ];

        $request->validate($rules);

        $hasSelectedPlatform = false;

        foreach ($request->platforms as $platform) {
            if (isset($platform['selected'])) {
                $hasSelectedPlatform = true;
                break;
            }
        }

        if (!$hasSelectedPlatform) {
            return back()
                ->withErrors([
                    'platforms' => 'Please select at least one platform.'
                ])
                ->withInput();
        }

        foreach ($request->platforms as $platform) {
            if (isset($platform['selected']) && (!isset($platform['price']) || $platform['price'] === '')){
                return back()->withErrors(['platforms' => 'Selected platforms must have a price.'])->withInput();
            }
        }

        $game = Game::create([
            'title' => $request->title,
            'publisher_id' => $request->publisher_id,
            'release_date' => $request->release_date,
            'description' => $request->description,
            'image_url' => $request->image_url,
        ]);

        $game->categories()->sync($request->categories);

        foreach ($request->platforms as $platformId => $platform) {
            if(isset($platform['selected'])){
                GamePlatform::create([
                    'game_id' => $game->id,
                    'platform_id' => $platformId,
                    'price' => $platform['price'],
                    'old_price' => $platform['old_price'] ?? null,
                    'active' => true,
                ]);
            }
        }

        return redirect()->route('admin.games.index')->with('success', 'Game created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $publishers = Publisher::all();
        $platforms = Platform::all();
        $categories = Category::all();
        return view('admin.games.edit', compact('game', 'publishers', 'platforms', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $rules = [
            'title' => 'required|max:255|unique:games,title,' . $game->id,
            'publisher_id' => 'required',
            'release_date' => 'required|date',
            'description' => 'required',
            'image_url' => 'nullable|url',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'platforms' => 'required|array',
            'platforms.*.price' => 'nullable|numeric|min:0',
            'platforms.*.old_price' => 'nullable|numeric|min:0'
        ];

        $request->validate($rules);

        foreach ($request->platforms as $platform) {
            if (isset($platform['selected']) && (!isset($platform['price']) || $platform['price'] === '')){
                return back()->withErrors(['platforms' => 'Selected platforms must have a price.'])->withInput();
            }
        }

        $game->update([
            'title' => $request->title,
            'publisher_id' => $request->publisher_id,
            'release_date' => $request->release_date,
            'description' => $request->description,
            'image_url' => $request->image_url,
        ]);

        $game->categories()->sync($request->categories);

        foreach ($request->platforms as $platformId => $platform) {
            if (isset($platform['selected'])) {
                $gamePlatform = GamePlatform::withTrashed()
                    ->where('game_id', $game->id)
                    ->where('platform_id', $platformId)
                    ->first();

                if ($gamePlatform) {
                    if ($gamePlatform->trashed()) {
                        $gamePlatform->restore();
                    }

                    $gamePlatform->update([
                        'price' => $platform['price'],
                        'old_price' => $platform['old_price'] ?? null,
                        'active' => true,
                    ]);
                } else {
                    GamePlatform::create([
                        'game_id' => $game->id,
                        'platform_id' => $platformId,
                        'price' => $platform['price'],
                        'old_price' => $platform['old_price'] ?? null,
                        'active' => true,
                    ]);
                }

            } else {

                GamePlatform::where('game_id', $game->id)
                    ->where('platform_id', $platformId)
                    ->delete();
            }
        }

        return redirect()->route('admin.games.index')->with('success', 'Game updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games.index')->with('success', 'Game deleted successfully');
    }

    public function trashed(Request $request){

        $query = Game::onlyTrashed();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('publisher')) {
            $query->where('publisher_id', $request->publisher);
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        if ($request->filled('platform')) {
            $query->whereHas('gamePlatforms', function ($q) use ($request) {
                $q->where('platform_id', $request->platform);
            });
        }

        $games = $query->get();

        foreach ($games as $game) {
            if ($game->image_path) {
                $game->display_image = asset($game->image_path);
            }
            elseif ($game->image_url) {
                $game->display_image = $game->image_url;
            }
            else{
                $game->display_image = null;
            }
        }

        $categories = Category::all();
        $publishers = Publisher::all();
        $platforms = Platform::all();

        return view('admin.games.trashed', compact('games', 'categories', 'publishers', 'platforms'));
    }

    public function restore($id){
        $game = Game::onlyTrashed()->findOrFail($id);
        $game->restore();
        return redirect()->route('admin.games.trashed')->with('success', 'Game restored successfully');
    }
}
