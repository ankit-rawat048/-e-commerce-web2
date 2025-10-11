<?php
// cards.php
$page = $_GET['page'] ?? 'dashboard';

$cards = [];
try {
    if ($page === 'dashboard') {
        $total_orders = $pdo->query("SELECT COUNT(id) FROM orders")->fetchColumn();
        $revenue = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE payment_status = 'paid'")->fetchColumn() ?? 0;
        $customers = $pdo->query("SELECT COUNT(id) FROM customers")->fetchColumn();
        $pending = $pdo->query("SELECT COUNT(id) FROM orders WHERE order_status = 'Pending'")->fetchColumn();
        $cards = [
            ['title' => 'Total Orders', 'value' => $total_orders, 'icon' => 'fa-shopping-cart', 'color' => 'bg-blue-500'],
            ['title' => 'Revenue', 'value' => '₹' . number_format($revenue, 2), 'icon' => 'fa-wallet', 'color' => 'bg-green-500'],
            ['title' => 'Customers', 'value' => $customers, 'icon' => 'fa-users', 'color' => 'bg-yellow-500'],
            ['title' => 'Pending', 'value' => $pending, 'icon' => 'fa-clock', 'color' => 'bg-red-500'],
        ];
    } elseif ($page === 'orders') {
        $new_orders = $pdo->query("SELECT COUNT(id) FROM orders WHERE DATE(created_at) = CURDATE()")->fetchColumn();
        $delivered = $pdo->query("SELECT COUNT(id) FROM orders WHERE order_status = 'Delivered'")->fetchColumn();
        $cancelled = $pdo->query("SELECT COUNT(id) FROM orders WHERE order_status = 'Cancelled'")->fetchColumn();
        $cards = [
            ['title' => 'New Orders', 'value' => $new_orders, 'icon' => 'fa-truck', 'color' => 'bg-indigo-500'],
            ['title' => 'Delivered', 'value' => $delivered, 'icon' => 'fa-check-circle', 'color' => 'bg-green-600'],
            ['title' => 'Cancelled', 'value' => $cancelled, 'icon' => 'fa-times-circle', 'color' => 'bg-red-600'],
        ];
    } elseif ($page === 'products') {
        $total_products = $pdo->query("SELECT COUNT(id) FROM products")->fetchColumn();
        $categories = $pdo->query("SELECT COUNT(DISTINCT category_id) FROM products")->fetchColumn();
        $stmt = $pdo->query("
            SELECT p.category_id, SUM(oi.quantity) AS total_qty
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            GROUP BY p.category_id
            ORDER BY total_qty DESC
            LIMIT 1
        ");
        $row = $stmt->fetch();
        $most_sell_category = $row ? $row['category_id'] : 'None';
        $cards = [
            ['title' => 'Total Products', 'value' => $total_products, 'icon' => 'fa-box', 'color' => 'bg-purple-500'],
            ['title' => 'Out of Stock', 'value' => '0', 'icon' => 'fa-exclamation-triangle', 'color' => 'bg-orange-500'], // No stock field
            ['title' => 'Categories', 'value' => $categories, 'icon' => 'fa-tags', 'color' => 'bg-teal-500'],
            ['title' => 'Most Sell Category', 'value' => $most_sell_category, 'icon' => 'fa-tags', 'color' => 'bg-teal-500'],
        ];
    }
} catch (PDOException $e) {
    echo '<p class="text-red-500">Error fetching card data: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>
<div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php foreach ($cards as $card): ?>
        <div class="p-6 rounded-2xl shadow-md text-white <?= $card['color'] ?> flex items-center justify-between">
            <div>
                <h3 class="md:text-lg sm:text-sm font-semibold"><?= $card['title'] ?></h3>
                <p class="md:text-2xl sm:text-sm font-bold"><?= $card['value'] ?></p>
            </div>
            <i class="fas <?= $card['icon'] ?> md:text-3xl sm:text-sm opacity-80"></i>
        </div>
    <?php endforeach; ?>
</div>