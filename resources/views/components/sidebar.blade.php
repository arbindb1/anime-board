<!-- Mobile Sidebar Overlay -->
<div id="mobile-sidebar-overlay" onclick="closeSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[90] hidden md:hidden transition-opacity opacity-0"></div>

<!-- Sidebar -->
<aside id="mobile-sidebar" class="w-64 bg-brand-dark h-full flex flex-col border-r border-gray-800 shrink-0 fixed inset-y-0 left-0 z-[100] transform -translate-x-full transition-transform duration-300 md:relative md:translate-x-0 md:flex">
    <div class="p-6 relative">
        <button onclick="closeSidebar()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white hover:bg-gray-800 rounded-full transition-colors md:hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="flex items-center gap-3 text-white font-bold text-lg mb-8 tracking-wide">
            <svg class="w-6 h-6 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
            </svg>
            My Anime Hub
        </div>

        <div class="mb-4">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Library</h3>
            <nav class="space-y-1">
                <a href="{{ route('anime-board.index') }}" class="flex items-center gap-3 px-3 py-2 bg-brand-card text-white rounded-lg hover:bg-brand-card/80 transition-colors">
                    <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="text-sm font-medium">My List</span>
                </a>
                <a href="{{ route('anime-board.browse') }}" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:text-white hover:bg-brand-card/50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">Browse Anime</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:text-white hover:bg-brand-card/50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <span class="text-sm font-medium">Favorites</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:text-white hover:bg-brand-card/50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">History</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- User Profile Area -->
    <div class="mt-auto p-4 border-t border-gray-800">
        <div class="flex items-center gap-3 bg-brand-card p-3 rounded-xl border border-gray-700/50 hover:border-gray-600 transition-colors cursor-pointer">
            <img src="https://ui-avatars.com/api/?name=Orion&background=6366f1&color=fff" alt="Orion" class="w-10 h-10 rounded-lg">
            <div class="flex flex-col">
                <span class="text-sm font-semibold text-white">Orion</span>
                <span class="text-xs text-gray-400">PRO Member</span>
            </div>
            <svg class="w-4 h-4 ml-auto text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>
</aside>
