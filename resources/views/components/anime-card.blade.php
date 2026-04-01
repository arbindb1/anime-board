@props(['anime'])

<div class="relative bg-brand-card rounded-xl overflow-hidden group hover:ring-2 hover:ring-brand-accent transition-all duration-300 cursor-pointer shadow-lg">
    <!-- Image & Overlay -->
    <div class="relative aspect-[4/5] w-full overflow-hidden">
        <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-brand-card via-brand-card/50 to-transparent opacity-90"></div>

        <!-- Top Badges -->
        <div class="absolute top-3 left-3 right-3 flex justify-between items-start">
            <span class="px-2 py-1 bg-black/60 backdrop-blur-sm text-xs font-semibold text-white rounded-md border border-white/10">
                {{ $anime->format }}
            </span>
            <div class="flex items-start gap-2">
                @if(isset($anime->score) || isset($anime->global_score))
                <div class="flex items-center gap-1 bg-black/60 backdrop-blur-sm px-2 py-1 rounded-md border border-white/10">
                    <svg class="w-3.5 h-3.5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <span class="text-xs font-bold text-white">{{ $anime->score ?? $anime->global_score }}</span>
                </div>
                @endif

                @if(!($anime->is_external ?? false) && isset($anime->id))
                <button type="button" onclick="event.stopPropagation(); toggleFav({{ $anime->id }}, this)" class="p-1 rounded-md shadow-lg backdrop-blur-sm transition-colors ring-1 ring-white/10 {{ $anime->is_favourite ? 'bg-yellow-500/20 text-yellow-400' : 'bg-black/60 text-gray-400 hover:text-white hover:bg-black/80' }}" title="Toggle Favourite">
                    <svg class="w-4 h-4 shadow-sm" fill="{{ $anime->is_favourite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.975-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </button>
                @endif
                
                @if($anime->is_external ?? false)
                <button type="button" onclick="event.stopPropagation(); openQuickAddModal({{ json_encode($anime) }})" class="p-1 bg-brand-accent hover:bg-brand-accentHover text-white rounded-md shadow-lg backdrop-blur-sm transition-colors ring-1 ring-white/10" title="Quick Add">
                    <svg class="w-4 h-4 shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                </button>
                @endif
            </div>
        </div>

        <div class="absolute bottom-4 left-4 right-4 text-center">
            <h3 class="text-white font-bold leading-tight line-clamp-2">{{ $anime->title }}</h3>
            <div class="mt-2 flex items-center justify-center gap-2 text-xs text-gray-400">
                <span>{{ $anime->episodes ?? '?' }} Eps</span>
                <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                <span>{{ $anime->season }}</span>
            </div>
        </div>
    </div>
</div>
