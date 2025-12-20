<?php
// 依使用者 ID 取得貼文列表
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");

require_once 'connection.php';
$userId = $_GET['user_id'] ?? null;
if (!$userId || !ctype_digit((string)$userId)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing or invalid user_id']);
    exit;
}
try{
    $stmt = $db->prepare("CALL getpostByUserId(?)");//注意procedure要用CALL的
    $stmt->execute([$userId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $rows]);
} 
catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit();