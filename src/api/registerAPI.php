<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST");

$input = json_decode(file_get_contents("php://input"), true);//取得前端傳來的json資料
$username = $input["username"] ?? "";//??表示如果前端沒傳這個值就給空字串
$account = $input["account"] ?? "";
$password = $input["password"] ?? "";
if (empty($username) || empty($account) || empty($password)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "請填寫所有欄位"
    ]);
    exit();
}
include_once 'connection.php';
try{
    // 檢查帳號是否已存在
$stmt = $db->prepare("SELECT id FROM users WHERE account = ?");
$stmt->execute([$account]);
if ($stmt->rowCount() > 0) {
    http_response_code(409);
    echo json_encode([
        "status" => "error",
        "message" => "帳號已存在"
    ]);
    exit();
}
$stmt = $db->prepare("INSERT INTO users (username, account, password) VALUES (?, ?, ?)");
$passwordHash = password_hash($password, PASSWORD_DEFAULT);//將密碼加密
$stmt->execute([$username, $account, $passwordHash]);
    http_response_code(201);
    echo json_encode([
        "status" => "success",
        "message" => "註冊成功"
    ]);
    exit();
    }
catch(PDOException $e){
    http_response_code(500);
    echo json_encode([
        "status" => "error", 
        "message" => "註冊失敗: " . $e->getMessage()
    ]);
    exit();//終止程式
}
