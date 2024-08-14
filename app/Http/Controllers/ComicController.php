<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Comic;
use App\Models\Author;
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
            // Custom error messages
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
            'chapter_images.*.image' => 'Each chapter image must be an image file.',
            'chapter_images.*.mimes' => 'Each chapter image must be a file of type: jpeg, png, jpg.',
            'chapter_images.*.max' => 'Each chapter image may not be greater than 2048 kilobytes.',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $imagePath = $image->store('images', 'public');
                Log::info('Image uploaded to: ' . $imagePath);
            } else {
                Log::error('Image upload failed.');
            }
        }

        // Handle chapter images upload
        $chapterImagesPaths = [];
        if ($request->hasFile('chapter_images')) {
            foreach ($request->file('chapter_images') as $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('chapter_images', 'public');
                    $chapterImagesPaths[] = $path;
                    Log::info('Chapter image uploaded to: ' . $path);
                } else {
                    Log::error('Chapter image upload failed.');
                }
            }
        }

        // Store the comic data
        $comic = Comic::create([
            'title' => $request->input('title'),
            'author_id' => $request->input('author_id'),
            'publisher_id' => $request->input('publisher_id'),
            'synopsis' => $request->input('synopsis'),
            'image' => $imagePath,
        ]);

        // Assuming you have a relationship to store chapter images
        foreach ($chapterImagesPaths as $path) {
            $comic->chapterImages()->create(['path' => $path]);
        }

        // Redirect or return response
        return redirect()->route('comics.index')->with('success', 'Comic created successfully!');
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

        // Update comic information
        $comic->update($request->except(['genres', 'synopsis', 'image']));

        // Handle image update
        if ($request->hasFile('image')) {
            if ($comic->image) {
                Storage::disk('public')->delete($comic->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $comic->image = $imagePath;
        }

        // Update or create synopsis
        $comic->synopsis()->updateOrCreate([], ['content' => $request->synopsis]);

        // Update genres
        $comic->genres()->sync($request->genres);

        $comic->save(); // Ensure the image change is saved

        return redirect()->route('comics.index')->with('success', 'Comic updated successfully.');
    }

    public function destroy(Comic $comic)
    {
        // Delete images
        if ($comic->image) {
            Storage::disk('public')->delete($comic->image);
        }

        foreach ($comic->chapterImages as $chapterImage) {
            Storage::disk('public')->delete($chapterImage->path);
        }

        // Delete comic
        $comic->delete();

        return redirect()->route('comics.index')->with('success', 'Comic deleted successfully.');
    }
}
