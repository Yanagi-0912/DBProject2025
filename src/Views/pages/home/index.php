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
                <label for="sortSelect">排序依據：
                    <select id="sortSelect">
                        <option value="latest">最新上架</option>
                        <option value="comments">評論數最多</option>
                        <option value="rating">評分最高</option>
                        <option value="price_asc">價格：低 → 高</option>
                        <option value="price_desc">價格：高 → 低</option>
                    </select>
                </label>
            </div>

            <div id="gameList" class="game-grid">
                <p class="loading">載入遊戲中...</p>
            </div>

        </main>

        <div class="sidebar-area">
            <?php include '../../partials/sidebar_right/index.php'; ?>
        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchGames();

        });
        let allGames = [];
        async function fetchGames() {
            try {
                // 改回呼叫 getGamesAPI
                const response = await fetch('../../../api/getGamesAPI.php');
                const result = await response.json();
                
                if (result.status === 'success') {
                    allGames = result.data;
                    let detailedGame = [];
                    for(let i=0;i<allGames.length;i++){
                        const game=allGames[i];
                        try{
                            const detailResponse = await fetch('../../../api/getGameDetailsAPI.php?title=' + encodeURIComponent(game.game_title));
                            const detailResult = await detailResponse.json(); 
                            if (detailResult.status === 'success') {
                                // 把原本的遊戲資料和新的評論數、評分加在一起
                                game.review_count = detailResult.game.review_count || 0;
                                game.avg_rating = detailResult.game.avg_rating || 0;
                            }
                        }
                        catch(e){
                            console.error('Fetch game detail failed:', e);
                        }
                        detailedGame.push(game);
                    }
                    allGames=detailedGame;
                    renderGames(allGames);
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
                const avgRating = game.avg_rating ? parseFloat(game.avg_rating).toFixed(1) : '無評分';
                const reviewCount = game.review_count || 0;
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
                                <div class="game-stats">
                                    <span>⭐ ${avgRating}</span>
                                    <span>💬 ${reviewCount} 則評論</span>
                                </div>
                        </div>
                    </div>
                `;
                container.innerHTML += card;
            });
        }

        document.getElementById('sortSelect').addEventListener('change', function () {
        const type = this.value;
        let sortedGames = [...allGames];

        switch (type) {
            case 'comments':
                sortedGames.sort((a, b) => b.review_count - a.review_count);
                break;
            case 'rating':
                sortedGames.sort((a, b) => b.avg_rating - a.avg_rating);
                break;
            case 'price_asc':
                sortedGames.sort((a, b) => a.price - b.price);
                break;
            case 'price_desc':
                sortedGames.sort((a, b) => b.price - a.price);
                break;
            case 'latest':
            default:
                sortedGames.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                break;
        }

        renderGames(sortedGames);
    });
    </script>
</body>
</html>