<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Anime Board</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-300 bg-brand-darkest h-screen flex overflow-hidden">
    
    <!-- Sidebar -->
    <x-sidebar />

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Top Navigation / Search -->
        <header class="h-16 flex items-center justify-between px-4 lg:px-8 bg-brand-darkest shrink-0 border-b border-gray-800 md:border-none">
            <div class="flex items-center gap-3">
                <button onclick="openSidebar()" class="md:hidden p-2 text-gray-400 hover:text-white rounded-lg hover:bg-gray-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-xl md:text-2xl font-bold text-white tracking-wide">
                    Anime Boards
                    <span class="hidden md:block text-xs font-normal text-gray-400 tracking-normal mt-0.5">Track your anime list and organize your watching schedule.</span>
                </h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative w-64 hidden md:block">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" placeholder="Search anime by title..." class="w-full pl-10 pr-4 py-2 bg-brand-dark border-transparent rounded-lg text-sm focus:border-brand-accent focus:ring-1 focus:ring-brand-accent text-white placeholder-gray-500 transition-colors">
                </div>
                <button onclick="openAddAnimeModal()" class="bg-brand-accent hover:bg-brand-accentHover text-white px-3 py-2 md:px-4 md:py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2 shadow-sm shadow-brand-accent/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="hidden sm:inline">Add anime</span>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-auto overflow-y-hidden p-4 lg:p-8 pt-4">
            {{ $slot }}
        </main>
    </div>

    <!-- Optional Detail Panel Slot -->
    @if (isset($detailsPanel))
        {{ $detailsPanel }}
    @endif

    <!-- Add Anime Modal -->
    <div id="add-anime-modal" class="fixed inset-0 z-[60] hidden flex items-center justify-center">
        <!-- Overlay -->
        <div onclick="closeAddAnimeModal()" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0" id="add-modal-overlay"></div>
        
        <!-- Modal Content -->
        <div id="add-modal-content" class="relative bg-brand-dark border border-gray-800 rounded-2xl w-full max-w-2xl transform scale-95 opacity-0 transition-all duration-300 shadow-2xl p-6 lg:p-8 m-4 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeAddAnimeModal()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white hover:bg-gray-800 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <h2 id="add-modal-heading" class="text-2xl font-bold text-white mb-6">Add New Anime</h2>

            <form id="add-anime-form" action="{{ route('anime-board.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="mal_id" id="add-input-mal_id">
                <input type="hidden" name="description" id="add-input-description">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="add-input-title" required class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="add-input-status" required class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                            <option value="Watching">Watching</option>
                            <option value="Plan to watch">Plan to watch</option>
                            <option value="Completed">Completed</option>
                            <option value="Dropped">Dropped</option>
                        </select>
                    </div>

                    <!-- Grouping Logic -->
                    <div class="md:col-span-2 space-y-3 p-3 bg-black/20 border border-gray-800 rounded-lg">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="add-toggle-group" onchange="toggleGroupInput('add')" class="w-4 h-4 text-brand-accent bg-brand-card border-gray-700 rounded focus:ring-brand-accent focus:ring-2">
                            <label for="add-toggle-group" class="text-sm font-medium text-gray-300 cursor-pointer">Group this anime as part of a franchise?</label>
                        </div>
                        
                        <div id="add-group-container" class="hidden space-y-1 pl-6 transition-all">
                            <label class="block text-xs font-medium text-gray-500">Collection / Franchise Name</label>
                            <input type="text" name="group_name" id="add-input-group_name" list="available-groups" placeholder="e.g. Naruto or select existing..." class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                        </div>
                    </div>
                    
                    <div class="space-y-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400">Genres (Comma separated)</label>
                        <input type="text" name="genres" id="add-input-genres" placeholder="Action, Adventure, Fantasy" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Format</label>
                        <input type="text" name="format" id="add-input-format" placeholder="TV Series" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Season</label>
                        <input type="text" name="season" id="add-input-season" placeholder="Fall 2024" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Total Episodes</label>
                        <input type="number" name="episodes" id="add-input-episodes" min="1" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    <div class="space-y-1" id="add-progress-container">
                        <label class="block text-sm font-medium text-gray-400">Episodes Watched</label>
                        <input type="number" name="progress" id="add-input-progress" min="0" value="0" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2" id="add-completed-checkbox-container">
                        <input type="checkbox" name="is_completed" id="add-input-is_completed" onchange="toggleCompletedAnime('add')" class="w-4 h-4 text-brand-accent bg-brand-card border-gray-700 rounded focus:ring-brand-accent focus:ring-2">
                        <label for="add-input-is_completed" class="text-sm font-medium text-gray-400 cursor-pointer">I have completed this anime</label>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Personal Score (0-10)</label>
                        <input type="number" name="score" id="add-input-score" step="0.1" min="0" max="10" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Global Score (0-10)</label>
                        <input type="number" name="global_score" id="add-input-global_score" step="0.1" min="0" max="10" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    
                    <div class="space-y-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400">Rank</label>
                        <input type="number" name="rank" id="add-input-rank" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400">Popularity</label>
                        <input type="number" name="popularity" id="add-input-popularity" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-800">
                    <button type="button" onclick="closeAddAnimeModal()" class="px-5 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-brand-accent hover:bg-brand-accentHover text-white rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-accent/20">
                        Save Anime
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Anime Modal -->
    <div id="edit-anime-modal" class="fixed inset-0 z-[60] hidden flex items-center justify-center">
        <!-- Overlay -->
        <div onclick="closeEditAnimeModal()" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0" id="edit-modal-overlay"></div>
        
        <!-- Modal Content -->
        <div id="edit-modal-content" class="relative bg-brand-dark border border-gray-800 rounded-2xl w-full max-w-2xl transform scale-95 opacity-0 transition-all duration-300 shadow-2xl p-6 lg:p-8 m-4 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeEditAnimeModal()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white hover:bg-gray-800 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <h2 class="text-2xl font-bold text-white mb-6">Edit <span id="edit-modal-title" class="text-brand-accent"></span></h2>

            <form id="edit-anime-form" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="edit-input-title" required class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="edit-input-status" required class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                            <option value="Watching">Watching</option>
                            <option value="Plan to watch">Plan to watch</option>
                            <option value="Completed">Completed</option>
                            <option value="Dropped">Dropped</option>
                        </select>
                    </div>

                    <!-- Grouping Logic -->
                    <div class="md:col-span-2 space-y-3 p-3 bg-black/20 border border-gray-800 rounded-lg">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="edit-toggle-group" onchange="toggleGroupInput('edit')" class="w-4 h-4 text-brand-accent bg-brand-card border-gray-700 rounded focus:ring-brand-accent focus:ring-2">
                            <label for="edit-toggle-group" class="text-sm font-medium text-gray-300 cursor-pointer">Group this anime as part of a franchise?</label>
                        </div>
                        
                        <div id="edit-group-container" class="hidden space-y-1 pl-6 transition-all">
                            <label class="block text-xs font-medium text-gray-500">Collection / Franchise Name</label>
                            <input type="text" name="group_name" id="edit-input-group_name" list="available-groups" placeholder="e.g. Naruto or select existing..." class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                        </div>
                    </div>
                    
                    <div class="space-y-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400">Genres (Comma separated)</label>
                        <input type="text" name="genres" id="edit-input-genres" placeholder="Action, Adventure, Fantasy" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Format</label>
                        <input type="text" name="format" id="edit-input-format" placeholder="TV Series" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Season</label>
                        <input type="text" name="season" id="edit-input-season" placeholder="Fall 2024" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Total Episodes</label>
                        <input type="number" name="episodes" id="edit-input-episodes" min="1" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    <div class="space-y-1" id="edit-progress-container">
                        <label class="block text-sm font-medium text-gray-400">Episodes Watched</label>
                        <input type="number" name="progress" id="edit-input-progress" min="0" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>

                    <div class="flex items-center gap-2 mt-2" id="edit-completed-checkbox-container">
                        <input type="checkbox" name="is_completed" id="edit-input-is_completed" onchange="toggleCompletedAnime('edit')" class="w-4 h-4 text-brand-accent bg-brand-card border-gray-700 rounded focus:ring-brand-accent focus:ring-2">
                        <label for="edit-input-is_completed" class="text-sm font-medium text-gray-400 cursor-pointer">I have completed this anime</label>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Personal Score (0-10)</label>
                        <input type="number" name="score" id="edit-input-score" step="0.1" min="0" max="10" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-400">Global Score (0-10)</label>
                        <input type="number" name="global_score" id="edit-input-global_score" step="0.1" min="0" max="10" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-800">
                    <button type="button" onclick="closeEditAnimeModal()" class="px-5 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-brand-accent hover:bg-brand-accentHover text-white rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-accent/20">
                        Update Anime
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Add Modal -->
    <div id="quick-add-modal" class="fixed inset-0 z-[70] hidden flex items-center justify-center">
        <!-- Overlay -->
        <div onclick="closeQuickAddModal()" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0" id="quick-add-modal-overlay"></div>
        
        <!-- Modal Content -->
        <div id="quick-add-modal-content" class="relative bg-brand-dark border border-gray-800 rounded-2xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 shadow-2xl p-6 lg:p-8 m-4 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeQuickAddModal()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white hover:bg-gray-800 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <h2 class="text-2xl font-bold text-white mb-2">Quick Add</h2>
            <p id="quick-add-modal-title" class="text-sm text-gray-400 mb-6 truncate"></p>

            <form id="quick-add-form" action="{{ route('anime-board.store') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Hidden fields for API data -->
                <div id="quick-add-hidden-fields"></div>

                <!-- Grouping Logic -->
                <div class="space-y-3 p-3 bg-black/20 border border-gray-800 rounded-lg">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="quick-add-toggle-group" onchange="toggleGroupInput('quick-add')" class="w-4 h-4 text-brand-accent bg-brand-card border-gray-700 rounded focus:ring-brand-accent focus:ring-2">
                        <label for="quick-add-toggle-group" class="text-sm font-medium text-gray-300 cursor-pointer">Group this anime as part of a franchise?</label>
                    </div>
                    
                    <div id="quick-add-group-container" class="hidden space-y-1 pl-6 transition-all">
                        <label class="block text-xs font-medium text-gray-500">Collection / Franchise Name</label>
                        <input type="text" name="group_name" id="quick-add-input-group_name" list="available-groups" placeholder="e.g. Naruto or select existing..." class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-400">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="quick-add-input-status" required class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                        <option value="Watching">Watching</option>
                        <option value="Plan to watch">Plan to watch</option>
                        <option value="Completed">Completed</option>
                        <option value="Dropped">Dropped</option>
                    </select>
                </div>

                <div class="space-y-1" id="quick-add-progress-container">
                    <label class="block text-sm font-medium text-gray-400">Episodes Watched</label>
                    <input type="number" name="progress" id="quick-add-input-progress" min="0" value="0" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                </div>

                <div class="flex items-center gap-2 mt-2" id="quick-add-completed-checkbox-container">
                    <input type="checkbox" name="is_completed" id="quick-add-input-is_completed" onchange="toggleCompletedAnime('quick-add')" class="w-4 h-4 text-brand-accent bg-brand-card border-gray-700 rounded focus:ring-brand-accent focus:ring-2">
                    <label for="quick-add-input-is_completed" class="text-sm font-medium text-gray-400 cursor-pointer">I have completed this anime</label>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-400">Personal Score (0-10)</label>
                    <input type="number" name="score" id="quick-add-input-score" step="0.1" min="0" max="10" placeholder="e.g. 8.5" class="w-full px-3 py-2 bg-brand-card border border-gray-700 rounded-lg text-white focus:ring-1 focus:ring-brand-accent focus:border-brand-accent">
                </div>

                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-800">
                    <button type="button" onclick="closeQuickAddModal()" class="px-5 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-brand-accent hover:bg-brand-accentHover text-white rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-accent/20">
                        Save to List
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Datalist for Anime Franchises -->
    <datalist id="available-groups">
        @if(isset($availableGroups))
            @foreach($availableGroups as $grp)
                <option value="{{ $grp }}">
            @endforeach
        @endif
    </datalist>

    <script>
        // Store current active anime globally when panel opens
        window.currentActiveAnime = null;
        
        // Sidebar Mobile Toggle functions
        function openSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('mobile-sidebar-overlay');
            if(sidebar && overlay) {
                overlay.classList.remove('hidden');
                sidebar.classList.remove('-translate-x-full');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                }, 10);
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('mobile-sidebar-overlay');
            if(sidebar && overlay) {
                overlay.classList.add('opacity-0');
                sidebar.classList.add('-translate-x-full');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        // Listen for openPanel event to save the data
        const originalOpenPanel = window.openPanel;
        window.openPanel = function(anime) {
            window.currentActiveAnime = anime;
            if(originalOpenPanel) {
                originalOpenPanel(anime);
            }
        };

        // Basic guesser to auto-populate the Franchises
        function guessGroupName(title) {
            if (!title) return '';
            // Basic rules: remove anything after ':', '-', 'Season', 'Part', '2nd', '3rd', etc.
            let parts = title.split(':');
            let base = parts[0];
            
            // Also split by common words indicating sequels
            let sequelKeywords = ['Season', 'Part', '2nd', '3rd', '4th', '5th', 'Final'];
            for (let keyword of sequelKeywords) {
                let index = base.indexOf(keyword);
                if (index > 0) {
                    base = base.substring(0, index);
                }
            }
            return base.trim();
        }

        function openAddAnimeModal(anime = null) {
            // Clear fields for a truly "New" anime, if called directly
            document.getElementById('add-anime-form').reset();
            document.getElementById('add-input-mal_id').value = '';
            document.getElementById('add-input-description').value = '';
            document.getElementById('add-input-progress').value = '0';
            
            document.getElementById('add-input-is_completed').checked = false;
            document.getElementById('add-toggle-group').checked = false;
            toggleGroupInput('add');
            document.getElementById('add-input-group_name').value = ''; // Clear group name
            if (document.getElementById('add-input-genres')) {
                document.getElementById('add-input-genres').value = ''; // Clear genres
            }
            toggleCompletedAnime('add');

            if (anime) {
                // Populate fields with API data
                document.getElementById('add-input-title').value = anime.title || '';
                document.getElementById('add-input-image_url').value = anime.image_url || '';
                document.getElementById('add-input-format').value = anime.format || '';
                document.getElementById('add-input-season').value = anime.season || '';
                document.getElementById('add-input-episodes').value = anime.episodes || '';
                document.getElementById('add-input-global_score').value = anime.global_score || '';
                document.getElementById('add-input-rank').value = anime.rank || '';
                document.getElementById('add-input-popularity').value = anime.popularity || '';
                document.getElementById('add-input-mal_id').value = anime.mal_id || '';
                document.getElementById('add-input-description').value = anime.description || '';
                document.getElementById('add-input-group_name').value = guessGroupName(anime.title);
                
                if (anime.genres && Array.isArray(anime.genres)) {
                    document.getElementById('add-input-genres').value = anime.genres.join(', ');
                }

                document.getElementById('add-modal-heading').innerText = "Add " + anime.title + " to My List";
            } else {
                document.getElementById('add-modal-heading').innerText = "Add New Anime";
            }
            
            showAddModalUI();
            
            // Close details panel instantly so it doesn't overlap weirdly
            closePanel();
        }

        function openAddFromBrowserModal() {
            openAddAnimeModal(window.currentActiveAnime);
        }

        function showAddModalUI() {
            const modal = document.getElementById('add-anime-modal');
            const overlay = document.getElementById('add-modal-overlay');
            const content = document.getElementById('add-modal-content');

            modal.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                content.classList.remove('opacity-0', 'scale-95');
                content.classList.add('scale-100');
            }, 10);
        }

        function closeAddAnimeModal() {
            const modal = document.getElementById('add-anime-modal');
            const overlay = document.getElementById('add-modal-overlay');
            const content = document.getElementById('add-modal-content');

            overlay.classList.add('opacity-0');
            content.classList.add('opacity-0', 'scale-95');
            content.classList.remove('scale-100');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function openEditAnimeModal() {
            if (!window.currentActiveAnime) return;
            
            const anime = window.currentActiveAnime;
            const modal = document.getElementById('edit-anime-modal');
            const overlay = document.getElementById('edit-modal-overlay');
            const content = document.getElementById('edit-modal-content');

            // Populate Form Fields
            document.getElementById('edit-modal-title').innerText = anime.title;
            document.getElementById('edit-anime-form').action = `/anime/${anime.id}`;
            
            document.getElementById('edit-input-title').value = anime.title;
            document.getElementById('edit-input-genres').value = (anime.genres && Array.isArray(anime.genres)) ? anime.genres.join(', ') : '';
            
            // Handle group check
            const groupInput = document.getElementById('edit-input-group_name');
            groupInput.value = anime.group_name || '';
            const groupToggle = document.getElementById('edit-toggle-group');
            groupToggle.checked = !!anime.group_name;
            toggleGroupInput('edit');

            document.getElementById('edit-input-format').value = anime.format || '';
            document.getElementById('edit-input-season').value = anime.season || '';
            document.getElementById('edit-input-episodes').value = anime.episodes || '';
            document.getElementById('edit-input-progress').value = anime.progress || '0';
            document.getElementById('edit-input-score').value = anime.score || '';
            document.getElementById('edit-input-global_score').value = anime.global_score || '';

            // Handle Completed logic
            const isCompletedCheckbox = document.getElementById('edit-input-is_completed');
            isCompletedCheckbox.checked = (anime.progress >= anime.episodes && anime.episodes > 0) || anime.status === 'Completed';
            toggleCompletedAnime('edit');
            
            if (anime.genres && Array.isArray(anime.genres)) {
                document.getElementById('edit-input-genres').value = anime.genres.join(', ');
            } else {
                document.getElementById('edit-input-genres').value = '';
            }

            modal.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                content.classList.remove('opacity-0', 'scale-95');
                content.classList.add('scale-100');
            }, 10);
        }

        function closeEditAnimeModal() {
            const modal = document.getElementById('edit-anime-modal');
            const overlay = document.getElementById('edit-modal-overlay');
            const content = document.getElementById('edit-modal-content');

            overlay.classList.add('opacity-0');
            content.classList.add('opacity-0', 'scale-95');
            content.classList.remove('scale-100');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function openQuickAddModal(anime) {
            const modal = document.getElementById('quick-add-modal');
            const overlay = document.getElementById('quick-add-modal-overlay');
            const content = document.getElementById('quick-add-modal-content');

            document.getElementById('quick-add-modal-title').innerText = anime.title || 'Unknown Anime';
            document.getElementById('quick-add-form').reset();
            document.getElementById('quick-add-input-is_completed').checked = false;
            
            // Auto guess grouping
            const guessedGroup = guessGroupName(anime.title);
            document.getElementById('quick-add-input-group_name').value = guessedGroup;
            document.getElementById('quick-add-toggle-group').checked = !!guessedGroup;
            toggleGroupInput('quick-add');
            
            toggleCompletedAnime('quick-add');
            
            // Generate hidden fields
            const hiddenContainer = document.getElementById('quick-add-hidden-fields');
            hiddenContainer.innerHTML = '';
            
            const fieldsToInject = {
                title: anime.title || '',
                image_url: anime.image_url || '',
                format: anime.format || '',
                season: anime.season || '',
                episodes: anime.episodes || '',
                global_score: anime.global_score || '',
                rank: anime.rank || '',
                popularity: anime.popularity || '',
                mal_id: anime.mal_id || '',
                description: anime.description || ''
            };
            
            for (const [key, value] of Object.entries(fieldsToInject)) {
                if(value !== null && value !== '') {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    hiddenContainer.appendChild(input);
                }
            }
            
            if (anime.genres && Array.isArray(anime.genres)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'genres';
                input.value = anime.genres.join(', ');
                hiddenContainer.appendChild(input);
            }

            modal.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                content.classList.remove('opacity-0', 'scale-95');
                content.classList.add('scale-100');
            }, 10);
        }

        function closeQuickAddModal() {
            const modal = document.getElementById('quick-add-modal');
            const overlay = document.getElementById('quick-add-modal-overlay');
            const content = document.getElementById('quick-add-modal-content');

            overlay.classList.add('opacity-0');
            content.classList.add('opacity-0', 'scale-95');
            content.classList.remove('scale-100');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
        
        // Toggle Completed Anime Tracking
        function toggleCompletedAnime(prefix) {
            const isCompleted = document.getElementById(`${prefix}-input-is_completed`).checked;
            const progressContainer = document.getElementById(`${prefix}-progress-container`);
            const progressInput = document.getElementById(`${prefix}-input-progress`);
            const statusSelect = document.getElementById(`${prefix}-input-status`);

            // Check if status is manually set to Completed
            if (statusSelect && statusSelect.value === 'Completed') {
                 document.getElementById(`${prefix}-input-is_completed`).checked = true;
                 progressContainer.classList.add('hidden');
                 return;
            }

            if (isCompleted) {
                // Auto-hide progress
                progressContainer.classList.add('hidden');
                // Temporarily alter the select dropdown visually if we want
                if(statusSelect) statusSelect.value = 'Completed';
            } else {
                progressContainer.classList.remove('hidden');
            }
        }
        
        // Toggle Grouping UI
        function toggleGroupInput(prefix) {
            const isGrouped = document.getElementById(`${prefix}-toggle-group`).checked;
            const container = document.getElementById(`${prefix}-group-container`);
            const input = document.getElementById(`${prefix}-input-group_name`);
            
            if (isGrouped) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
                input.value = ''; // clear when disabled
            }
        }
        
        // Hook into status dropdowns to auto-check 'Completed'
        ['add', 'edit', 'quick-add'].forEach(prefix => {
            const statusSelect = document.getElementById(`${prefix}-input-status`);
            if (statusSelect) {
                statusSelect.addEventListener('change', (e) => {
                    if (e.target.value === 'Completed') {
                        document.getElementById(`${prefix}-input-is_completed`).checked = true;
                    } else {
                        document.getElementById(`${prefix}-input-is_completed`).checked = false;
                    }
                    toggleCompletedAnime(prefix);
                });
            }
        });
    </script>
</body>
</html>
