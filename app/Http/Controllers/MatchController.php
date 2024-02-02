<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function showPotentialMatches()
    {
        $user = Auth::user();
        $potentialMatches = $user->potentialMatches();

        return view('matches.show', compact('user', 'potentialMatches'));
    }
}
