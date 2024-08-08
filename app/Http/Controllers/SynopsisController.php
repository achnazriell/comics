<?php

namespace App\Http\Controllers;

use App\Models\Synopsis;
use App\Models\Comic;
use Illuminate\Http\Request;

class SynopsisController extends Controller
{
    public function index()
    {
        $synopses = Synopsis::with('comic')->get();
        return view('synopses.index', compact('synopses'));
    }

    public function create()
    {
        $comics = Comic::all();
        return view('synopses.create', compact('comics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'synopsis' => 'required|string',
        ]);

        Synopsis::create($request->all());

        return redirect()->route('synopses.index')->with('success', 'Synopsis created successfully.');
    }

    public function show(Synopsis $synopsis)
    {
        return view('synopses.show', compact('synopsis'));
    }

    public function edit(Synopsis $synopsis)
    {
        $comics = Comic::all();
        return view('synopses.edit', compact('synopsis', 'comics'));
    }

    public function update(Request $request, Synopsis $synopsis)
    {
        $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'synopsis' => 'required|string',
        ]);

        $synopsis->update($request->all());

        return redirect()->route('synopses.index')->with('success', 'Synopsis updated successfully.');
    }

    public function destroy(Synopsis $synopsis)
    {
        $synopsis->delete();

        return redirect()->route('synopses.index')->with('success', 'Synopsis deleted successfully.');
    }
}

