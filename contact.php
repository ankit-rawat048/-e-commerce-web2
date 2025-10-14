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
        <!-- Hero Section -->
        <div class="bg-green-100 w-full">
            <img src="./images/herbal_page-0003.jpg" id="bgImg" class="w-full" alt="hero-img">
        </div>
        <!-- Contact Heading -->
        <section class="text-center">
            <h3 class="text-2xl font-bold text-green-600">CONTACT US</h3>
            <div class="w-16 h-1 bg-green-600 mx-auto mt-2"></div>
        </section>

        <!-- Contact Info & Image -->
        <section
            class="flex flex-col lg:flex-row items-start gap-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 max-w-6xl mx-auto mt-10 p-6">

            <!-- Info -->
            <div class="w-full lg:w-1/2 space-y-4 text-gray-700">
                <h3 class="text-2xl font-bold text-green-600">Our Store</h3>
                <div class="space-y-1">
                    <p class="text-base">Shop No. 2, Ram Jhula, Swarg Ashram Rishikesh</p>
                    <p class="text-base">Uttarakhand 249304</p>
                </div>

                <div class="space-y-1 mt-4">
                    <p><span class="font-semibold">Tel:</span> will be shared soon</p>
                    <p><span class="font-semibold">Email:</span> will be shared soon</p>
                </div>
            </div>

            <!-- Map location -->
            <div class="w-full lg:w-1/2 h-64 lg:h-80 rounded-xl overflow-hidden shadow-md">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d27608.195142008146!2d78.28660978097336!3d30.122115489830332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3909163f9ef61bbb%3A0xed99e60b4c11e008!2sShri%20Ganga%20Ayurveda%20Store!5e0!3m2!1sen!2sin!4v1760418609351!5m2!1sen!2sin"
                    class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </section>



    </main>

    <!-- Subscribe Section -->
    <?php include("include/subscribe.php") ?>

    <!-- Footer -->
    <?php include("include/footer.php") ?>

</body>

</html>