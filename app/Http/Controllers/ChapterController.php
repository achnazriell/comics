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
        return view('table.chapter-table    ', compact('chapters'));
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
                $imageName = time().rand(1, 100).'.'.$image->extension();
                $image->move(public_path('chapter_images'), $imageName);
    
                ChapterImage::create([
                    'chapter_id' => $chapter->id,
                    'image' => $imageName,
                ]);
            }
        }
    
        return redirect()->route('create.create-chapter')->with('success', 'Chapter created successfully.');
    }
    

    public function show(Chapter $chapter)
    {
        return view('chapters.show', compact('chapter'));
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
            'title' => 'required|string|max:255',
            'number' => 'required|integer',
        ]);

        $chapter->update($request->all());

        return redirect()->route('create.create-chapter')->with('success', 'Chapter updated successfully.');
    }

    public function destroy(Chapter $chapter)
    {
        try {
            if ($chapter->comic()->exists()) {
                return redirect()->route('create.create-chapter')->with('error', 'Chapter tidak bisa dihapus karena masih terkait dengan data comic.');
            }
            $chapter->delete();
            return redirect()->route('create.create-chapter')->with('success', 'Chapter deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('create.create-chapter')->with('error', 'Terjadi kesalahan saat menghapus chapter.');
        }
    }
    
    
}
