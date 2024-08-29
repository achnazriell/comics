<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Get publishers based on the search query
        $publishers = Publisher::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(10); // Adjust pagination as needed

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
        ], [
            'name.required' => 'Genre must be filled in',
            'address.required' => 'Address must be filled in',
            'unique' => 'Genre is already in the menu',
        ]);

        Publisher::create($request->all());

        return redirect()->route('publishers.index')->with('success', 'Publisher created successfully.');
    }

    public function edit(Publisher $publisher)
    {
        return view('update.edit-publisher', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Genre must be filled in',
            'address.required' => 'Address must be filled in',
            'unique' => 'Genre is already in the menu',
        ]);

        $publisher->update($request->all());

        return redirect()->route('publishers.index')->with('success', 'Publisher updated successfully.');
    }

    public function destroy(Publisher $publisher)
    {
        try {
            if ($publisher->comics()->exists()) {
                return redirect()->route('publishers.index')->with('error', 'Publisher cannot be deleted because it is still related to comic data.');
            }
            $publisher->delete();
            return redirect()->route('publishers.index')->with('success', 'Publisher deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('publishers.index')->with('error', 'An error occurs when removing the publisher.');
        }
    }


}
