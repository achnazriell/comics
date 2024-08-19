<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search'); 

    if ($search) {
        $authors = Author::where('name', 'LIKE', "%$search%")->get();
    } else {
        $authors = Author::all();
    }

    return view('table.author-table', compact('authors', 'search'));
}


    public function create()
    {
        return view('create.create-authors'); // Sesuaikan nama view di sini
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:authors|string|max:255',
        ], [
            'required' => 'Authors must be filled in',
            'unique' => 'Genre is already in the menu',
        ]);

        Author::create($request->all()); // Menyimpan data ke database

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    public function edit(Author $author)
    {
        return view('update.edit-author', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id,
        ], [
            'required' => 'Authors must be filled in',
            'unique' => 'Genre is already in the menu',
        ]);

        $author->update($request->all());

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        try {
            if ($author->comics()->exists()) {
                return redirect()->route('authors.index')->with('error', 'Author cannot be deleted because it is still related to comic data.');
            }
            $author->delete();
            return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('authors.index')->with('error', 'An error occurs when deleting the author.');
        }
    }
}
