<?php
include('includes/conn.php');

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please login first"); window.location.href = "https://shrigangaherbal.com/";</script>';
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle form submission
$success = "";
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $productName = $_POST['product_name'];
        $companyName = $_POST['company_name'];
        $imageUrl = $_POST['image_url'] ?? '';
        $metaTitle = $_POST['meta_title'];
        $metaDescription = $_POST['meta_description'];
        $keywords = $_POST['keywords'];

        // Update products table
        $stmt = $pdo->prepare("
            UPDATE products 
            SET brand_name = ?, image = ?, meta_title = ?, meta_description = ?, meta_keywords = ?
            WHERE name = ?
        ");
        $stmt->execute([$companyName, $imageUrl, $metaTitle, $metaDescription, $keywords, $productName]);

        if ($stmt->rowCount() > 0) {
            $success = "SEO settings updated for product: " . htmlspecialchars($productName);
        } else {
            $error = "No product found with name: " . htmlspecialchars($productName);
        }
    } catch (PDOException $e) {
        $error = "Error updating SEO settings: " . htmlspecialchars($e->getMessage());
    }
}

// Fetch products from database
try {
    $stmt = $pdo->query("
        SELECT id, name, image, description, brand_name, meta_title, meta_description, meta_keywords
        FROM products 
        ORDER BY created_at DESC
    ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching products: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Product SEO</title>
    <?php include("../include/links.php"); ?>
    <link rel="stylesheet" href="sameStyle.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .modal {
            position: fixed;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            z-index: 50;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .modal.show {
            opacity: 1;
            pointer-events: auto;
        }
        .modal-content {
            background: #fff;
            width: 100%;
            max-width: 600px;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .overflow-x-auto {
            overflow-x: auto;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row w-full">
        <?php include("sidebar.php"); ?>
        <div class="flex-1 p-4 md:p-6 w-full lg:w-[75%]">
            <div class="flex justify-between items-center my-2">
                <button id="menuButton" class="md:hidden text-2xl text-black">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h2 class="text-2xl font-bold">Manage Product SEO</h2>
            </div>
            <hr class="border-2 border-black mb-4">
            <?php include 'cards.php'; ?>
            <?php if ($success): ?>
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                <?= htmlspecialchars($success) ?>
            </div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            <!-- SEO Modal -->
            <div id="formModal" class="modal">
                <div class="modal-content">
                    <button id="closeFormBtn"
                        class="absolute top-2 right-2 text-gray-500 hover:text-black text-2xl">&times;</button>
                    <h3 class="text-xl font-semibold mb-4">Manage Product SEO</h3>
                    <form method="POST" class="space-y-4" id="seoForm">
                        <div>
                            <label class="block text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="product_name" id="seoProductName" placeholder="Enter product name"
                                class="w-full border rounded p-2" required readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Company Name</label>
                            <input type="text" name="company_name" id="seoCompanyName" placeholder="Enter company name"
                                class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Product Image URL</label>
                            <input type="url" name="image_url" id="seoImageUrl" placeholder="Enter product image URL"
                                class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Meta Title</label>
                            <input type="text" name="meta_title" id="seoMetaTitle" placeholder="SEO meta title"
                                class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Meta Description</label>
                            <textarea name="meta_description" id="seoMetaDescription" rows="3"
                                placeholder="SEO meta description" class="w-full border rounded p-2"
                                required></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Keywords (comma-separated)</label>
                            <input type="text" name="keywords" id="seoKeywords"
                                placeholder="e.g., ayurveda, herbal medicine"
                                class="w-full border rounded p-2">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save
                            SEO</button>
                    </form>
                </div>
            </div>
            <!-- Products Table -->
            <div class="w-full mx-auto bg-white shadow-lg rounded-lg md:p-6 p-0 mt-6">
                <h3 class="text-xl font-semibold pl-2 pt-2 mb-4">Products List</h3>
                <div class="table-size overflow-y-auto overflow-x-auto max-h-[500px] lg:max-h-[60vh] bg-white rounded-lg shadow-lg">
                    <table class="w-full lg:min-w-[900px] divide-y divide-gray-200">
                        <thead class="bg-gray-800 text-white sticky top-0 z-10">
                            <tr>
                                <th class="py-2 px-4">#</th>
                                <th class="py-2 px-4">Image</th>
                                <th class="py-2 px-4">Product</th>
                                <th class="py-2 px-4">Company</th>
                                <th class="py-2 px-4">Meta Description</th>
                                <th class="py-2 px-4">SEO</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody" class="divide-y divide-gray-200">
                            <?php foreach ($products as $index => $p): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4"><?= $index + 1 ?></td>
                                <td class="py-2 px-4">
                                    <?php if ($p['image']): ?>
                                        <img src="<?= htmlspecialchars($p['image'] ?? '') ?>" class="product-img" alt="<?= htmlspecialchars($p['name'] ?? '') ?>">
                                    <?php endif; ?>
                                </td>
                                <td class="py-2 px-4"><?= htmlspecialchars($p['name'] ?? '') ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($p['brand_name'] ?? '') ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($p['meta_description'] ?? '') ?></td>
                                <td class="py-2 px-4 w-[10rem]">
                                    <button onclick="openSeoModal('<?= htmlspecialchars(json_encode($p), ENT_QUOTES) ?>')" 
                                        class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-2 h-full w-full rounded text-sm">MANAGE SEO</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="6" class="py-6 px-4 text-center text-gray-500">No products found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="samescript.js"></script>
    <script>
        const modal = document.getElementById('formModal');
        const closeBtn = document.getElementById('closeFormBtn');
        closeBtn.addEventListener('click', () => modal.classList.remove('show'));
        window.addEventListener('click', e => { if (e.target === modal) modal.classList.remove('show'); });

        function openSeoModal(productJson) {
            const product = JSON.parse(productJson);
            document.getElementById('seoProductName').value = product.name || '';
            document.getElementById('seoCompanyName').value = product.brand_name || '';
            document.getElementById('seoImageUrl').value = product.image || '';
            document.getElementById('seoMetaTitle').value = product.meta_title || '';
            document.getElementById('seoMetaDescription').value = product.meta_description || '';
            document.getElementById('seoKeywords').value = product.meta_keywords || '';
            modal.classList.add('show');
        }
    </script>
</body>
</html>