<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
    
        // Query ke Comic dengan pencarian jika ada
        $comics = Comic::with(['author', 'genres', 'publisher', 'synopsis', 'chapters.chapterImages'])
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'like', "%{$query}%");
            })
            ->get();
    
        // Mengirim data ke tampilan
        return view('dashboard', compact('comics', 'query'));
    }
}
