<?php
session_start();
require_once 'include/conn.php';

// Get the product ID from URL query string
$productId = $_GET['id'] ?? null;

// Fetch the product from the database
if ($productId) {
    $stmt = $pdo->prepare("SELECT p.id, p.name, p.image, p.description, p.disease, p.brand_name, c.name AS category_name, c.id AS category_id
                           FROM products p
                           JOIN categories c ON p.category_id = c.id
                           WHERE p.id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    // Check if product exists
    if (!$product) {
        echo "Product not found!";
        exit;
    }

    // Fetch weight variants for this product
    $stmt = $pdo->prepare("SELECT id, weight, price FROM product_variants WHERE product_id = ? ORDER BY price ASC");
    $stmt->execute([$productId]);
    $variants = $stmt->fetchAll();

    // If no variants, show error
    if (empty($variants)) {
        echo "No weight options available for this product!";
        exit;
    }

    // Fetch related products (same category, excluding current product)
    $stmt = $pdo->prepare("SELECT p.id, p.name, p.image, p.brand_name, MIN(v.price) AS min_price
                           FROM products p
                           LEFT JOIN product_variants v ON p.id = v.product_id
                           WHERE p.category_id = ? AND p.id != ?
                           GROUP BY p.id, p.name, p.image, p.brand_name
                           LIMIT 4");
    $stmt->execute([$product['category_id'], $productId]);
    $related_products = $stmt->fetchAll();

    // If no related products, fetch bestseller products (excluding current product)
    if (empty($related_products)) {
        $stmt = $pdo->prepare("SELECT p.id, p.name, p.image, p.brand_name, MIN(v.price) AS min_price
                               FROM products p
                               LEFT JOIN product_variants v ON p.id = v.product_id
                               WHERE p.id != ?
                               GROUP BY p.id, p.name, p.image, p.brand_name
                               ORDER BY p.id ASC
                               LIMIT 4");
        $stmt->execute([$productId]);
        $related_products = $stmt->fetchAll();
    }
} else {
    echo "Invalid product ID!";
    exit;
}

// Base price is the lowest variant's price
$basePrice = $variants[0]['price'];
$baseWeight = $variants[0]['weight'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Open+Sans:wght@400;600&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <?php include("include/title.php") ?>
    <?php include("include/links.php") ?>
    <link rel="stylesheet" href="style.css">
</head>

<body class="sm:px-[5vw] md:px-[7vw] lg:px-[9vw]">
    <?php include("include/header.php") ?>

    <!-- Product Details -->
    <div class="max-w-5xl mx-auto p-4 sm:p-6 mt-10 product-div">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Product Image -->
            <div class="md:w-1/2 image-section flex justify-center items-center">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-64 sm:h-80 md:h-[350px] object-contain rounded">
            </div>

            <!-- Product Info -->
            <div class="flex-1 bg-[#efefef] p-[2rem] rounded-lg shadow">
                <!-- Name & Category -->
                <div class="py-2 mb-3 flex flex-row items-center justify-center lg:flex-col lg:items-start">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold"><?php echo htmlspecialchars($product['name']); ?></h1>
                        <?php if (!empty($product['disease'])): ?>
                            <div class="flex items-center">
                                <p class="text-[16px] font-bold text-green-500 mr-[2px]">Helps With:</p>
                                <p class="text-gray-800 font-bold text-[14px]"><?php echo htmlspecialchars($product['disease']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="bg-gray-400 text-white font-bold uppercase px-4 py-2 rounded-lg shadow cursor-pointer lg:mt-2">
                        <?php echo htmlspecialchars($product['category_name']); ?>
                    </div>
                </div>

                <!-- Price -->
                <p id="priceDisplay" class="text-2xl sm:text-3xl font-semibold text-orange-600 mb-4 price-display" data-base-price="<?php echo $basePrice; ?>">
                    &#8377;<?php echo number_format($basePrice, 2); ?>
                </p>

                <!-- Description -->
                <p class="text-gray-700 mb-6"><?php echo htmlspecialchars($product['description']); ?></p>

                <!-- Size Selector -->
                <div class="mb-6">
                    <label class="font-semibold mb-2 block">Select Weight</label>
                    <select id="proQuan" class="border border-gray-300 rounded px-3 py-2 sm:w-1/2 focus:outline-none focus:ring-2 focus:ring-green-600">
                        <?php foreach ($variants as $variant): ?>
                            <option value="<?php echo htmlspecialchars($variant['price']); ?>" data-weight="<?php echo htmlspecialchars($variant['weight']); ?>">
                                <?php echo htmlspecialchars($variant['weight']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Add to Cart -->
                <form method="post" action="cart.php" class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                    <input type="hidden" id="priceInput" name="price" value="<?php echo $basePrice; ?>">
                    <input type="hidden" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
                    <input type="hidden" id="weightInput" name="weight" value="<?php echo $baseWeight; ?>">
                    <button type="submit" name="add_to_cart" class="add-to-cart-btn text-white px-6 py-3 rounded-lg font-medium bg-green-600 transition hover:bg-green-700">
                        Add to Cart
                    </button>
                </form>

                <!-- Extra Info -->
                <ul class="text-sm text-gray-600 space-y-2 mt-6">
                    <li>✔ 100% Original Product.</li>
                    <li>✔ Cash on delivery is available.</li>
                    <li>✔ Easy return & exchange policy within 7 days.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-16">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold"><?php echo empty($related_products) || count($related_products) == 0 ? 'BESTSELLER PRODUCTS' : 'RELATED PRODUCTS'; ?></h2>
            <div class="w-16 h-1 bg-green-600 mx-auto mt-2 rounded"></div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            <?php if (!empty($related_products)): ?>
                <?php foreach ($related_products as $prod): ?>
                    <a href="product.php?id=<?php echo htmlspecialchars($prod['id']); ?>" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                        <img src="<?php echo htmlspecialchars($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" class="w-full h-40 object-contain mb-3">
                        <p class="font-semibold"><?php echo htmlspecialchars($prod['name']); ?></p>
                        <p class="text-green-600 font-semibold">&#8377;<?php echo number_format($prod['min_price'] ?? 0, 2); ?></p>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-600 col-span-full">No products found.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include("include/footer.php") ?>

    <!-- JS for dynamic price update -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const select = document.getElementById("proQuan");
            const priceDisplay = document.getElementById("priceDisplay");
            const priceInput = document.getElementById("priceInput");
            const weightInput = document.getElementById("weightInput");

            select.addEventListener("change", function () {
                let newPrice = parseFloat(this.value);
                let selectedWeight = this.options[this.selectedIndex].dataset.weight;

                // Update display
                priceDisplay.innerHTML = "&#8377; " + newPrice.toFixed(2);

                // Update hidden inputs for cart
                priceInput.value = newPrice.toFixed(2);
                weightInput.value = selectedWeight;
            });
        });
    </script>
</body>
</html>