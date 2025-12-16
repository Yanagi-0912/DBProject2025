<?php
// 依遊戲 ID 取得貼文列表
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");

require_once 'connection.php';

$gameId = $_GET['game_id'] ?? null;
if (!$gameId || !ctype_digit((string)$gameId)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing or invalid game_id']);
    exit;
}

try {
    $sql = "
        SELECT 
            p.post_id,
            p.title,
            p.content,
            p.rating,
            p.post_date,
            p.image_url,
            u.id AS user_id,
            u.username,
            g.game_id,
            g.game_title
        FROM posts p
        JOIN users u ON p.user_id = u.id
        JOIN games g ON p.game_id = g.game_id
        WHERE p.game_id = ?
        ORDER BY p.post_date DESC
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$gameId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $rows]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
