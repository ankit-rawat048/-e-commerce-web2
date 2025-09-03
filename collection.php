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

  <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">

    <!-- Filters Sidebar -->
    <aside class="md:col-span-1 bg-white p-6 rounded-lg shadow">
      <h2 class="text-xl font-bold mb-4">FILTERS</h2>

      <div class="mb-6">
        <h4 class="font-semibold mb-2">CATEGORIES</h4>
        <div class="flex flex-col gap-2">
          <label class="flex items-center gap-2">
            <input type="checkbox" name="productType" value="oil" class="accent-green-600">
            Oil
          </label>
          <label class="flex items-center gap-2">
            <input type="checkbox" name="productType" value="shampoo" class="accent-green-600">
            Shampoo
          </label>
          <label class="flex items-center gap-2">
            <input type="checkbox" name="productType" value="tablet" class="accent-green-600">
            Taplet
          </label>
        </div>
      </div>
    </aside>

    <!-- Products Section -->
    <main class="md:col-span-3">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold">ALL COLLECTION</h1>
        <select class="border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-600">
          <option value="">Sort By:</option>
          <option value="ayurvedic">Relavent</option>
          <option value="herbal">Low to High</option>
          <option value="organic">High to Low</option>
        </select>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
    </main>
  </div>

  <!-- Footer -->
  <?php include("include/footer.php") ?>

</body>
</html>
