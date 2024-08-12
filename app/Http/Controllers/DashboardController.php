<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $comics = Comic::with(['author', 'genres', 'publisher', 'synopsis', 'chapters.chapterImages'])
            ->where('title', 'like', "%{$query}%")
            ->get();

        return view('dashboard', compact('comics'));
    }
}
