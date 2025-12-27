<?php
// 刪除貼文
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: DELETE, POST");

require_once 'connection.php';

$input = json_decode(file_get_contents('php://input'), true) ?? [];

$postId = $input['post_id'] ?? null;

if (!$postId || !ctype_digit((string)$postId)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing or invalid post_id']);
    exit;
}

try {
    $pdo = getPDO();
    
    // 檢查貼文是否存在
    $checkStmt = $pdo->prepare("SELECT post_id FROM posts WHERE post_id = ?");
    $checkStmt->execute([$postId]);
    
    if (!$checkStmt->fetch()) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Post not found']);
        exit;
    }
    
    // 刪除貼文
    $deleteStmt = $pdo->prepare("DELETE FROM posts WHERE post_id = ?");
    $deleteStmt->execute([$postId]);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Post deleted successfully'
    ]);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error occurred']);
}
