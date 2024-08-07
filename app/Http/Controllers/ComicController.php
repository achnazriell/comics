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
        $comics = Comic::with('author', 'genre')->get();
        return view('comics.index', compact('comics'));
    }

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('comics.create', compact('authors', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        Comic::create($request->all());

        return redirect()->route('comics.index')->with('success', 'Comic created successfully.');
    }

    public function show(Comic $comic)
    {
        return view('comics.show', compact('comic'));
    }

    public function edit(Comic $comic)
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('comics.edit', compact('comic', 'authors', 'genres'));
    }

    public function update(Request $request, Comic $comic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $comic->update($request->all());

        return redirect()->route('comics.index')->with('success', 'Comic updated successfully.');
    }

    public function destroy(Comic $comic)
    {
        $comic->delete();

        return redirect()->route('comics.index')->with('success', 'Comic deleted successfully.');
    }
}
