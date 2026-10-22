<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Platform::query();

        if($request->filled('search')){
            $query->where('platform_name', 'like', '%' . $request->search . '%');
        }

        $platforms = $query->latest()->paginate(6)->withQueryString();

        return view('admin.platforms.index', compact('platforms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'platform_name' => 'required|string|max:255|unique:platforms,platform_name',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $iconPath = null;

        if($request->hasFile('icon')){
            $iconPath = $request->file('icon')->store('platforms', 'public');
        }

        Platform::create([
            'platform_name' => $request->platform_name,
            'icon_path' => $iconPath,
        ]);

        return redirect()->route('admin.platforms.index')
            ->with('success', 'Platform created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Platform $platform)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Platform $platform)
    {
        return view('admin.platforms.edit', compact('platform'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Platform $platform)
    {
        $request->validate([
            'platform_name' => 'required|string|max:255|unique:platforms,platform_name,' . $platform->id,
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $iconPath = $platform->icon_path;

        if($request->hasFile('icon')){

            if($platform->icon_path){
                Storage::disk('public')->delete($platform->icon_path);
            }

            $iconPath = $request->file('icon')->store('platforms', 'public');
        }

        $platform->platform_name = $request->platform_name;
        $platform->icon_path = $iconPath;

        $platform->save();

        return redirect()->route('admin.platforms.index')
            ->with('success', 'Platform updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()->route('admin.platforms.index')
            ->with('success', 'Platform deleted successfully.');
    }

    public function trashed(Request $request)
    {
        $query = Platform::onlyTrashed();

        if($request->filled('search')){
            $query->where('platform_name', 'like', '%' . $request->search . '%');
        }

        $platforms = $query->latest()->paginate(6)->withQueryString();

        return view('admin.platforms.trashed', compact('platforms'));
    }

    public function restore($id)
    {
        $platform = Platform::onlyTrashed()->findOrFail($id);
        $platform->restore();

        return redirect()->route('admin.platforms.trashed')
            ->with('success', 'Platform restored successfully.');
    }
}
