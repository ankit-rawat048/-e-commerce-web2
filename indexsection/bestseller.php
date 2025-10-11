<?php
require_once 'include/conn.php';

// Fetch best sellers with lowest price from product_variants
$stmt = $pdo->query("SELECT p.id, p.name, p.image, p.brand_name, MIN(v.price) AS min_price
                     FROM products p
                     LEFT JOIN product_variants v ON p.id = v.product_id
                     GROUP BY p.id, p.name, p.image, p.brand_name
                     ORDER BY p.id ASC 
                     LIMIT 7");
$bestsellers = $stmt->fetchAll();
?>

<!-- Best Sellers -->
<section class="py-16 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-center mb-6 space-x-3">
            <h1 class="border-b-2 text-center text-3xl font-bold">BEST SELLERS</h1>
        </div>

        <!-- Horizontal Scrollable Row -->
        <div class="overflow-x-auto no-scrollbar cursor-grab" id="scrollablesRow">
            <div class="flex gap-6 p-[1rem]">
                <?php foreach ($bestsellers as $product): ?>
                    <a href="product.php?id=<?php echo htmlspecialchars($product['id']); ?>"
                       class="bg-white rounded-2xl shadow-lg p-4 flex flex-col items-center min-w-[12rem] max-w-[14rem] flex-shrink-0 transform transition hover:scale-105 hover:shadow-2xl border-2 border-green-800">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>"
                             class="w-full h-40 object-contain mb-4 rounded-lg border-2 border-blue-800 p-1 bg-gray-50">
                        <hr class="w-full border-2 border-orange-400">
                        <p class="font-semibold text-center text-gray-800 text-sm md:text-base">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </p>
                        <div class="flex justify-between items-center w-full h-[3rem] mt-auto gap-2">
    <span class="bg-gray-200 text-gray-700 flex justify-center items-center w-1/2 h-full text-center text-xs md:text-sm rounded-lg">
        <?php echo htmlspecialchars($product['brand_name'] ?? 'Shri Ganga Herbal'); ?>
    </span>
    <span class="bg-orange-100 text-orange-700 flex justify-center items-center w-1/2 h-full text-base font-bold rounded-lg">
        ₹<?php echo number_format($product['min_price'] ?? 0, 2); ?>
    </span>
</div>

                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    const sliders = document.getElementById('scrollablesRow');
    let isDowns = false;
    let startXs;
    let scrollLeft;

    sliders.addEventListener('mousedown', (e) => {
        isDowns = true;
        sliders.classList.add('cursor-grabbing');
        startXs = e.pageX - sliders.offsetLeft;
        scrollLeft = sliders.scrollLeft;
    });

    sliders.addEventListener('mouseleave', () => {
        isDowns = false;
        sliders.classList.remove('cursor-grabbing');
    });

    sliders.addEventListener('mouseup', () => {
        isDowns = false;
        sliders.classList.remove('cursor-grabbing');
    });

    sliders.addEventListener('mousemove', (e) => {
        if (!isDowns) return;
        e.preventDefault();
        const x = e.pageX - sliders.offsetLeft;
        const walk = (x - startXs) * 2;
        sliders.scrollLeft = scrollLeft - walk;
    });

    sliders.addEventListener('mouseenter', () => {
        scrollIntervals = setInterval(() => {
            sliders.scrollLeft += 1;
            if (sliders.scrollLeft + sliders.offsetWidth >= sliders.scrollWidth) {
                sliders.scrollLeft = 0;
            }
        }, 10);
    });

    sliders.addEventListener('mouseleave', () => {
        clearInterval(scrollIntervals);
    });
</script>