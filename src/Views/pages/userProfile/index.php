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
    <link rel="stylesheet" href="/Views/partials/layout.css">
    <style>
        .userProfile {
            background-color: #151621; /* 深色卡片背景 */
            border: 2px solid #00f2ea; /* 霓虹青邊框 */
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(0, 242, 234, 0.2);
            color: #ffffff;
        }

        .userProfile h2 {
            font-size: 28px;
            font-weight: 800;
            color: #00f2ea;
            margin-bottom: 8px;
            text-shadow: 0 0 10px rgba(0, 242, 234, 0.5);
        }

        .userProfile p {
            font-size: 16px;
            color: #8f90a6;
            margin-bottom: 16px;
        }

        .editUserInfo-btn {
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

        .editUserInfo-btn:hover {
            background-color: #00d5cc;
            box-shadow: 0 0 20px rgba(0, 242, 234, 0.8);
            transform: translateY(-2px);
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
        <?php include '../../partials/Header/index.php'; ?>

        <div class="main-wrapper"> <!-- Grid container -->
            <div class="sidebar-area"> <!-- 左側 sidebar -->
                <?php include '../../partials/sidebar_left/index.php'; ?>
            </div>

            <div class="main-content middle"> <!-- 中間使用者資料 + 貼文 -->
                <div class="userProfile">
                    <h2><?php echo htmlspecialchars($username); ?></h2>
                    <p><?php echo htmlspecialchars($account); ?></p>
                    <button class="editUserInfo-btn" onclick="window.location.href='userEditing/index.php'">編輯個人資料</button>
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

            <div class="sidebar-area"> <!-- 右側 sidebar -->
                <?php include '../../partials/sidebar_right/index.php'; ?>
            </div>
        </div>
    </div>

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
