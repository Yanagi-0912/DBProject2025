<?php
session_start();//用session紀錄登入狀態
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST");

$input = json_decode(file_get_contents("php://input"), true);//取得前端傳來的json資料
$account = $input["account"] ?? "";//??表示如果前端沒傳這個值就給空字串
$password = $input["password"] ?? "";

if (empty($account) || empty($password)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "請填寫所有欄位"
    ]);
    exit();
}

include_once 'connection.php';
$stmt = $db->prepare("SELECT *  FROM users WHERE account = ?");
$stmt->execute([$account]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user || !password_verify($password, $user["password"])){//password_verify是php內建的
    http_response_code(401);
    echo json_encode([
        "status" => "error",
        "message" => "帳號或密碼錯誤"
    ]);
    exit();
}
// 登入成功
$_SESSION["user_id"] = $user["id"];
$_SESSION["username"] = $user["username"];
$_SESSION["account"] = $user["account"];
$_SESSION["follower_count"] = $user["follower_count"] ?? 0;

http_response_code(200);
echo json_encode([
    "status" => "success",
    "message" => "登入成功",
    "user" => [
        "id" => $user["id"],
        "username" => $user["username"],
        "account" => $user["account"],
        "follower_count" => $user["follower_count"] ?? 0
    ]
]);
exit();