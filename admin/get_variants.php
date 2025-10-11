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

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

try {
    $stmt = $pdo->prepare("SELECT weight, price FROM product_variants WHERE product_id = :product_id");
    $stmt->execute(['product_id' => $product_id]);
    $variants = $stmt->fetchAll();
    echo json_encode(['success' => true, 'variants' => $variants]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . htmlspecialchars($e->getMessage())]);
}
?>