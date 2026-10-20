<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Publisher::query();

        if($request->filled('search')){
            $query->where('publisher_name', 'like', '%' . $request->search . '%');
        }

        $publishers = $query->latest()->paginate(6)->withQueryString();

        return view('admin.publishers.index', compact('publishers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.publishers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'publisher_name' => 'required|string|max:255|unique:publishers,publisher_name',
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        Publisher::create([
            'publisher_name' => $request->publisher_name,
            'website' => $request->website,
            'country' => $request->country,
        ]);

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'publisher_name' => 'required|string|max:255|unique:publishers,publisher_name,' . $publisher->id,
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $publisher->publisher_name = $request->publisher_name;
        $publisher->website = $request->website;
        $publisher->country = $request->country;

        $publisher->save();

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher deleted successfully.');
    }

    public function trashed(Request $request)
    {
        $query = Publisher::onlyTrashed();

        if($request->filled('search')){
            $query->where('publisher_name', 'like', '%' . $request->search . '%');
        }

        $publishers = $query->latest('deleted_at')->paginate(6)->withQueryString();

        return view('admin.publishers.trashed', compact('publishers'));
    }

    public function restore($id)
    {
        $publisher = Publisher::onlyTrashed()->findOrFail($id);
        $publisher->restore();

        return redirect()->route('admin.publishers.trashed')
            ->with('success', 'Publisher restored successfully.');
    }
}
