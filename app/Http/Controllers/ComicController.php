<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComicController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $comics = Comic::with(['author', 'publisher', 'genres', 'chapters', 'synopsis'])
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('author', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('publisher', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('genres', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('synopsis', function ($query) use ($search) {
                        $query->where('content', 'like', "%{$search}%");
                    });
            })
            ->paginate(10);

        return view('table.comics-table', compact('comics'));
    }

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        $publishers = Publisher::all();
        return view('create.create-comics', compact('authors', 'genres', 'publishers'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $comic = Comic::create($request->except(['genres', 'synopsis', 'image']));

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $comic->image = $imagePath;
            $comic->save();
        }

        $comic->genres()->attach($request->genres);
        $comic->synopsis()->create(['content' => $request->synopsis]);

        return redirect()->route('comics.index')->with('success', 'Comic created successfully.');
    }
    public function show(Comic $comic)
    {
        $comic->load(['author', 'genres', 'publisher', 'synopsis', 'chapters.chapterImages']);
        return view('comics-show', compact('comic'));
    }

    public function edit(Comic $comic)
    {
        $authors = Author::all();
        $genres = Genre::all();
        $publishers = Publisher::all();
        $selectedGenres = $comic->genres->pluck('id')->toArray();
        return view('update.edit-comic', compact('comic', 'authors', 'genres', 'publishers', 'selectedGenres'));
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
        $comic->update($request->except(['genres', 'synopsis', 'image']));
    
        if ($request->hasFile('image')) {
            if ($comic->image) {
                @unlink(public_path('images/' . $comic->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $comic->image = $imageName;
        }
    
        $comic->synopsis()->updateOrCreate([], ['content' => $request->synopsis]);

        $comic->genres()->sync($request->genres);

        $comic->save(); // Ensure the image change is saved

        return redirect()->route('comics.index')->with('success', 'Comic updated successfully.');
    }
    


    public function destroy(Comic $comic)
    {
        if ($comic->image) {
            Storage::disk('public')->delete($comic->image);
        }
        $comic->delete();
        return redirect()->route('comics.index')->with('success', 'Comic deleted successfully.');
    }
}
