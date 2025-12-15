<link rel="stylesheet" href="/Views/partials/sidebar_left/sidebar_left.css">
<aside class="sidebar-left">
    <div class="sidebar-content">
        <h2 class="sidebar-title">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M10 2L12.09 7.26L17.18 8.03L13.59 11.54L14.45 16.61L10 14.27L5.55 16.61L6.41 11.54L2.82 8.03L7.91 7.26L10 2Z" fill="currentColor"/>
            </svg>
            熱門遊戲排行榜
        </h2>
        
        <div class="game-ranking-list">
            <!-- Game Rank Item 1 -->
            <div class="game-rank-item" data-rank="1">
                <div class="rank-number top-rank">1</div>
                <div class="game-info">
                    <div class="game-avatar">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <rect width="40" height="40" rx="8" fill="#4ecca3"/>
                            <path d="M20 12L24 20H16L20 12Z" fill="white"/>
                            <rect x="16" y="22" width="8" height="6" rx="1" fill="white"/>
                        </svg>
                    </div>
                    <div class="game-details">
                        <h3 class="game-name">Apex Legends</h3>
                        <p class="game-posts">1,234 篇貼文</p>
                    </div>
                </div>
                <div class="trend-indicator up">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M8 3L8 13M8 3L4 7M8 3L12 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Game Rank Item 2 -->
            <div class="game-rank-item" data-rank="2">
                <div class="rank-number top-rank">2</div>
                <div class="game-info">
                    <div class="game-avatar">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <rect width="40" height="40" rx="8" fill="#f38181"/>
                            <circle cx="20" cy="20" r="8" fill="white"/>
                        </svg>
                    </div>
                    <div class="game-details">
                        <h3 class="game-name">League of Legends</h3>
                        <p class="game-posts">1,089 篇貼文</p>
                    </div>
                </div>
                <div class="trend-indicator up">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M8 3L8 13M8 3L4 7M8 3L12 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Game Rank Item 3 -->
            <div class="game-rank-item" data-rank="3">
                <div class="rank-number top-rank">3</div>
                <div class="game-info">
                    <div class="game-avatar">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <rect width="40" height="40" rx="8" fill="#aa96da"/>
                            <rect x="12" y="12" width="16" height="16" rx="2" fill="white"/>
                        </svg>
                    </div>
                    <div class="game-details">
                        <h3 class="game-name">Valorant</h3>
                        <p class="game-posts">876 篇貼文</p>
                    </div>
                </div>
                <div class="trend-indicator down">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M8 13L8 3M8 13L12 9M8 13L4 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Game Rank Item 4 -->
            <div class="game-rank-item" data-rank="4">
                <div class="rank-number">4</div>
                <div class="game-info">
                    <div class="game-avatar">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <rect width="40" height="40" rx="8" fill="#fcbad3"/>
                            <polygon points="20,10 26,18 20,26 14,18" fill="white"/>
                        </svg>
                    </div>
                    <div class="game-details">
                        <h3 class="game-name">Genshin Impact</h3>
                        <p class="game-posts">765 篇貼文</p>
                    </div>
                </div>
                <div class="trend-indicator up">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M8 3L8 13M8 3L4 7M8 3L12 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Game Rank Item 5 -->
            <div class="game-rank-item" data-rank="5">
                <div class="rank-number">5</div>
                <div class="game-info">
                    <div class="game-avatar">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <rect width="40" height="40" rx="8" fill="#a8d8ea"/>
                            <path d="M20 28C24.4183 28 28 24.4183 28 20C28 15.5817 24.4183 12 20 12C15.5817 12 12 15.5817 12 20C12 24.4183 15.5817 28 20 28Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="game-details">
                        <h3 class="game-name">Overwatch 2</h3>
                        <p class="game-posts">654 篇貼文</p>
                    </div>
                </div>
                <div class="trend-indicator down">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M8 13L8 3M8 13L12 9M8 13L4 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <a href="#" class="view-all-link">查看完整排行榜 →</a>
    </div>
</aside>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click handlers for game items
    const gameItems = document.querySelectorAll('.game-rank-item');
    gameItems.forEach(item => {
        item.addEventListener('click', function() {
            const gameName = this.querySelector('.game-name').textContent;
            // TODO: Navigate to game page or filter posts by game
            console.log('Clicked on game:', gameName);
            window.location.href = `/src/Views/pages/game/index.php?game=${encodeURIComponent(gameName)}`;
        });
    });

    // TODO: Fetch real game ranking data from API
    // fetch('/src/api/getGameRankings.php')
    //     .then(response => response.json())
    //     .then(data => updateGameRankings(data));
});
</script>