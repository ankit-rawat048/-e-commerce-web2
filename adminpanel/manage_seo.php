<?php
// Path to SEO settings file
$seoFile = "seo_product_seo.json";

// Load existing SEO settings
$seoData = file_exists($seoFile) ? json_decode(file_get_contents($seoFile), true) : [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $companyName = $_POST['company_name'];
    $imageUrl = $_POST['image_url'] ?? '';

    $seoData[$productName] = [
        'product_name' => $productName,
        'company_name' => $companyName,
        'image' => $imageUrl,
        'meta_title' => $_POST['meta_title'],
        'meta_description' => $_POST['meta_description'],
        'keywords' => $_POST['keywords']
    ];

    file_put_contents($seoFile, json_encode($seoData, JSON_PRETTY_PRINT));
    $success = "SEO settings updated for product: $productName";
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

        /* Modal */
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

        /* Table */
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
    <div class="flex flex-col md:flex-row">
        <?php include("sidebar.php"); ?>
        <div class="flex-1 p-4 md:p-6">
            <div class="flex justify-between items-center my-2">
                <button id="menuButton" class="md:hidden text-2xl text-black">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h2 class="text-2xl font-bold">Manage Product SEO</h2>
            </div>

            <hr class="border-2 border-black mb-4">

            <?php include 'cards.php'; ?>


            <?php if (isset($success)): ?>
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                <?= $success ?>
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
                                value="<?= htmlspecialchars($_POST['product_name'] ?? '') ?>"
                                class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Company Name</label>
                            <input type="text" name="company_name" id="seoCompanyName" placeholder="Enter company name"
                                value="<?= htmlspecialchars($_POST['company_name'] ?? '') ?>"
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
                                value="<?= htmlspecialchars($_POST['meta_title'] ?? '') ?>"
                                class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Meta Description</label>
                            <textarea name="meta_description" id="seoMetaDescription" rows="3"
                                placeholder="SEO meta description" class="w-full border rounded p-2"
                                required><?= htmlspecialchars($_POST['meta_description'] ?? '') ?></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Keywords (comma-separated)</label>
                            <input type="text" name="keywords" id="seoKeywords"
                                placeholder="e.g., ayurveda, herbal medicine"
                                value="<?= htmlspecialchars($_POST['keywords'] ?? '') ?>"
                                class="w-full border rounded p-2">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save
                            SEO</button>
                    </form>
                </div>
            </div>

            <!-- Products Table -->
            <div class="w-full mx-auto bg-white shadow-lg rounded-lg p-6 mt-6">
                <h3 class="text-xl font-semibold mb-4">Products List</h3>
                <div class="table-size overflow-y-auto overflow-x-auto max-h-[500px] bg-white rounded-lg shadow-lg">
                    <table class="w-full md:min-w-[700px] lg:min-w-[900px] divide-y divide-gray-200">
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
                        <tbody id="productTableBody" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="samescript.js"></script>
    <script>
        let defaultProducts = [
            { "name": "Coffee Beans", "company": "Beans Factory", "description": "This product is for everyOne.", "imageUrl": "http://localhost/shriganga/adminpanel/uploads/1759221088_Screenshot 2025-09-29 132051.png" },
            { "name": "Apple Tea", "company": "Tea-Unit", "description": "Apple flavored tea", "imageUrl": "" },
            { "name": "New Beans", "company": "BeansForYou", "description": "Special kidney care beans", "imageUrl": "" },
            { "name": "Herbal Tea", "company": "Medic Pharma", "description": "Natural herbal tea", "imageUrl": "" },
            { "name": "Green Tea", "company": "TATA", "description": "Boosts immunity", "imageUrl": "" }
        ];
        let products = JSON.parse(localStorage.getItem('products')) || defaultProducts;

        function renderProductTable() {
            const tbody = document.getElementById('productTableBody');
            tbody.innerHTML = '';
            products.forEach((p, i) => {
                let imgSrc = p.image || p.imageUrl || '';
                tbody.innerHTML += `<tr class="hover:bg-gray-100">
                    <td class="py-2 px-4">${i + 1}</td>
                    <td class="py-2 px-4">${imgSrc ? `<img src="${imgSrc}" class="product-img" alt="${p.name}">` : ''}</td>
                    <td class="py-2 px-4">${p.name}</td>
                    <td class="py-2 px-4">${p.company}</td>
                    <td class="py-2 px-4">${p.description}</td>
                    <td class="py-2 px-4 w-[10rem]"><button onclick="openSeoModal('${p.name}','${p.company}')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-2 h-full w-full rounded text-sm">MANAGE SEO</button></td>
                </tr>`;
            });
        }
        renderProductTable();

        const modal = document.getElementById('formModal');
        const closeBtn = document.getElementById('closeFormBtn');
        closeBtn.addEventListener('click', () => modal.classList.remove('show'));
        window.addEventListener('click', e => { if (e.target === modal) modal.classList.remove('show'); });

        function openSeoModal(productName, companyName) {
            document.getElementById('seoProductName').value = productName;
            document.getElementById('seoCompanyName').value = companyName;

            let seoData = <?= json_encode($seoData) ?>;
            let product = products.find(p => p.name === productName);

            let imageUrl = (seoData[productName]?.image) || (product?.imageUrl) || '';

            document.getElementById('seoMetaTitle').value = seoData[productName]?.meta_title || '';
            document.getElementById('seoMetaDescription').value = seoData[productName]?.meta_description || '';
            document.getElementById('seoKeywords').value = seoData[productName]?.keywords || '';
            document.getElementById('seoImageUrl').value = imageUrl;

            modal.classList.add('show');
        }
    </script>
</body>

</html>