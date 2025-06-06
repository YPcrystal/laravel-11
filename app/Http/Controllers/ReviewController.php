<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Game $game)
    {
        $reviews = $game->reviews;
        return view('reviews.index', compact('game', 'reviews'));
    }

    public function create(Game $game)
    {
        return view('reviews.create', compact('game'));
    }

    public function store(Request $request, Game $game)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:255',
        ]);

        $review = Review::create([
            'game_id' => $game->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        // Hitung ulang rating rata-rata
        $game->rating_rata_rata = $game->averageCriticScore();
        $game->save();

        return redirect()->route('games.show', $game->id)->with('success', 'Review berhasil ditambahkan!');
    }

    public function destroy(Game $game, Review $review)
    {
        $review->delete();

        // Hitung ulang rating rata-rata
        $game->rating_rata_rata = $game->averageCriticScore();
        $game->save();

        return redirect()->route('games.show', $game->id)->with('success', 'Review berhasil dihapus!');
    }
}