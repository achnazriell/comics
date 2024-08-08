<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function index()
    {
        $comics = Comic::with('author', 'genres')->get();
        return view('table.comics-table', compact('comics'));
    }

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('create.create-comics', compact('authors', 'genres'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'author_id' => 'required|exists:authors,id',
        'synopsis' => 'required|string',
        'genres' => 'required|array',
        'genres.*' => 'exists:genres,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $comic = new Comic($request->except(['genres', 'synopsis', 'image']));

    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $comic->image = $imageName;
    }

    $comic->save();
    $comic->genres()->attach($request->genres);
    $comic->synopsis()->create(['content' => $request->synopsis]);

    return redirect()->route('comics.index')->with('success', 'Comic created successfully.');
}


    public function show(Comic $comic)
    {
        // return view('comics.show', compact('comic'));
    }

    public function edit(Comic $comic)
    {
        $authors = Author::all();
        $genres = Genre::all();
        $selectedGenres = $comic->genres->pluck('id')->toArray();
        return view('', compact('comic', 'authors', 'genres', 'selectedGenres'));
    }

    public function update(Request $request, Comic $comic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'synopsis' => 'required|string',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $comic->image = $imageName;
        }

        $comic->update($request->except(['genres', 'synopsis', 'image']));
        $comic->genres()->sync($request->genres);
        $comic->synopsis()->updateOrCreate([], ['content' => $request->synopsis]);

        return redirect()->route('comics.index')->with('success', 'Comic updated successfully.');
    }

    public function destroy(Comic $comic)
    {
        $comic->delete();

        return redirect()->route('comics.index')->with('success', 'Comic deleted successfully.');
    }
}
