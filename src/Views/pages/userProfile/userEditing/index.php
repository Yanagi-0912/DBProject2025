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
        <link rel="stylesheet" href="/Views/partials/layout.css">
    <link rel="stylesheet" href="../userPosts.css">
    <style>
        .username-edit {
            display: flex;
            align-items: center;
            gap: 8px; /* 名稱和鉛筆間距 */
            margin-bottom: 16px;
        }

        .username-edit h1 {
            font-weight: 600;
            font-size: 18px;
            color: #00f2ea;
        }

        #editUsernameBtn {
            width: 20px;
            height: 20px;
            cursor: pointer;
            fill: #00f2ea; /* 讓鉛筆圖標在深色背景下可見 */
            transition: transform 0.2s;
        }

        #editUsernameBtn:hover {
            transform: scale(1.2);
        }
        #saveChangesBtn {
            background-color: #00f2ea;
            color: #0b0c15;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(0, 242, 234, 0.5);
        }
        /* 顯示/隱藏 input 時的樣式 */
        #usernameInput {
            flex: 1;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #2d2d44;
            background-color: #1f202e;
            color: #ffffff;
            width: 50%;
        }

        /* 儲存/取消按鈕 */
        #saveUsernameBtn,
        #cancelUsernameBtn {
            background-color: #00f2ea;
            border: none;
            border-radius: 6px;
            color: #0b0c15;
            padding: 4px 8px;
            cursor: pointer;
            margin-left: 4px;
            font-weight: bold;
        }

        #saveUsernameBtn:hover,
        #cancelUsernameBtn:hover {
            background-color: #00d5cc;
        }

        /* 密碼欄位加強顯眼 */
        .userProfile input[type="password"] {
            background-color: #ffffffa9;
            color: #ffffff;
            border: 1px solid #2d2d44;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 16px;
            width: 50%;
        }
                /* 文章卡片風格 */
        .post-card {
            background-color: #151621;
            border: 2px solid #ff0050; /* 紅色霓虹邊框 */
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(255, 0, 80, 0.2);
        }

        .post-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 0, 80, 0.4);
        }

        .post-card h3 {
            font-size: 20px;
            color: #ff0050;
            margin-bottom: 8px;
        }

        .post-card .tags {
            font-size: 14px;
            color: #8f90a6;
            margin-bottom: 12px;
        }

        .post-card p {
            font-size: 16px;
            line-height: 1.5;
            color: #ffffff;
        }

        .post-card img {
            margin-top: 12px;
            max-width: 100%;
            border-radius: 8px;
            display: block;
        }
    </style>
</head>

<body>

<div class="userpage-container">
    <?php include '../../../partials/Header/index.php'; ?>   


    <!-- Holy Grail Layout -->
    <div class="main-wrapper">

        <!-- 左側 sidebar -->
        <div class="sidebar-area">
            <?php include '../../../partials/sidebar_left/index.php'; ?>
        </div>

        <!-- 中間 main-content -->
        <div class="main-content middle">

            <!-- 編輯容器 -->
            <div class="userProfile">
                <form method="POST" id="editUserForm">
                    <div class="username-edit">
                        <h1 id="usernameText"><?php echo htmlspecialchars($username); ?></h1>
                        <input type="text" id="usernameInput" value="<?php echo htmlspecialchars($username); ?>" style="display:none;">
                        
                        <svg id="editUsernameBtn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                        </svg>

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
                    <button type="submit" id="saveChangesBtn">儲存修改</button>
                </form>
            </div>

            <!-- 文章容器 -->
            <div class="userPosts">
                <?php include '../userPosts.php'; ?>
            </div>

        </div>

        <!-- 右側 sidebar -->
        <div class="sidebar-area">
            <?php include '../../../partials/sidebar_right/index.php'; ?>
        </div>

    </div> <!-- main-wrapper -->

</div> <!-- userpage-container -->
</div>
<script>
document.addEventListener('DOMContentLoaded', getUserPost);
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
            window.location.href = '../index.php';
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
