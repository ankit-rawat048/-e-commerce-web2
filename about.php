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

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto py-12 space-y-12">

        <!-- About Section -->
        <section class="text-center">
            <p class="text-green-600 font-semibold mb-2">ABOUT US</p>
            <div class="w-16 h-1 bg-green-600 mx-auto mb-8"></div>
        </section>

        <!-- Image and Text -->
        <section class="flex flex-col md:flex-row items-center gap-8">
            <img src="images/logo.png" alt="aboutImg"
                class="w-full md:w-1/2 object-cover">

            <div class="md:w-1/2 space-y-4 px-[1rem] text-gray-700">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda natus excepturi doloribus
                    voluptates repellendus optio doloremque earum mollitia alias voluptatibus maxime obcaecati, odio
                    labore. Dolorum quas illo enim aliquam optio dolor vero fuga, corrupti expedita odio beatae quae
                    eligendi assumenda accusantium nemo commodi! Nobis, animi!</p>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe libero magnam ad! Fugit sequi aliquid
                    dolorem nam consequuntur, vero quisquam, ducimus maiores quaerat ipsa vel dolorum necessitatibus
                    laboriosam. Alias inventore nesciunt id libero veritatis aliquid debitis quaerat quo, nostrum
                    placeat!</p>

                <h3 class="text-lg font-semibold text-green-600">Our Mission</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis laborum itaque magni asperiores,
                    dolore dolor quas autem laboriosam ea quam minima aperiam reprehenderit saepe quod veniam, fugiat
                    adipisci accusamus eius iure. Quis, optio magnam quia sed delectus libero molestias tempora.</p>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="space-y-6">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-green-600">WHY CHOOSE US</h3>
                <div class="w-16 h-1 bg-green-600 mx-auto mt-2"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <p class="font-semibold mb-2">Quality Assurance:</p>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus beatae
                        facilis dolore blanditiis debitis illum?</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <p class="font-semibold mb-2">Customer Satisfaction:</p>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus beatae
                        facilis dolore blanditiis debitis illum?</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <p class="font-semibold mb-2">Fast Delivery:</p>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus beatae
                        facilis dolore blanditiis debitis illum?</p>
                </div>
            </div>
        </section>

        <!-- Subscribe Section -->
        <?php include("include/subscribe.php") ?>

    </main>

    <!-- Footer -->
    <?php include("include/footer.php") ?>

</body>

</html>