@props(['group'])

@php
    $firstAnime = $group->first();
    $groupName = $firstAnime->group_name ?: 'Unknown Collection';
    $count = $group->count();
    
    // Average rating from personal scores
    $validScores = $group->filter(fn($anime) => !empty($anime->score))->pluck('score');
    $avgScore = $validScores->count() > 0 ? $validScores->avg() : null;
    
    $isFavourite = $group->where('is_favourite', true)->count() > 0;
@endphp

<div class="relative bg-brand-card rounded-xl overflow-hidden group hover:ring-2 hover:ring-brand-accent transition-all duration-300 cursor-pointer shadow-lg w-full aspect-[4/5]">
    <!-- Main Image & Overlay -->
    <div class="relative w-full h-full overflow-hidden">
        <img src="{{ $firstAnime->image_url }}" alt="{{ $groupName }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 opacity-70">
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-brand-card via-brand-card/70 to-transparent"></div>

        <!-- Badges -->
        <div class="absolute top-3 left-3 right-3 flex justify-between items-start">
            <span class="px-2 py-1 bg-brand-accent/90 backdrop-blur-sm text-xs font-bold text-white rounded-md border border-white/10 shadow-lg flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Collection
            </span>
            
            <div class="flex items-start gap-2">
                @if($avgScore)
                <div class="flex items-center gap-1 bg-black/60 backdrop-blur-sm px-2 py-1 rounded-md border border-white/10">
                    <svg class="w-3.5 h-3.5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <span class="text-xs font-bold text-white">{{ number_format($avgScore, 1) }}</span>
                </div>
                @endif
                <button type="button" onclick="event.stopPropagation(); toggleCollectionFav('{{ addslashes($groupName) }}', this)" class="p-1 rounded-md shadow-lg backdrop-blur-sm transition-colors ring-1 ring-white/10 {{ $isFavourite ? 'bg-yellow-500/20 text-yellow-400' : 'bg-black/60 text-gray-400 hover:text-white hover:bg-black/80' }}" title="Toggle Collection Favourite">
                    <svg class="w-4 h-4 shadow-sm" fill="{{ $isFavourite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.975-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </button>
            </div>
        </div>

        <div class="absolute inset-x-4 bottom-4 text-center">
            <h3 class="text-white font-black text-lg leading-tight line-clamp-2 drop-shadow-md">{{ $groupName }}</h3>
            <div class="mt-2 flex items-center justify-center gap-2 text-xs text-brand-accent font-semibold bg-black/40 rounded-md py-1 mx-4 backdrop-blur-sm border border-brand-accent/30">
                <span>{{ $count }} Seasons / Entries</span>
            </div>
        </div>
    </div>
</div>
