<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Comic;
use App\Models\Author;
use App\Models\Chapter;
use App\Models\ChapterImage;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;

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
    // Validate request
    $request->validate([
        'title' => 'required|string|max:255',
        'author_id' => 'required|exists:authors,id',
        'publisher_id' => 'required|exists:publishers,id',
        'synopsis' => 'required|string',
        'genres' => 'required|array',
        'genres.*' => 'exists:genres,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'chapter_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ], [
        'title.required' => 'The title field is required.',
        'title.string' => 'The title must be a string.',
        'title.max' => 'The title may not be greater than 255 characters.',
        'author_id.required' => 'The author field is required.',
        'author_id.exists' => 'The selected author does not exist.',
        'publisher_id.required' => 'The publisher field is required.',
        'publisher_id.exists' => 'The selected publisher does not exist.',
        'synopsis.required' => 'The synopsis field is required.',
        'synopsis.string' => 'The synopsis must be a string.',
        'genres.required' => 'At least one genre must be selected.',
        'genres.array' => 'The genres field must be an array.',
        'genres.*.exists' => 'One or more selected genres are invalid.',
        'image.image' => 'The image must be an image file.',
        'image.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
        'image.max' => 'The image may not be greater than 2048 kilobytes.',
    ]);

    // Create the comic
    $comic = Comic::create($request->except(['genres', 'synopsis', 'image', 'chapter_images']));

    // Handle comic image
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $comic->image = $imageName;
        $comic->save();
    }

    // Attach genres to the comic
    $comic->genres()->attach($request->genres);

    // Create synopsis
    $comic->synopsis()->create(['content' => $request->synopsis]);

    // Handle chapter images
    if ($request->hasFile('chapter_images')) {
        // Create a chapter first
        $chapter = $comic->chapters()->create(); // Add other chapter-specific fields if necessary

        foreach ($request->file('chapter_images') as $file) {
            $imageName = time() . rand(1, 100) . '.' . $file->extension();
            $file->move(public_path('chapter_images'), $imageName);

            // Create chapter images
            ChapterImage::create([
                'chapter_id' => $chapter->id,
                'image' => $imageName,
            ]);
        }
    }

    return redirect()->route('comics.index')->with('success', 'Comic created successfully.');
}

    public function show(Comic $comic)
    {
        $comic->load(['author', 'genres', 'publisher', 'synopsis', 'chapters']);
        $filteredChapters = $comic->chapters()->orderBy('created_at', 'asc')->get();
        return view('comics-show', compact('comic', 'filteredChapters'));
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
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'author_id.required' => 'The author field is required.',
            'author_id.exists' => 'The selected author does not exist.',
            'publisher_id.required' => 'The publisher field is required.',
            'publisher_id.exists' => 'The selected publisher does not exist.',
            'synopsis.required' => 'The synopsis field is required.',
            'synopsis.string' => 'The synopsis must be a string.',
            'genres.required' => 'At least one genre must be selected.',
            'genres.array' => 'The genres field must be an array.',
            'genres.*.exists' => 'One or more selected genres are invalid.',
            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'image.max' => 'The image may not be greater than 2048 kilobytes.',
        ]);

        $comic->update($request->except(['genres', 'synopsis', 'image']));

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($comic->image) {
                Storage::disk('public')->delete($comic->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images','public'), $imageName);
            $comic->image = $imageName;
            $comic->save();
        }

        // Sync genres (removes old and attaches new ones)
        $comic->genres()->sync($request->genres);

        // Update synopsis
        $comic->synopsis->update(['content' => $request->synopsis]);

        return redirect()->route('comics.index')->with('success', 'Comic updated successfully.');
    }


    public function destroy(Comic $comic)
    {
        // Delete comic image
        if ($comic->image) {
            $imagePath = public_path('images/' . $comic->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        // Delete chapter images associated with the comic
        foreach ($comic->chapters as $chapter) {
            foreach ($chapter->images as $image) {
                $imagePath = public_path('chapter_images/' . $image->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $image->delete();
            }
        }
    
        // Delete the comic itself
        $comic->delete();
    
        return redirect()->route('comics.index')->with('success', 'Comic deleted successfully.');
    }
}    