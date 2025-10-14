<?php
require_once 'include/conn.php';

// Fetch all categories and their products with lowest price
$stmt = $pdo->query("SELECT c.id, c.name AS category_name
                     FROM categories c
                     ORDER BY c.name");
$categories = $stmt->fetchAll();

$category_products = [];
foreach ($categories as $category) {
    $stmt = $pdo->prepare("SELECT p.id, p.name, p.image, p.brand_name, MIN(v.price) AS min_price
                           FROM products p
                           LEFT JOIN product_variants v ON p.id = v.product_id
                           WHERE p.category_id = ?
                           GROUP BY p.id, p.name, p.image, p.brand_name
                           LIMIT 6");
    $stmt->execute([$category['id']]);
    $category_products[$category['id']] = [
        'name' => $category['category_name'],
        'products' => $stmt->fetchAll()
    ];
}
?>

<div id="categories-wrapper" class="container mx-auto px-4">
    <?php foreach ($category_products as $cat): ?>
    <div class="my-16">
        <div class="flex items-center space-x-3 mb-6">
            <h1 class="mx-6 border-b-4 border-green-500 text-center text-3xl font-extrabold text-gray-800">
                <?php echo htmlspecialchars($cat['name']); ?>
            </h1>
        </div>

        <div class="gallery-wrapper relative w-full overflow-hidden max-w-9xl mx-auto">
            <!-- Left Button -->
            <button onclick="scrollGallery(this, -1)"
                class="absolute left-2 top-1/2 text-white px-4 py-3 rounded-full z-10 transition duration-300 transform">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <!-- Scrollable Gallery -->
            <div class="overflow-x-auto no-scrollbar cursor-grab">
                <div class="gallery flex gap-6 p-4">
                    <?php foreach ($cat['products'] as $p): ?>
                    <a href="product.php?id=<?php echo htmlspecialchars($p['id']); ?>"
                        class="bg-white rounded-2xl shadow-lg p-4 flex flex-col items-center min-w-[12rem] max-w-[14rem] flex-shrink-0 transform transition hover:scale-105 hover:shadow-2xl border-2 border-green-800">
                        <img src="<?php echo htmlspecialchars($p['image']); ?>"
                            alt="<?php echo htmlspecialchars($p['name']); ?>"
                            class="w-full rounded-lg border-2 border-blue-800 h-40 object-contain mb-3 bg-gray-50 p-1">
                        <hr class="w-full border-2 border-orange-400">
                        <p class="font-semibold text-center text-gray-800 text-sm md:text-base">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </p>
                        <div class="flex justify-between items-center w-full h-[3rem] mt-4 gap-2">
                            <span
                                class="bg-gray-200 text-gray-700 flex justify-center items-center w-1/2 h-full text-center text-xs md:text-sm rounded-lg">
                                <?php echo htmlspecialchars($product['brand_name'] ?? 'Shri Ganga Herbal'); ?>
                            </span>
                            <span
                                class="bg-orange-100 text-orange-700 flex justify-center items-center w-1/2 h-full text-base font-bold rounded-lg">
                                ₹
                                <?php echo number_format($product['min_price'] ?? 0, 2); ?>
                            </span>
                        </div>

                    </a>
                    <?php endforeach; ?>
                    <div style="flex: 0 0 16px;"></div>
                </div>
            </div>


            <!-- Right Button -->
            <button onclick="scrollGallery(this, 1)"
                class="absolute right-2 top-1/2 text-white hover:text-gray-300 px-4 py-3 rounded-full z-10 transition duration-300 transform">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
    .gallery-wrapper {
        position: relative;
    }

    .product-card {
        padding: 16px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .product-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
    }

    .gallery {
        display: flex;
        gap: 20px;
        padding: 16px 16px 16px 16px;
        transition: transform 0.5s ease-in-out;
    }

    .gallery-wrapper button {
        background-color: rgba(0, 0, 0, 0.4);
        font-size: 18px;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 10;
    }

    .gallery-wrapper button i {
        color: #fff;
    }
</style>