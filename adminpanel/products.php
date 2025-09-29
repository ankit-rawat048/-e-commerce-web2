<?php
// Default Products (only load if localStorage is empty)
$products = [
  ["name"=>"Coffee Beans", "category"=>"Beverages", "price"=>25.00, "stock"=>120],
  ["name"=>"Green Tea", "category"=>"Beverages", "price"=>15.50, "stock"=>80],
  ["name"=>"Olive Oil", "category"=>"Grocery", "price"=>45.00, "stock"=>30],
  ["name"=>"Pasta", "category"=>"Grocery", "price"=>12.00, "stock"=>0],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ayurveda</title>
  <?php include("../include/links.php") ?>

  <style>
    .modal { display: none; }
    .modal.active { display: flex; z-index: 50; }
    /* Smooth sidebar transition */
    #sidebar { transition: transform 0.3s ease; }
    #sidebar.-translate-x-full { transform: translateX(-100%); }
  </style>
</head>
<body class="bg-gray-100">

<div class="flex">
  <!-- Sidebar -->
  <?php include('sidebar.php'); ?>

  <!-- Main Content -->
  <div class="flex-1 p-6">
    <div class="flex justify-between items-center mb-4">
      <button id="menuButton" class="md:hidden text-2xl text-black">
        <i class="fa-solid fa-bars"></i>
      </button>
      <h2 class="text-2xl font-bold">Manage Products</h2>
    </div>

    <hr class="border-2 border-black mb-4">

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php
      $cards = [
        ["title"=>"Total Products", "value"=>count($products), "bg"=>"card1.jpg"],
        ["title"=>"Out Of Stock", "value"=>count(array_filter($products, fn($p)=>$p['stock']==0)), "bg"=>"card2.jpg"],
        ["title"=>"Best-Selling", "value"=>"Coffee Beans", "bg"=>"card3.jpg"],
        ["title"=>"Upcoming", "value"=>"Patti Oil", "bg"=>"card4.jpg"]
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
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-xl font-semibold">All Products</h3>
        <button onclick="openAddModal()" class="bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow flex items-center gap-2 px-4 py-2 transition">
          <i class="fa-solid fa-plus-circle text-lg"></i> Add Product
        </button>
      </div>

      <div class="overflow-x-auto border rounded-lg shadow">
        <div class="max-h-[400px] overflow-y-auto">
          <table class="min-w-full bg-white" id="productTable">
            <thead class="bg-gray-800 text-white sticky top-0 z-10">
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
            <tbody id="tableBody" class="divide-y divide-gray-200"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] relative">
    <button onclick="closeAddModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black">
      <i class="fa-solid fa-xmark text-xl"></i>
    </button>
    <h2 class="text-xl font-bold mb-4">Add Product</h2>
    <form id="addProductForm" class="space-y-3">
      <input type="text" name="name" placeholder="Product Name" class="w-full border p-2 rounded" required>
      <input type="text" name="category" placeholder="Category" class="w-full border p-2 rounded" required>
      <input type="number" name="price" placeholder="Price" step="0.01" class="w-full border p-2 rounded" required>
      <input type="number" name="stock" placeholder="Stock" class="w-full border p-2 rounded" required>
      <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add</button>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] relative">
    <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black">
      <i class="fa-solid fa-xmark text-xl"></i>
    </button>
    <h2 class="text-xl font-bold mb-4">Edit Product</h2>
    <form id="editProductForm" class="space-y-3">
      <input type="hidden" name="index">
      <input type="text" name="name" class="w-full border p-2 rounded" required>
      <input type="text" name="category" class="w-full border p-2 rounded" required>
      <input type="number" name="price" step="0.01" class="w-full border p-2 rounded" required>
      <input type="number" name="stock" class="w-full border p-2 rounded" required>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
  </div>
</div>

<script>
  // Sidebar toggle
  const sidebar = document.getElementById('sidebar');
  const menuButton = document.getElementById('menuButton');
  const cancelBtn = document.querySelector(".cancelBtn");

cancelBtn.addEventListener("click", ()=> sidebar.classList.add("-translate-x-full"));
  if(menuButton) menuButton.addEventListener("click", () => sidebar.classList.toggle("-translate-x-full"));

  // Products storage
  let defaultProducts = <?php echo json_encode($products); ?>;
  let products = JSON.parse(localStorage.getItem("products")) || defaultProducts;

  function saveProducts() {
    localStorage.setItem("products", JSON.stringify(products));
  }

  // Render table
  function renderTable() {
    const tbody = document.getElementById("tableBody");
    tbody.innerHTML = "";
    products.forEach((p, index) => {
      let status = "";
      if(p.stock == 0) status = `<span class="px-2 py-1 bg-red-500 text-white rounded-full text-xs">Out of Stock</span>`;
      else if(p.stock < 50) status = `<span class="px-2 py-1 bg-yellow-500 text-white rounded-full text-xs">Low Stock</span>`;
      else status = `<span class="px-2 py-1 bg-green-500 text-white rounded-full text-xs">In Stock</span>`;
      tbody.innerHTML += `
        <tr class="hover:bg-gray-100">
          <td class="py-2 px-4">${index+1}</td>
          <td class="py-2 px-4">${p.name}</td>
          <td class="py-2 px-4">${p.category}</td>
          <td class="py-2 px-4">$${parseFloat(p.price).toFixed(2)}</td>
          <td class="py-2 px-4">${p.stock}</td>
          <td class="py-2 px-4">${status}</td>
          <td class="py-2 px-4 flex gap-2">
            <button onclick="openEditModal(${index})" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"><i class="fa-solid fa-pen"></i></button>
            <button onclick="deleteProduct(${index})" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"><i class="fa-solid fa-trash"></i></button>
          </td>
        </tr>`;
    });
  }
  renderTable();

  // Add Product
  function openAddModal() { document.getElementById("addModal").classList.add("active"); }
  function closeAddModal() { document.getElementById("addModal").classList.remove("active"); }

  document.getElementById("addProductForm").addEventListener("submit", e => {
    e.preventDefault();
    const form = e.target;
    products.push({
      name: form.name.value,
      category: form.category.value,
      price: parseFloat(form.price.value),
      stock: parseInt(form.stock.value)
    });
    saveProducts();
    form.reset();
    closeAddModal();
    renderTable();
  });

  // Edit Product
  let editIndex = null;
  function openEditModal(index) {
    editIndex = index;
    const p = products[index];
    const form = document.getElementById("editProductForm");
    form.index.value = index;
    form.name.value = p.name;
    form.category.value = p.category;
    form.price.value = p.price;
    form.stock.value = p.stock;
    document.getElementById("editModal").classList.add("active");
  }
  function closeEditModal() { document.getElementById("editModal").classList.remove("active"); }

  document.getElementById("editProductForm").addEventListener("submit", e => {
    e.preventDefault();
    const form = e.target;
    products[editIndex] = {
      name: form.name.value,
      category: form.category.value,
      price: parseFloat(form.price.value),
      stock: parseInt(form.stock.value)
    };
    saveProducts();
    closeEditModal();
    renderTable();
  });

  // Delete Product
  function deleteProduct(index) {
    if(confirm("Are you sure you want to delete this product?")) {
      products.splice(index, 1);
      saveProducts();
      renderTable();
    }
  }
</script>

</body>
</html>
