<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Comic;
use App\Models\Publisher;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::with('comic', 'publisher')->get();
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Comic $comic)
    {
        // Pass the specific comic to the review form
        return view('create.create-review', compact('comic'));
    }

    public function store(Request $request, Comic $comic)
    {
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        // Automatically associate the review with the selected comic
        $comic->reviews()->create($validatedData);

        return redirect()->route('comics.show', $comic->id)->with('success', 'Review created successfully!');
    }


    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        $comics = Comic::all();
        $publishers = Publisher::all();
        return view('reviews.edit', compact('review', 'comics', 'publishers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'publisher_id' => 'required|exists:publishers,id',
            'review' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review->update($request->all());

        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }
}
