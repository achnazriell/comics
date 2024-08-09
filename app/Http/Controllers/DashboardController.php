<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Comic::query();
    
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }
    
        $comics = $query->with(['author', 'genres', 'publisher', 'synopsis', 'chapters.chapterImages'])->get();
        
        return view('dashboard', compact('comics'));
    }
}
