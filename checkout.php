<?php
session_start();

// Fetch totals from session (default to 0 if not set)
$subtotal = $_SESSION['subtotal'] ?? 0;
$shipping = $_SESSION['shipping'] ?? 0;
$total    = $_SESSION['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="sm:px-[5vw] md:px-[7vw] lg:px-[9vw]">


    <!-- Header -->
    <?php include("include/header.php") ?>

    <div class="max-w-6xl mx-auto py-10 grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Delivery Information -->
        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-6 border-b pb-2">DELIVERY INFORMATION</h2>

            <form class="space-y-5" method="post" action="place_order.php">
                <!-- Name -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <input type="text" name="firstName" placeholder="First Name"
                        class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                        required>
                    <input type="text" name="lastName" placeholder="Last Name"
                        class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                        required>
                </div>

                <!-- Email + Street -->
                <input type="email" name="email" placeholder="Email Address"
                    class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                    required>
                <input type="text" name="street" placeholder="Street Address"
                    class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                    required>

                <!-- City + State + Zip + Country -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <input type="text" name="city" placeholder="City"
                        class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                        required>
                    <input type="text" name="state" placeholder="State"
                        class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                        required>
                    <input type="text" name="zipcode" placeholder="Zip Code"
                        class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                        required>
                    <input type="text" name="country" placeholder="Country"
                        class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                        required>
                </div>

                <!-- Phone -->
                <input type="number" name="phone" placeholder="Phone Number"
                    class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                    required>
        </div>

        <!-- Cart Total + Payment -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-6 border-b pb-2">CART TOTAL</h2>

            <div class="space-y-3 mb-6">
                <div class="flex justify-between text-gray-700">
                    <span>Subtotal</span>
                    <span>₹
                        <?= number_format($subtotal, 2) ?>
                    </span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Shipping fee</span>
                    <span>₹
                        <?= number_format($shipping, 2) ?>
                    </span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span>₹
                        <?= number_format($total, 2) ?>
                    </span>
                </div>
            </div>

            <!-- Payment Method -->
            <h3 class="text-lg font-semibold mb-3 border-b pb-1">PAYMENT METHOD</h3>
            <div class="space-y-3 mb-6">
                <label class="flex items-center space-x-3">
                    <input type="radio" name="payment" value="razorpay" class="w-5 h-5 text-green-600" required>
                    <span>RAZORPAY (Card/UPI/Netbanking)</span>
                </label>
                <label class="flex items-center space-x-3">
                    <input type="radio" name="payment" value="cod" class="w-5 h-5 text-green-600" required>
                    <span>CASH ON DELIVERY</span>
                </label>
            </div>

            <!-- Place Order Button -->
            <button type="submit"
                class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                PLACE ORDER
            </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include("include/footer.php") ?>

</body>

</html>