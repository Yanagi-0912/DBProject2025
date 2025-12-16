<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST");
if (!isset($_SESSION["user_id"])) {// 如果未登入，回傳錯誤
    http_response_code(401);
    echo json_encode([
        "status" => "error",
        "message" => "未登入"
    ]);
    exit();
}
require_once 'connection.php'; 
$input = json_decode(file_get_contents("php://input"), true);//取得前端傳來的json資料
$user_id = $_SESSION["user_id"];
$newUsername = trim($input["username"]);
$password = $input["password"] ?? "";
$passwordConfirm = $input["passwordConfirm"] ?? "";

if (empty($newUsername)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "使用者名稱不能為空"
    ]);
    exit();
}

if(!empty($password)||!empty($passwordConfirm)){
    if ($password !== $passwordConfirm) {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "密碼與確認密碼不符"
        ]);
        exit();
    }
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    $stmt->execute([$newUsername, $passwordHash, $user_id]);
} 
else {// 只更新使用者名稱
    $stmt = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->execute([$newUsername, $user_id]);
}
http_response_code(200);
echo json_encode([
    "status" => "success",
    "message" => "修改個人資料成功",
]);
$_SESSION["username"] = $newUsername;// 更新 session 中的使用者名稱
exit();