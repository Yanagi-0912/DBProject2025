<?php

?>
<script>
    function getUserPost() {
    fetch(`../../../../api/getPostsByUserIdAPI.php?user_id=<?php echo $user_id; ?>`)
        .then(res => res.json())
        .then(data => {
            const container = document.querySelector('.userPosts');
            container.innerHTML = '<h2>我的文章</h2>'; // 清空舊文章，但保留標題

            if (data.status !== 'success' || data.data.length === 0) {
                container.innerHTML += '<p>尚未發布任何文章</p>';
                return;
            }

            data.data.forEach(p => {
                const postCard = document.createElement('div');
                postCard.className = 'post-card';
                postCard.innerHTML = `
                    <h3>${escapeHtml(p.title)}</h3>
                    <p class="tags">#遊戲：${escapeHtml(p.game_title)}</p>
                    <div class="post-body-wrapper">
                        <div class="cover">
                            <img src="${p.image_url ? p.image_url : 'https://placehold.co/500x350?text=No+Image'}" alt="post image" />
                        </div>
                        <div class="post-content">
                            <p>${escapeHtml(p.content)}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="btn-text" onclick="window.location.href='../post/detail/index.php?id=${p.post_id}'">查看</button>
                        <button class="btn-text" onclick="window.location.href='../postEditing/index.php?id=${p.post_id}'">編輯</button>
                    </div>
                `;
                postCard.addEventListener('click', () => {
                    window.location.href = `../post/detail/index.php?id=${p.post_id}`;
                });
                container.appendChild(postCard);
            });
        })
        .catch(err => {
            console.error('Error fetching posts:', err);
        });
    }
</script>