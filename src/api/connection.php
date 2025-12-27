<?php

$host = getenv('DB_HOST') ;
$dbname = getenv('DB_NAME') ;
$user = getenv('DB_USER') ;
$dbPassword = getenv('DB_PASSWORD');

function getPDO() {
    global $host, $dbname, $user, $dbPassword;
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    } catch(PDOException $e) {
        throw $e;
    }
}

// 舊版相容性
try{
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$dbPassword);
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db ->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
}
catch(PDOException $e){
    // 僅在直接訪問此文件時輸出錯誤
    if (basename($_SERVER['PHP_SELF']) === 'connection.php') {
        header("Content-Type: application/json; charset=utf-8");
        http_response_code(500);
        echo json_encode(array(
            "status" => "error", 
            "message" => "資料庫連線失敗: " . $e->getMessage()
        ));
        exit();
    }
}

