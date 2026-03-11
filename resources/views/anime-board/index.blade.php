<x-anime-layout>
    @if ($errors->any())
        <div class="absolute top-4 right-4 z-[100] bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded shadow-lg">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @php
        function groupAnimes($collection) {
            return $collection->groupBy(function($anime) {
                return $anime->group_name ?: 'single_' . $anime->id;
            });
        }
        $groupedWatching = groupAnimes($watching);
        $groupedPlanToWatch = groupAnimes($planToWatch);
        $groupedCompleted = groupAnimes($completed);
        $groupedDropped = groupAnimes($dropped);
    @endphp
    
    <div class="h-full flex flex-col">
        <!-- Main Board Columns -->
        <!-- Tabs Header -->
        <div class="flex items-center justify-between border-b border-gray-800 pb-4 mb-6 shrink-0">
            <div class="flex overflow-x-auto whitespace-nowrap gap-2 md:gap-4 custom-scrollbar pr-4">
                <button onclick="switchTab('watching')" id="tab-btn-watching" class="tab-btn active-tab bg-brand-card text-white ring-1 ring-brand-accent/50 px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 shrink-0">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]"></span>
                    Watching
                    <span class="bg-brand-dark border border-gray-700/50 text-xs px-2 py-0.5 rounded-md">{{ $watching->count() }}</span>
                </button>
                <button onclick="switchTab('plan-to-watch')" id="tab-btn-plan-to-watch" class="tab-btn text-gray-400 hover:text-white hover:bg-brand-card/50 px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 shrink-0">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.6)]"></span>
                    Plan to watch
                    <span class="bg-brand-dark border border-gray-700/50 text-xs px-2 py-0.5 rounded-md">{{ $planToWatch->count() }}</span>
                </button>
                <button onclick="switchTab('completed')" id="tab-btn-completed" class="tab-btn text-gray-400 hover:text-white hover:bg-brand-card/50 px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 shrink-0">
                    <span class="w-2.5 h-2.5 rounded-full bg-orange-500 shadow-[0_0_8px_rgba(249,115,22,0.6)]"></span>
                    Completed
                    <span class="bg-brand-dark border border-gray-700/50 text-xs px-2 py-0.5 rounded-md">{{ $completed->count() }}</span>
                </button>
                <button onclick="switchTab('dropped')" id="tab-btn-dropped" class="tab-btn text-gray-400 hover:text-white hover:bg-brand-card/50 px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 shrink-0">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.6)]"></span>
                    Dropped
                    <span class="bg-brand-dark border border-gray-700/50 text-xs px-2 py-0.5 rounded-md">{{ $dropped->count() }}</span>
                </button>
            </div>
            
            <!-- Drag & Drop Toggle -->
            <div class="flex items-center gap-3 pl-4 border-l border-gray-800 shrink-0">
                <span class="text-xs text-gray-400 font-medium hidden sm:block uppercase tracking-wider">Sort Mode</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle-drag-drop" onchange="toggleDragDrop()" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-accent"></div>
                </label>
            </div>
        </div>

        <!-- Tab Contents -->
        <div class="flex-1 overflow-y-auto pb-4 custom-scrollbar">
            <!-- Watching Grid -->
            <div id="tab-content-watching" class="tab-content grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 gap-4 md:gap-6">
                @foreach($groupedWatching as $group)
                    @if($group->count() == 1)
                        <div data-id="{{ $group->first()->id }}" onclick='openPanel(@json($group->first()))'>
                            <x-anime-card :anime="$group->first()" />
                        </div>
                    @else
                        <div onclick="openCollectionGrid('{{ md5($group->first()->group_name) }}', '{{ addslashes($group->first()->group_name) }}')">
                            <x-anime-collection-card :group="$group" />
                        </div>
                        <template id="collection-tpl-{{ md5($group->first()->group_name) }}">
                            @foreach($group as $anime)
                                <div onclick='openPanel(@json($anime))'>
                                    <x-anime-card :anime="$anime" />
                                </div>
                            @endforeach
                        </template>
                    @endif
                @endforeach
                @if($watching->isEmpty())
                    <div class="col-span-full py-12 text-center text-gray-500 bg-brand-dark rounded-xl border border-gray-800 border-dashed">No animes in this list.</div>
                @endif
            </div>

            <!-- Plan to Watch Grid -->
            <div id="tab-content-plan-to-watch" class="tab-content hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 gap-4 md:gap-6">
                @foreach($groupedPlanToWatch as $group)
                    @if($group->count() == 1)
                        <div data-id="{{ $group->first()->id }}" onclick='openPanel(@json($group->first()))'>
                            <x-anime-card :anime="$group->first()" />
                        </div>
                    @else
                        <div onclick="openCollectionGrid('{{ md5($group->first()->group_name) }}', '{{ addslashes($group->first()->group_name) }}')">
                            <x-anime-collection-card :group="$group" />
                        </div>
                        <template id="collection-tpl-{{ md5($group->first()->group_name) }}">
                            @foreach($group as $anime)
                                <div onclick='openPanel(@json($anime))'>
                                    <x-anime-card :anime="$anime" />
                                </div>
                            @endforeach
                        </template>
                    @endif
                @endforeach
                @if($planToWatch->isEmpty())
                    <div class="col-span-full py-12 text-center text-gray-500 bg-brand-dark rounded-xl border border-gray-800 border-dashed">No animes in this list.</div>
                @endif
            </div>

            <!-- Completed Grid -->
            <div id="tab-content-completed" class="tab-content hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 gap-4 md:gap-6">
                @foreach($groupedCompleted as $group)
                    @if($group->count() == 1)
                        <div data-id="{{ $group->first()->id }}" onclick='openPanel(@json($group->first()))'>
                            <x-anime-card :anime="$group->first()" />
                        </div>
                    @else
                        <div onclick="openCollectionGrid('{{ md5($group->first()->group_name) }}', '{{ addslashes($group->first()->group_name) }}')">
                            <x-anime-collection-card :group="$group" />
                        </div>
                        <template id="collection-tpl-{{ md5($group->first()->group_name) }}">
                            @foreach($group as $anime)
                                <div onclick='openPanel(@json($anime))'>
                                    <x-anime-card :anime="$anime" />
                                </div>
                            @endforeach
                        </template>
                    @endif
                @endforeach
                @if($completed->isEmpty())
                    <div class="col-span-full py-12 text-center text-gray-500 bg-brand-dark rounded-xl border border-gray-800 border-dashed">No animes in this list.</div>
                @endif
            </div>

            <!-- Dropped Grid -->
            <div id="tab-content-dropped" class="tab-content hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 gap-4 md:gap-6">
                @foreach($groupedDropped as $group)
                    @if($group->count() == 1)
                        <div data-id="{{ $group->first()->id }}" onclick="openPanel({{ $group->first()->toJson() }})">
                            <x-anime-card :anime="$group->first()" />
                        </div>
                    @else
                        <div onclick="openCollectionGrid('{{ md5($group->first()->group_name) }}', '{{ addslashes($group->first()->group_name) }}')">
                            <x-anime-collection-card :group="$group" />
                        </div>
                        <template id="collection-tpl-{{ md5($group->first()->group_name) }}">
                            @foreach($group as $anime)
                                <div onclick="openPanel({{ $anime->toJson() }})">
                                    <x-anime-card :anime="$anime" />
                                </div>
                            @endforeach
                        </template>
                    @endif
                @endforeach
                @if($dropped->isEmpty())
                    <div class="col-span-full py-12 text-center text-gray-500 bg-brand-dark rounded-xl border border-gray-800 border-dashed">No animes in this list.</div>
                @endif
            </div>
        </div>
    </div>

    <x-slot name="detailsPanel">
        <!-- Anime Details Side Panel (Hidden by default) -->
        <div id="anime-details-panel" class="fixed inset-y-0 right-0 w-full sm:w-[400px] bg-brand-dark border-l border-gray-800 transform translate-x-full transition-transform duration-300 ease-in-out z-50 flex flex-col shadow-2xl">
            <!-- Loading or Content Area -->
            <div id="panel-content" class="flex-1 overflow-y-auto h-full flex flex-col">
                <!-- Banner Image -->
                <div class="relative w-full h-64 shrink-0">
                    <img id="panel-banner" src="" class="w-full h-full object-cover opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark to-transparent"></div>
                    <button onclick="closePanel()" class="absolute top-4 right-4 p-2 bg-black/40 hover:bg-black/80 rounded-full text-white backdrop-blur-md transition-colors border border-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    
                    <div class="absolute bottom-4 left-6 flex gap-4">
                        <img id="panel-poster" src="" class="w-24 h-36 object-cover rounded-md shadow-2xl border border-gray-700 block">
                        <div class="flex flex-col justify-end pb-1">
                            <h2 id="panel-title" class="text-xl font-bold text-white line-clamp-2 leading-tight drop-shadow-md"></h2>
                            <div class="mt-2 text-xs">
                                <span id="panel-status" class="px-2 py-1 bg-green-500/20 text-green-400 font-semibold rounded border border-green-500/30 shadow-sm"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details Content -->
                <div class="p-6 flex-1 flex flex-col gap-6">
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-4 gap-2 bg-brand-card p-3 rounded-xl border border-gray-800 shadow-inner">
                        <div class="flex flex-col items-center">
                            <span class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">My Score</span>
                            <div class="flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5 text-orange-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span id="panel-score" class="font-bold text-white text-sm"></span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center border-l border-gray-800">
                            <span class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Global</span>
                            <div class="flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5 text-orange-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span id="panel-global-score" class="font-bold text-white text-sm"></span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center border-l border-r border-gray-800">
                            <span class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Rank</span>
                            <div class="flex items-center gap-1 mt-1 text-gray-300">
                                <span class="text-xs text-gray-500">#</span>
                                <span id="panel-rank" class="font-bold text-sm"></span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Popularity</span>
                            <div class="flex items-center gap-1 mt-1 text-gray-300">
                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span id="panel-popularity" class="font-bold text-sm"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button class="flex-1 bg-brand-accent hover:bg-brand-accentHover text-white font-medium py-2.5 rounded-lg flex items-center justify-center gap-2 transition-colors shadow-lg shadow-brand-accent/25 ring-1 ring-brand-accent/50">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            <span>Continue Watching</span>
                        </button>
                        <button onclick="openEditAnimeModal()" class="px-4 py-2.5 bg-brand-card hover:bg-gray-800 text-gray-300 rounded-lg font-medium transition-colors border border-gray-700 flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Edit
                        </button>
                        <form id="delete-anime-form" method="POST" class="inline-block m-0" onsubmit="return confirm('Are you sure you want to delete this anime?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2.5 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-lg font-medium transition-colors border border-red-500/20 flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Info -->
                    <div class="space-y-4">
                        <h3 class="font-semibold border-b border-gray-800 pb-2 text-sm text-gray-400 uppercase tracking-wider">Information</h3>
                        
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center bg-brand-card/30 p-2 rounded-md">
                                <span class="text-gray-500">Format</span>
                                <span id="panel-format" class="font-medium text-gray-300"></span>
                            </div>
                            <div class="flex justify-between items-center bg-brand-card/30 p-2 rounded-md">
                                <span class="text-gray-500">Episodes</span>
                                <span id="panel-episodes" class="font-medium text-gray-300"></span>
                            </div>
                            <div class="flex justify-between items-center bg-brand-card/30 p-2 rounded-md">
                                <span class="text-gray-500">Season</span>
                                <span id="panel-season" class="font-medium text-gray-300"></span>
                            </div>
                        </div>

                        <!-- Genres -->
                        <div class="pt-3">
                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-2.5 block">Genres</span>
                            <div id="panel-genres" class="flex flex-wrap gap-2">
                                <!-- Genres injected JS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Collection Grid Modal -->
        <div id="collection-grid-modal" class="fixed inset-0 z-[110] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
            <!-- Modal Backdrop -->
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" onclick="closeCollectionGrid()"></div>
            <!-- Modal Content -->
            <div class="relative w-[95%] max-w-7xl h-[85vh] bg-brand-dark/95 border border-gray-800 rounded-2xl shadow-2xl flex flex-col overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center bg-brand-card/50 shrink-0">
                    <div class="flex items-center gap-3 text-brand-accent">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <h2 id="collection-grid-title" class="text-2xl font-black text-white truncate max-w-[400px]">Collection</h2>
                    </div>
                    <button onclick="closeCollectionGrid()" class="p-2 bg-gray-800/50 hover:bg-gray-700/80 rounded-full text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Grid Container -->
                <div class="flex-1 min-h-0 overflow-y-auto p-6 custom-scrollbar bg-black/20">
                    <div id="collection-grid-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6 pb-8">
                        <!-- Injected via JS from hidden templates -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay for single anime panel -->
        <div id="panel-overlay" onclick="closeAllPanels()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden transition-opacity opacity-0"></div>
    </x-slot>

    <!-- Custom Style & Script for Panel -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #2a3040;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #3a4258;
        }
    </style>

    <script>
        function closeAllPanels() {
            closePanel();
            closeCollectionGrid();
        }

        function openPanel(anime) {
            const panel = document.getElementById('anime-details-panel');
            const overlay = document.getElementById('panel-overlay');

            // Populate data
            document.getElementById('panel-banner').src = anime.image_url;
            document.getElementById('panel-poster').src = anime.image_url;
            document.getElementById('panel-title').innerText = anime.title;
            document.getElementById('panel-status').innerText = anime.status;
            document.getElementById('panel-score').innerText = anime.score || '-';
            document.getElementById('panel-global-score').innerText = anime.global_score || '-';
            document.getElementById('panel-rank').innerText = anime.rank || '-';
            document.getElementById('panel-popularity').innerText = anime.popularity || '-';
            document.getElementById('panel-format').innerText = anime.format || 'Unknown';
            document.getElementById('panel-episodes').innerText = anime.episodes || 'Unknown';
            document.getElementById('panel-season').innerText = anime.season || 'Unknown';

            // Handle Genres
            const genresContainer = document.getElementById('panel-genres');
            genresContainer.innerHTML = '';
            if (anime.genres && Array.isArray(anime.genres)) {
                anime.genres.forEach(genre => {
                    const span = document.createElement('span');
                    span.className = 'px-2.5 py-1 bg-brand-card border border-gray-700 rounded-md text-xs font-medium text-gray-300 shadow-sm';
                    span.innerText = genre;
                    genresContainer.appendChild(span);
                });
            }

            // Handle Details View Button
            const viewDetailsBtn = document.getElementById('btn-view-details');
            if (viewDetailsBtn) {
                if (anime.id) {
                    viewDetailsBtn.classList.remove('hidden');
                    viewDetailsBtn.href = `/anime-board/${anime.id}`;
                } else {
                    viewDetailsBtn.classList.add('hidden');
                }
            }

            // Handle Delete View Button
            const deleteForm = document.getElementById('delete-anime-form');
            if (deleteForm && anime.id) {
                deleteForm.action = `/anime/${anime.id}`;
            }

            // Finally show panel
            document.getElementById('anime-details-panel').classList.remove('translate-x-full');
            
            // Show overlay
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
            }, 10);
        }

        function closePanel() {
            document.getElementById('anime-details-panel').classList.add('translate-x-full');
            window.currentActiveAnime = null;
            
            // Only hide overlay if collection grid is also closed
            if (document.getElementById('collection-grid-modal').classList.contains('hidden')) {
                const overlay = document.getElementById('panel-overlay');
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        function openCollectionGrid(tplId, groupName) {
            closePanel(); // Close single view if open

            document.getElementById('collection-grid-title').innerText = groupName || 'Collection';
            
            // Grab template and inject
            const tpl = document.getElementById('collection-tpl-' + tplId);
            const container = document.getElementById('collection-grid-container');
            if(tpl) {
                container.innerHTML = tpl.innerHTML;
            }

            const modal = document.getElementById('collection-grid-modal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
            }, 10);
        }

        function closeCollectionGrid() {
            const modal = document.getElementById('collection-grid-modal');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('collection-grid-container').innerHTML = ''; // free memory
            }, 300);
            
            // if details panel is open, ensure overlay stays active, otherwise handled by closePanel
            if (document.getElementById('anime-details-panel').classList.contains('translate-x-full')) {
                const overlay = document.getElementById('panel-overlay');
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        // Tab Switching Logic
        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            
            // Remove active styling from all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active-tab', 'bg-brand-card', 'text-white', 'ring-1', 'ring-brand-accent/50');
                btn.classList.add('text-gray-400', 'hover:text-white', 'hover:bg-brand-card/50');
            });

            // Show target content
            document.getElementById('tab-content-' + tabId).classList.remove('hidden');

            // Apply active styling to target button
            const activeBtn = document.getElementById('tab-btn-' + tabId);
            activeBtn.classList.remove('text-gray-400', 'hover:text-white', 'hover:bg-brand-card/50');
            activeBtn.classList.add('active-tab', 'bg-brand-card', 'text-white', 'ring-1', 'ring-brand-accent/50');
        }

        // Initialize SortableJS
        let sortableInstances = [];

        document.addEventListener('DOMContentLoaded', () => {
            const grids = [
                document.getElementById('tab-content-watching'),
                document.getElementById('tab-content-plan-to-watch'),
                document.getElementById('tab-content-completed'),
                document.getElementById('tab-content-dropped')
            ];

            grids.forEach(grid => {
                if(grid) {
                    const instance = new Sortable(grid, {
                        animation: 150,
                        ghostClass: 'opacity-50',
                        disabled: true, // Drag state defaults to OFF
                        onEnd: function (evt) {
                            // Collect the new order of IDs
                            const items = Array.from(grid.children);
                            const orderedIds = items.map(item => item.getAttribute('data-id')).filter(id => id);
                            
                            if (orderedIds.length > 0) {
                                fetch('{{ route('anime-board.reorder') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ anime_ids: orderedIds })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if(!data.success) {
                                        console.error('Failed to sort animes');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error sorting animes:', error);
                                });
                            }
                        }
                    });

                    sortableInstances.push(instance);
                }
            });
        });

        function toggleDragDrop() {
            const isEnabled = document.getElementById('toggle-drag-drop').checked;
            
            // Enable or disable Sortable instances
            sortableInstances.forEach(instance => {
                instance.option('disabled', !isEnabled);
            });

            // Toggle CSS classes to show a grab cursor or normal view
            document.querySelectorAll('.tab-content').forEach(grid => {
                if(isEnabled) {
                    grid.classList.add('cursor-grab');
                } else {
                    grid.classList.remove('cursor-grab');
                }
            });
        }
    </script>
</x-anime-layout>
