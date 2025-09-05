<?php
session_start();

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    $product = [
        "id" => $_POST['id'],
        "name" => $_POST['name'],
        "price" => (float)$_POST['price'],
        "quantity" => (int)$_POST['quantity'],
        "weight" => $_POST['weight'],
        "image" => $_POST['image'] ?? "https://via.placeholder.com/80"
    ];
    $_SESSION['cart'][] = $product;

    // Redirect to avoid form resubmission
    header("Location: cart.php");
    exit;
}

// Remove product
if (isset($_POST['remove_index'])) {
    $removeIndex = (int)$_POST['remove_index'];
    if (isset($_SESSION['cart'][$removeIndex])) {
        unset($_SESSION['cart'][$removeIndex]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Handle AJAX quantity update
if (isset($_POST['action']) && $_POST['action'] === 'update_qty' && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $index => $qty) {
        if (isset($_SESSION['cart'][$index])) {
            $_SESSION['cart'][$index]['quantity'] = max(1, (int)$qty);
        }
    }
    // Recalculate totals
    $grandTotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $grandTotal += $item['price'] * $item['quantity'];
    }
    $_SESSION['subtotal'] = $grandTotal;
    $_SESSION['shipping'] = 10;
    $_SESSION['total'] = $grandTotal + 10;

    // Return JSON for AJAX
    if (isset($_POST['ajax'])) {
        echo json_encode([
            'subtotal' => $_SESSION['subtotal'],
            'shipping' => $_SESSION['shipping'],
            'total' => $_SESSION['total']
        ]);
        exit;
    }
}

// Function to calculate totals
function calculate_totals() {
    $grandTotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $grandTotal += $item['price'] * $item['quantity'];
    }
    $_SESSION['subtotal'] = $grandTotal;
    $_SESSION['shipping'] = 10;
    $_SESSION['total'] = $grandTotal + 10;
}

calculate_totals();

// Proceed to checkout
if (isset($_POST['checkout'])) {
    header("Location: checkout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body class="sm:px-[5vw] md:px-[7vw] lg:px-[9vw]">


    <?php include("include/header.php") ?>

    <div class="my-10">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">YOUR <span class="text-green-600">CART</span></h1>

        <?php if (!empty($_SESSION['cart'])): ?>
        <form id="cartForm" method="post">
            <div class="space-y-6" id="cartItems">
                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <div class="flex items-center bg-white p-4 rounded shadow justify-between cart-row"
                    data-index="<?= $index ?>" data-price="<?= $item['price'] ?>">
                    <!-- Product Info -->
                    <div class="flex items-center space-x-4">
                        <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>"
                            class="w-20 h-20 object-cover rounded">
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800">
                                <?= $item['name'] ?>
                            </h3>
                            <p class="text-gray-600">₹
                                <?= number_format($item['price'], 2) ?> |
                                <?= $item['weight'] ?>
                            </p>
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="flex items-center space-x-2">
                        <button type="button" class="decrease px-2 py-1 bg-gray-200 rounded">-</button>
                        <input type="number" name="quantities[<?= $index ?>]" value="<?= $item['quantity'] ?>" min="1"
                            class="border rounded px-3 py-1 w-20 text-center qty-input">
                        <button type="button" class="increase px-2 py-1 bg-gray-200 rounded">+</button>
                    </div>

                    <!-- Line Total -->
                    <div class="font-semibold text-gray-700 line-total">
                        ₹
                        <?= number_format($item['price'] * $item['quantity'], 2) ?>
                    </div>

                    <!-- Remove -->
                    <div>
                        <button type="submit" name="remove_index" value="<?= $index ?>"
                            class="text-red-500 hover:text-red-700">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Totals -->
            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2"></div>
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-bold mb-4">CART TOTAL</h2>
                    <div class="flex justify-between py-2 border-b">
                        <span>Subtotal</span>
                        <span id="subtotal">₹
                            <?= number_format($_SESSION['subtotal'], 2) ?>
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span>Shipping fee</span>
                        <span id="shipping">₹
                            <?= number_format($_SESSION['shipping'], 2) ?>
                        </span>
                    </div>
                    <div class="flex justify-between py-2 font-bold">
                        <span>Total</span>
                        <span id="total">₹
                            <?= number_format($_SESSION['total'], 2) ?>
                        </span>
                    </div>

                    <div class="space-y-3 mt-4">
                        <button type="submit" name="checkout"
                            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <?php else: ?>
        <p class="text-gray-600">Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <?php include("include/footer.php") ?>

    <script>
        const shippingFee = 10;

        // Update totals visually
        function updateTotals() {
            let subtotal = 0;
            document.querySelectorAll(".cart-row").forEach(row => {
                const price = parseFloat(row.dataset.price);
                const qtyInput = row.querySelector(".qty-input");
                let qty = parseInt(qtyInput.value);
                if (qty < 1) qty = 1;
                qtyInput.value = qty;

                const lineTotal = price * qty;
                row.querySelector(".line-total").textContent = "₹" + lineTotal.toFixed(2);
                subtotal += lineTotal;
            });

            document.getElementById("subtotal").textContent = "₹" + subtotal.toFixed(2);
            document.getElementById("shipping").textContent = "₹" + shippingFee.toFixed(2);
            document.getElementById("total").textContent = "₹" + (subtotal + shippingFee).toFixed(2);
        }

        // Sync quantities to PHP via AJAX
        function syncQuantities() {
            const formData = new FormData();
            formData.append('action', 'update_qty');
            formData.append('ajax', 1);

            document.querySelectorAll(".qty-input").forEach(input => {
                formData.append(input.name, input.value);
            });

            fetch("", { method: "POST", body: formData })
                .then(res => res.json())
                .then(data => {
                    document.getElementById("subtotal").textContent = "₹" + parseFloat(data.subtotal).toFixed(2);
                    document.getElementById("shipping").textContent = "₹" + parseFloat(data.shipping).toFixed(2);
                    document.getElementById("total").textContent = "₹" + parseFloat(data.total).toFixed(2);
                })
                .catch(err => console.error(err));
        }

        // Event listeners
        document.querySelectorAll(".increase").forEach(btn => {
            btn.addEventListener("click", () => {
                const input = btn.parentElement.querySelector(".qty-input");
                input.value = parseInt(input.value) + 1;
                updateTotals();
                syncQuantities();
            });
        });

        document.querySelectorAll(".decrease").forEach(btn => {
            btn.addEventListener("click", () => {
                const input = btn.parentElement.querySelector(".qty-input");
                if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
                updateTotals();
                syncQuantities();
            });
        });

        document.querySelectorAll(".qty-input").forEach(input => {
            input.addEventListener("change", () => {
                if (input.value < 1) input.value = 1;
                updateTotals();
                syncQuantities();
            });
        });

        // Initial totals
        updateTotals();
    </script>
</body>

</html>