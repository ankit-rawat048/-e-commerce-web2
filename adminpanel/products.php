<?php

// Example Products (later replace with DB)
$products = [
  ["name"=>"Coffee Beans", "category"=>"Beverages", "price"=>25.00, "stock"=>120, "status"=>"In Stock"],
  ["name"=>"Green Tea", "category"=>"Beverages", "price"=>15.50, "stock"=>80, "status"=>"In Stock"],
  ["name"=>"Olive Oil", "category"=>"Grocery", "price"=>45.00, "stock"=>30, "status"=>"Low Stock"],
  ["name"=>"Pasta", "category"=>"Grocery", "price"=>12.00, "stock"=>0, "status"=>"Out of Stock"],  ["name"=>"Coffee Beans", "category"=>"Beverages", "price"=>25.00, "stock"=>120, "status"=>"In Stock"],
  ["name"=>"Green Tea", "category"=>"Beverages", "price"=>15.50, "stock"=>80, "status"=>"In Stock"],
  ["name"=>"Olive Oil", "category"=>"Grocery", "price"=>45.00, "stock"=>30, "status"=>"Low Stock"],
  ["name"=>"Pasta", "category"=>"Grocery", "price"=>12.00, "stock"=>0, "status"=>"Out of Stock"],  ["name"=>"Coffee Beans", "category"=>"Beverages", "price"=>25.00, "stock"=>120, "status"=>"In Stock"],
  ["name"=>"Green Tea", "category"=>"Beverages", "price"=>15.50, "stock"=>80, "status"=>"In Stock"],
  ["name"=>"Olive Oil", "category"=>"Grocery", "price"=>45.00, "stock"=>30, "status"=>"Low Stock"],
  ["name"=>"Pasta", "category"=>"Grocery", "price"=>12.00, "stock"=>0, "status"=>"Out of Stock"],  ["name"=>"Coffee Beans", "category"=>"Beverages", "price"=>25.00, "stock"=>120, "status"=>"In Stock"],
  ["name"=>"Green Tea", "category"=>"Beverages", "price"=>15.50, "stock"=>80, "status"=>"In Stock"],
  ["name"=>"Olive Oil", "category"=>"Grocery", "price"=>45.00, "stock"=>30, "status"=>"Low Stock"],
  ["name"=>"Pasta", "category"=>"Grocery", "price"=>12.00, "stock"=>0, "status"=>"Out of Stock"],  ["name"=>"Coffee Beans", "category"=>"Beverages", "price"=>25.00, "stock"=>120, "status"=>"In Stock"],
  ["name"=>"Green Tea", "category"=>"Beverages", "price"=>15.50, "stock"=>80, "status"=>"In Stock"],
  ["name"=>"Olive Oil", "category"=>"Grocery", "price"=>45.00, "stock"=>30, "status"=>"Low Stock"],
  ["name"=>"Pasta", "category"=>"Grocery", "price"=>12.00, "stock"=>0, "status"=>"Out of Stock"],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <title>Admin - Products</title>
</head>
<body class="bg-gray-100">

<div class="flex">

  <!-- Sidebar -->
  <?php include('sidebar.php'); ?>

  <!-- Main Content -->
  <div class="flex-1 p-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
      <div class="md:hidden mb-4">
        <button id="menuButton" class="text-2xl text-black">
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>
      <h2 class="text-2xl font-bold mb-4">Manage Products</h2>
    </div>
    <hr class="border-2 border-black mb-4">

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php
      $cards = [
        ["title"=>"Total Products", "value"=>count($products), "bg"=>"card1.jpg", "link"=>"directs.php"],
        ["title"=>"Out Of Stock", "value"=>count(array_filter($products, fn($p)=>$p['stock']==0)), "bg"=>"card2.jpg", "link"=>"directs.php"],
        ["title"=>"Best-Selling", "value"=>"Coffee Beans", "bg"=>"card3.jpg", "link"=>"directs.php"],
        ["title"=>"Upcoming", "value"=>"Patti Oil", "bg"=>"card4.jpg", "link"=>"directs.php"]
      ];
      foreach($cards as $card): ?>
        <div class="relative rounded-xl shadow-lg h-40 text-white overflow-hidden transform hover:scale-105 transition duration-300"
           style="background-image: url('../images/<?= $card['bg'] ?>'); background-size: cover; background-position: center;">
          <div class="absolute inset-0 bg-black bg-opacity-50"></div>
          <div class="relative p-4 h-full flex flex-col justify-between">
            <h2 class="text-lg sm:text-xl font-semibold"><?= $card['title'] ?></h2>
            <h1 class="text-2xl sm:text-3xl font-bold"><?= $card['value'] ?></h1>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Products Table -->
    <div class="mt-10">
      <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold">All Products</h3>

        <!-- Add Product Button -->
        <label for="add-modal" class="bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-lg flex items-center gap-2 px-4 py-2 cursor-pointer transition transform hover:scale-105">
          <i class="fa-solid fa-plus-circle text-lg"></i>
          Add Products
        </label>
      </div>

      <hr class="border-1 border-black mt-2 mb-6">

      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow">
          <thead class="bg-gray-800 text-white">
            <tr>
              <th class="py-3 px-4 text-left">#</th>
              <th class="py-3 px-4 text-left">Product</th>
              <th class="py-3 px-4 text-left">Category</th>
              <th class="py-3 px-4 text-left">Price</th>
              <th class="py-3 px-4 text-left">Stock</th>
              <th class="py-3 px-4 text-left">Status</th>
              <th class="py-3 px-4 text-left">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php foreach($products as $index => $p): ?>
              <tr class="hover:bg-gray-100">
                <td class="py-2 px-4"><?= $index+1 ?></td>
                <td class="py-2 px-4"><?= $p['name'] ?></td>
                <td class="py-2 px-4"><?= $p['category'] ?></td>
                <td class="py-2 px-4">$<?= number_format($p['price'], 2) ?></td>
                <td class="py-2 px-4"><?= $p['stock'] ?></td>
                <td class="py-2 px-4">
                  <?php if($p['status']=="In Stock"): ?>
                    <span class="px-2 py-1 bg-green-500 text-white rounded-full text-xs"><?= $p['status'] ?></span>
                  <?php elseif($p['status']=="Low Stock"): ?>
                    <span class="px-2 py-1 bg-yellow-500 text-white rounded-full text-xs"><?= $p['status'] ?></span>
                  <?php else: ?>
                    <span class="px-2 py-1 bg-red-500 text-white rounded-full text-xs"><?= $p['status'] ?></span>
                  <?php endif; ?>
                </td>
                <td class="py-2 px-4 flex gap-2">
                  <label for="edit-modal" class="px-2 py-1 bg-blue-500 text-white rounded cursor-pointer hover:bg-blue-600">Edit</label>
                  <button class="deleteBtn px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- Tailwind Modals -->
<input type="checkbox" id="edit-modal" class="modal-toggle hidden">
<div class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
  <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] max-h-[90vh] overflow-y-auto relative">
    <label for="edit-modal" class="absolute top-2 right-2 text-gray-600 hover:text-black cursor-pointer">
      <i class="fa-solid fa-xmark text-xl"></i>
    </label>
    <?php include('productDetail.php'); ?>
  </div>
</div>

<input type="checkbox" id="add-modal" class="modal-toggle hidden">
<div class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
  <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] max-h-[90vh] overflow-y-auto relative">
    <label for="add-modal" class="absolute top-2 right-2 text-gray-600 hover:text-black cursor-pointer">
      <i class="fa-solid fa-xmark text-xl"></i>
    </label>
    <?php include('addProduct.php'); ?>
  </div>
</div>

<script>
const sidebar = document.getElementById('sidebar');
const menuButton = document.getElementById('menuButton');

// Sidebar toggle
menuButton?.addEventListener('click', () => {
  sidebar.classList.toggle('-translate-x-full');
});

// Confirm Delete
document.querySelectorAll(".deleteBtn").forEach(btn => {
  btn.addEventListener("click", () => {
    if(confirm("Are you sure you want to delete this product?")){
      console.log("Product deleted");
    }
  });
});
</script>

<style>
/* Tailwind modal visibility */
.modal-toggle:checked + .modal {
  opacity: 1 !important;
  pointer-events: auto !important;
}
</style>

</body>
</html>
