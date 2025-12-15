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
                <h3>評論列表</h3>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <button class="btn-comment" onclick="alert('請使用右側邊欄的新增貼文功能')">我要評論</button>
                <?php endif; ?>

                <div id="reviewList">
                    </div>
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
                    renderReviews(data.reviews);
                } else {
                    document.getElementById('gameDetailArea').innerHTML = `<p>${data.message}</p>`;
                }
            } catch (error) {
                console.error(error);
                document.getElementById('gameDetailArea').innerHTML = '<p>載入失敗</p>';
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

        function renderReviews(reviews) {
            const list = document.getElementById('reviewList');
            list.innerHTML = '';

            if (reviews.length === 0) {
                list.innerHTML = '<p class="no-data">目前尚無評論，快來搶頭香！</p>';
                return;
            }

            reviews.forEach(review => {
                const item = `
                    <div class="review-item">
                        <div class="review-title">
                            <strong>${review.title}</strong>
                            <span class="rating-badge">${review.rating} 分</span>
                        </div>
                        <p class="review-content">${review.content}</p>
                        <div class="review-footer">
                            <span>作者: ${review.username}</span>
                            <span>時間: ${review.post_date}</span>
                        </div>
                    </div>
                `;
                list.innerHTML += item;
            });
        }
    </script>
</body>
</html>