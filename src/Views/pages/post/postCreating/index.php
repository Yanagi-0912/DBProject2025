<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>新增貼文</title>
	<link rel="stylesheet" href="/Views/partials/layout.css">
	<style>
		.form-card { background: #151621; border: 1px solid #222438; border-radius: 12px; padding: 20px; max-width: 860px; }
		.form-row { display: flex; gap: 16px; margin-bottom: 12px; }
		.form-row label { width: 120px; color: #cfd2ff; }
		.form-row input, .form-row select, .form-row textarea { flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #2c2f45; background: #0f101a; color: #fff; }
		textarea { min-height: 140px; resize: vertical; }
		.actions { display: flex; gap: 10px; margin-top: 16px; }
		.primary { background: #6c63ff; color: #fff; border: none; padding: 10px 14px; border-radius: 8px; cursor: pointer; }
		.primary:hover { background: #5851d8; }
		.secondary { background: transparent; color: #e5e7ff; border: 1px solid #3a3d5c; padding: 10px 14px; border-radius: 8px; cursor: pointer; }
		.status { margin-top: 12px; padding: 10px; border-radius: 8px; }
		.status.success { background: #19351f; color: #b0ffb8; }
		.status.error { background: #3b1f1f; color: #ffb0b0; }
	</style>
</head>
<body>
	<?php include '../../../partials/Header/index.php'; ?>

	<div class="main-wrapper">
		<div class="sidebar-area">
			<?php include '../../../partials/sidebar_left/index.php'; ?>
		</div>

		<main class="main-content">
			<h2>新增貼文</h2>
			<div class="form-card">
				<form id="postForm">
					<div class="form-row">
						<label for="title">標題</label>
						<input id="title" name="title" required placeholder="輸入貼文標題">
					</div>
					<div class="form-row">
						<label for="user_id">發文者 ID</label>
						<input id="user_id" name="user_id" required placeholder="請輸入使用者 ID">
					</div>
					<div class="form-row">
						<label for="game_id">遊戲</label>
						<select id="game_id" name="game_id" required>
							<option value="">載入中...</option>
						</select>
					</div>
					<div class="form-row">
						<label for="rating">評分 (1-10)</label>
						<input id="rating" name="rating" type="number" min="1" max="10" placeholder="可留空">
					</div>
					<div class="form-row">
						<label for="image_url">圖片網址</label>
						<input id="image_url" name="image_url" placeholder="https://...">
					</div>
					<div class="form-row">
						<label for="content">內文</label>
						<textarea id="content" name="content" required placeholder="分享你的心得..."></textarea>
					</div>
					<div class="actions">
						<button type="submit" class="primary">送出</button>
						<button type="button" class="secondary" onclick="location.href='../index.php'">返回列表</button>
					</div>
					<div id="status" class="status" style="display:none;"></div>
				</form>
			</div>
		</main>

		<div class="sidebar-area">
			<?php include '../../../partials/sidebar_right/index.php'; ?>
		</div>
	</div>

	<?php include '../../../partials/footer/index.php'; ?>

	<script>
		document.addEventListener('DOMContentLoaded', () => {
			loadGames();
			document.getElementById('postForm').addEventListener('submit', handleSubmit);
		});

		async function loadGames() {
			const select = document.getElementById('game_id');
			try {
				const res = await fetch('../../../../api/getGamesAPI.php');
				const data = await res.json();
				if (data.status !== 'success') throw new Error(data.message || '取得遊戲失敗');
				select.innerHTML = '<option value="">請選擇遊戲</option>';
				data.data.forEach(g => {
					const opt = document.createElement('option');
					opt.value = g.game_id;
					opt.textContent = `${g.game_title}`;
					select.appendChild(opt);
				});
			} catch (err) {
				select.innerHTML = '<option value="">載入失敗</option>';
			}
		}

		async function handleSubmit(e) {
			e.preventDefault();
			const statusEl = document.getElementById('status');
			statusEl.style.display = 'none';
			const payload = {
				title: document.getElementById('title').value.trim(),
				user_id: document.getElementById('user_id').value.trim(),
				game_id: document.getElementById('game_id').value,
				rating: document.getElementById('rating').value || null,
				image_url: document.getElementById('image_url').value.trim(),
				content: document.getElementById('content').value.trim()
			};
			try {
				const res = await fetch('../../../../api/createPostAPI.php', {
					method: 'POST',
					headers: { 'Content-Type': 'application/json' },
					body: JSON.stringify(payload)
				});
				const data = await res.json();
				if (data.status !== 'success') throw new Error(data.message || '新增失敗');
				statusEl.textContent = '新增成功，將返回列表。';
				statusEl.className = 'status success';
				statusEl.style.display = 'block';
				setTimeout(() => location.href = '../index.php', 1000);
			} catch (err) {
				statusEl.textContent = err.message;
				statusEl.className = 'status error';
				statusEl.style.display = 'block';
			}
		}
	</script>
</body>
</html>
