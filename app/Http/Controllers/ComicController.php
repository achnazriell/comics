<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Synopsis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                        $query->where('content', 'like', "%{$search}%"); // Assuming synopsis has 'content'
                    });
            })
            ->paginate(10); // Adjust pagination as needed
    
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
    
    
    
// app/Http/Controllers/ComicController.php

    public function show(Comic $comic)
    {
    // Load relationships as needed
    $comic->load(['author', 'genres', 'publisher', 'synopsis', 'chapters.chapterImages']);

    return view('comics-show', compact('comic'));
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
        // Log the incoming request data
        Log::debug('Update Request Data:', $request->all());

        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'synopsis' => 'required|string',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the comic's attributes
        $comic->update([
            'title' => $request->title,
            'author_id' => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'image' => $comic->image // Preserve the existing image if no new image is provided
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($comic->image) {
                @unlink(public_path('images/' . $comic->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $comic->image = $imageName;
        }

        // Update or create the synopsis
        $comic->synopsis()->updateOrCreate([], ['content' => $request->synopsis]);

        // Update genres
        $comic->genres()->sync($request->genres);

        // Save the comic
        $comic->save();

        return redirect()->route('comics.index')->with('success', 'Comic updated successfully.');
    }


    public function destroy(Comic $comic)
    {
        $comic->delete();

        return redirect()->route('comics.index')->with('success', 'Comic deleted successfully.');
    }
}
