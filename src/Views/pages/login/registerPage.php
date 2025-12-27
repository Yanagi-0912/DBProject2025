<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8" />
    <title>註冊</title>
    <link rel="stylesheet" href="loginPage.css">
</head>
<body>

<div class="login-container">
    <div class="login-form">
        <div class="logo">
                <span class="logo-text">GameHub</span>
        </div>

        <h2>註冊帳號</h2>

        <form id="registerForm">
            <div class="form-group">
                <label>用戶名稱:</label>
                <input type="text" id="username" required>
            </div>

            <div class="form-group">
                <label>帳號:</label>
                <input type="text" id="account" required>
            </div>

            <div class="form-group">
                <label>密碼:</label>
                <input type="password" id="password" required>
            </div>

            <div class="form-group">
                <label>確認密碼:</label>
                <input type="password" id="confirmPassword" required>
            </div>

            <div class="form-actions">
                <button type="submit">註冊</button>
                <button type="button" onclick="window.location.href='index.php'">返回登入</button>
            </div>
        </form>

    </div>

</div>
<script>
document.getElementById("registerForm").addEventListener("submit", async function(e){
    e.preventDefault();

    const username = document.getElementById("username").value;
    const account = document.getElementById("account").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if(password !== confirmPassword){
        alert("密碼與確認密碼不符");
        return;
    }
    if(password.length < 5){
        alert("密碼長度至少5個字元");
        return;
    }
    const response = await fetch("http://localhost:8080/api/registerAPI.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, account, password })
    });

    const data = await response.json();
    console.log(data);
    if(data.status==="success"){//後端注意status要傳正確字串
        alert("註冊成功！");//註冊成功後導向登入頁面
        window.location.href = 'index.php';
    } 
    else {
        alert("註冊失敗：" + data.message);
    }
});
</script>
</body>
</html>
