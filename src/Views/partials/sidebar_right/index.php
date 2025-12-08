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

<style>
.sidebar-right {
    width: 300px;
    background-color: #1a1a2e;
    border-left: 1px solid #2d2d44;
    height: calc(100vh - 60px);
    position: sticky;
    top: 60px;
    overflow-y: auto;
}

.sidebar-right .sidebar-content {
    padding: 24px 16px 100px 16px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.card-title {
    color: #ffffff;
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 16px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid #2d2d44;
}

/* Stats Card */
.stats-card {
    background: linear-gradient(135deg, #2d2d44 0%, #1f1f35 100%);
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #363653;
}

.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.stat-item {
    text-align: center;
    padding: 12px;
    background-color: rgba(78, 204, 163, 0.05);
    border-radius: 8px;
}

.stat-value {
    color: #4ecca3;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 4px;
}

.stat-label {
    color: #9b9b9b;
    font-size: 12px;
}

/* Topics Card */
.topics-card {
    background-color: #2d2d44;
    padding: 20px;
    border-radius: 12px;
}

.topics-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.topic-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 12px;
    background-color: #1a1a2e;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.topic-item:hover {
    background-color: #363653;
    transform: translateX(4px);
}

.topic-tag {
    color: #4ecca3;
    font-weight: 600;
    font-size: 14px;
}

.topic-count {
    color: #9b9b9b;
    font-size: 12px;
    background-color: #2d2d44;
    padding: 4px 8px;
    border-radius: 12px;
}

/* Create Post Button */
.create-post-container {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 268px;
    z-index: 100;
}

.create-post-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 16px 24px;
    background: linear-gradient(135deg, #4ecca3 0%, #3db88e 100%);
    color: #ffffff;
    border: none;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(78, 204, 163, 0.4);
    transition: all 0.3s ease;
}

.create-post-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(78, 204, 163, 0.6);
    background: linear-gradient(135deg, #3db88e 0%, #4ecca3 100%);
}

.create-post-btn:active {
    transform: translateY(0);
}

.plus-icon {
    stroke-width: 2.5;
}

/* Scrollbar styling */
.sidebar-right::-webkit-scrollbar {
    width: 6px;
}

.sidebar-right::-webkit-scrollbar-track {
    background: #1a1a2e;
}

.sidebar-right::-webkit-scrollbar-thumb {
    background: #4ecca3;
    border-radius: 3px;
}

.sidebar-right::-webkit-scrollbar-thumb:hover {
    background: #3db88e;
}

@media (max-width: 1280px) {
    .sidebar-right {
        display: none;
    }
    
    .create-post-container {
        right: 24px;
        width: auto;
    }
    
    .create-post-btn {
        width: 60px;
        height: 60px;
        padding: 0;
        border-radius: 50%;
    }
    
    .create-post-btn span {
        display: none;
    }
}

@media (max-width: 768px) {
    .create-post-container {
        right: 16px;
        bottom: 16px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create post button handler
    document.getElementById('create-post-btn')?.addEventListener('click', function() {
        window.location.href = '/src/Views/pages/post/postCreating/index.php';
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