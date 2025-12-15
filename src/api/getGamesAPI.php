<?php
//首頁用的抓遊戲API
// 連線
require_once 'connection.php';

try {
    // 簡單查詢所有遊戲
    $sql = "SELECT * FROM games ORDER BY game_id DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $games]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>