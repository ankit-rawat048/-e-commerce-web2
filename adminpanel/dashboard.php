<?php
$orders = [
  ["customer"=>"John Doe","product"=>"Coffee Beans","quantity"=>2,"date"=>"2025-09-25","status"=>"Delivered"],
  ["customer"=>"Jane Smith","product"=>"Patti Oil","quantity"=>1,"date"=>"2025-09-24","status"=>"Pending"],
  ["customer"=>"Alex Lee","product"=>"Green Tea","quantity"=>3,"date"=>"2025-09-23","status"=>"Delivered"],
  ["customer"=>"John Doe","product"=>"Coffee Beans","quantity"=>2,"date"=>"2025-09-25","status"=>"Delivered"],
  ["customer"=>"Jane Smith","product"=>"Patti Oil","quantity"=>1,"date"=>"2025-09-24","status"=>"Pending"],
  ["customer"=>"Alex Lee","product"=>"Green Tea","quantity"=>3,"date"=>"2025-09-23","status"=>"Delivered"],
  ["customer"=>"John Doe","product"=>"Coffee Beans","quantity"=>2,"date"=>"2025-09-25","status"=>"Delivered"],
  ["customer"=>"Jane Smith","product"=>"Patti Oil","quantity"=>1,"date"=>"2025-09-24","status"=>"Pending"],
  ["customer"=>"Alex Lee","product"=>"Green Tea","quantity"=>3,"date"=>"2025-09-23","status"=>"Delivered"],
  ["customer"=>"John Doe","product"=>"Coffee Beans","quantity"=>2,"date"=>"2025-09-25","status"=>"Delivered"],
  ["customer"=>"Jane Smith","product"=>"Patti Oil","quantity"=>1,"date"=>"2025-09-24","status"=>"Pending"],
  ["customer"=>"Alex Lee","product"=>"Green Tea","quantity"=>3,"date"=>"2025-09-23","status"=>"Delivered"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("../include/links.php") ?>

</head>
<body class="bg-gray-100">

<div class="flex">

  <!-- Include reusable sidebar -->
  <?php include('sidebar.php'); ?>

  <!-- Main content -->
  <div class="flex-1 p-6">
    <div class="flex justify-between items-center">
      <div class="md:hidden mb-4">
        <button id="menuButton" class="text-2xl text-black">
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>
      <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
    </div>

    <hr class="border-2 border-black mb-4">

 <!-- Dashboard Cards -->
<div class="card-four grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-6 w-full">
  <?php
  $cards = [
    ["title"=>"Total Orders Today", "value"=>"128 Orders", "bg"=>"card1.jpg", "link"=>"orders.php"],
    ["title"=>"Total Revenue", "value"=>"$4,520", "bg"=>"card2.jpg", "link"=>"revenue.php"],
    ["title"=>"Best-Selling Product", "value"=>"Coffee Beans", "bg"=>"card3.jpg", "link"=>"bestseller.php"],
    ["title"=>"Pending Appointments", "value"=>"42", "bg"=>"card4.jpg", "link"=>"appointments.php"]
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


    <!-- Customer Orders Table -->
    <div class="mt-10 ]">
      <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold">Customer Orders</h3>
        <a href="addOrder.php" class="invisible bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-lg flex items-center gap-2 px-4 py-2 transition transform hover:scale-105">
          <i class="fa-solid fa-plus-circle text-lg"></i> Add Order
        </a>
      </div>
      
      <hr class="border-1 border-black mt-2 mb-6">

      <div class="overflow-x-auto bg-white rounded shadow">
<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
  <!-- Table Header -->
  <table class="min-w-full border-collapse">
    <thead class="bg-gray-800 text-white sticky top-0 z-10 shadow-md">
      <tr>
        <th class="py-3 pl-4 text-left font-semibold">#</th>
        <th class="py-3 pl-4 text-left font-semibold">Customer</th>
        <th class="py-3 pl-4 text-left font-semibold">Product</th>
        <th class="py-3 pl-4 text-left font-semibold">Quantity</th>
        <th class="py-3 pl-4 text-left font-semibold">Date</th>
        <th class="py-3 pl-4 text-left font-semibold">Status</th>
      </tr>
    </thead>
  </table>

  <!-- Scrollable Table Body -->
  <div class="max-h-96 overflow-y-auto">
    <table class="min-w-full border-collapse">
      <tbody class="divide-y divide-gray-200 text-sm">
        <?php foreach($orders as $index=>$o): ?>
        <tr class="hover:bg-gray-100 even:bg-gray-50 transition">
          <!-- Index -->
          <td class="py-3 pl-4 font-medium text-gray-700"><?= $index+1 ?></td>
          <!-- Customer -->
          <td class="py-3 pl-4 text-gray-600"><?= $o['customer'] ?></td>
          <!-- Product -->
          <td class="py-3 pl-4 text-gray-600"><?= $o['product'] ?></td>
          <!-- Quantity -->
          <td class="py-3 pl-4 text-gray-600"><?= $o['quantity'] ?></td>
          <!-- Date -->
          <td class="py-3 pl-4 text-gray-500"><?= $o['date'] ?></td>
          <!-- Status -->
          <td class="py-3 pl-4">
            <span class="px-3 py-1 rounded-full text-xs font-medium 
              <?= $o['status']=='Delivered' 
                ? 'bg-green-100 text-green-700 border border-green-300' 
                : 'bg-yellow-100 text-yellow-700 border border-yellow-300' ?>">
              <?= $o['status'] ?>
            </span>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</div>

    </div>

  </div>
</div>

<script>
const sidebar = document.getElementById('sidebar');
const menuButton = document.getElementById('menuButton');
const cancelBtn = document.querySelector(".cancelBtn");

cancelBtn.addEventListener("click", () => sidebar.classList.add("-translate-x-full"));
menuButton.addEventListener("click", () => sidebar.classList.toggle("-translate-x-full"));
</script>

<!-- <style>
@media (max-width: 640px) {
  .card-four{
    display: flex;
  }
}
</style> -->

</body>
</html>
