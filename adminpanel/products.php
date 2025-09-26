<?php
// Sidebar links (common for all pages)
$sidebarLinks = [
    ["label"=>"Dashboard", "href"=>"dashboard.php", "icon"=>"fa-gauge-high"],
    ["label"=>"Products", "href"=>"products.php", "icon"=>"fa-box-open"],
    ["label"=>"Orders", "href"=>"orders.php", "icon"=>"fa-cart-shopping"],
    ["label"=>"Users", "href"=>"users.php", "icon"=>"fa-users"],
    ["label"=>"Reports", "href"=>"reports.php", "icon"=>"fa-chart-line"],
    ["label"=>"Settings", "href"=>"settings.php", "icon"=>"fa-gear"],
    ["label"=>"Logout", "href"=>"logout.php", "icon"=>"fa-right-from-bracket", "class"=>"mt-auto text-red-400 hover:bg-red-600"]
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

  <!-- Include reusable sidebar -->
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
      <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
    </div>
    <hr class="border-2 border-black mb-4">

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php
      $cards = [
        ["title"=>"Total Products", "value"=>"128", "bg"=>"card1.jpg", "link"=>"directs.php"],
        ["title"=>"Out Of Stock", "value"=>"16", "bg"=>"card2.jpg", "link"=>"directs.php"],
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
          <a href="<?= $card['link'] ?>" class="self-end bg-white bg-opacity-20 hover:bg-opacity-40 px-3 py-1 rounded-full text-lg font-bold transition">&#62;</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Products Table -->
    <div class="mt-10">
      <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold">All Products</h3>

        <!-- Add Product Button -->
        <a href="addProductForm.php"
          class="bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-lg flex items-center gap-2 px-4 py-2 transition transform hover:scale-105">
          <i class="fa-solid fa-plus-circle text-lg"></i>
          Add Products
        </a>
      </div>

      <hr class="border-1 border-black mt-2 mb-6">

      <!-- Table -->
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
            <tr class="hover:bg-gray-100">
              <td class="py-2 px-4">1</td>
              <td class="py-2 px-4">Coffee Beans</td>
              <td class="py-2 px-4">Beverages</td>
              <td class="py-2 px-4">$25.00</td>
              <td class="py-2 px-4">120</td>
              <td class="py-2 px-4">
                <span class="px-2 py-1 bg-green-500 text-white rounded-full text-xs">In Stock</span>
              </td>
              <td class="py-2 px-4 flex gap-2">
                <button class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                <button class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
              </td>
            </tr>
            <tr class="hover:bg-gray-100">
              <td class="py-2 px-4">2</td>
              <td class="py-2 px-4">Patti Oil</td>
              <td class="py-2 px-4">Health</td>
              <td class="py-2 px-4">$15.00</td>
              <td class="py-2 px-4">0</td>
              <td class="py-2 px-4">
                <span class="px-2 py-1 bg-red-500 text-white rounded-full text-xs">Out of Stock</span>
              </td>
              <td class="py-2 px-4 flex gap-2">
                <button class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                <button class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<script>
const sidebar = document.getElementById('sidebar');
const menuButton = document.getElementById('menuButton');
const cancelBtn = document.querySelector(".cancelBtn");

// Close sidebar
cancelBtn.addEventListener("click", () => {
  sidebar.classList.add("-translate-x-full");
});

// Toggle sidebar
menuButton.addEventListener('click', () => {
  sidebar.classList.toggle('-translate-x-full');
});
</script>

</body>
</html>
