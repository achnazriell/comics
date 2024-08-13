<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // In App\Http\Controllers\DashboardController.php

    public function index(Request $request)
    {
        $query = Comic::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        $comics = $query->with(['author', 'genres', 'publisher', 'synopsis', 'chapters.chapterImages'])->get();

        $query = $request->input('query');
    
        $comics = Comic::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%");
        })
        ->with(['author', 'genres', 'publisher', 'synopsis', 'chapters.chapterImages'])
        ->get();

    
        return view('dashboard', [
            'comics' => $comics,
            'search' => $search
        ]);
    }
}
    $search = $request->input('search', '');

    // Fetch comics or other data
    $comics = Comic::when($search, function ($query, $search) {
        return $query->where('title', 'like', "%{$search}%");
    })->get();

    return view('dashboard', [
        'comics' => $comics,
        'search' => $search
    ]);


