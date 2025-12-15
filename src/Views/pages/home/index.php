<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首頁 - 遊戲列表</title>
    <link rel="stylesheet" href="/Views/partials/layout.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <?php include '../../partials/Header/index.php'; ?>

    <div class="main-wrapper">
        
        <div class="sidebar-area">
            <?php include '../../partials/sidebar_left/index.php'; ?>
        </div>

        <main class="main-content">
            
            <div class="filter-bar">
                <h2>所有遊戲</h2>
                <div class="filter-options">
                    <span>排序依據: 最新上架</span>
                </div>
            </div>

            <div id="gameList" class="game-grid">
                <p class="loading">載入遊戲中...</p>
            </div>

        </main>

        <div class="sidebar-area">
            <?php include '../../partials/sidebar_right/index.php'; ?>
        </div>

    </div>

    <?php include '../../partials/footer/index.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchGames();
        });

        async function fetchGames() {
            try {
                // 改回呼叫 getGamesAPI
                const response = await fetch('../../../api/getGamesAPI.php');
                const result = await response.json();
                
                if (result.status === 'success') {
                    renderGames(result.data);
                } else {
                    document.getElementById('gameList').innerHTML = '<p>目前沒有遊戲資料。</p>';
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('gameList').innerHTML = '<p>載入失敗，請稍後再試。</p>';
            }
        }

        function renderGames(games) {
            const container = document.getElementById('gameList');
            container.innerHTML = '';

            if(games.length === 0) {
                container.innerHTML = '<p>目前沒有遊戲資料。</p>';
                return;
            }

            games.forEach(game => {
                // 若無圖片則顯示預設圖
                const imgUrl = game.image ? game.image : 'https://placehold.co/300x200?text=No+Image';
                
                // 產生遊戲卡片 (點擊跳轉到遊戲詳情頁，傳遞 game title)
                const card = `
                    <div class="game-card" onclick="location.href='../game/index.php?game=${encodeURIComponent(game.game_title)}'">
                        <div class="game-card-img">
                            <img src="${imgUrl}" alt="${game.game_title}">
                            <div class="game-price">${game.price == 0 ? '免費' : '$' + game.price}</div>
                        </div>
                        <div class="game-card-info">
                            <h3 class="game-title">${game.game_title}</h3>
                            <div class="game-meta">
                                <span class="genre-tag">${game.genre}</span>
                                <span class="platform-text">${game.platform}</span>
                            </div>
                            <p class="game-desc">${game.description}</p>
                        </div>
                    </div>
                `;
                container.innerHTML += card;
            });
        }
    </script>
</body>
</html>