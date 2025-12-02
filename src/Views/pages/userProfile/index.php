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
    <title>User Page</title>
    <link rel="stylesheet" href="userPage.css">
</head>

<body>

<div class="userpage-container">

    <!-- 頂部導覽列 -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="top-btn" onclick="">首頁圖標</button>
        </div>

        <div class="topbar-right">
            <button class="top-btn" onclick="logout()">登出</button>
            <button class="top-btn">個人資料</button>
        </div>
    </header>

    <div class="content">

        <!-- 左側遊戲清單 -->
        <div class="left">
            <div class="games">
                <h2>熱門遊戲</h2>

                <div class="game-card">
                    <img alt="game">
                    <h3>圓神</h3>
                </div>

                <div class="game-card">
                    <img alt="game">
                    <h3>巫師4</h3>
                </div>

                <div class="game-card">
                    <img alt="game">
                    <h3>特展硬漢</h3>
                </div>
            </div>
        </div>

        <!-- 中間：個人資料 + 貼文 -->
        <div class="middle">

            <div class="userProfile">
                <h2><?php echo htmlspecialchars($username); ?></h2>
                <p><?php echo htmlspecialchars($account); ?></p>
                <button class="editUserInfo-btn" onclick="alert('編輯個人資料功能尚未實作')">編輯個人資料</button>
            </div>

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

        <!-- 右側新增貼文 -->
        <div class="right">
            <div class="createPost">
                <button class="create-btn" onclick="alert('發佈新貼文功能尚未實作')">發佈新貼文</button>
            </div>
        </div>

    </div> <!-- content -->

</div> <!-- container -->
<script>
    function logout() {
        if(confirm("確定要登出？")) {//confirm讓user選擇是否登出,js內建的功能
            // 清除 session 並重定向到登入頁面
            fetch('../../../api/logoutAPI.php', {
                method: 'POST',
                credentials: 'include'
            }).then(response => response.json())
            .then(data => {
                window.location.href = '../login/index.php';
                window.alert(data.message);
            })
            .catch(error => {
                console.error('Error during logout:', error);
            });
        }
    }
</script>
</body>
</html>
