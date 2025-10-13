<?php
session_start();
require_once 'include/conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayurveda</title>

    <?php include("include/links.php") ?>

    
</head>

<body class="sm:px-[5vw] md:px-[7vw] lg:px-[9vw]">

    <!-- Header -->
    <?php include("include/header.php") ?>

    <!-- Hero Section -->
    <div class="bg-green-100 w-full">
        <img src="./images/herbal_page-0002.jpg" id="bgImg" class="w-full" alt="hero-img">
</div>

    <!-- Latest Collections -->
    <?php include("indexsection/latest.php") ?>

    <!-- Best Sellers -->
    <?php include("indexsection/bestseller.php") ?>

    <!-- Categories Page -->
    <section class="py-16 bg-gray-200">
        <div class="max-w-6xl mx-auto lg:px-6">
            <h1 class="border-b-2 border-black text-center text-3xl font-bold main-title">CATEGORIES</h1>
            <?php include("include/scrollableproduct.php") ?>
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

    <!-- Hero Section -->
    <div class="bg-green-100 w-full">
        <img src="./images/herbal_page-0003.jpg" id="bgImg" class="w-full" alt="hero-img">
</div>

    <!-- Subscribe Section -->
    <?php include("include/subscribe.php") ?>

    <!-- Footer -->
    <?php include("include/footer.php") ?>

    <!-- JS Function -->
    <script>
        function scrollGallery(button, direction) {
            const wrapper = button.closest(".gallery-wrapper");
            if (!wrapper) return;
            const gallery = wrapper.querySelector(".gallery");
            if (!gallery) return;

            const items = gallery.children.length;
            if (items === 0) return;

            const itemWidth = gallery.children[0].offsetWidth + 16;
            let visibleItems;
            if (window.innerWidth < 640) {
                visibleItems = 2;
            } else if (window.innerWidth < 930) {
                visibleItems = 3;
            } else {
                visibleItems = 4;
            }
            const maxIndex = items - visibleItems;

            if (!wrapper.dataset.index) wrapper.dataset.index = 0;
            let currentIndex = parseInt(wrapper.dataset.index);

            currentIndex += direction;
            if (currentIndex < 0) currentIndex = 0;
            if (currentIndex > maxIndex) currentIndex = maxIndex;

            wrapper.dataset.index = currentIndex;
            gallery.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
        }
    </script>

    <!-- Optional CSS to hide scrollbar -->
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

</body>
</html>
