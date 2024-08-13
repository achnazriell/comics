<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // In App\Http\Controllers\DashboardController.php

    public function index(Request $request)
{
    $search = $request->input('search', '');

    // Fetch comics or other data
    $comics = Comic::when($search, function ($query, $search) {
        return $query->where('title', 'like', "%{$search}%");
    })->get();

    return view('dashboard', [
        'comics' => $comics,
        'search' => $search
    ]);
}
}