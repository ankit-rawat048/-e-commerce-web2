<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("include/title.php") ?>
    <?php include("include/links.php") ?>
</head>

<body class="sm:px-[5vw] md:px-[7vw] lg:px-[9vw]">

    <!-- Header -->
    <?php include("include/header.php") ?>

    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- Filters Sidebar (Desktop Only) -->
        <aside id="filterDiv" class="hidden md:block md:col-span-1 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">FILTERS</h2>
            <div class="flex flex-col gap-2">
                <label class="flex items-center gap-2">
                    <input type="checkbox" value="oil" class="category-checkbox accent-green-600"> Oil
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" value="sampoo" class="category-checkbox accent-green-600"> Sampoo
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" value="tablet" class="category-checkbox accent-green-600"> Tablet
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" value="balm" class="category-checkbox accent-green-600"> Balm
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" value="tea" class="category-checkbox accent-green-600"> Tea
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" value="paste" class="category-checkbox accent-green-600"> Paste
                </label>
            </div>
        </aside>

        <!-- Products Section -->
        <main class="md:col-span-3">

            <!-- Desktop Top Bar -->
            <div id="mainDiv"
                class="hidden md:flex items-center justify-between mb-6 gap-4 bg-white p-4 rounded-lg shadow">
                <h1 class="text-2xl font-bold">ALL COLLECTION</h1>
                <select id="sortSelect"
                    class="border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-600">
                    <option value="">Sort By:</option>
                    <option value="priceLow">Price: Low to High</option>
                    <option value="priceHigh">Price: High to Low</option>
                    <option value="nameAsc">Name: A-Z</option>
                    <option value="nameDesc">Name: Z-A</option>
                </select>
            </div>

            <!-- Mobile Top Bar -->
            <div id="mobileTop" class="md:hidden mb-6 bg-white p-4 rounded-lg shadow flex flex-col justify-between gap-4">
                <h1 class="text-xl font-bold">ALL COLLECTION</h1>
                <div class="flex items-center justify-between gap-4">
                    <select id="mobileSortSelect"
                        class="border border-gray-300 w-[50%]  p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-600">
                        <option value="">Sort By:</option>
                        <option value="priceLow">Price: Low to High</option>
                        <option value="priceHigh">Price: High to Low</option>
                        <option value="nameAsc">Name: A-Z</option>
                        <option value="nameDesc">Name: Z-A</option>
                    </select>

                    <!-- Mobile Filters (Collapsible) -->
                    <div class="relative w-[50%]">
  <button id="toggleFilters" 
          class="border border-gray-300 w-full py-2 border rounded flex justify-between items-center gap-1">
    Filters 
    <i id="filterArrow" class="fa-solid fa-angle-down"></i>
  </button>

  <div id="mobileFilters"
       class="hidden absolute left-0 top-full mt-2 p-4 rounded bg-white shadow flex flex-col gap-2 z-50 w-48">
    <!-- JS will inject checkboxes here -->
  </div>
