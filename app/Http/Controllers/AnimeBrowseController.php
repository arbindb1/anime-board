<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnimeBrowseController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $animes = [];

        try {
            if ($query) {
                // Search anime
                $response = Http::get('https://api.jikan.moe/v4/anime', [
                    'q' => $query,
                    'sfw' => true,
                    'limit' => 24
                ]);
            } else {
                // Get top anime by default
                $response = Http::get('https://api.jikan.moe/v4/top/anime', [
                    'limit' => 24,
                    'filter' => 'bypopularity'
                ]);
            }

            if ($response->successful()) {
                $animes = $response->json('data');
            }
        } catch (\Exception $e) {
            // Handle error silently or return empty array
            $animes = [];
        }

        return view('anime-board.browse', compact('animes', 'query'));
    }
}
