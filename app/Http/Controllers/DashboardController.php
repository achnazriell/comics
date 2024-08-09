<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch comics with relationships
        $comics = Comic::with(['author', 'genres', 'publisher', 'synopsis', 'chapters.chapterImages'])->get();
        
        // Pass comics to view
        return view('dashboard', compact('comics'));
    }
}
