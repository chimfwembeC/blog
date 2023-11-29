<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch and return all shares
        $shares = Share::all();
        return view('shares.index', compact('shares'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new share
        return view('shares.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the new share
        $request->validate([
            // Your validation rules here
        ]);

        Share::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
        ]);

        return redirect()->route('shares.index')->with('success', 'Share created successfully!');
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
    public function edit(Share $share)
    {
        // Return the view for editing a share
        return view('shares.edit', compact('share'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Share $share)
    {
        // Validate and update the share
        $request->validate([
            // Your validation rules here
        ]);

        $share->update([
            'post_id' => $request->post_id,
        ]);

        return redirect()->route('shares.index')->with('success', 'Share updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Share $share)
    {
        // Delete the share
        $share->delete();

        return redirect()->route('shares.index')->with('success', 'Share deleted successfully!');
    }
}
