<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        
        if ($query) {
            $authors = Author::where('name', 'LIKE', "%$query%")->get();
        } else {
            $authors = Author::all();
        }
        
        return view('table.author-table', compact('authors', 'query'));
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
        try {
            if ($author->comics()->exists()) {
                return redirect()->route('authors.index')->with('error', 'Author tidak bisa dihapus karena masih terkait dengan data comic.');
            }
            $author->delete();
            return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('authors.index')->with('error', 'Terjadi kesalahan saat menghapus author.');
        }
    }
    
    
}
