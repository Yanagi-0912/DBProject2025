<link rel="stylesheet" href="/Views/partials/sidebar_left/sidebar_left.css">
<aside class="sidebar-left">
    <div class="sidebar-content">
        <h2 class="sidebar-title">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M10 2L12.09 7.26L17.18 8.03L13.59 11.54L14.45 16.61L10 14.27L5.55 16.61L6.41 11.54L2.82 8.03L7.91 7.26L10 2Z" fill="currentColor"/>
            </svg>
            熱門遊戲排行榜
        </h2>
        
        <div id="gameRanking" class="game-ranking-list">
            <p class="game-posts">載入中...</p>
        </div>

        <a href="/Views/pages/home/index.php" class="view-all-link">回首頁查看更多 →</a>
    </div>
</aside>



<script>
document.addEventListener('DOMContentLoaded', function() {
    loadRanking();
});

async function loadRanking() {
    const container = document.getElementById('gameRanking');
    container.innerHTML = '<p class="game-posts">載入中...</p>';
    try {
        const res = await fetch('/api/getTopGamesAPI.php?limit=5');
        const data = await res.json();
        if (data.status !== 'success') throw new Error(data.message || '載入失敗');
        renderRanking(data.data);
    } catch (err) {
        container.innerHTML = `<p class="game-posts">${err.message}</p>`;
    }
}

function renderRanking(list) {
    const container = document.getElementById('gameRanking');
    container.innerHTML = '';
    if (!list.length) {
        container.innerHTML = '<p class="game-posts">目前沒有資料</p>';
        return;
    }

    list.forEach((item, idx) => {
        const rank = idx + 1;
        const img = item.image ? item.image : 'https://placehold.co/80x80?text=Game';
        const div = document.createElement('div');
        div.className = 'game-rank-item';
        div.dataset.rank = rank;
        div.innerHTML = `
            <div class="rank-number ${rank <= 3 ? 'top-rank' : ''}">${rank}</div>
            <div class="game-info">
                <div class="game-avatar"><img src="${img}" alt="${item.game_title}" style="width:40px;height:40px;border-radius:8px;object-fit:cover;" /></div>
                <div class="game-details">
                    <h3 class="game-name">${escapeHtml(item.game_title)}</h3>
                    <p class="game-posts">${item.post_count} 篇貼文</p>
                </div>
            </div>
            <div class="trend-indicator up">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3L8 13M8 3L4 7M8 3L12 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        `;
        div.addEventListener('click', () => {
            window.location.href = `/Views/pages/game/index.php?game=${encodeURIComponent(item.game_title)}`;
        });
        container.appendChild(div);
    });
}

function escapeHtml(str) {
    return str ? str.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[c])) : '';
}
</script>