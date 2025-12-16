<link rel="stylesheet" href="/Views/partials/sidebar_right/sidebar_right.css">
<aside class="sidebar-right">
    <div class="sidebar-content">
        <!-- Quick Stats Card -->
        <div class="stats-card">
            <h3 class="card-title">社群動態</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value">2.5K</div>
                    <div class="stat-label">今日貼文</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">12.8K</div>
                    <div class="stat-label">線上用戶</div>
                </div>
            </div>
        </div>

        <!-- Trending Topics -->
        <div class="topics-card">
            <h3 class="card-title">熱門話題</h3>
            <div class="topics-list">
                <a href="#" class="topic-item">
                    <span class="topic-tag">#新賽季</span>
                    <span class="topic-count">1.2K</span>
                </a>
                <a href="#" class="topic-item">
                    <span class="topic-tag">#電競賽事</span>
                    <span class="topic-count">856</span>
                </a>
                <a href="#" class="topic-item">
                    <span class="topic-tag">#攻略分享</span>
                    <span class="topic-count">734</span>
                </a>
                <a href="#" class="topic-item">
                    <span class="topic-tag">#精彩時刻</span>
                    <span class="topic-count">612</span>
                </a>
            </div>
        </div>

        <!-- Create Post Button - Fixed at bottom -->
        <div class="create-post-container">
            <button class="create-post-btn" id="create-post-btn">
                <svg class="plus-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
                <span>新增貼文</span>
            </button>
        </div>
    </div>
</aside>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create post button handler
    document.getElementById('create-post-btn')?.addEventListener('click', function() {
        window.location.href = '/Views/pages/post/postCreating/index.php';
    });

    // Topic items click handlers
    const topicItems = document.querySelectorAll('.topic-item');
    topicItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const topic = this.querySelector('.topic-tag').textContent;
            // TODO: Filter posts by topic
            console.log('Clicked on topic:', topic);
        });
    });

    // TODO: Fetch real stats and topics from API
    // fetch('/src/api/getStats.php')
    //     .then(response => response.json())
    //     .then(data => updateStats(data));
    
    // fetch('/src/api/getTrendingTopics.php')
    //     .then(response => response.json())
    //     .then(data => updateTopics(data));
});
</script>