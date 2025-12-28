<?php 
session_start(); 

// 檢查是否登入
if (!isset($_SESSION['user_id'])) {
    header('Location: /Views/pages/login/index.php');
    exit;
}

$username = $_SESSION['username'] ?? '使用者';
$account = $_SESSION['account'] ?? '';
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account setting</title>
    <link rel="stylesheet" href="/Views/partials/layout.css">
    <link rel="stylesheet" href="settings.css">
</head>
<body>

    <?php include '../../partials/Header/index.php'; ?>

    <div class="main-wrapper">
        
        <div class="sidebar-area">
            <?php include '../../partials/sidebar_left/index.php'; ?>
        </div>

        <main class="main-content">
            <div class="settings-container">
                <h1 class="settings-title">帳號設定</h1>

                <!-- 帳號資訊區塊 -->
                <section class="settings-section">
                    <h2 class="section-title">帳號資訊</h2>
                    <div class="info-group">
                        <label>使用者名稱</label>
                        <p class="info-text"><?php echo htmlspecialchars($username); ?></p>
                    </div>
                    <div class="info-group">
                        <label>帳號</label>
                        <p class="info-text"><?php echo htmlspecialchars($account); ?></p>
                    </div>
                </section>

                <section class="settings-section danger-zone">
                    <h2 class="section-title danger-title">危險區域</h2>
                    <div class="danger-content">
                        <div class="danger-info">
                            <h3>刪除帳號</h3>
                            <p>刪除您的帳號將會永久移除所有資料，包括貼文、評論等。此操作無法復原。</p>
                        </div>
                        <button id="deleteAccountBtn" class="btn-danger">刪除我的帳號</button>
                    </div>
                </section>
            </div>
        </main>

        <div class="sidebar-area">
            <?php include '../../partials/sidebar_right/index.php'; ?>
        </div>

    </div>

    <!-- 確認刪除的彈窗 -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>⚠️ 確認刪除帳號</h2>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
            <div class="modal-body">
                <p>您確定要刪除帳號嗎？此操作將會：</p>
                <ul class="warning-list">
                    <li>永久刪除您的所有個人資料</li>
                    <li>刪除您發布的所有貼文和評論</li>
                    <li>此操作無法復原</li>
                </ul>
                <p class="confirm-text">請輸入您的帳號 <strong><?php echo htmlspecialchars($account); ?></strong> 以確認：</p>
                <input type="text" id="confirmAccountInput" placeholder="輸入您的帳號" class="confirm-input">
                <p id="errorMsg" class="error-msg"></p>
            </div>
            <div class="modal-footer">
                <button id="cancelBtn" class="btn-secondary">取消</button>
                <button id="confirmDeleteBtn" class="btn-danger">確認刪除</button>
            </div>
        </div>
    </div>

    <script>
        const deleteAccountBtn = document.getElementById('deleteAccountBtn');
        const modal = document.getElementById('deleteModal');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const confirmInput = document.getElementById('confirmAccountInput');
        const errorMsg = document.getElementById('errorMsg');
        const userAccount = '<?php echo htmlspecialchars($account); ?>';

        // 開啟彈窗
        deleteAccountBtn.addEventListener('click', function() {
            modal.style.display = 'flex';
            confirmInput.value = '';
            errorMsg.textContent = '';
        });

        // 關閉彈窗
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        cancelBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // 點擊彈窗外部關閉
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        confirmDeleteBtn.addEventListener('click', async function() {
            const inputValue = confirmInput.value.trim();
            
            if (inputValue !== userAccount) {
                errorMsg.textContent = '帳號輸入錯誤，請重新輸入';
                return;
            }

            try {
                const response = await fetch('../../../api/deleteUserAPI.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        confirm: true
                    })
                });

                const result = await response.json();

                if (result.status === 'success') {
                    alert('帳號已成功刪除');
                    window.location.href = '/Views/pages/login/index.php';
                } else {
                    errorMsg.textContent = result.message || '刪除失敗，請稍後再試';
                }
            } catch (error) {
                console.error('Error:', error);
                errorMsg.textContent = '發生錯誤，請稍後再試';
            }
        });
    </script>
</body>
</html>