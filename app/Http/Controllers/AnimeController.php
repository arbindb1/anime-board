<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anime;

class AnimeController extends Controller
{
    public function index()
    {
        $watching = Anime::where('status', 'Watching')->orderByRaw('CASE WHEN sort_order = 0 OR sort_order IS NULL THEN 999999 ELSE sort_order END ASC')->orderBy('created_at', 'desc')->get();
        $planToWatch = Anime::where('status', 'Plan to watch')->orderByRaw('CASE WHEN sort_order = 0 OR sort_order IS NULL THEN 999999 ELSE sort_order END ASC')->orderBy('created_at', 'desc')->get();
        $completed = Anime::where('status', 'Completed')->orderByRaw('CASE WHEN sort_order = 0 OR sort_order IS NULL THEN 999999 ELSE sort_order END ASC')->orderBy('created_at', 'desc')->get();
        $dropped = Anime::where('status', 'Dropped')->orderByRaw('CASE WHEN sort_order = 0 OR sort_order IS NULL THEN 999999 ELSE sort_order END ASC')->orderBy('created_at', 'desc')->get();

        return view('anime-board.index', compact('watching', 'planToWatch', 'completed', 'dropped'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'status' => 'required|in:Watching,Plan to watch,Completed,Dropped',
            'format' => 'nullable|string|max:50',
            'episodes' => 'nullable|integer|min:1',
            'season' => 'nullable|string|max:50',
            'score' => 'nullable|numeric|between:0,10',
            'global_score' => 'nullable|numeric|between:0,10',
            'rank' => 'nullable|integer|min:1',
            'popularity' => 'nullable|integer|min:1',
            'genres' => 'nullable|string', 
            'description' => 'nullable|string',
            'mal_id' => 'nullable|integer',
            'progress' => 'nullable|integer|min:0',
            'group_name' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:1',
        ]);

        // Auto max out progress if marked as 'Completed'
        if ($validated['status'] === 'Completed' && isset($validated['episodes']) && $validated['episodes'] > 0) {
            $validated['progress'] = $validated['episodes'];
        }

        // Convert comma-separated string to array for JSON column
        if (!empty($validated['genres'])) {
            $validated['genres'] = array_map('trim', explode(',', $validated['genres']));
        } else {
            $validated['genres'] = [];
        }

        Anime::create($validated);

        return redirect()->route('anime-board.index')->with('success', 'Anime added successfully!');
    }

    public function update(Request $request, Anime $anime)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'status' => 'required|in:Watching,Plan to watch,Completed,Dropped',
            'format' => 'nullable|string|max:50',
            'episodes' => 'nullable|integer|min:1',
            'season' => 'nullable|string|max:50',
            'score' => 'nullable|numeric|between:0,10',
            'global_score' => 'nullable|numeric|between:0,10',
            'rank' => 'nullable|integer|min:1',
            'popularity' => 'nullable|integer|min:1',
            'genres' => 'nullable|string', 
            'description' => 'nullable|string',
            'mal_id' => 'nullable|integer',
            'progress' => 'nullable|integer|min:0',
            'group_name' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:1',
        ]);

        // Auto max out progress if marked as 'Completed'
        if ($validated['status'] === 'Completed' && isset($validated['episodes']) && $validated['episodes'] > 0) {
            $validated['progress'] = $validated['episodes'];
        }

        if (!empty($validated['genres'])) {
            $validated['genres'] = array_map('trim', explode(',', $validated['genres']));
        } else {
            $validated['genres'] = [];
        }

        $anime->update($validated);

        return redirect()->route('anime-board.index')->with('success', 'Anime updated successfully!');
    }

    public function destroy(Anime $anime)
    {
        $anime->delete();

        return redirect()->route('anime-board.index')->with('success', 'Anime removed successfully!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'anime_ids' => 'required|array',
            'anime_ids.*' => 'integer|exists:animes,id'
        ]);

        $ids = $request->input('anime_ids');
        
        foreach ($ids as $index => $id) {
            Anime::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
