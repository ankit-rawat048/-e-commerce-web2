<?php

session_start();
// Get the product ID from URL query string
$productId = $_GET['id'] ?? null;

// For demo, sample products array
$products = [
    1 => [
        'name' => 'Himalayan Ghutno ke Dard Grice ki Fanki',
        'price' => 100,
        'image' => 'https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png',
        'description' => 'A powerful herbal remedy for joint and knee pain relief.'
    ],
    2 => [
        'name' => 'Hari Ganga Balm',
        'price' => 200,
        'image' => 'https://shrigangaherbal.com/assets/p_img60-D3dQvT_e.png',
        'description' => 'An herbal balm for instant pain relief.'
    ],
    3 => [
        'name' => 'Samahan Herbal Tea',
        'price' => 200,
        'image' => 'https://shrigangaherbal.com/assets/p_img61-BAipXeaP.png',
        'description' => 'Natural herbal tea to boost immunity and relieve cold symptoms.'
    ],
    4 => [
        'name' => 'Nidco Shilajit Paste',
        'price' => 200,
        'image' => 'https://shrigangaherbal.com/assets/p_img62-D0zloGw6.png',
        'description' => 'Pure Shilajit paste for energy and vitality.'
    ],
];

// Check if product exists
$product = $products[$productId] ?? null;

if (!$product) {
    echo "Product not found!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $product['name']; ?></title>
  <?php include("include/links.php") ?>
</head>
<body class="px-4 sm:px-[5vw] md:px-[7vw] lg:px-[9vw]
">

  <?php include("include/header.php") ?>

  <!-- Product Details -->
  <div class="max-w-5xl mx-auto p-6 mt-10">
    <div class="flex flex-col md:flex-row gap-8">
      <!-- Product Image -->
      <div class="md:w-1/2">
        <img src="<?php echo $product['image']; ?>" 
             alt="<?php echo $product['name']; ?>" 
             class="w-full h-[350px] object-contain rounded">
      </div>

      <!-- Product Info -->
      <div class="flex-1">
        <h1 class="text-3xl font-bold mb-3"><?php echo $product['name']; ?></h1>

        <!-- Ratings -->
        <div class="flex items-center gap-2 mb-3 text-red-500">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star text-red-100"></i>
          <span class="text-gray-600 text-sm">(122 reviews)</span>
        </div>

        <!-- Price -->
        <p class="text-green-600 text-2xl font-semibold mb-4">
          &#8377; <?php echo $product['price']; ?>
        </p>

        <!-- Description -->
        <p class="text-gray-700 mb-6">
          <?php echo $product['description']; ?>
        </p>

        <!-- Size Selector -->
        <div class="mb-6">
          <p class="font-semibold mb-2">Select Size</p>
          <select class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            <option>23g</option>
            <option>50g</option>
            <option>100g</option>
          </select>
        </div>

        <!-- Add to Cart -->
        <form method="post" action="cart.php">
  <input type="hidden" name="id" value="<?php echo $productId; ?>">
  <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
  <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
  <input type="number" name="quantity" value="1" min="1" 
         class="border px-2 py-1 w-16 rounded mb-4">

  <button type="submit" name="add_to_cart" 
          class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition">
    Add to Cart
  </button>
</form>

        <!-- Extra Info -->
        <ul class="text-sm text-gray-600 space-y-2">
          <li>✔ 100% Original Product.</li>
          <li>✔ Cash on delivery is available.</li>
          <li>✔ Easy return & exchange policy within 7 days.</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Related Products -->
  <div class="max-w-6xl mx-auto px-6 mt-16">
    <div class="text-center mb-8">
      <h2 class="text-2xl font-bold">RELATED PRODUCTS</h2>
      <div class="w-16 h-1 bg-green-600 mx-auto mt-2 rounded"></div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <a href="product.php?id=1" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Himalayan Ghutno ke Dard Grice ki Fanki</p>
          <p class="text-green-600 font-bold">&#8377; 100</p>
        </a>

        <a href="product.php?id=2" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img60-D3dQvT_e.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Hari Ganga Balm</p>
          <p class="text-green-600 font-bold">&#8377; 200</p>
        </a>

        <a href="product.php?id=3" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img61-BAipXeaP.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Samahan Herbal Tea</p>
          <p class="text-green-600 font-bold">&#8377; 200</p>
        </a>

        <a href="product.php?id=4" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img62-D0zloGw6.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Nidco Shilajit Paste</p>
          <p class="text-green-600 font-bold">&#8377; 110</p>
        </a>
      </div>
  </div>

  <!-- Footer -->
  <?php include("include/footer.php") ?>
   
</body>
</html>
