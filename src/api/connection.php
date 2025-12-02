<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:8080");


$host = getenv('DB_HOST') ;
$dbname = getenv('DB_NAME') ;
$user = getenv('DB_USER') ;
$dbPassword = getenv('DB_PASSWORD');

try{
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$dbPassword);
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db ->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    /*測試時再取消註解
    echo json_encode(array(//回傳json讓前端fetch
        "status" => "success", 
        "message" => "資料庫連線成功",
        "host" => $host,
        "databasename" => $dbname
    ));
    */
}
catch(PDOException $e){
    http_response_code(500);
    echo json_encode(array(
        "status" => "error", 
        "message" => "資料庫連線失敗: " . $e->getMessage()
    ));
    exit();//終止程式
}

//$db = null;//結束連線

