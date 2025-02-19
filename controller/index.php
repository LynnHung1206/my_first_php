<?php

require_once '../db/db.php';
use Monolog\Logger;

header('Content-Type: application/json');


$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

print_r($path);
$resource = $path[0] ?? '';
$id = $path[1] ?? null;

$dbConnection = new DatabaseConnection();
$db = $dbConnection->getDbConnection();

// 路由處理
if ($resource === 'users') {
    switch ($method) {
        case 'GET':
            if ($id) {
                getUser($id, $db);
            } else {
                getUsers($db);
            }
            break;
        case 'POST':
            createUser($db);
            break;
        case 'PUT':
            if ($id) {
                updateUser($id, $db);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'User ID is required']);
            }
            break;
        case 'DELETE':
            if ($id) {
                deleteUser($id, $db);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'User ID is required']);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Resource Not Found']);
}

// 取得所有用戶
function getUsers($db): void
{
    $result = $db->query('SELECT * FROM users');
    $users = $result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
}

// 取得單個用戶
function getUser($id, $db): void
{
    $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'User Not Found']);
    }
}

// 創建用戶
function createUser($db): void
{
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['name']) || !isset($input['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
        return;
    }
    $stmt = $db->prepare('INSERT INTO users (name, email) VALUES (:name, :email)');
    $stmt->execute(['name' => $input['name'], 'email' => $input['email']]);
    http_response_code(201);
    echo json_encode(['id' => $db->lastInsertId()]);
}

// 更新用戶
function updateUser($id, $db): void
{
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['name']) || !isset($input['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
        return;
    }
    $stmt = $db->prepare('UPDATE users SET name = :name, email = :email WHERE id = :id');
    $stmt->execute(['name' => $input['name'], 'email' => $input['email'], 'id' => $id]);
    echo json_encode(['success' => $stmt->rowCount() > 0]);
}

// 刪除用戶
function deleteUser($id, $db): void
{
    $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
    $stmt->execute(['id' => $id]);
    echo json_encode(['success' => $stmt->rowCount() > 0]);
}
