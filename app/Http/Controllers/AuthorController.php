<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('table.author-table', compact('authors'));
    }

    public function create()
    {
        return view('create.create-authors');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:authors|string|max:255',
        ]);

        Author::create($request->all());

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    public function show(Author $author)
    {
      //
    }

    public function edit(Author $author)
    {
        return view('update.edit-author', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id,
        ]);

        $author->update($request->all());

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}
