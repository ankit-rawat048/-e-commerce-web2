<?php
session_start();

// Get the product ID from URL query string
$productId = $_GET['id'] ?? null;

// Sample products array
$products = [
    1 => [
        'name' => 'Himalayan Ghutno ke Dard Grice ki Fanki',
        'price' => 100,
        'image' => 'https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png',
        'description' => 'A powerful herbal remedy for joint and knee pain relief.',
        'categories' => 'oil'
    ],
    2 => [
        'name' => 'Hari Ganga Balm',
        'price' => 200,
        'image' => 'https://shrigangaherbal.com/assets/p_img60-D3dQvT_e.png',
        'description' => 'An herbal balm for instant pain relief.',
        'categories' => 'balm'
    ],
    3 => [
        'name' => 'Samahan Herbal Tea',
        'price' => 200,
        'image' => 'https://shrigangaherbal.com/assets/p_img61-BAipXeaP.png',
        'description' => 'Natural herbal tea to boost immunity and relieve cold symptoms.',
        'categories' => 'tea'
    ],
    4 => [
        'name' => 'Nidco Shilajit Paste',
        'price' => 200,
        'image' => 'https://shrigangaherbal.com/assets/p_img62-D0zloGw6.png',
        'description' => 'Pure Shilajit paste for energy and vitality.',
        'categories' => 'paste'
    ],
    5 => [
        'name' => 'Kailash Jeevan MultiPurpose Cream',
        'price' => 200,
        'image' => 'https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png',
        'description' => 'Pure Shilajit paste for energy and vitality.',
        'categories' => 'paste'
    ],
    6 => [
        'name' => 'Nidco Shilajeet Tablet',
        'price' => 200,
        'image' => 'https://shrigangaherbal.com/assets/p_img64-C8_eQaK1.png',
        'description' => 'Pure Shilajit paste for energy and vitality.',
        'categories' => 'paste'
    ],
    7 => [
        'name' => 'Kesri Marham',
        'price' => 200,
        'image' => 'https://shrigangaherbal.com/assets/p_img65-jtLWbZUI.png',
        'description' => 'Pure Shilajit paste for energy and vitality.',
        'categories' => 'paste'
    ],
    8 => [
        'name' => 'Herbal Product 8',
        'price' => 200,
        'image' => 'https://shrigangaherbal.com/assets/p_img55-BB5qRI_o.png',
        'description' => 'Pure Shilajit paste for energy and vitality.',
        'categories' => 'paste'
    ],
];

// Check if product exists
$product = $products[$productId] ?? null;
if (!$product) {
    echo "Product not found!";
    exit;
}

// Category class
$categoryColors = [
    'oil' => 'bg-yellow-500',
    'balm' => 'bg-red-500',
    'tea' => 'bg-green-500',
    'paste' => 'bg-orange-500'
];

$catClass = $categoryColors[$product['categories']] ?? 'bg-gray-400';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Open+Sans:wght@400;600&family=Montserrat:wght@700&family=Roboto:wght@400&display=swap" rel="stylesheet">

    <?php include("include/title.php") ?>
    <?php include("include/links.php") ?>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        h1, h2, h3, .font-bold {
            font-family: 'Open Sans', sans-serif;
        }

        h1, h2, .font-semibold {
            font-family: 'Montserrat', sans-serif;
        }

        .product-div {
            border: 2px solid gray;
            background-color: #e5e5e5;
            padding: 20px;
        }

        .image-section {
            background-color: #f5f5f5;
        }

        .add-to-cart-btn {
            background-color: #FF9800;
        }

        .add-to-cart-btn:hover {
            background-color: #FB8C00;
        }
    </style>
</head>

<body class="sm:px-[5vw] md:px-[7vw] lg:px-[9vw]">

    <?php include("include/header.php") ?>

    <!-- Product Details -->
    <div class="max-w-5xl mx-auto p-4 sm:p-6 mt-10 product-div">
        <div class="flex flex-col md:flex-row gap-8">

            <!-- Product Image -->
            <div class="md:w-1/2 image-section">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"
                    class="w-full h-64 sm:h-80 md:h-[350px] object-contain rounded">
            </div>

            <!-- Product Info -->
            <div class="flex-1">

                <!-- Name & Category -->
                <div class="py-2 mb-3 flex flex-row items-center justify-center lg:flex-col lg:items-start">

                    <h1 class="text-2xl sm:text-3xl font-bold mb-0 lg:mb-2">
                        <?php echo $product['name']; ?>
                    </h1>

                    <div class="<?php echo $catClass; ?> text-white font-bold bg-gray-400 uppercase px-4 py-2 rounded-lg shadow cursor-pointer lg:mt-2">
                        <?php echo $product['categories']; ?>
                    </div>

                </div>

                <!-- Price -->
                <p class="text-2xl sm:text-3xl font-semibold text-green-600 mb-4 price-display">
                    &#8377; <?php echo $product['price']; ?>
                </p>

                <!-- Description -->
                <p class="text-gray-700 mb-6">
                    <?php echo $product['description']; ?>
                </p>

                <!-- Size Selector -->
                <div class="mb-6">
                    <label class="font-semibold mb-2 block">Select Weight</label>
                    <select id="proQuan"
                        class="border border-gray-300 rounded px-3 py-2 sm:w-1/2 focus:outline-none focus:ring-2 focus:ring-green-600">
                        <option value="1">23g</option>
                        <option value="2">50g</option>
                        <option value="3">100g</option>
                    </select>
                </div>

                <!-- Add to Cart -->
                <form method="post" action="cart.php" class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <input type="hidden" name="id" value="<?php echo $productId; ?>">
                    <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                    <input type="hidden" name="image" value="<?php echo $product['image']; ?>">
                    <input type="hidden" name="weight" value="23g">

                    <button type="submit" name="add_to_cart"
                        class="add-to-cart-btn text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition">
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
            <h2 class="text-2xl font-bold">RELATED PRODUCTS</h2>
            <div class="w-16 h-1 bg-green-600 mx-auto mt-2 rounded"></div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            <?php foreach($products as $id => $prod): ?>
            <?php if($id != $productId): ?>
            <a href="product.php?id=<?php echo $id; ?>"
                class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <img src="<?php echo $prod['image']; ?>" alt="product" class="w-full h-40 object-contain mb-3">
                <p class="font-semibold"><?php echo $prod['name']; ?></p>
                <p class="text-green-600 font-semibold">&#8377; <?php echo $prod['price']; ?></p>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include("include/footer.php") ?>

</body>

</html>