</div>

                </div>
            </div>

            <!-- Products Grid -->
            <div id="productsGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div class="product-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition" data-category="oil"
                    data-price="100" data-name="Himalayan Ghutno ke Dard Grice ki Fanki">
                    <a href="product.php?id=1">
                        <img src="https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png" alt="product"
                            class="w-full h-40 object-contain mb-3">
                        <p class="font-semibold">Himalayan Ghutno ke Dard Grice ki Fanki</p>
                        <p class="text-green-600 font-bold">&#8377; 100</p>
                    </a>
                </div><div class="product-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition" data-category="oil"
                    data-price="100" data-name="Himalayan Ghutno ke Dard Grice ki Fanki">
                    <a href="product.php?id=1">
                        <img src="https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png" alt="product"
                            class="w-full h-40 object-contain mb-3">
                        <p class="font-semibold">Himalayan Ghutno ke Dard Grice ki Fanki</p>
                        <p class="text-green-600 font-bold">&#8377; 100</p>
                    </a>
                </div><div class="product-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition" data-category="oil"
                    data-price="100" data-name="Himalayan Ghutno ke Dard Grice ki Fanki">
                    <a href="product.php?id=1">
                        <img src="https://shrigangaherbal.com/assets/p_img59-BApsG3fC.png" alt="product"
                            class="w-full h-40 object-contain mb-3">
                        <p class="font-semibold">Himalayan Ghutno ke Dard Grice ki Fanki</p>
                        <p class="text-green-600 font-bold">&#8377; 100</p>
                    </a>
                </div>
                <div class="product-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition" data-category="balm"
                    data-price="200" data-name="Hari Ganga Balm">
                    <a href="product.php?id=2">
                        <img src="https://shrigangaherbal.com/assets/p_img60-D3dQvT_e.png" alt="product"
                            class="w-full h-40 object-contain mb-3">
                        <p class="font-semibold">Hari Ganga Balm</p>
                        <p class="text-green-600 font-bold">&#8377; 200</p>
                    </a>
                </div>
                <div class="product-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition" data-category="tea"
                    data-price="200" data-name="Samahan Herbal Tea">
                    <a href="product.php?id=3">
                        <img src="https://shrigangaherbal.com/assets/p_img61-BAipXeaP.png" alt="product"
                            class="w-full h-40 object-contain mb-3">
                        <p class="font-semibold">Samahan Herbal Tea</p>
                        <p class="text-green-600 font-bold">&#8377; 200</p>
                    </a>
                </div>
                <div class="product-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition"
                    data-category="paste" data-price="110" data-name="Nidco Shilajit Paste">
                    <a href="product.php?id=4">
                        <img src="https://shrigangaherbal.com/assets/p_img62-D0zloGw6.png" alt="product"
                            class="w-full h-40 object-contain mb-3">
                        <p class="font-semibold">Nidco Shilajit Paste</p>
                        <p class="text-green-600 font-bold">&#8377; 110</p>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <?php include("include/footer.php") ?>

    <!-- JS for filtering and sorting -->
    <script>
        const categoryCheckboxes = document.querySelectorAll(".category-checkbox");
        const productsGrid = document.getElementById("productsGrid");
        const productCards = Array.from(document.querySelectorAll(".product-card"));
        const sortSelect = document.getElementById("sortSelect");
        const mobileSortSelect = document.getElementById("mobileSortSelect");

        // Toggle mobile filters
        const toggleBtn = document.getElementById("toggleFilters");
const mobileFilters = document.getElementById("mobileFilters");
const filterArrow = document.getElementById("filterArrow");

toggleBtn.addEventListener("click", () => {
  mobileFilters.classList.toggle("hidden");

  // Toggle between angle-down and angle-up
  if (mobileFilters.classList.contains("hidden")) {
    filterArrow.classList.remove("fa-angle-up");
    filterArrow.classList.add("fa-angle-down");
  } else {
    filterArrow.classList.remove("fa-angle-down");
    filterArrow.classList.add("fa-angle-up");
  }
});


        // Clone desktop filters into mobile
        const desktopFilters = document.querySelector("#filterDiv .flex-col");
        if (desktopFilters && mobileFilters) {
            mobileFilters.innerHTML = desktopFilters.innerHTML;
            mobileFilters.querySelectorAll(".category-checkbox")
                .forEach(cb => cb.addEventListener("change", filterProducts));
        }

        function filterProducts() {
            const selected = Array.from(document.querySelectorAll(".category-checkbox:checked")).map(cb => cb.value);
            productCards.forEach(card => {
                card.style.display = (selected.length === 0 || selected.includes(card.dataset.category)) ? "block" : "none";
            });
        }

        function sortProducts(selectElement) {
            const value = selectElement.value;
            let sorted = [...productCards];
            if (value === "priceLow") sorted.sort((a, b) => a.dataset.price - b.dataset.price);
            else if (value === "priceHigh") sorted.sort((a, b) => b.dataset.price - a.dataset.price);
            else if (value === "nameAsc") sorted.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
            else if (value === "nameDesc") sorted.sort((a, b) => b.dataset.name.localeCompare(a.dataset.name));
            sorted.forEach(card => productsGrid.appendChild(card));
        }

        document.querySelectorAll(".category-checkbox").forEach(cb => cb.addEventListener("change", filterProducts));
        sortSelect.addEventListener("change", () => sortProducts(sortSelect));
        mobileSortSelect.addEventListener("change", () => sortProducts(mobileSortSelect));
    </script>
</body>

</html>
