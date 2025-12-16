<?php 
session_start(); 
// 設定 Partial 路徑前綴
// 修正為絕對路徑，避免深層目錄引用錯誤
$path_prefix = "../../partials/"; 

// 1. 修改接收參數：從 id 改為 game (這是你的 sidebar 傳過來的參數名)
$game_title = isset($_GET['game']) ? $_GET['game'] : '';
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($game_title); ?> - 遊戲詳情</title>
    <link rel="stylesheet" href="/Views/partials/layout.css">
    <link rel="stylesheet" href="game.css">
    <style>
        /* 針對貼文卡片補充樣式 */
        .review-item { display: flex; gap: 12px; background: #151621; border: 1px solid #222438; border-radius: 10px; padding: 12px; margin-bottom: 12px; }
        .review-cover { width: 120px; flex-shrink: 0; }
        .review-cover img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; background: #0b0c15; min-height: 90px; }
        .review-body { flex: 1; display: flex; flex-direction: column; gap: 6px; }
        .review-actions { display: flex; gap: 8px; justify-content: flex-end; margin-top: 4px; }
        .btn-text { background: transparent; color: #e5e7ff; border: 1px solid #3a3d5c; padding: 6px 10px; border-radius: 6px; cursor: pointer; }
        .btn-text:hover { border-color: #6c63ff; color: #fff; }
    </style>
</head>
<body>

    <?php include $path_prefix . 'Header/index.php'; ?>

    <div class="main-wrapper">
        
        <div class="sidebar-area">
            <?php include $path_prefix . 'sidebar_left/index.php'; ?>
        </div>

        <main class="main-content">
            <div id="gameDetailArea" class="game-detail-container">
                <p>載入遊戲資訊中...</p>
            </div>

            <div class="comments-section">
                <h3>貼文列表</h3>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <button class="btn-comment" onclick="alert('請使用右側邊欄的新增貼文功能')">我要評論</button>
                <?php endif; ?>

                <div id="postList"></div>
            </div>
        </main>

        <div class="sidebar-area">
            <?php include $path_prefix . 'sidebar_right/index.php'; ?>
        </div>

    </div>

    <?php include $path_prefix . 'footer/index.php'; ?>

    <script>
        // 2. 將 PHP 變數傳給 JS
        const gameTitle = "<?php echo htmlspecialchars($game_title); ?>";

        document.addEventListener('DOMContentLoaded', () => {
            if(gameTitle) {
                fetchGameDetails(gameTitle);
            } else {
                document.getElementById('gameDetailArea').innerHTML = '<p>無效的遊戲名稱</p>';
            }
        });

        async function fetchGameDetails(title) {
            try {
                // 3. 修改 API 呼叫：參數改為 title
                // 使用 encodeURIComponent 處理中文或特殊符號
                const res = await fetch(`../../../api/getGameDetailsAPI.php?title=${encodeURIComponent(title)}`);
                const data = await res.json();
                
                if (data.status === 'success') {
                    renderGame(data.game);
                    loadGamePosts(data.game.game_id);
                } else {
                    document.getElementById('gameDetailArea').innerHTML = `<p>${data.message}</p>`;
                }
            } catch (error) {
                console.error(error);
                document.getElementById('gameDetailArea').innerHTML = '<p>載入失敗</p>';
            }
        }

        async function loadGamePosts(gameId) {
            const list = document.getElementById('postList');
            list.innerHTML = '<p class="no-data">載入貼文中...</p>';
            try {
                const res = await fetch(`../../../api/getPostsByGameAPI.php?game_id=${gameId}`);
                const data = await res.json();
                if (data.status !== 'success') throw new Error(data.message || '載入失敗');
                renderPosts(data.data);
            } catch (err) {
                list.innerHTML = `<p class="no-data">${err.message}</p>`;
            }
        }

        function renderGame(game) {
            const imgUrl = game.image ? game.image : 'https://placehold.co/400x300';
            const rating = game.avg_rating ? parseFloat(game.avg_rating).toFixed(1) : 'N/A';

            const html = `
                <div class="game-header">
                    <div class="game-cover">
                        <img src="${imgUrl}" alt="${game.game_title}">
                    </div>
                    <div class="game-info">
                        <h1>${game.game_title}</h1>
                        <p class="meta">類型: ${game.genre} | 平台: ${game.platform}</p>
                        <p class="price">價格: $${game.price}</p>
                        <div class="rating-display">
                            <span class="score">${rating}</span>
                            <span class="count"> / 10 (${game.review_count} 人評分)</span>
                        </div>
                        <p class="description">${game.description}</p>
                    </div>
                </div>
            `;
            document.getElementById('gameDetailArea').innerHTML = html;
        }

        function renderPosts(posts) {
            const list = document.getElementById('postList');
            list.innerHTML = '';

            if (!posts.length) {
                list.innerHTML = '<p class="no-data">目前尚無貼文，快來搶頭香！</p>';
                return;
            }

            posts.forEach(post => {
                const rating = post.rating ? `${post.rating} 分` : '尚未評分';
                const image = post.image_url ? post.image_url : 'https://placehold.co/300x200?text=No+Image';
                const item = `
                    <div class="review-item">
                        <div class="review-cover">
                            <img src="${image}" alt="post image">
                        </div>
                        <div class="review-body">
                            <div class="review-title">
                                <strong>${escapeHtml(post.title)}</strong>
                                <span class="rating-badge">${rating}</span>
                            </div>
                            <p class="review-content">${escapeHtml(post.content)}</p>
                            <div class="review-footer">
                                <span>作者: ${escapeHtml(post.username)}</span>
                                <span>時間: ${post.post_date}</span>
                            </div>
                            <div class="review-actions">
                                <a class="btn-text" href="../post/detail/index.php?id=${post.post_id}">查看貼文</a>
                                <a class="btn-text" href="../post/postEditing/index.php?id=${post.post_id}">編輯貼文</a>
                            </div>
                        </div>
                    </div>
                `;
                list.innerHTML += item;
            });
        }

        function escapeHtml(str) {
            return str ? str.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[c])) : '';
        }
    </script>
</body>
</html>