<?php
session_start();

// If cart not set, create one
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product when form is submitted
if (isset($_POST['add_to_cart'])) {
    $product = [
        "id" => $_POST['id'],
        "name" => $_POST['name'],
        "price" => $_POST['price'],
        "quantity" => $_POST['quantity']
    ];

    $_SESSION['cart'][] = $product;
}

// Show cart
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="px-6 py-8 bg-gray-100">
  <h1 class="text-2xl font-bold mb-6">🛒 Your Cart</h1>

  <?php if (!empty($_SESSION['cart'])): ?>
    <table class="w-full border border-gray-300 bg-white rounded shadow">
      <tr class="bg-gray-200">
        <th class="border p-2">Product</th>
        <th class="border p-2">Price</th>
        <th class="border p-2">Quantity</th>
        <th class="border p-2">Total</th>
      </tr>
      <?php $grandTotal = 0; ?>
      <?php foreach ($_SESSION['cart'] as $item): ?>
        <?php $total = $item['price'] * $item['quantity']; ?>
        <?php $grandTotal += $total; ?>
        <tr>
          <td class="border p-2"><?= $item['name'] ?></td>
          <td class="border p-2">₹<?= $item['price'] ?></td>
          <td class="border p-2"><?= $item['quantity'] ?></td>
          <td class="border p-2">₹<?= $total ?></td>
        </tr>
      <?php endforeach; ?>
      <tr class="bg-gray-100">
        <td colspan="3" class="border p-2 text-right font-bold">Grand Total</td>
        <td class="border p-2 font-bold">₹<?= $grandTotal ?></td>
      </tr>
    </table>
  <?php else: ?>
    <p class="text-gray-600">Your cart is empty.</p>
  <?php endif; ?>
</body>
</html>
