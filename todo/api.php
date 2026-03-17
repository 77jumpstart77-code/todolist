<?php
header('Content-Type: application/json');
require_once 'db.php';

// Security: Basic CORS (Restrict this in production)
// header("Access-Control-Allow-Origin: yourdomain.com");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

// Utility for XSS Prevention
function clean($data) {
    return htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
}

switch ($method) {
    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'stats') {
            $stmt = $pdo->query("SELECT DATE(completed_at) as date, COUNT(*) as count 
                                 FROM tasks 
                                 WHERE completed = 1 AND completed_at IS NOT NULL 
                                 GROUP BY DATE(completed_at) 
                                 ORDER BY date DESC LIMIT 30");
            echo json_encode($stmt->fetchAll());
        } else {
            $stmt = $pdo->query("SELECT id, text, completed, created_at, completed_at FROM tasks ORDER BY created_at DESC");
            echo json_encode($stmt->fetchAll());
        }
        break;

    case 'POST':
        if (isset($input['text']) && !empty(trim($input['text']))) {
            $cleaned_text = clean($input['text']);
            $stmt = $pdo->prepare("INSERT INTO tasks (text) VALUES (?)");
            $stmt->execute([$cleaned_text]);
            echo json_encode(['id' => $pdo->lastInsertId(), 'text' => $cleaned_text, 'completed' => false]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
        break;

    case 'PUT':
        if (isset($input['id'])) {
            $id = (int)$input['id'];
            // Toggle completed status and set/unset completed_at
            $stmt = $pdo->prepare("UPDATE tasks SET 
                completed = NOT completed, 
                completed_at = IF(completed = 0, CURRENT_TIMESTAMP, NULL) 
                WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        }
        break;
}
?>
