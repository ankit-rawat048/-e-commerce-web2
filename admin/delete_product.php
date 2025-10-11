<?php
session_start();
include('includes/conn.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit();
}

$product_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

try {
    $pdo->beginTransaction();

    // Delete variants
    $stmt = $pdo->prepare("DELETE FROM product_variants WHERE product_id = :product_id");
    $stmt->execute(['product_id' => $product_id]);

    // Delete product
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :product_id");
    $stmt->execute(['product_id' => $product_id]);

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => 'Database error: ' . htmlspecialchars($e->getMessage())]);
}
?>