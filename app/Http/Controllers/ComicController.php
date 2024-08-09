<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Synopsis;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function index()
    {
        $comics = Comic::with(['author', 'genres', 'publisher', 'synopsis', 'chapters.chapterImages'])->get(); 
        return view('table.comics-table', compact('comics'));
    }
    
    
    
    

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        $publishers = Publisher::all(); // Add this line
        return view('create.create-comics', compact('authors', 'genres', 'publishers')); // Include 'publishers' in the compact array
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
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
    
        // Set the publisher_id here
        $comic->publisher_id = $request->publisher_id;
        
        $comic->save();
        $comic->genres()->attach($request->genres);
    
        $synopsis = new Synopsis([
            'content' => $request->synopsis
        ]);
        $comic->synopsis()->save($synopsis);
    
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
        $publishers = Publisher::all(); // Add this line
        $selectedGenres = $comic->genres->pluck('id')->toArray();
        return view('update.edit-comic', compact('comic', 'authors', 'genres', 'publishers', 'selectedGenres')); // Include 'publishers' in the compact array
    }
    
    public function update(Request $request, Comic $comic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'synopsis' => 'required|string',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($comic->image) {
                @unlink(public_path('images/' . $comic->image));
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $comic->image = $imageName;
        }

        $comic->update($request->except(['genres', 'synopsis', 'image']));
        $comic->publisher_id = $request->publisher_id; // Update publisher_id
        $comic->genres()->sync($request->genres);
        $comic->synopsis()->updateOrCreate([], ['content' => $request->synopsis]);

        return redirect()->route('comic.table')->with('success', 'Comic updated successfully.');
    }

    public function destroy(Comic $comic)
    {
        $comic->delete();

        return redirect()->route('comic.table')->with('success', 'Comic deleted successfully.');
    }
}
