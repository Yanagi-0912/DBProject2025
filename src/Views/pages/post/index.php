<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>貼文列表</title>
	<link rel="stylesheet" href="/Views/partials/layout.css">
	<style>
		.page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
		.page-header h2 { margin: 0; }
		.action-btn { background: #6c63ff; color: #fff; border: none; padding: 10px 14px; border-radius: 6px; cursor: pointer; }
		.action-btn:hover { background: #5851d8; }
		.post-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px; }
		.post-card { background: #151621; border: 1px solid #222438; border-radius: 12px; padding: 16px; display: flex; flex-direction: column; gap: 10px; }
		.post-card img { width: 100%; height: 180px; object-fit: cover; border-radius: 10px; background: #0b0c15; }
		.meta { font-size: 14px; color: #c7c7d4; }
		.title-row { display: flex; justify-content: space-between; gap: 10px; align-items: center; }
		.title-row h3 { margin: 0; font-size: 18px; }
		.badge { background: #222438; padding: 4px 8px; border-radius: 6px; font-size: 13px; color: #cfd2ff; }
		.card-actions { display: flex; justify-content: flex-end; gap: 8px; }
		.text-btn { background: transparent; border: 1px solid #3a3d5c; color: #e5e7ff; padding: 6px 10px; border-radius: 6px; cursor: pointer; }
		.text-btn:hover { border-color: #6c63ff; color: #fff; }
		.loading, .error { padding: 12px; background: #222438; border-radius: 8px; }
		.content-preview { color: #d8d8e5; font-size: 14px; line-height: 1.5; max-height: 80px; overflow: hidden; }
	</style>
</head>
<body>
	<?php include '../../partials/Header/index.php'; ?>

	<div class="main-wrapper">
		<div class="sidebar-area">
			<?php include '../../partials/sidebar_left/index.php'; ?>
		</div>

		<main class="main-content">
			<div class="page-header">
				<h2>貼文列表</h2>
				<button class="action-btn" onclick="location.href='postCreating/index.php'">新增貼文</button>
			</div>

			<div id="postContainer" class="post-grid">
				<p class="loading">載入中...</p>
			</div>
		</main>

		<div class="sidebar-area">
			<?php include '../../partials/sidebar_right/index.php'; ?>
		</div>
	</div>

	<?php include '../../partials/footer/index.php'; ?>

	<script>
		document.addEventListener('DOMContentLoaded', () => {
			loadPosts();
		});

		async function loadPosts() {
			const container = document.getElementById('postContainer');
			container.innerHTML = '<p class="loading">載入中...</p>';
			try {
				const res = await fetch('../../../api/getPostsAPI.php');
				const data = await res.json();
				if (data.status !== 'success') throw new Error(data.message || '載入失敗');
				renderPosts(data.data);
			} catch (err) {
				container.innerHTML = `<p class="error">${err.message}</p>`;
			}
		}

		function renderPosts(posts) {
			const container = document.getElementById('postContainer');
			if (!posts.length) {
				container.innerHTML = '<p class="loading">目前沒有貼文。</p>';
				return;
			}
			container.innerHTML = '';
			posts.forEach(p => {
				const image = p.image_url ? p.image_url : 'https://placehold.co/600x400?text=No+Image';
				const rating = p.rating ? `評分 ${p.rating}/10` : '尚未評分';
				const date = p.post_date ? new Date(p.post_date).toLocaleString() : '';
				const card = document.createElement('div');
				card.className = 'post-card';
				card.innerHTML = `
					<div class="title-row">
						<h3>${escapeHtml(p.title)}</h3>
						<span class="badge">${escapeHtml(p.game_title)}</span>
					</div>
					<img src="${image}" alt="post image">
					<div class="meta">發文者：${escapeHtml(p.username)} · ${rating} · ${date}</div>
					<div class="content-preview">${escapeHtml(p.content)}</div>
					<div class="card-actions">
						<a class="text-btn" href="detail/index.php?id=${p.post_id}">查看</a>
						<button class="text-btn" onclick="location.href='postEditing/index.php?id=${p.post_id}'">編輯</button>
					</div>
				`;
				container.appendChild(card);
			});
		}

		function escapeHtml(str) {
			return str ? str.replace(/[&<>"]+/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c])) : '';
		}
	</script>
</body>
</html>
