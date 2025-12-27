<?php
//將init.sql內插入的user的密碼hash
require_once 'connection.php';

try{
    $stmt = $db->prepare("SELECT *  FROM users ");
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$user){
        http_response_code(401);
        echo json_encode([
            "status" => "error",
            "message" => "沒有使用者"
        ]);
        exit();
    }
    for ($i=0; $i < count($user); $i++) { 
        if(password_get_info($user[$i]['password'])['algo']!=0){//已經是hash過的密碼就跳過
            continue;
        }
        $password=$user[$i]['password'];
        echo "<h1>".$password."</h1> ";
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);//將密碼加密
        echo "<h1>".$passwordHash."</h1> ";
        $stmt = $db->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->execute([$passwordHash,$user[$i]['id']]);
    }

}

catch(PDOException $e){
    http_response_code(500);
    echo json_encode([
        "status" => "error", 
        "message" => "註冊失敗: " . $e->getMessage()
    ]);
    exit();//終止程式
}
