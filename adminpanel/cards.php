<?php
// cards.php
$page = $_GET['page'] ?? 'dashboard'; // default page

// cards.php
include "../include/links.php";
// include "sidebar.php";

// Card content for different pages
$cards = [
    'dashboard' => [
        ['title' => 'Total Orders', 'value' => '1,250', 'icon' => 'fa-shopping-cart', 'color' => 'bg-blue-500'],
        ['title' => 'Revenue', 'value' => '₹75,000', 'icon' => 'fa-wallet', 'color' => 'bg-green-500'],
        ['title' => 'Customers', 'value' => '890', 'icon' => 'fa-users', 'color' => 'bg-yellow-500'],
        ['title' => 'Pending', 'value' => '23', 'icon' => 'fa-clock', 'color' => 'bg-red-500'],
    ],
    'orders' => [
        ['title' => 'New Orders', 'value' => '120', 'icon' => 'fa-truck', 'color' => 'bg-indigo-500'],
        ['title' => 'Delivered', 'value' => '1100', 'icon' => 'fa-check-circle', 'color' => 'bg-green-600'],
        ['title' => 'Cancelled', 'value' => '30', 'icon' => 'fa-times-circle', 'color' => 'bg-red-600'],
    ],
    'products' => [
        ['title' => 'Total Products', 'value' => '350', 'icon' => 'fa-box', 'color' => 'bg-purple-500'],
        ['title' => 'Out of Stock', 'value' => '15', 'icon' => 'fa-exclamation-triangle', 'color' => 'bg-orange-500'],
        ['title' => 'Categories', 'value' => '12', 'icon' => 'fa-tags', 'color' => 'bg-teal-500'],
        ['title' => 'Most Sell Categorie', 'value' => 'Watermelon', 'icon' => 'fa-tags', 'color' => 'bg-teal-500'],
    ],
];
?>
<div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php foreach ($cards[$page] as $card): ?>
        <div class="p-6 rounded-2xl shadow-md text-white <?= $card['color'] ?> flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold"><?= $card['title'] ?></h3>
                <p class="text-2xl font-bold"><?= $card['value'] ?></p>
            </div>
            <i class="fas <?= $card['icon'] ?> text-3xl opacity-80"></i>
        </div>
    <?php endforeach; ?>
</div>




<!-- <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
      < ?php
      $cards = [
        ["title"=>"Total Orders Today", "value"=>"128 Orders", "bg"=>"card1.jpg", "link"=>"orders.php"],
        ["title"=>"Total Revenue", "value"=>"$4,520", "bg"=>"card2.jpg", "link"=>"revenue.php"],
        ["title"=>"Best-Selling Product", "value"=>"Coffee Beans", "bg"=>"card3.jpg", "link"=>"bestseller.php"],
        ["title"=>"Pending Appointments", "value"=>"42", "bg"=>"card4.jpg", "link"=>"appointments.php"]
      ];
      foreach($cards as $card): ?>
        <div class="relative rounded-xl shadow-lg h-40 text-white overflow-hidden transform hover:scale-105 transition duration-300"
          style="background-image: url('../images/< ?= $card['bg'] ?>'); background-size: cover; background-position: center;">
          <div class="absolute inset-0 bg-black bg-opacity-50"></div>
          <div class="relative p-4 h-full flex flex-col justify-between">
            <h2 class="text-lg sm:text-xl font-semibold">< ?= $card['title'] ?></h2>
            <h1 class="text-2xl sm:text-3xl font-bold">< ?= $card['value'] ?></h1>
          </div>
        </div>
      < ?php endforeach; ?>
    </div> -->