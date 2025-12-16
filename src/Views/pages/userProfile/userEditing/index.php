<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    // 如果未登入，重定向到登入頁面
    header("Location: ../login/index.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$account = $_SESSION["account"];
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8" />
    <title>Userprofile Editing Page</title>
    <link rel="stylesheet" href="userProfileEdit.css">
</head>

<body>

<div class="userpage-container">

    <!-- 頂部導覽列 -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="top-btn" onclick="window.location.href='../../home/index.php'">首頁圖標</button>
        </div>

        <div class="topbar-right">
            <button class="top-btn" onclick="logout()">登出</button>
            <button class="top-btn" onclick="window.location.href='../../userProfile/index.php'">個人資料</button>
        </div>
    </header>

    <div class="content">
        <!-- 中間：個人資料 + 貼文 -->
        <div class="middle">
            <!-- 編輯容器 -->
            <div class="userProfile">
                <form method="POST" id="editUserForm">
                    <div class="username-edit">
                        <span id="usernameText"><?php echo htmlspecialchars($username); ?></span>
                        <input type="text" id="usernameInput" value="<?php echo htmlspecialchars($username); ?>" style="display:none;">
                        <svg id="editUsernameBtn" ...>...</svg>
                        <button id="saveUsernameBtn" style="display:none;">✔</button>
                        <button id="cancelUsernameBtn" style="display:none;">✖</button>
                    </div>

                    <p><?php echo htmlspecialchars($account); ?></p>
                    <div>
                        <label>新密碼</label><br>
                        <input type="password" name="password" id="password">
                    </div>
                    <div>
                        <label>確認新密碼</label><br>
                        <input type="password" name="password_confirm" id="password_confirm">
                    </div>
                    <button type="submit">儲存修改</button>
                </form>
            </div>

            <!-- 文章容器 -->
            <div class="userPosts">
                <h2>我的文章</h2>
                <div class="post-card" onclick="alert('文章詳細頁面尚未實作')">
                    <h3>文章標題</h3>
                    <p class="tags">#tag1 #tag2</p>
                    <p>文章內容...</p>
                    <img alt="post">
                </div>
            </div>
        </div>
    </div>

</div>
<script>
const usernameText = document.getElementById('usernameText');
const usernameInput = document.getElementById('usernameInput');
const editBtn = document.getElementById('editUsernameBtn');
const saveBtn = document.getElementById('saveUsernameBtn');
const cancelBtn = document.getElementById('cancelUsernameBtn');
const form = document.getElementById('editUserForm');

/* 進入編輯模式 */
editBtn.addEventListener('click', () => {
    usernameInput.value = usernameText.innerText.trim();
    usernameText.style.display = 'none';
    editBtn.style.display = 'none';

    usernameInput.style.display = 'inline-block';
    saveBtn.style.display = 'inline-block';
    cancelBtn.style.display = 'inline-block';

    usernameInput.focus();
});

/* 取消 */
cancelBtn.addEventListener('click', (e) => {
    e.preventDefault();
    usernameInput.style.display = 'none';
    saveBtn.style.display = 'none';
    cancelBtn.style.display = 'none';

    usernameText.style.display = 'inline';
    editBtn.style.display = 'inline';
});


/* Enter / ESC */
usernameInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        updatePersonProfile();
    }
    if (e.key === 'Escape') cancelBtn.click();
});

/* 表單送出（改密碼） */
form.addEventListener('submit', function (e) {
    e.preventDefault();
    updatePersonProfile();
});


function updatePersonProfile() {
    const username = usernameInput.value.trim();
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;

    if (!username && !password) {
        alert('沒有任何修改');
        return;
    }

    if (password && password !== passwordConfirm) {
        alert('兩次密碼不一致');
        return;
    }

    fetch('http://localhost:8080/api/editUserProfileAPI.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'include',
        body: JSON.stringify({
            username,
            password,
            passwordConfirm
        })
    })
    .then(res => res.json())
    .then(result => {
        if (result.status === 'success') {
            alert('修改個人資料成功');

            if (username) {
                usernameText.innerText = username;
                cancelBtn.click();
            }

            document.getElementById('password').value = '';
            document.getElementById('password_confirm').value = '';
        } else {
            alert(result.message);
        }
    })
    .catch(() => alert('更新失敗'));
}

/* 登出 */
function logout() {
    if (confirm("確定要登出？")) {
        fetch('../../../../api/logoutAPI.php', {
            method: 'POST',
            credentials: 'include'
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            window.location.href = '../../login/index.php';
        });
    }
}
</script>

</body>
</html>
