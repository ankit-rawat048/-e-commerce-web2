<?php
// Default Products (only load if localStorage is empty)
$products = [
  ["name"=>"Ashwagandha", "company"=>"Himalaya", "diseases"=>"Stress, Anxiety", "price"=>250.00, "stock"=>120, "description"=>"Natural stress reliever", "imageUrl"=>"/uploads/ashwagandha.png"],
  ["name"=>"Triphala", "company"=>"Patanjali", "diseases"=>"Digestion, Constipation", "price"=>150.50, "stock"=>80, "description"=>"Improves digestion", "imageUrl"=>"/uploads/triphala.png"],
  ["name"=>"Neem Oil", "company"=>"Dabur", "diseases"=>"Skin problems", "price"=>300.00, "stock"=>30, "description"=>"For acne and skin care", "imageUrl"=>"/uploads/neem.png"],
  ["name"=>"Giloy", "company"=>"Baidyanath", "diseases"=>"Immunity booster", "price"=>180.00, "stock"=>0, "description"=>"Boosts immunity naturally", "imageUrl"=>"/uploads/giloy.png"]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include("../include/links.php") ?>
  <style>
    body { font-family: sans-serif; }

    /* Modal */
    .modal { display: none; align-items: center; justify-content: center; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; }
    .modal.active { display: flex; }

    /* Product image */
    img.product-img { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }

    /* Table Wrapper */
    .table-wrapper { overflow-x: auto; max-height: 500px; background: white; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }

    table { border-collapse: collapse; width: 100%; min-width: 800px; }
    thead th { position: sticky; top: 0; background: #1f2937; color: white; z-index: 20; padding: 0.75rem 1rem; text-align: left; }
    tbody td { padding: 0.75rem 1rem; }
    tbody tr:hover { background: #f3f4f6; }
    tbody tr:nth-child(even) { background: #f9fafb; }

    .truncate { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px; }

    /* Buttons */
    button { cursor: pointer; }
  </style>
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="flex flex-col md:flex-row">
    <?php include('sidebar.php'); ?>

    <div class="flex-1 p-4 md:p-6">
      <div class="flex justify-between items-center my-2">
        <button id="menuButton" class="md:hidden text-2xl text-black">
          <i class="fa-solid fa-bars"></i>
        </button>
        <h2 class="text-2xl font-bold">Manage Products</h2>
      </div>

      <hr class="border-2 border-black mb-4">
      
      <?php include 'cards.php'; ?>

      <!-- Products Table -->
      <div class="mt-10">
        <div class="flex flex-col sm:flex-row w-full items-start sm:items-center mb-4 gap-4">
          <h3 class="text-2xl font-bold text-gray-800 whitespace-nowrap">All Products</h3>

          <div class="flex flex-col sm:flex-row w-full justify-between items-stretch sm:items-center bg-gray-100 p-2 rounded-lg shadow-sm gap-2">
            <button onclick="openAddModal()"
              class="bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow flex items-center justify-center gap-2 px-4 py-2 transition duration-200">
              <i class="fa-solid fa-plus-circle text-lg"></i>
              Add Product
            </button>

            <input type="text" id="searchInput" placeholder="Search by ID or Name"
              class="border border-gray-400 focus:border-green-500 focus:ring-1 focus:ring-green-400 rounded-lg px-3 py-2 text-sm w-full sm:w-60 outline-none transition" />
          </div>
        </div>

        <div class="overflow-y-auto max-h-[500px] overflow-x-auto max-w-[500px] lg:max-w-full border rounded-lg shadow">
          <div class="max-h-[400px] overflow-y-auto">
            <table class="min-w-full bg-white" id="productTable">
              <thead class="bg-gray-800 text-white sticky top-0 z-10">
                <tr>
                  <th class="py-3 px-4 text-left">#</th>
                  <th class="py-3 px-4 text-left">Image</th>
                  <th class="py-3 px-4 text-left">Product</th>
                  <th class="py-3 px-4 text-left">Company</th>
                  <th class="py-3 px-4 text-left">Diseases</th>
                  <th class="py-3 px-4 text-left">Price</th>
                  <th class="py-3 px-4 text-left">Stock</th>
                  <th class="py-3 px-4 text-left">Description</th>
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
  <div id="addModal" class="modal">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md relative">
      <button onclick="closeAddModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
        <i class="fa-solid fa-xmark text-xl"></i>
      </button>
      <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Product</h2>
      <form id="addProductForm" class="space-y-4">
        <input type="text" name="name" placeholder="Product Name" class="w-full border rounded-lg p-3" required>
        <input type="text" name="company" placeholder="Company Name" class="w-full border rounded-lg p-3" required>
        <input type="text" name="diseases" placeholder="Diseases" class="w-full border rounded-lg p-3" required>
        <div class="grid grid-cols-2 gap-4">
          <input type="number" step="0.01" name="price" placeholder="Price" class="w-full border rounded-lg p-3" required>
          <input type="number" name="stock" placeholder="Stock" class="w-full border rounded-lg p-3" required>
        </div>
        <textarea name="description" rows="3" placeholder="About Product" class="w-full border rounded-lg p-3"></textarea>
        <input type="text" name="imageUrl" placeholder="/uploads/img.png OR http://..." class="w-full border rounded-lg p-3">
        <button type="submit" class="w-full bg-green-500 text-white rounded-lg py-3">Add Product</button>
      </form>
    </div>
  </div>

  <!-- Edit Modal -->
  <div id="editModal" class="modal">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md relative">
      <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
        <i class="fa-solid fa-xmark text-xl"></i>
      </button>
      <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Product</h2>
      <form id="editProductForm" class="space-y-4">
        <input type="hidden" name="index">
        <input type="text" name="name" class="w-full border rounded-lg p-3" required>
        <input type="text" name="company" class="w-full border rounded-lg p-3" required>
        <input type="text" name="diseases" class="w-full border rounded-lg p-3" required>
        <div class="grid grid-cols-2 gap-4">
          <input type="number" step="0.01" name="price" class="w-full border rounded-lg p-3" required>
          <input type="number" name="stock" class="w-full border rounded-lg p-3" required>
        </div>
        <textarea name="description" rows="3" class="w-full border rounded-lg p-3"></textarea>
        <input type="text" name="imageUrl" class="w-full border rounded-lg p-3" placeholder="/uploads/img.png OR http://...">
        <button type="submit" class="w-full bg-blue-500 text-white rounded-lg py-3">Update Product</button>
      </form>
    </div>
  </div>

  <script src="samescript.js"></script>
  <script>
    let defaultProducts = <?php echo json_encode($products, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    let products = JSON.parse(localStorage.getItem("products")) || defaultProducts;
    let editIndex = null;

    function saveProducts() { localStorage.setItem("products", JSON.stringify(products)); }

    function renderTable(filter = "") {
      const tbody = document.getElementById("tableBody");
      tbody.innerHTML = "";
      filter = filter.toLowerCase();
      products.forEach((p, index) => {
        const idStr = (index + 1).toString();
        if (filter && !idStr.includes(filter) && !p.name.toLowerCase().includes(filter)) return;

        let status = p.stock == 0
          ? `<div class="px-2 py-1 w-[5rem] bg-red-500 text-white rounded-lg text-xs text-center">Out of Stock</div>`
          : p.stock < 50
            ? `<div class="px-2 py-1 w-[5rem] bg-yellow-500 text-white rounded-lg text-xs text-center">Low Stock</div>`
            : `<div class="px-2 py-1 w-[5rem] bg-green-500 text-white rounded-lg text-xs text-center">In Stock</div>`;

        tbody.innerHTML += `
          <tr class="hover:bg-gray-100 even:bg-gray-50 transition">
            <td class="sm:table-cell">${index + 1}</td>
            <td>${p.imageUrl ? `<img src="${p.imageUrl}" class="product-img" alt="${p.name}">` : ""}</td>
            <td>${p.name}</td>
            <td>${p.company}</td>
            <td>${p.diseases}</td>
            <td>₹${parseFloat(p.price).toFixed(2)}</td>
            <td>${p.stock}</td>
            <td class="truncate md:hidden sm:hidden">${p.description}</td>
            <td>${status}</td>
            <td class="flex gap-2 md:hidden sm:hidden">
  <button onclick="openEditModal(${index})" class="px-2 py-1 bg-blue-500 text-white rounded">
    <i class="fa-solid fa-pen"></i>
  </button>
  <button onclick="deleteProduct(${index})" class="px-2 py-1 bg-red-500 text-white rounded">
    <i class="fa-solid fa-trash"></i>
  </button>
</td>

          </tr>`;
      });
    }

    renderTable();

    document.getElementById("addProductForm").addEventListener("submit", e => {
      e.preventDefault();
      const f = e.target;
      products.push({
        name: f.name.value,
        company: f.company.value,
        diseases: f.diseases.value,
        price: parseFloat(f.price.value) || 0,
        stock: parseInt(f.stock.value) || 0,
        description: f.description.value,
        imageUrl: f.imageUrl.value
      });
      saveProducts(); f.reset(); closeAddModal(); renderTable();
    });

    function openEditModal(i) {
      editIndex = i;
      const p = products[i];
      const f = document.getElementById("editProductForm");
      f.index.value = i; f.name.value = p.name; f.company.value = p.company;
      f.diseases.value = p.diseases; f.price.value = p.price; f.stock.value = p.stock;
      f.description.value = p.description; f.imageUrl.value = p.imageUrl;
      document.getElementById("editModal").classList.add("active");
    }

    document.getElementById("editProductForm").addEventListener("submit", e => {
      e.preventDefault();
      const f = e.target;
      products[editIndex] = {
        name: f.name.value, company: f.company.value, diseases: f.diseases.value,
        price: parseFloat(f.price.value) || 0, stock: parseInt(f.stock.value) || 0,
        description: f.description.value, imageUrl: f.imageUrl.value
      };
      saveProducts(); closeEditModal(); renderTable();
    });

    function deleteProduct(i) { 
      if(confirm("Delete this product?")) { products.splice(i,1); saveProducts(); renderTable(); } 
    }

    function openAddModal() { document.getElementById("addModal").classList.add("active"); }
    function closeAddModal() { document.getElementById("addModal").classList.remove("active"); }
    function closeEditModal() { document.getElementById("editModal").classList.remove("active"); }

    document.getElementById("searchInput").addEventListener("input", function() { renderTable(this.value.toLowerCase()); });
  </script>
</body>
</html>
