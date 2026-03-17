<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

$input = json_decode(file_get_contents('php://input'), true);
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'signup':
        if (!empty($input['username']) && !empty($input['password'])) {
            $username = trim($input['username']);
            $password = password_hash($input['password'], PASSWORD_DEFAULT);
            
            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->execute([$username, $password]);
                echo json_encode(['success' => true]);
            } catch (PDOException $e) {
                http_response_code(400);
                echo json_encode(['error' => 'Username already exists or database error.']);
            }
        }
        break;

    case 'login':
        if (!empty($input['username']) && !empty($input['password'])) {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$input['username']]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($input['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo json_encode(['success' => true, 'username' => $user['username']]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Invalid username or password.']);
            }
        }
        break;

    case 'logout':
        session_destroy();
        echo json_encode(['success' => true]);
        break;

    case 'status':
        if (isset($_SESSION['user_id'])) {
            echo json_encode(['logged_in' => true, 'username' => $_SESSION['username']]);
        } else {
            echo json_encode(['logged_in' => false]);
        }
        break;
}
?>
