<link rel="stylesheet" href="/Views/partials/sidebar_right/sidebar_right.css">
<aside class="sidebar-right">
    <div class="sidebar-content">
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