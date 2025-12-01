<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DBProject2025</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <h1>DBProject2025 - 資料庫系統課程專題</h1>
    
    <h2>環境資訊</h2>
    <div class="status info">
        <strong>PHP 版本:</strong> <?php echo phpversion(); ?>
    </div>
    
    <h2>資料庫連線測試</h2>
    <?php
    // Get and validate database configuration from environment variables
    $host = getenv('DB_HOST') ?: 'db';
    $dbname = getenv('DB_NAME') ?: 'dbproject';
    $user = getenv('DB_USER') ?: 'dbuser';
    $password = getenv('DB_PASSWORD') ?: 'dbpassword';

    // Validate host (only allow alphanumeric, hyphens, underscores, and dots)
    if (!preg_match('/^[a-zA-Z0-9._-]+$/', $host)) {
        echo '<div class="status error">';
        echo '<strong>Invalid database host configuration</strong>';
        echo '</div>';
    } else {
        try {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4',
                $host,
                preg_replace('/[^a-zA-Z0-9_]/', '', $dbname)
            );
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Get MariaDB version
            $version = $pdo->query('SELECT VERSION()')->fetchColumn();
            
            echo '<div class="status success">';
            echo '<strong>資料庫連線成功!</strong><br>';
            echo 'MariaDB 版本: ' . htmlspecialchars($version);
            echo '</div>';
        } catch (PDOException $e) {
            echo '<div class="status error">';
            echo '<strong>資料庫連線失敗:</strong><br>';
            echo htmlspecialchars($e->getMessage());
            echo '</div>';
        }
    }
    ?>
    
    <h2>已安裝的 PHP 擴充模組</h2>
    <div class="status info">
        <?php
        $extensions = ['pdo', 'pdo_mysql', 'mysqli', 'gd', 'zip'];
        foreach ($extensions as $ext) {
            $loaded = extension_loaded($ext) ? '✓' : '✗';
            echo "$ext: $loaded<br>";
        }
        ?>
    </div>
</body>
</html>
