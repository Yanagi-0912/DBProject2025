<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

// 只接受 POST 請求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

// 取得 JSON 資料
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['confirm']) || $input['confirm'] !== true) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Confirmation required']);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$userId]);
    session_destroy();
    echo json_encode([
        'status' => 'success',
        'message' => 'Account deleted successfully'
    ]);

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to delete account: ' . $e->getMessage()
    ]);
}
?>