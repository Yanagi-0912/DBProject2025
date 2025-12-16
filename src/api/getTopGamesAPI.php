<?php
// 取得貼文數最多的遊戲排行榜
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");

require_once 'connection.php';

$limit = $_GET['limit'] ?? 5;
if (!ctype_digit((string)$limit) || (int)$limit < 1) {
    $limit = 5;
}
$limit = min((int)$limit, 20); // 防止過大

try {
    $sql = "
        SELECT g.game_id, g.game_title, g.image, COUNT(p.post_id) AS post_count
        FROM games g
        LEFT JOIN posts p ON p.game_id = g.game_id
        GROUP BY g.game_id, g.game_title, g.image
        ORDER BY post_count DESC, g.game_id ASC
        LIMIT {$limit}
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $rows]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
