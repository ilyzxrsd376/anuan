<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index() {
        $leaderboard = Leaderboard::orderBy('score', 'desc')->get();
        return view('leaderboard.index', compact('leaderboard'));
    }
}
