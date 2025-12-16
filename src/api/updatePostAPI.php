<?php
// 更新貼文
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, PUT, PATCH");

require_once 'connection.php';

$input = json_decode(file_get_contents('php://input'), true) ?? [];

$postId = $input['post_id'] ?? null;
$title = trim($input['title'] ?? '');
$content = trim($input['content'] ?? '');
$userId = $input['user_id'] ?? null;
$gameId = $input['game_id'] ?? null;
$rating = $input['rating'] ?? null;
$imageUrl = trim($input['image_url'] ?? '');

if (!$postId || !ctype_digit((string)$postId)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing or invalid post_id']);
    exit;
}

if ($title === '' || $content === '' || !$userId || !$gameId) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

if (!ctype_digit((string)$userId) || !ctype_digit((string)$gameId)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid user_id or game_id']);
    exit;
}

if ($rating !== null && (!is_numeric($rating) || $rating < 1 || $rating > 10)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Rating must be 1-10']);
    exit;
}

try {
    $sql = "
        UPDATE posts
        SET user_id = ?, game_id = ?, title = ?, content = ?, rating = ?, image_url = ?
        WHERE post_id = ?
        LIMIT 1
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        (int)$userId,
        (int)$gameId,
        $title,
        $content,
        $rating !== null ? (int)$rating : null,
        $imageUrl !== '' ? $imageUrl : null,
        (int)$postId
    ]);

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
