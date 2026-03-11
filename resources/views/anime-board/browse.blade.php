<x-anime-layout>
    <div class="h-full flex flex-col">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-white mb-4">Browse External Action</h2>
            <form action="{{ route('anime-board.browse') }}" method="GET" class="flex gap-2 max-w-xl">
                <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Search Jikan MyAnimeList API..." class="flex-1 px-4 py-2 bg-brand-dark border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent transition-colors">
                <button type="submit" class="px-6 py-2 bg-brand-accent hover:bg-brand-accentHover text-white font-medium rounded-lg transition-colors">Search</button>
            </form>
        </div>

        @if(empty($animes))
            <div class="flex-1 flex items-center justify-center text-gray-500">
                <p>No anime found. Try searching for something else.</p>
            </div>
        @else
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 gap-4 md:gap-6 overflow-y-auto pb-4 custom-scrollbar">
                @foreach($animes as $apiAnime)
                    @php
                        // Map Jikan API data to match our typical anime object shape for the UI
                        $mappedAnime = (object) [
                            'mal_id' => $apiAnime['mal_id'] ?? null,
                            'title' => $apiAnime['title'] ?? 'Unknown Title',
                            'image_url' => $apiAnime['images']['jpg']['large_image_url'] ?? null,
                            'format' => $apiAnime['type'] ?? 'Unknown',
                            'episodes' => $apiAnime['episodes'] ?? null,
                            'season' => isset($apiAnime['season']) && isset($apiAnime['year']) ? ucfirst($apiAnime['season']) . ' ' . $apiAnime['year'] : 'Unknown',
                            'global_score' => $apiAnime['score'] ?? null,
                            'rank' => $apiAnime['rank'] ?? null,
                            'popularity' => $apiAnime['popularity'] ?? null,
                            'genres' => collect($apiAnime['genres'] ?? [])->pluck('name')->toArray(),
                            'status' => 'External',
                            'description' => $apiAnime['synopsis'] ?? 'No description available.',
                            'is_external' => true
                        ];
                    @endphp
                    <div onclick="openPanel({{ json_encode($mappedAnime) }})">
                        <x-anime-card :anime="$mappedAnime" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-anime-layout>
