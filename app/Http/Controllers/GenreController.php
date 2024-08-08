<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{

    public function index()
    {
        $genres = Genre::all();
        return view('table.genre-table', compact('genres'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create.create-genre');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:genres|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        Genre::create($request->all());

        return redirect()->route('genre.table')->with('success', 'Genre created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        // You might want to implement this method if you have a detail view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('update.edit-genre', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $genre->update($request->all());

        return redirect()->route('genres.index')->with('success', 'Genre updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('genres.index')->with('success', 'Genre deleted successfully.');
    }
}
