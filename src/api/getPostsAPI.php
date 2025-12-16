<?php
// 取得所有貼文列表（含作者與遊戲資訊）
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");

require_once 'connection.php';

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
        ORDER BY p.post_date DESC
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $rows]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
