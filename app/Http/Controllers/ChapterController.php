<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
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
            'number' => 'required|integer',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $chapter = Chapter::create($request->only(['comic_id', 'number']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . rand(1, 100) . '.' . $image->extension();
                $image->move(public_path('chapter_images'), $imageName);

                ChapterImage::create([
                    'chapter_id' => $chapter->id,
                    'image' => $imageName,
                ]);
            }
        }

        return redirect()->route('comics.show', $chapter->comic_id)->with('success', 'Chapter created successfully.');
    }

    public function show(Chapter $chapter)
    {
        $images = $chapter->images; // Get images associated with the chapter
        return view('chapter-show', compact('chapter', 'images'));
    }

    public function edit(Chapter $chapter)
    {
        $comics = Comic::all();
        return view('update.edit-chapter', compact('chapter', 'comics'));
    }

    public function update(Request $request, Chapter $chapter)
    {
        $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'number' => 'required|integer',
        ]);

        $chapter->update($request->only(['comic_id', 'number']));


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . rand(1, 100) . '.' . $image->extension();
                $image->move(public_path('chapter_images'), $imageName);

                ChapterImage::create([
                    'chapter_id' => $chapter->id,
                    'image' => $imageName,
                ]);
            }
        }

        return redirect()->route('chapters.index')->with('success', 'Chapter updated successfully.');
    }

    public function destroy(Chapter $chapter)
    {
        try {
            // Delete associated images
            $chapter->images->each(function ($image) {
                Storage::disk('public/chapter_images')->delete($image->image); // Deleting the file from storage
                $image->delete(); // Deleting the image record from database
            });

            // Delete the chapter
            $chapter->delete();

            return redirect()->route('chapters.index')->with('success', 'Chapter deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('chapters.index')->with('error', 'An error occurred while deleting the chapter.');
        }
    }

}
