<?php
// 取得單一貼文（含作者與遊戲資訊）
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");

require_once 'connection.php';

$postId = $_GET['id'] ?? null;
if (!$postId || !ctype_digit((string)$postId)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing or invalid post id']);
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
        WHERE p.post_id = ?
        LIMIT 1
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$postId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Post not found']);
        exit;
    }

    echo json_encode(['status' => 'success', 'data' => $row]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
