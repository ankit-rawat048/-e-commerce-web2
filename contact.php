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

    <!-- Main Contact Section -->
    <main class="max-w-6xl mx-auto px-4 py-12 space-y-12">

        <!-- Contact Heading -->
        <section class="text-center">
            <h3 class="text-2xl font-bold text-green-600">CONTACT US</h3>
            <div class="w-16 h-1 bg-green-600 mx-auto mt-2"></div>
        </section>

        <!-- Contact Info & Image -->
        <section class="flex flex-col md:flex-row items-center gap-8 bg-white p-6 rounded-lg shadow-lg">

            <!-- Image -->
            <img src="./images/herbal_page-0003.jpg"
                alt="contact image" class="w-full md:w-1/2 rounded-lg shadow-lg object-cover">

            <!-- Info -->
            <div class="md:w-1/2 space-y-6 text-gray-700">
                <div>
                    <h3 class="text-xl font-semibold text-green-600 mb-2">Our Store</h3>
                    <div class="space-y-1">
                        <p>34998 Willms Station</p>
                        <p>Suite 35, Washington, USA</p>
                    </div>
                    <div class="space-y-1 mt-2">
                        <p>Tel: (415) 555-0132</p>
                        <p>Email: admin@forever.com</p>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- Subscribe Section -->
    <?php include("include/subscribe.php") ?>

    <!-- Footer -->
    <?php include("include/footer.php") ?>

</body>

</html>