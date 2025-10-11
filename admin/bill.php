<?php
include('includes/conn.php');

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

$order = null;
$items = [];
try {
    $stmt = $pdo->prepare("
        SELECT 
            o.customer_name, 
            o.customer_email, 
            o.customer_phone, 
            o.customer_address, 
            o.subtotal, 
            o.delivery_fee, 
            o.total_amount, 
            o.created_at AS order_date, 
            o.order_status AS status,
            o.order_id AS invoice_number
        FROM orders o
        WHERE o.id = :order_id
    ");
    $stmt->execute(['order_id' => $order_id]);
    $order = $stmt->fetch();

    $stmt = $pdo->prepare("
        SELECT 
            oi.product_name, 
            oi.quantity, 
            oi.unit_price, 
            oi.total_price,
            oi.size
        FROM order_items oi
        WHERE oi.order_id = :order_id
    ");
    $stmt->execute(['order_id' => $order_id]);
    $items = $stmt->fetchAll();
} catch (PDOException $e) {
    echo '<p class="text-red-500">Error fetching bill data: ' . htmlspecialchars($e->getMessage()) . '</p>';
    exit();
}

if (!$order || empty($items)) {
    echo '<p class="text-red-500">Invalid order ID or no items found.</p>';
    exit();
}

$customer = htmlspecialchars($order['customer_name']);
$email = htmlspecialchars($order['customer_email']);
$phone = htmlspecialchars($order['customer_phone']);
$address = htmlspecialchars($order['customer_address']);
$subtotal = (float)$order['subtotal'];
$delivery_fee = (float)$order['delivery_fee'];
$order_date = htmlspecialchars(date('d/m/Y', strtotime($order['order_date'])));
$status = htmlspecialchars($order['status']);
$invoice_number = htmlspecialchars($order['invoice_number']);
$due_date = date('d/m/Y', strtotime($order['order_date'] . ' +7 days'));

$tax = $subtotal * 0.10;
$grand_total = $subtotal + $tax + $delivery_fee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    @media print {
        body { background: #fff; margin: 0; padding: 0; }
        #invoice { width: 100%; max-width: 100%; padding: 1rem; box-shadow: none; border-radius: 0; }
        table { page-break-inside: auto; }
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
        tr { page-break-inside: avoid; page-break-after: auto; }
    }
</style>
</head>
<body class="bg-gray-100 flex justify-center py-6 px-2">

<div id="invoice" class="bg-white p-4 sm:p-8 rounded-xl shadow-xl w-full max-w-5xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start gap-4 sm:gap-0">
        <div class="flex items-center gap-4">
            <?php if (file_exists("../images/logo.png")): ?>
                <img src="../images/logo.png" alt="Shri Ganga Herbal Logo" class="h-20 w-20 object-contain">
            <?php else: ?>
                <h2 class="text-2xl font-bold">Shri Ganga Herbal</h2>
            <?php endif; ?>
        </div>
        <div class="mt-4 sm:mt-0 text-left sm:text-right text-sm sm:text-base">
            <p><strong>Invoice Number:</strong> <?= $invoice_number ?></p>
            <p><strong>Invoice Date:</strong> <?= $order_date ?></p>
            <p><strong>Due Date:</strong> <?= $due_date ?></p>
            <p class="text-gray-600 break-words">
                info@shrigangaherbal.com<br>
                +91-1234567890<br>
                GSTIN: 12ABCDE3456F1Z5
            </p>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="mt-6 text-sm sm:text-base">
        <p class="font-semibold">Bill to:</p>
        <p class="break-words">
            <?= $customer ?><br>
            <?= $address ?><br>
            <?= $email ?><br>
            <?= $phone ?>
        </p>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto mt-6 border-t border-b rounded-lg">
        <table class="min-w-full text-sm table-auto">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="py-2 px-3">Item</th>
                    <th class="py-2 px-3">Size</th>
                    <th class="py-2 px-3">Qty</th>
                    <th class="py-2 px-3">Unit Price</th>
                    <th class="py-2 px-3">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr class="border-t">
                    <td class="py-2 px-3"><?= htmlspecialchars($item['product_name']) ?></td>
                    <td class="py-2 px-3"><?= htmlspecialchars($item['size']) ?></td>
                    <td class="py-2 px-3"><?= (int)$item['quantity'] ?></td>
                    <td class="py-2 px-3">₹<?= number_format($item['unit_price'], 2) ?></td>
                    <td class="py-2 px-3">₹<?= number_format($item['total_price'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="mt-6 flex flex-col sm:flex-row justify-end gap-2 sm:gap-4 text-sm sm:text-base">
        <div class="text-right w-full sm:w-auto">
            <p>Subtotal: ₹<?= number_format($subtotal, 2) ?></p>
            <p>Tax (10%): ₹<?= number_format($tax, 2) ?></p>
            <p>Delivery Fee: ₹<?= number_format($delivery_fee, 2) ?></p>
            <p class="font-bold text-lg">Total: ₹<?= number_format($grand_total, 2) ?></p>
        </div>
    </div>

</div>

</body>
</html>
