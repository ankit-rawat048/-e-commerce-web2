<?php
session_start();
require_once 'include/conn.php';

// Fetch all categories for filters
$stmt = $pdo->query("SELECT name FROM categories ORDER BY name");
$categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch all products with lowest price from product_variants
$stmt = $pdo->query("SELECT p.id, p.name, p.image, p.brand_name, c.name AS category_name, MIN(v.price) AS min_price
                     FROM products p
                     JOIN categories c ON p.category_id = c.id
                     LEFT JOIN product_variants v ON p.id = v.product_id
                     GROUP BY p.id, p.name, p.image, p.brand_name, c.name");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <?php foreach ($categories as $category): ?>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" value="<?php echo htmlspecialchars($category); ?>" class="category-checkbox accent-green-600">
                        <?php echo htmlspecialchars(ucfirst($category)); ?>
                    </label>
                <?php endforeach; ?>
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
                        class="border border-gray-300 w-[50%] p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-600">
                        <option value="">Sort By:</option>
                        <option value="priceLow">Price: Low to High</option>
                        <option value="priceHigh">Price: High to Low</option>
                        <option value="nameAsc">Name: A-Z</option>
                        <option value="nameDesc">Name: Z-A</option>
                    </select>

                    <!-- Mobile Filters (Collapsible) -->
                    <div class="relative w-[50%]">
                        <button id="toggleFilters" 
                                class="border border-gray-300 w-full px-2 py-2 border rounded flex justify-between items-center gap-1">
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
                <?php foreach ($products as $product): ?>
                    <div class="product-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition"
                         data-category="<?php echo htmlspecialchars($product['category_name']); ?>"
                         data-price="<?php echo htmlspecialchars($product['min_price'] ?? 0); ?>"
                         data-name="<?php echo htmlspecialchars($product['name']); ?>">
                        <a href="product.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 class="w-full h-40 object-contain mb-3">
                            <p class="font-semibold"><?php echo htmlspecialchars($product['name']); ?></p>
                            <p class="text-green-600 font-bold">&#8377;<?php echo number_format($product['min_price'] ?? 0, 2); ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
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