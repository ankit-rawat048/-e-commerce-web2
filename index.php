<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include("include/title.php") ?>
  
  <?php include("include/links.php") ?>
</head>
<body class="px-4 sm:px-[5vw] md:px-[7vw] lg:px-[9vw]
">

  <!-- Header -->
        <?php include("include/header.php") ?>

  <!-- Hero Section -->
  <section id="bgImg" class="bg-green-100 py-20 text-center">
    <div class="max-w-xl mx-auto">
      <p class="text-green-800 font-semibold mb-2">OUR BESTSELLERS</p>
      <h2 class="text-4xl md:text-5xl font-bold mb-4">Latest Arrival</h2>
      <!-- <p class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 cursor-pointer">SHOP NOW</p> -->
    </div>
  </section>

  <!-- Latest Collections -->
  <section class="py-16 px-6">
    <div class="max-w-6xl mx-auto">
      <div class="flex items-center justify-center mb-6 space-x-3">
        <h1 class="border-b-2 text-center text-3xl font-bold">LATEST COLLECTIONS</h1>
        <!-- <p class="text-green-600 text-center text-3xl font-bold">-</p> -->
      </div>
      <!-- <p class="text-gray-600 mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias sed nulla tenetur esse, quas quasi. Incidunt, fuga voluptatum.</p> -->

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
  </section>

  <!-- Best Sellers -->
  <section class="py-16 px-6 bg-gray-100">
    <div class="max-w-6xl mx-auto">
      <div class="flex items-center mb-6 space-x-3">
        <h1 class="border-b-2 text-center text-3xl font-bold">BEST SELLERS</h1>
        <!-- <span class="text-green-600 text-3xl font-bold">-</span> -->
      </div>
      <!-- <p class="text-gray-600 mb-10">Discover our top-selling products loved by our customers.</p> -->

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <a href="product.php?id=1" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Himalayan Ghutno ke Dard Grice ki Fanki</p>
          <p class="text-green-600 font-bold">&#8377; 100</p>
        </a>

        <a href="product.php?id=2" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Himalayan Ghutno ke Dard Grice ki Fanki</p>
          <p class="text-green-600 font-bold">&#8377; 200</p>
        </a>

        <a href="product.php?id=3" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Himalayan Ghutno ke Dard Grice ki Fanki</p>
          <p class="text-green-600 font-bold">&#8377; 200</p>
        </a>

        <a href="product.php?id=4" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Himalayan Ghutno ke Dard Grice ki Fanki</p>
          <p class="text-green-600 font-bold">&#8377; 110</p>
        </a>
      </div>
    </div>
  </section>

<!-- Categories Page -->
<section class="py-16 bg-gray-100">
  <div class="max-w-6xl mx-auto px-6">

    <!-- Ayurvedic Category -->
    <div class="mb-16">
      <div class="flex items-center space-x-3 mb-4">
        <h1 class="border-b-2 text-center text-3xl font-bold">AYURVEDIC</h1>
        <!-- <span class="text-green-600 text-3xl font-bold">-</span> -->
      </div>
      <!-- <p class="text-gray-600 mb-10">Discover our top-selling products loved by our customers.</p> -->

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <a href="product.php?id=1" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img60-D3dQvT_e.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Himalayan Ghutno ke Dard Grice ki Fanki</p>
          <p class="text-green-600 font-bold">&#8377; 100</p>
        </a>
        <a href="product.php?id=2" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png" alt="product" class="w-full h-40 object-contain mb-3">
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

    <!-- Herbal Category -->
    <div class="mb-16">
      <div class="flex items-center space-x-3 mb-4">
        <h1 class="border-b-2 text-center text-3xl font-bold">HERBAL</h1>
        <!-- <span class="text-green-600 text-3xl font-bold">-</span> -->
      </div>
      <!-- <p class="text-gray-600 mb-10">Discover our top-selling products loved by our customers.</p> -->

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <a href="product.php?id=5" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Kailash Jeevan MultiPurpose Cream</p>
          <p class="text-green-600 font-bold">&#8377; 150</p>
        </a>
        <a href="product.php?id=6" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img65-jtLWbZUI.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Kesri Marham</p>
          <p class="text-green-600 font-bold">&#8377; 200</p>
        </a>
        <a href="product.php?id=7" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img55-BB5qRI_o.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Herbal Product</p>
          <p class="text-green-600 font-bold">&#8377; 180</p>
        </a>
        <a href="product.php?id=8" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img56-BXkPPiBF.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Herbal Product</p>
          <p class="text-green-600 font-bold">&#8377; 220</p>
        </a>
      </div>
    </div>

    <!-- Organic Category -->
    <div class="mb-16">
      <div class="flex items-center space-x-3 mb-4">
        <h1 class="border-b-2 text-center text-3xl font-bold">ORGANIC</h1>
        <!-- <span class="text-green-600 text-3xl font-bold">-</span> -->
      </div>
      <!-- <p class="text-gray-600 mb-10">Discover our top-selling products loved by our customers.</p> -->

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <a href="product.php?id=9" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img54-B2o6kMBP.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Organic  Product</p>
          <p class="text-green-600 font-bold">&#8377; 130</p>
        </a>
        <a href="product.php?id=3" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img61-BAipXeaP.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Samahan Herbal Tea</p>
          <p class="text-green-600 font-bold">&#8377; 180</p>
        </a>
        <a href="product.php?id=5" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Kailash Jeevan MultiPurpose Cream</p>
          <p class="text-green-600 font-bold">&#8377; 200</p>
        </a>
        <a href="product.php?id=8" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <img src="https://shrigangaherbal.com/assets/p_img56-BXkPPiBF.png" alt="product" class="w-full h-40 object-contain mb-3">
          <p class="font-semibold">Organic Product 4</p>
          <p class="text-green-600 font-bold">&#8377; 210</p>
        </a>
      </div>
    </div>

  </div>
</section>

<!-- Policies Section -->
<section class="py-16 bg-gray-50">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
    
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
      <i class="fa-solid fa-arrows-rotate text-4xl text-green-600 mb-4"></i>
      <p class="font-semibold text-lg mb-2">Easy Exchange Policy</p>
      <p class="text-gray-600 text-sm">We offer hassle-free exchange policy</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
      <i class="fa-solid fa-circle-check text-4xl text-green-600 mb-4"></i>
      <p class="font-semibold text-lg mb-2">7 Day Return Policy</p>
      <p class="text-gray-600 text-sm">We provide 7 days free return policy</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
      <i class="fa-solid fa-headset text-4xl text-green-600 mb-4"></i>
      <p class="font-semibold text-lg mb-2">Best Customer Support</p>
      <p class="text-gray-600 text-sm">We provide 24/7 customer support</p>
    </div>

  </div>
</section>

<!-- Subscribe Section -->
  <?php include("include/subscribe.php") ?>


<!-- Footer -->

  <?php include("include/footer.php") ?>


</body>
</html>
