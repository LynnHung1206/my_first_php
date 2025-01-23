<?php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "開始執行 \n";

$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

try {
    // 建立 PDO 連接
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password);

    // 設定 PDO 錯誤模式為異常
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "成功連接到 PostgreSQL！\n";

    // 測試查詢
    $query = $pdo->query("SELECT version();");
    $query1 = $pdo->query("SELECT * FROM line_message;");
    $r = $query1->fetchAll(PDO::FETCH_ASSOC);

    // 呈現方式一
    var_dump($r);
    // 呈現方式二
    echo json_encode($r, JSON_PRETTY_PRINT);
    // 呈現方式三
    foreach ($r as $row) {
        print_r($row);
    }

    $version = $query->fetchColumn();
    echo "PostgreSQL 版本: $version\n";
} catch (PDOException $e) {
    // 捕捉連接異常
    echo "連接失敗：" . $e->getMessage();
}

