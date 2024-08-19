<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\ChapterImage;
use App\Models\Comic;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index()
    {
        $chapters = Chapter::with('comic')->get();
        return view('table.chapter-table', compact('chapters'));
    }

    public function create()
    {
        $comics = Comic::all();
        return view('create.create-chapter', compact('comics'));
    }

    public function store(Request $request)
{
    $request->validate([
        'comic_id' => 'required|exists:comics,id',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Create a new chapter
    $chapter = Chapter::create($request->only(['comic_id']));

    // Handle image uploads
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            if ($file->isValid()) {
                $imageName = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('chapter_images'), $imageName);

                ChapterImage::create([
                    'chapter_id' => $chapter->id,
                    'image' => $imageName,
                ]);
            }
        }
    }

    return redirect()->route('comics.show', $chapter->comic_id)->with('success', 'Chapter created successfully.');
}


    public function show(Chapter $chapter)
    {
        return view('chapter-show', compact('chapter'));
    }

    public function edit(Chapter $chapter)
    {
        $comics = Comic::all();
        $chapters = Chapter::where('comic_id', $chapter->comic_id)
                           ->orderBy('created_at', 'asc')
                           ->get();
        return view('update.edit-chapter', compact('chapter', 'comics', 'chapters'));
    }
    
    

    public function update(Request $request, Chapter $chapter)
{
    $request->validate([
        'comic_id' => 'required|exists:comics,id',
        'chapter_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'delete_images.*' => 'nullable|exists:chapter_images,id',
    ]);

    // Update chapter details
    $chapter->update($request->only(['comic_id']));

    // Handle image deletions
    if ($request->has('delete_images')) {
        $deleteImages = ChapterImage::whereIn('id', $request->delete_images)->get();
        foreach ($deleteImages as $image) {
            $imagePath = public_path('chapter_images/' . $image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the file
            }
            $image->delete(); // Delete from database
        }
    }

    // Handle new image uploads
    if ($request->hasFile('chapter_images')) {
        foreach ($request->file('chapter_images') as $file) {
            if ($file->isValid()) {
                $imageName = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('chapter_images'), $imageName);

                ChapterImage::create([
                    'chapter_id' => $chapter->id,
                    'image' => $imageName,
                ]);
            }
        }
    }

    return redirect()->route('comics.index')->with('success', 'Chapter updated successfully.');
}


    public function destroy(Chapter $chapter)
    {
        try {
            if ($chapter->comic()->exists()) {
                return redirect()->route('chapters.show', $chapter)->with('error', 'Chapter cannot be deleted because it is still associated with a comic.');
            }

            $chapter->images()->delete(); // Deleting associated images first
            $chapter->delete();

            return redirect()->route('comics.index')->with('success', 'Chapter deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('comics.index')->with('error', 'An error occurred while deleting the chapter.');
        }
    }
}
