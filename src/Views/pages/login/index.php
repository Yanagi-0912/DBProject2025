<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登入頁面</title>
    <link rel="stylesheet" href="loginPage.css">
</head>
<body>

<div class="login-container">
    <header class="login-header">
        <div class="header-buttons">
            <button onclick="alert('設定功能尚未實作')">設定</button>
            <button onclick="alert('請先登入!')">個人資料</button>
        </div>
    </header>

    <div class="login-form">
        <div class="logo">
            <img src="public/sample.png" alt="Logo" height="150" width="150">
        </div>

        <h2>登入或註冊</h2>

        <form method="POST" id="loginForm">

            <div class="form-group">
                <label>帳號:</label>
                <input type="text"  name="account" id="account" required>
            </div>

            <div class="form-group">
                <label>密碼:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-actions">
                <button type="submit" name="action" value="login">登入</button>
                <button type="button" onclick="window.location.href='registerPage.php'">註冊</button>
            </div>

        </form>
    </div>

</div>
<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // 防止表單自動提交

        const account = document.getElementById('account').value;
        const password = document.getElementById('password').value;
        console.log({ account, password });
        fetch('http://localhost:8080/api/loginAPI.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ account, password })
        })
        .then(response => response.json())
        .then(result => {
            console.log(result);
            if (result.status === 'success') {
                alert('登入成功');
                window.location.href = '../home/index.php'; // 登入成功後跳轉到用戶頁面
            } 
            else {
                alert('登入失敗: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('發生錯誤，請稍後再試。');
        });
    });
</script>
</body>
</html>
