<?php
require_once 'include/conn.php';

// Fetch latest products with lowest price from product_variants
$stmt = $pdo->query("SELECT p.id, p.name, p.image, p.brand_name, MIN(v.price) AS min_price
                     FROM products p
                     LEFT JOIN product_variants v ON p.id = v.product_id
                     GROUP BY p.id, p.name, p.image, p.brand_name
                     ORDER BY p.created_at DESC 
                     LIMIT 10");
$latest_products = $stmt->fetchAll();
?>

<!-- Latest Collections -->
<section class="py-16 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-center mb-6 space-x-3">
            <h1 class="border-b-2 text-center text-3xl font-bold">LATEST COLLECTIONS</h1>
        </div>

        <!-- Horizontal Scrollable Row -->
        <div class="overflow-x-auto no-scrollbar cursor-grab" id="scrollableRow">
            <div id="scrollContent" class="flex gap-6 p-[1rem]">
                <?php foreach ($latest_products as $product): ?>
                    <a href="product.php?id=<?php echo htmlspecialchars($product['id']); ?>"
                       class="bg-white rounded-2xl shadow-lg p-4 flex flex-col items-center min-w-[12rem] max-w-[14rem] flex-shrink-0 transform transition hover:scale-105 hover:shadow-2xl border-2 border-green-800">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>"
                             class="w-full h-40 object-contain mb-4 rounded-lg border-2 border-blue-800 p-1 bg-gray-50">
                        <hr class="w-full border-2 border-orange-400">
                        <p class="font-semibold text-center text-gray-800 text-sm md:text-base">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </p>
                        <div class="flex items-center w-full mt-auto gap-2">
                            <span class="bg-gray-200 text-gray-700 p-2 w-[50%] text-center text-xs md:text-sm">
                                <?php echo htmlspecialchars($product['brand_name'] ?? 'Shri Ganga Herbal'); ?>
                            </span>
                            <span class="bg-orange-100 text-orange-700 flex justify-center items-center w-[50%] h-[100%] text-[1rem] font-bold">
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
    const slider = document.getElementById('scrollableRow');
    let isDown = false, startX, scrollLeft;

    slider.addEventListener('mousedown', e => {
        isDown = true;
        slider.classList.add('cursor-grabbing');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('cursor-grabbing');
    });
    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('cursor-grabbing');
    });
    slider.addEventListener('mousemove', e => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        slider.scrollLeft = scrollLeft - (x - startX) * 2;
    });

    let scrollAmount = 2;
    let autoScroll = setInterval(() => {
        slider.scrollLeft += scrollAmount;
        if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth) {
            clearInterval(autoScroll);
        }
    }, 20);
</script>