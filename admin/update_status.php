<?php
session_start();
include('includes/conn.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     echo json_encode(['success' => false, 'error' => 'Invalid request method']);
//     exit();
// }

$order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
$new_status = isset($_POST['status']) ? trim($_POST['status']) : '';

// Normalize status case
$valid_statuses = ['Delivered', 'Pending', 'Cancelled', 'In-Progress'];
$new_status_normalized = ucfirst(strtolower($new_status));
// if (!in_array($new_status_normalized, $valid_statuses)) {
//     echo json_encode(['success' => false, 'error' => 'Invalid status']);
//     exit();
// }

try {
    // Start transaction
    $pdo->beginTransaction();

    // Get current status
    $stmt = $pdo->prepare("SELECT order_status FROM orders WHERE id = :order_id");
    $stmt->execute(['order_id' => $order_id]);
    $current_status = $stmt->fetchColumn();

    // if ($current_status === false) {
    //     $pdo->rollBack();
    //     echo json_encode(['success' => false, 'error' => 'Order not found']);
    //     exit();
    // }

    // Update order status
    $stmt = $pdo->prepare("UPDATE orders SET order_status = :status, updated_at = NOW() WHERE id = :order_id");
    $stmt->execute(['status' => $new_status_normalized, 'order_id' => $order_id]);

    // Log status change in order_status_history
    $stmt = $pdo->prepare("
        INSERT INTO order_status_history (order_id, old_status, new_status, changed_by, notes, created_at)
        VALUES (:order_id, :old_status, :new_status, :changed_by, :notes, NOW())
    ");
    $stmt->execute([
        'order_id' => $order_id,
        'old_status' => $current_status,
        'new_status' => $new_status_normalized,
        'changed_by' => (int)$_SESSION['user_id'],
        'notes' => 'Status updated via dashboard'
    ]);

    // Commit transaction
    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => 'Database error: ' . htmlspecialchars($e->getMessage())]);
}
?>