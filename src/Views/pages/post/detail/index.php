<?php 
session_start();
$postId = $_GET['id'] ?? '';
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>貼文內容</title>
    <link rel="stylesheet" href="/Views/partials/layout.css">
    <style>
        .post-container { background: #151621; border: 1px solid #222438; border-radius: 12px; padding: 20px; max-width: 900px; }
        .post-header { display: flex; gap: 16px; margin-bottom: 12px; }
        .cover { width: 220px; flex-shrink: 0; }
        .cover img { width: 100%; height: 100%; object-fit: cover; border-radius: 10px; background: #0b0c15; min-height: 160px; }
        .meta { display: flex; flex-direction: column; gap: 6px; }
        .badge { background: #222438; padding: 6px 10px; border-radius: 8px; display: inline-block; color: #cfd2ff; }
        .rating { font-size: 20px; color: #ffd166; }
        .post-body { margin-top: 12px; line-height: 1.7; color: #e7e8f5; white-space: pre-wrap; }
        .info-line { color: #c7c7d4; font-size: 14px; }
        .actions { margin-top: 16px; display: flex; gap: 10px; }
        .btn-text { background: transparent; color: #e5e7ff; border: 1px solid #3a3d5c; padding: 8px 12px; border-radius: 8px; cursor: pointer; text-decoration: none; }
        .btn-text:hover { border-color: #6c63ff; color: #fff; }
    </style>
</head>
<body>
    <?php include '../../../partials/Header/index.php'; ?>

    <div class="main-wrapper">
        <div class="sidebar-area">
            <?php include '../../../partials/sidebar_left/index.php'; ?>
        </div>

        <main class="main-content">
            <h2>貼文內容</h2>
            <div id="postArea" class="post-container">
                <p>載入中...</p>
            </div>
        </main>

        <div class="sidebar-area">
            <?php include '../../../partials/sidebar_right/index.php'; ?>
        </div>
    </div>

    <?php include '../../../partials/footer/index.php'; ?>

    <script>
        const postId = "<?php echo htmlspecialchars($postId); ?>";

        document.addEventListener('DOMContentLoaded', () => {
            if (!postId) {
                document.getElementById('postArea').innerHTML = '<p>缺少貼文編號。</p>';
                return;
            }
            loadPost(postId);
        });

        async function loadPost(id) {
            const area = document.getElementById('postArea');
            area.innerHTML = '<p>載入中...</p>';
            try {
                const res = await fetch(`../../../../api/getPostAPI.php?id=${id}`);
                const data = await res.json();
                if (data.status !== 'success') throw new Error(data.message || '載入失敗');
                renderPost(data.data);
            } catch (err) {
                area.innerHTML = `<p>${err.message}</p>`;
            }
        }

        function renderPost(p) {
            const area = document.getElementById('postArea');
            const image = p.image_url ? p.image_url : 'https://placehold.co/500x350?text=No+Image';
            const rating = p.rating ? `${p.rating} / 10` : '尚未評分';
            const date = p.post_date || '';
            area.innerHTML = `
                <div class="post-header">
                    <div class="cover"><img src="${image}" alt="post image"></div>
                    <div class="meta">
                        <h3>${escapeHtml(p.title)}</h3>
                        <div class="badge">遊戲：${escapeHtml(p.game_title)}</div>
                        <div class="info-line">發文者：${escapeHtml(p.username)}</div>
                        <div class="info-line">時間：${date}</div>
                        <div class="rating">評分：${rating}</div>
                        <div class="info-line">平台：${escapeHtml(p.platform || '')}｜類型：${escapeHtml(p.genre || '')}｜價格：${p.price ?? ''}</div>
                    </div>
                </div>
                <div class="post-body">${escapeHtml(p.content)}</div>
                <div class="actions">
                    <a class="btn-text" href="../postEditing/index.php?id=${p.post_id}">編輯貼文</a>
                    <a class="btn-text" href="../../game/index.php?game=${encodeURIComponent(p.game_title)}">查看遊戲頁</a>
                </div>
            `;
        }

        function escapeHtml(str) {
            return str ? str.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[c])) : '';
        }
    </script>
</body>
</html>
