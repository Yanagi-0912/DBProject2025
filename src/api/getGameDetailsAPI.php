<?php
require_once 'connection.php';

// 1. 接收參數改為 'title'
$title = $_GET['title'] ?? null;

if (!$title) {
    echo json_encode(['status' => 'error', 'message' => 'Missing Game Title']);
    exit;
}

try {
    // 2. 修改 SQL：使用 game_title 來查詢遊戲本體
    $sqlGame = "
        SELECT g.*, AVG(p.rating) as avg_rating, COUNT(p.post_id) as review_count
        FROM games g
        LEFT JOIN posts p ON g.game_id = p.game_id
        WHERE g.game_title = ? 
        GROUP BY g.game_id
    ";
    $stmt = $db->prepare($sqlGame);
    $stmt->execute([$title]);
    $gameData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$gameData) {
        echo json_encode(['status' => 'error', 'message' => 'Game not found']);
        exit;
    }

    // 3. 修改 SQL：取得評論時，也需要確保是對應到該遊戲標題
    // 由於我們已經拿到了 $gameData['game_id']，這裡可以直接用 ID 查評論，效率會比較好
    // 或者也可以用 JOIN games g ON ... WHERE g.game_title = ?
    $gameId = $gameData['game_id'];

    $sqlReviews = "
        SELECT p.*, u.username 
        FROM posts p
        JOIN users u ON p.user_id = u.id
        WHERE p.game_id = ?
        ORDER BY p.post_date DESC
    ";
    $stmtReviews = $db->prepare($sqlReviews);
    $stmtReviews->execute([$gameId]);
    $reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success', 
        'game' => $gameData, 
        'reviews' => $reviews
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>