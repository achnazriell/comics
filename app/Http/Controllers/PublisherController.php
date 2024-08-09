<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::all();
        return view('table.publishers-table', compact('publishers'));
    }

    public function create()
    {
        return view('create.create-publisher');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        Publisher::create($request->all());

        return redirect()->route('publishers.index')->with('success', 'Publisher created successfully.');
    }

    public function show(Publisher $publisher)
    {
        // return view('update.edit-publisher', compact('publisher'));
    }

    public function edit(Publisher $publisher)
    {
        return view('update.edit-publisher', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $publisher->update($request->all());

        return redirect()->route('publishers.index')->with('success', 'Publisher updated successfully.');
    }

    public function destroy(Publisher $publisher)
    {
        try {
            if ($publisher->comics()->exists()) {
                return redirect()->route('publishers.index')->with('error', 'Publisher tidak bisa dihapus karena masih terkait dengan data comic.');
            }
            $publisher->delete();
            return redirect()->route('publishers.index')->with('success', 'Publisher deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('publishers.index')->with('error', 'Terjadi kesalahan saat menghapus publisher.');
        }
    }
    
    
}
