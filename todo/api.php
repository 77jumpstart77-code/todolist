<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

// Check Authentication
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

function clean($data) {
    return htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
}

switch ($method) {
    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'stats') {
            $stmt = $pdo->prepare("SELECT DATE(completed_at) as date, COUNT(*) as count 
                                 FROM tasks 
                                 WHERE user_id = ? AND completed = 1 AND completed_at IS NOT NULL 
                                 GROUP BY DATE(completed_at) 
                                 ORDER BY date DESC LIMIT 30");
            $stmt->execute([$user_id]);
            echo json_encode($stmt->fetchAll());
        } else {
            $stmt = $pdo->prepare("SELECT id, text, completed, created_at, completed_at FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
            $stmt->execute([$user_id]);
            echo json_encode($stmt->fetchAll());
        }
        break;

    case 'POST':
        if (!empty($input['text'])) {
            $cleaned_text = clean($input['text']);
            $stmt = $pdo->prepare("INSERT INTO tasks (user_id, text) VALUES (?, ?)");
            $stmt->execute([$user_id, $cleaned_text]);
            echo json_encode(['id' => $pdo->lastInsertId(), 'text' => $cleaned_text, 'completed' => false]);
        }
        break;

    case 'PUT':
        if (isset($input['id'])) {
            $id = (int)$input['id'];
            $stmt = $pdo->prepare("UPDATE tasks SET 
                completed = NOT completed, 
                completed_at = IF(completed = 0, CURRENT_TIMESTAMP, NULL) 
                WHERE id = ? AND user_id = ?");
            $stmt->execute([$id, $user_id]);
            echo json_encode(['success' => true]);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
            $stmt->execute([$id, $user_id]);
            echo json_encode(['success' => true]);
        }
        break;
}
?>
