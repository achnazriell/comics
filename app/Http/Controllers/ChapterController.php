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

        $chapter = Chapter::create($request->only(['comic_id']));

        if ($request->hasFile('chapter_images')) {
            foreach ($request->file('chapter_images') as $file) {
                $imageName = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('chapter_images'), $imageName);

                ChapterImage::create([
                    'chapter_id' => $chapter->id,
                    'image' => $imageName, // Make sure the field name is consistent
                ]);
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
        ]);
    
        // Update comic_id if needed
        $chapter->update($request->only(['comic_id']));
    
        // Hapus gambar yang dipilih
        if ($request->has('delete_images')) {
            $deleteImages = ChapterImage::whereIn('id', $request->delete_images)->get();
            foreach ($deleteImages as $image) {
                $imagePath = public_path('chapter_images/' . $image->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Hapus file dari server
                }
                $image->delete(); // Hapus dari database
            }
        }
    
        // Upload dan simpan gambar baru
        if ($request->hasFile('chapter_images')) {
            foreach ($request->file('chapter_images') as $file) {
                $imageName = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('chapter_images'), $imageName);
    
                ChapterImage::create([
                    'chapter_id' => $chapter->id,
                    'image' => $imageName,
                ]);
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
