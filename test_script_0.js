
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

            // Finally show panel
            document.getElementById('anime-details-panel').classList.remove('translate-x-full');
            document.getElementById('collection-details-panel').classList.add('translate-x-full');
            
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
    