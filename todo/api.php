<?php
header('Content-Type: application/json');
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
        echo json_encode($stmt->fetchAll());
        break;

    case 'POST':
        if (isset($input['text'])) {
            $stmt = $pdo->prepare("INSERT INTO tasks (text) VALUES (?)");
            $stmt->execute([$input['text']]);
            echo json_encode(['id' => $pdo->lastInsertId(), 'text' => $input['text'], 'completed' => false]);
        }
        break;

    case 'PUT':
        if (isset($input['id'])) {
            // Toggle completed status
            $stmt = $pdo->prepare("UPDATE tasks SET completed = NOT completed WHERE id = ?");
            $stmt->execute([$input['id']]);
            echo json_encode(['success' => true]);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            echo json_encode(['success' => true]);
        }
        break;
}
?>
