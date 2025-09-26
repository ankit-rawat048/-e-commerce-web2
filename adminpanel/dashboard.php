<?php
$orders = [
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
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <title>Admin Dashboard</title>
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
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
          <a href="<?= $card['link'] ?>" class="self-end bg-white bg-opacity-20 hover:bg-opacity-40 px-3 py-1 rounded-full text-lg font-bold transition">&#62;</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Customer Orders Table -->
    <div class="mt-10 ]">
      <div class="flex justify-between items-center h-[44px]">
        <h3 class="text-xl font-semibold h-full">Customer Orders</h3>
        <!-- <a href="addOrder.php" class="bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-lg flex items-center gap-2 px-4 py-2 transition transform hover:scale-105">
          <i class="fa-solid fa-plus-circle text-lg"></i> Add Order
        </a> -->
      </div>
      
      <hr class="border-1 border-black mt-2 mb-6">

      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow">
          <thead class="bg-gray-800 text-white">
            <tr>
              <th class="py-3 px-4 text-left">#</th>
              <th class="py-3 px-4 text-left">Customer Name</th>
              <th class="py-3 px-4 text-left">Product</th>
              <th class="py-3 px-4 text-left">Quantity</th>
              <th class="py-3 px-4 text-left">Date</th>
              <th class="py-3 px-4 text-left">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php foreach($orders as $index=>$o): ?>
            <tr class="hover:bg-gray-100">
              <td class="py-2 px-4"><?= $index+1 ?></td>
              <td class="py-2 px-4"><?= $o['customer'] ?></td>
              <td class="py-2 px-4"><?= $o['product'] ?></td>
              <td class="py-2 px-4"><?= $o['quantity'] ?></td>
              <td class="py-2 px-4"><?= $o['date'] ?></td>
              <td class="py-2 px-4">
                <span class="px-2 py-1 text-white rounded-full text-xs <?= $o['status']=='Delivered'?'bg-green-500':'bg-yellow-500' ?>">
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

<script>
const sidebar = document.getElementById('sidebar');
const menuButton = document.getElementById('menuButton');
const cancelBtn = document.querySelector(".cancelBtn");

cancelBtn.addEventListener("click", () => sidebar.classList.add("-translate-x-full"));
menuButton.addEventListener("click", () => sidebar.classList.toggle("-translate-x-full"));
</script>

</body>
</html>
