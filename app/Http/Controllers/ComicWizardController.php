<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ComicWizardController extends Controller
{
    public function createStep1(Request $request)
    {
        $authors = Author::all();
        $genres = Genre::all();
        $publishers = Publisher::all();
        $comic = $request->session()->get('comic', new Comic());

        return view('wizard.step1', compact('comic', 'authors', 'genres', 'publishers'));
    }

    public function storeStep1(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'synopsis' => 'required|string',
        ]);

        $comic = new Comic($validatedData);
        $request->session()->put('comic', $comic);

        return redirect()->route('comics.create.step2');
    }

    public function createStep2(Request $request)
    {
        $comic = $request->session()->get('comic');

        if (!$comic) {
            return redirect()->route('comics.create.step1');
        }

        return view('wizard.step2', compact('comic'));
    }

    public function storeStep2(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $comic = $request->session()->get('comic');

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $comic->image = $imageName;
        }

        $request->session()->put('comic', $comic);

        return redirect()->route('comics.create.step3');
    }

    public function createStep3(Request $request)
    {
        $comic = $request->session()->get('comic');

        if (!$comic) {
            return redirect()->route('comics.create.step1');
        }

        $chapters = $request->session()->get('chapters', []);

        return view('wizard.step3', compact('comic', 'chapters'));
    }

    public function storeStep3(Request $request)
    {
        $validatedData = $request->validate([
            'chapters' => 'required|array',
            'chapters.*.title' => 'required|string|max:255',
            'chapters.*.number' => 'required|integer',
            'chapters.*.content' => 'required|string',
        ]);

        $chapters = $request->session()->get('chapters', []);
        $chapters[] = $validatedData['chapters'];
        $request->session()->put('chapters', $chapters);

        return redirect()->route('comics.create.step3')->with('success', 'Chapter added successfully.');
    }

    public function finish(Request $request)
    {
        $comic = $request->session()->get('comic');
        $chapters = $request->session()->get('chapters', []);

        $comic->save();
        $comic->genres()->attach($comic->genres);

        foreach ($chapters as $chapterData) {
            $comic->chapters()->create($chapterData);
        }

        $request->session()->forget(['comic', 'chapters']);

        return redirect()->route('comics.index')->with('success', 'Comic and chapters created successfully.');
    }
}
