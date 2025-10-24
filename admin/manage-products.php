<?php
include('includes/conn.php');

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please login first"); window.location.href = "https://shrigangaherbal.com/";</script>';
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch products with their variants and category names
$products = [];
$categories = [];
try {
    $stmt = $pdo->query("
        SELECT 
            p.id, 
            p.name, 
            p.image, 
            p.description, 
            p.category_id, 
            c.name AS category_name, 
            p.disease, 
            p.brand_name AS company, 
            p.stock, 
            p.created_at,
            MIN(pv.price) AS price
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN product_variants pv ON p.id = pv.product_id
        GROUP BY p.id
        ORDER BY p.created_at DESC
    ");
    $products = $stmt->fetchAll();

    $stmt = $pdo->query("SELECT id, name FROM categories ORDER BY name");
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo '<p class="text-red-500">Error fetching data: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("../include/links.php") ?>
    <link rel="stylesheet" href="sameStyle.css">
    <style>
        body {
            font-family: sans-serif;
        }

        .modal {
            display: none;
            align-items: center;
            justify-content: center;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 50;
        }

        .modal.active {
            display: flex;
        }

        img.product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .table-wrapper {
            overflow-x: auto;
            max-height: 500px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            border-collapse: collapse;
            width: 100%;
            min-width: 800px;
        }

        thead th {
            position: sticky;
            top: 0;
            background: #1f2937;
            color: white;
            z-index: 20;
            padding: 0.75rem 1rem;
            text-align: left;
        }

        tbody td {
            padding: 0.75rem 1rem;
        }

        tbody tr:hover {
            background: #f3f4f6;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }

        button {
            cursor: pointer;
        }

        .variant-row {
            display: flex;
            gap: 2px;
            /* 10px;flex justify-between items-center w-full  */
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .variant-row input {
            width: 40%;
        }


        .variant-row button {
            width: 10%;
        }

        .table-data td {
        display: flex;
        align-items: center;
}



    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex flex-col md:flex-row w-full">
        <?php
        if (file_exists('sidebar.php')) {
            include('sidebar.php');
        } else {
            echo '<p class="text-red-500">Error: sidebar.php not found</p>';
        }
        ?>
        <div class="flex-1 p-4 md:p-6 w-full lg:w-[75%]">
            <div class="flex justify-between items-center my-2">
                <button id="menuButton" class="md:hidden text-2xl text-black">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h2 class="text-2xl font-bold">Manage Products</h2>
            </div>
            <hr class="border-2 border-black mb-4">
            <?php
            if (file_exists('cards.php')) {
                include('cards.php');
            } else {
                echo '<p class="text-red-500">Error: cards.php not found</p>';
            }
            ?>
            <div class="mt-10">
<div class="flex w-full flex-col items-start gap-4 sm:flex-row sm:items-center">
  <div class="relative flex w-full flex-col items-stretch justify-between rounded-xl transition-all sm:items-center md:p-4">

    <!-- Header Section -->
    <div class="flex w-full flex-col gap-4 sm:relative sm:flex-row sm:items-center">

      <!-- Title & Buttons Section -->
      <div class="flex w-full items-end justify-between gap-3 sm:gap-4">
        <!-- Title -->
        <h3 class="text-xl font-semibold">
          All Products
        </h3>

        <!-- Buttons -->
        <div class="flex w-full gap-2 sm:w-auto sm:flex-row">
          <button
            onclick="openAddProductModal()"
            class="flex w-full items-center justify-center gap-2 rounded-lg bg-green-500 px-4 py-2 text-sm font-medium text-white shadow-sm transition duration-200 hover:bg-green-600 sm:w-auto"
          >
            <i class="fa-solid fa-plus"></i>
            <span>Add Product</span>
          </button>

          <button
            onclick="openAddCategoryModal()"
            class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm transition duration-200 hover:bg-blue-600 sm:w-auto"
          >
            <i class="fa-solid fa-plus"></i>
            <span>Add Category</span>
          </button>
        </div>
      </div>

      <!-- Search Bar -->
      <div class="mt-3 w-full lg:w-[40%] sm:absolute sm:left-1/2 sm:top-0 sm:mt-0 sm:-translate-x-1/2 sm:transform">
        <input
          type="text"
          id="searchInput"
          placeholder="Search by Name, Category, Company, Disease, or Description"
          class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm shadow-sm outline-none transition duration-200 focus:border-green-500 focus:ring-1 focus:ring-green-400 sm:text-base"
        />
      </div>
    </div>

  </div>
</div>

<hr class="border border-black mb-4">

                <div class="table-size overflow-x-auto max-h-[600px] lg:max-h-[60vh] w-full bg-white rounded-lg shadow-lg">
    <table class="w-full lg:min-w-[900px] divide-y divide-gray-200" id="productTable">
        <!-- Table Header -->
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

        <!-- Table Body -->
        <tbody id="tableBody" class="divide-y divide-gray-200">
            <?php foreach ($products as $index => $p): ?>
                <tr class="hover:bg-gray-100 even:bg-gray-50 transition"
                    data-name="<?= htmlspecialchars($p['name'] ?? '') ?>"
                    data-category="<?= htmlspecialchars($p['category_name'] ?? '') ?>"
                    data-company="<?= htmlspecialchars($p['company'] ?? '') ?>"
                    data-disease="<?= htmlspecialchars($p['disease'] ?? '') ?>"
                    data-description="<?= htmlspecialchars($p['description'] ?? '') ?>">

                    <td class="py-3 px-4"><?= $index + 1 ?></td>

                    <td class="py-3 px-4">
                        <img src="<?= htmlspecialchars($p['image'] ?? '') ?>"
                             alt="<?= htmlspecialchars($p['name'] ?? '') ?>"
                             class="w-12 h-12 object-cover rounded-md border border-gray-200">
                    </td>

                    <td class="py-3 px-4"><?= htmlspecialchars($p['name'] ?? '') ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($p['company'] ?? '') ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($p['disease'] ?? '') ?></td>
                    <td class="py-3 px-4">₹<?= number_format($p['price'] ?? 0, 2) ?></td>
                    <td class="py-3 px-4"><?= (int)($p['stock'] ?? 0) ?></td>
                    <td class="py-3 px-4 max-w-[200px] truncate"><?= htmlspecialchars($p['description'] ?? '') ?></td>

                    <td class="py-3 px-4">
                        <div class="px-2 py-1 w-[6rem] text-white rounded-lg text-xs text-center
                            <?= ($p['stock'] ?? 0) == 0 
                                ? 'bg-red-500' 
                                : (($p['stock'] ?? 0) < 50 
                                    ? 'bg-yellow-500' 
                                    : 'bg-green-500') ?>">
                            <?= ($p['stock'] ?? 0) == 0 
                                ? 'Out of Stock' 
                                : (($p['stock'] ?? 0) < 50 
                                    ? 'Low Stock' 
                                    : 'In Stock') ?>
                        </div>
                    </td>

                    <td class="py-3 px-4">
                        <div class="flex justify-center items-center gap-2">
                            <button
                                onclick="openEditProductModal(<?= $p['id'] ?>, '<?= htmlspecialchars($p['name'] ?? '') ?>', '<?= htmlspecialchars($p['image'] ?? '') ?>', '<?= htmlspecialchars($p['description'] ?? '') ?>', <?= $p['category_id'] ?? 0 ?>, '<?= htmlspecialchars($p['disease'] ?? '') ?>', '<?= htmlspecialchars($p['company'] ?? '') ?>')"
                                class="px-3 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 shadow transition">
                                <i class="fa-solid fa-pen"></i> Edit
                            </button>
                            <button
                                onclick="deleteProduct(<?= $p['id'] ?>, '<?= htmlspecialchars($p['name'] ?? '') ?>')"
                                class="px-3 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-600 shadow transition">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal"
        class="modal fixed inset-0 bg-black/50 backdrop-blur-sm flex items-end lg:items-center justify-center hidden z-50">
        <div
            class="bg-white w-full lg:w-[70%] max-w-4xl rounded-t-2xl lg:rounded-2xl p-6 lg:p-10 max-h-[90vh] overflow-y-auto relative">

            <!-- Close Button -->
            <button onclick="closeAddProductModal()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 transition">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>

            <!-- Title -->
            <h2 class="text-xl lg:text-2xl font-bold mb-6 text-gray-800 text-center lg:text-left border-b pb-2">
                Add Product
            </h2>

            <!-- Form -->
            <form id="addProductForm" class="space-y-5 lg:space-y-6" onsubmit="addProduct(event)">
                <!-- Row 1 -->
                <div class="space-y-5 lg:grid lg:grid-cols-2 lg:gap-6 lg:space-y-0">
                    <div>
                        <label for="addName" class="block text-sm font-medium mb-1">Product Name</label>
                        <input id="addName" type="text" name="name" placeholder="Enter product name"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                            required />
                    </div>
                    <div>
                        <label for="addCompany" class="block text-sm font-medium mb-1">Company Name</label>
                        <input id="addCompany" type="text" name="company" placeholder="Enter company name"
                            value="Shri Ganga Herbal"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                            required />
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="space-y-5 lg:grid lg:grid-cols-2 lg:gap-6 lg:space-y-0">
                    <div>
                        <label for="addDiseases" class="block text-sm font-medium mb-1">Diseases</label>
                        <input id="addDiseases" type="text" name="diseases" placeholder="Enter disease name"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                            required />
                    </div>
                    <div>
                        <label for="addImageUrl" class="block text-sm font-medium mb-1">Image URL</label>
                        <input id="addImageUrl" type="text" name="imageUrl" placeholder="/Uploads/img.png OR http://..."
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" />
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="space-y-5 lg:grid lg:grid-cols-2 lg:gap-6 lg:space-y-0">
                    <div>
                        <label for="addPrice" class="block text-sm font-medium mb-1">Price (₹)</label>
                        <input id="addPrice" type="number" step="0.01" name="price" placeholder="e.g. 120.50"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                            required />
                    </div>
                    <div>
                        <label for="addStock" class="block text-sm font-medium mb-1">Stock</label>
                        <input id="addStock" type="number" name="stock" placeholder="e.g. 50"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                            required />
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="space-y-5 lg:grid lg:grid-cols-2 lg:gap-6 lg:space-y-0">
                    <div>
                        <label for="addDescription" class="block text-sm font-medium mb-1">About Product</label>
                        <textarea id="addDescription" name="description" rows="2"
                            placeholder="Short product description..."
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                    <div>
                        <label for="addCategory" class="block text-sm font-medium mb-1">Category</label>
                        <select id="addCategory" name="category"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                            <?php foreach ($categories as $c): ?>
                            <option value="<?= $c['id'] ?>">
                                <?= htmlspecialchars($c['name'] ?? '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Variants -->
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="block text-sm font-medium">Variants (Weight, Price)</label>
                        <button type="button" onclick="addVariantRow('editVariants')"
                            class="bg-blue-600 text-white text-center rounded-lg md:w-[5rem] w-[3rem] hover:bg-blue-700 transition">
                            +
                        </button>
                    </div>
                    <div id="editVariants" class="space-y-2">
                        <div class="variant-row">
                            <input type="text" placeholder="Weight (e.g., 100g)"
                                class="flex-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" />
                            <input type="number" step="0.01" placeholder="Price"
                                class="flex-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" />

                            <button type="button" onclick="removeVariant(this)"
                                class="bg-red-500 md:w-[5rem] w-[3rem] text-white rounded-lg px-3 py-1 hover:bg-red-600 transition w-[10%]">X</button>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4 lg:text-right">
                    <button type="submit"
                        class="w-full lg:w-auto bg-green-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-700 transition">
                        Add Product
                    </button>
                </div>
            </form>

        </div>
    </div>




    <!-- Edit Product Modal -->
    <div id="editProductModal"
        class="modal fixed inset-0 bg-black/50 backdrop-blur-sm flex items-end lg:items-center justify-center hidden z-50">
        <div
            class="bg-white w-full lg:w-[70%] max-w-4xl rounded-t-2xl lg:rounded-2xl p-6 lg:p-10 max-h-[90vh] overflow-y-auto relative">
            <!-- Close Button -->
            <button onclick="closeEditProductModal()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 transition">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>

            <!-- Title -->
            <h2 class="text-xl lg:text-2xl font-bold mb-6 text-gray-800 text-center lg:text-left border-b pb-2">
                Edit Product
            </h2>

            <form id="editProductForm" class="space-y-5 lg:space-y-6" onsubmit="editProduct(event)">
                <input type="hidden" id="editId">

                <!-- Product Name & Company -->
                <div class="space-y-5 lg:grid lg:grid-cols-2 lg:gap-6 lg:space-y-0">
                    <div>
                        <label for="editName" class="block text-sm font-medium mb-1">Product Name</label>
                        <input id="editName" type="text" name="name" placeholder="Enter product name"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>
                    <div>
                        <label for="editCompany" class="block text-sm font-medium mb-1">Company Name</label>
                        <input id="editCompany" type="text" name="company" placeholder="Enter company name"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>
                </div>

                <!-- Diseases & Image URL -->
                <div class="space-y-5 lg:grid lg:grid-cols-2 lg:gap-6 lg:space-y-0">
                    <div>
                        <label for="editDiseases" class="block text-sm font-medium mb-1">Diseases</label>
                        <input id="editDiseases" type="text" name="diseases" placeholder="Enter disease name"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>
                    <div>
                        <label for="editImageUrl" class="block text-sm font-medium mb-1">Image URL</label>
                        <input id="editImageUrl" type="text" name="imageUrl"
                            placeholder="/Uploads/img.png OR http://..."
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <!-- Price & Stock -->
                <div class="space-y-5 lg:grid lg:grid-cols-2 lg:gap-6 lg:space-y-0">
                    <div>
                        <label for="editPrice" class="block text-sm font-medium mb-1">Price (₹)</label>
                        <input id="editPrice" type="number" step="0.01" name="price" placeholder="e.g. 120.50"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>
                    <div>
                        <label for="editStock" class="block text-sm font-medium mb-1">Stock</label>
                        <input id="editStock" type="number" name="stock" placeholder="e.g. 50"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="editDescription" class="block text-sm font-medium mb-1">About Product</label>
                    <textarea id="editDescription" name="description" rows="2"
                        placeholder="Short product description..."
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                </div>

                <!-- Category -->
                <div>
                    <label for="editCategory" class="block text-sm font-medium mb-1">Category</label>
                    <select id="editCategory" name="category"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                        <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['id'] ?>">
                            <?= htmlspecialchars($c['name'] ?? '') ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Variants -->
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="block text-sm font-medium">Variants (Weight, Price)</label>
                        <button type="button" onclick="addVariantRow('editVariants')"
                            class="bg-blue-600 text-white text-center rounded-lg md:w-[5rem] w-[3rem] hover:bg-blue-700 transition">
                            +
                        </button>
                    </div>
                    <div id="editVariants" class="space-y-2">
                        <div class="variant-row flex justify-between items-center w-full ">
                            <input type="text" placeholder="Weight (e.g., 100g)"
                                class="flex-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none w-[40%]" />
                            <input type="number" step="0.01" placeholder="Price"
                                class="flex-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none w-[40%]" />

                            <button type="button" onclick="removeVariant(this)"
                                class="bg-red-500 md:w-[5rem] w-[3rem] text-white rounded-lg px-3 py-1 hover:bg-red-600 transition w-[10%]">X</button>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-2 lg:text-right">
                    <button type="submit"
                        class="w-full lg:w-auto bg-green-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-700 transition">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>





    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="modal">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md relative">
            <button onclick="closeAddCategoryModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Category</h2>
            <form id="addCategoryForm" class="space-y-4" onsubmit="addCategory(event)">
                <div>
                    <label for="addCategoryName" class="block text-sm font-medium text-gray-700 mb-1">Category
                        Name</label>
                    <input id="addCategoryName" type="text" name="name" placeholder="Enter category name"
                        class="w-full border rounded-lg p-3" required>
                </div>
                <button type="submit" class="w-full bg-green-500 text-white rounded-lg py-3">Add Category</button>
            </form>
        </div>
    </div>

    <script src="samescript.js"></script>
    <script>
        // ✅ Open Modal
function openAddProductModal() {
  const modal = document.getElementById("addProductModal");
  modal.classList.add("active");

  // Reset form and default values
  document.getElementById("addProductForm").reset();
  document.getElementById("addCompany").value = "Shri Ganga Herbal";

  // Add default variant row
  document.getElementById("addVariants").innerHTML = `
    <div class="variant-row">
      <input type="text" placeholder="Weight (e.g., 100g)" class="border rounded px-3 py-2" required>
      <input type="number" step="0.01" placeholder="Price" class="border rounded px-3 py-2" required>
      <button type="button" onclick="removeVariant(this)" class="bg-red-500 text-white px-2 py-1 rounded">X</button>
    </div>
  `;
}

// ✅ Close Modal
function closeAddProductModal() {
  const modal = document.getElementById("addProductModal");
  modal.classList.remove("active");
}

window.addEventListener("click", function (e) {
  const modal = document.getElementById("addProductModal");
  if (e.target === modal) {
    closeAddProductModal();
  }
});


        function openAddCategoryModal() {
            const modal = document.getElementById("addCategoryModal");
            document.getElementById("addCategoryForm").reset();
            modal.classList.add("active");
            window.addEventListener("click", function handler(e) {
                if (e.target === modal) {
                    closeAddCategoryModal();
                    window.removeEventListener("click", handler);
                }
            });
        }

        function closeAddCategoryModal() {
            document.getElementById("addCategoryModal").classList.remove("active");
        }

        function openEditProductModal(id, name, image, description, category_id, disease, company) {
            const modal = document.getElementById("editProductModal");
            document.getElementById("editId").value = id;
            document.getElementById("editName").value = name;
            document.getElementById("editImageUrl").value = image;
            document.getElementById("editDescription").value = description;
            document.getElementById("editCategory").value = category_id;
            document.getElementById("editDiseases").value = disease;
            document.getElementById("editCompany").value = company;
            fetchVariants(id);
            modal.classList.add("active");
            window.addEventListener("click", function handler(e) {
                if (e.target === modal) {
                    closeEditProductModal();
                    window.removeEventListener("click", handler);
                }
            });
        }

        function closeEditProductModal() {
            document.getElementById("editProductModal").classList.remove("active");
        }

        function addVariantRow(containerId) {
            const container = document.getElementById(containerId);
            const row = document.createElement("div");
            row.className = "variant-row";
            row.innerHTML = `
                <input type="text" placeholder="Weight (e.g., 100g)" class="border rounded px-3 py-2">
                <input type="number" step="0.01" placeholder="Price" class="border rounded px-3 py-2">
                <button type="button" onclick="removeVariant(this)" class="bg-red-500 text-white px-2 py-1 rounded">X</button>
            `;
            container.appendChild(row);
        }

        function removeVariant(button) {
            if (document.querySelectorAll(".variant-row").length > 1) {
                button.parentElement.remove();
            } else {
                alert("At least one variant is required.");
            }
        }

        function fetchVariants(productId) {
            fetch('get_variants.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `product_id=${productId}`
            })
                .then(response => response.json())
                .then(data => {
                    const variantsContainer = document.getElementById("editVariants");
                    variantsContainer.innerHTML = '';
                    if (data.variants && data.variants.length > 0) {
                        data.variants.forEach(v => {
                            const row = document.createElement("div");
                            row.className = "variant-row";
                            row.innerHTML = `
                            <input type="text" value="${v.weight}" class="border rounded px-3 py-2">
                            <input type="number" step="0.01" value="${v.price}" class="border rounded px-3 py-2">
                            <button type="button" onclick="removeVariant(this)" class="bg-red-500 text-white px-2 py-1 rounded">X</button>
                        `;
                            variantsContainer.appendChild(row);
                        });
                        document.getElementById("editPrice").value = data.variants[0].price;
                    } else {
                        addVariantRow('editVariants');
                        document.getElementById("editPrice").value = '';
                    }
                })
                .catch(error => {
                    alert('Error fetching variants: ' + error);
                });
        }

        function addProduct(e) {
            e.preventDefault();
            const form = document.getElementById("addProductForm");
            const variants = Array.from(document.querySelectorAll("#addVariants .variant-row")).map(row => ({
                weight: row.querySelector("input[type='text']").value,
                price: row.querySelector("input[type='number']").value
            }));
            const data = {
                name: document.getElementById("addName").value,
                image: document.getElementById("addImageUrl").value,
                description: document.getElementById("addDescription").value,
                category_id: document.getElementById("addCategory").value,
                disease: document.getElementById("addDiseases").value,
                company: document.getElementById("addCompany").value,
                stock: document.getElementById("addStock").value,
                price: document.getElementById("addPrice").value,
                variants
            };
            fetch('save_product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product added successfully!');
                        location.reload();
                    } else {
                        alert('Error adding product: ' + data.error);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error);
                });
        }

        function editProduct(e) {
            e.preventDefault();
            const form = document.getElementById("editProductForm");
            const variants = Array.from(document.querySelectorAll("#editVariants .variant-row")).map(row => ({
                weight: row.querySelector("input[type='text']").value,
                price: row.querySelector("input[type='number']").value
            }));
            const data = {
                id: document.getElementById("editId").value,
                name: document.getElementById("editName").value,
                image: document.getElementById("editImageUrl").value,
                description: document.getElementById("editDescription").value,
                category_id: document.getElementById("editCategory").value,
                disease: document.getElementById("editDiseases").value,
                company: document.getElementById("editCompany").value,
                stock: document.getElementById("editStock").value,
                price: document.getElementById("editPrice").value,
                variants
            };
            fetch('save_product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product updated successfully!');
                        location.reload();
                    } else {
                        alert('Error updating product: ' + data.error);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error);
                });
        }

        function deleteProduct(id, name) {
            if (confirm(`Are you sure you want to delete ${name}? This will also delete its variants.`)) {
                fetch('delete_product.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${id}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product deleted successfully!');
                            location.reload();
                        } else {
                            alert('Error deleting product: ' + data.error);
                        }
                    })
                    .catch(error => {
                        alert('Error: ' + error);
                    });
            }
        }

        function addCategory(e) {
            e.preventDefault();
            const form = document.getElementById("addCategoryForm");
            const name = document.getElementById("addCategoryName").value;
            if (!name.trim()) {
                alert('Category name is required.');
                return;
            }
            fetch('save_category.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `name=${encodeURIComponent(name)}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Category added successfully!');
                        location.reload();
                    } else {
                        alert('Error adding category: ' + data.error);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error);
                });
        }

        document.getElementById("searchInput").addEventListener("input", function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll("tbody tr").forEach(row => {
                const name = row.dataset.name.toLowerCase();
                const category = row.dataset.category.toLowerCase();
                const company = row.dataset.company.toLowerCase();
                const disease = row.dataset.disease.toLowerCase();
                const description = row.dataset.description.toLowerCase();
                row.style.display = (name.includes(query) || category.includes(query) || company.includes(query) || disease.includes(query) || description.includes(query)) ? "" : "none";
            });
        });
    </script>
</body>

</html>