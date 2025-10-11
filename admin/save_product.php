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

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit();
}

$name = trim($input['name']);
$image = trim($input['image']);
$description = trim($input['description']);
$category_id = (int)$input['category_id'];
$disease = trim($input['disease']);
$company = trim($input['company']);
$stock = (int)$input['stock'];
$price = (float)$input['price'];
$variants = $input['variants'];

if (empty($name) || empty($image) || empty($description) || empty($category_id) || empty($disease) || empty($company) || empty($stock) || empty($price) || empty($variants)) {
    echo json_encode(['success' => false, 'error' => 'All fields are required']);
    exit();
}

try {
    $pdo->beginTransaction();

    if (isset($input['id']) && (int)$input['id'] > 0) {
        // Update existing product
        $product_id = (int)$input['id'];
        $stmt = $pdo->prepare("
            UPDATE products 
            SET name = :name, image = :image, description = :description, category_id = :category_id, 
                disease = :disease, brand_name = :company, stock = :stock
            WHERE id = :id
        ");
        $stmt->execute([
            'name' => $name,
            'image' => $image,
            'description' => $description,
            'category_id' => $category_id,
            'disease' => $disease,
            'company' => $company,
            'stock' => $stock,
            'id' => $product_id
        ]);

        // Delete existing variants
        $stmt = $pdo->prepare("DELETE FROM product_variants WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
    } else {
        // Insert new product
        $stmt = $pdo->prepare("
            INSERT INTO products (name, image, description, category_id, disease, brand_name, stock, created_at)
            VALUES (:name, :image, :description, :category_id, :disease, :company, :stock, NOW())
        ");
        $stmt->execute([
            'name' => $name,
            'image' => $image,
            'description' => $description,
            'category_id' => $category_id,
            'disease' => $disease,
            'company' => $company,
            'stock' => $stock
        ]);
        $product_id = $pdo->lastInsertId();
    }

    // Insert variants
    foreach ($variants as $variant) {
        if (!empty($variant['weight']) && !empty($variant['price'])) {
            $stmt = $pdo->prepare("
                INSERT INTO product_variants (product_id, weight, price, created_at)
                VALUES (:product_id, :weight, :price, NOW())
            ");
            $stmt->execute([
                'product_id' => $product_id,
                'weight' => $variant['weight'],
                'price' => (float)$variant['price']
            ]);
        }
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => 'Database error: ' . htmlspecialchars($e->getMessage())]);
}
?>