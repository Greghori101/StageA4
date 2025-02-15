<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\User;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the favorites.
     */
    public function index()
    {
        $favorites = Favorite::latest()->paginate(10);
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Show the form for creating a new favorite.
     */
    public function create()
    {
        $users = User::all();
        return view('favorites.create', compact('users'));
    }

    /**
     * Store a newly created favorite in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
        ]);

        Favorite::create($request->all());

        return redirect()->route('favorites.index')->with('success', 'Favori ajouté avec succès.');
    }

    /**
     * Display the specified favorite.
     */
    public function show(Favorite $favorite)
    {
        return view('favorites.show', compact('favorite'));
    }

    /**
     * Show the form for editing the specified favorite.
     */
    public function edit(Favorite $favorite)
    {
        $users = User::all();
        return view('favorites.edit', compact('favorite', 'users'));
    }

    /**
     * Update the specified favorite in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
        ]);

        $favorite->update($request->all());

        return redirect()->route('favorites.index')->with('success', 'Favori mis à jour avec succès.');
    }

    /**
     * Remove the specified favorite from storage.
     */
    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
        return redirect()->route('favorites.index')->with('success', 'Favori supprimé avec succès.');
    }
}

