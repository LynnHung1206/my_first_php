<?php

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class DatabaseConnection
{
    private $dsn;
    private $user;
    private $password;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $dbname = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    }

    public function getDbConnection()
    {
        try {
            $db = new PDO($this->dsn, $this->user, $this->password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database connection failed', 'details' => $e->getMessage()]);
            exit;
        }
    }

}

// 使用類來連接資料庫
$dbConnection = new DatabaseConnection();
$db = $dbConnection->getDbConnection();

// 你可以使用 $db 執行查詢
echo "資料庫連線成功\n";
