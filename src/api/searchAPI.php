<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");

require_once 'connection.php';

$query = trim($_GET['q'] ?? '');

if ($query === '') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Search query is required']);
    exit;
}

try {
    $pdo = getPDO();
    $searchTerm = "%{$query}%";
    
    // 搜尋遊戲
    $gamesStmt = $pdo->prepare("
        SELECT game_id, game_title, description, image as banner_url
        FROM games
        WHERE game_title LIKE ?
        LIMIT 10
    ");
    $gamesStmt->execute([$searchTerm]);
    $games = $gamesStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // 搜尋貼文
    $postsStmt = $pdo->prepare("
        SELECT p.post_id, p.title, p.content, p.image_url, p.post_date as created_at,
               u.username, g.game_title
        FROM posts p
        LEFT JOIN users u ON p.user_id = u.id
        LEFT JOIN games g ON p.game_id = g.game_id
        WHERE p.title LIKE ? OR p.content LIKE ?
        ORDER BY p.post_date DESC
        LIMIT 10
    ");
    $postsStmt->execute([$searchTerm, $searchTerm]);
    $posts = $postsStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // 搜尋用戶
    $usersStmt = $pdo->prepare("
        SELECT id as user_id, username, account
        FROM users
        WHERE username LIKE ? OR account LIKE ?
        LIMIT 10
    ");
    $usersStmt->execute([$searchTerm, $searchTerm]);
    $users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'status' => 'success',
        'data' => [
            'games' => $games,
            'posts' => $posts,
            'users' => $users
        ],
        'query' => $query
    ]);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Search failed']);
}
