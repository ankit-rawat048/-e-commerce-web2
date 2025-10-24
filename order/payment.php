<?php
require('config.php'); // Same directory
require('razorpay-php/Razorpay.php'); // Assumes razorpay-php folder is in /order

use Razorpay\Api\Api;

$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Shri Ganga</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 20px rgba(0,0,0,0.5);
            overflow-x: auto;
        }
        
        .header {
            background: white;
            color: black;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .content {
            padding: 30px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section h2 {
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #f37254;
            padding-bottom: 5px;
        }
        
        .customer-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .cart-table th,
        .cart-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .cart-table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .pricing-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin-left: auto;
        }
        
        .pricing-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .total-row {
            border-top: 2px solid #333;
            padding-top: 10px;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .pay-button {
            background: linear-gradient(90deg, #f37254, #fba919);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 10px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin: 30px auto 0;
            min-width: 200px;
        }
        
        .pay-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(243, 114, 84, 0.4);
        }
        
        .pay-button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .loading {
            text-align: center;
            padding: 50px;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #f37254;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 10px;
            }
            
            .content {
                padding: 20px;
            }
            
            .cart-table {
                font-size: 14px;
            }
            
            .cart-table th,
            .cart-table td {
                padding: 8px;
            }
            
            .product-img {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Complete Your Payment</h1>
            <p>Review your order and proceed to payment</p>
        </div>
        
        <div class="content">
            <div id="loading" class="loading">
                <div class="spinner"></div>
                <p>Loading your order details...</p>
            </div>
            
            <div id="error" class="error-message" style="display: none;">
                <p id="error-message">Unable to load order details. Please go back and try again.</p>
                <button onclick="window.history.back()" class="pay-button" style="margin-top: 15px;">Go Back</button>
            </div>
            
            <div id="order-content" style="display: none;">
                <!-- Customer Information -->
                <div class="section">
                    <h2>Customer Information</h2>
                    <div id="customer-info" class="customer-info">
                        <!-- Customer details will be loaded here -->
                    </div>
                </div>
                
                <!-- Order Items -->
                <div class="section">
                    <h2>Order Items</h2>
                    <table id="cart-table" class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            <!-- Cart items will be loaded here -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Pricing Summary -->
                <div class="section">
                    <div id="pricing-summary" class="pricing-summary">
                        <!-- Pricing details will be loaded here -->
                    </div>
                </div>
                
                <!-- Payment Button -->
                <button id="pay-button" class="pay-button" onclick="initiatePayment()">
                    Proceed to Payment
                </button>
            </div>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        const csrfToken = '<?php echo generateCSRFToken(); ?>';
        let orderData = null;
        
        // Load order data from localStorage
        function loadOrderData() {
            try {
                const storedData = localStorage.getItem('orderData');
                const timestamp = localStorage.getItem('orderTimestamp');
                
                if (!storedData || !timestamp) {
                    throw new Error('No order data found in localStorage');
                }
                
                // Check if data is not too old (24 hours)
                const now = Date.now();
                const dataAge = now - parseInt(timestamp);
                if (dataAge > 24 * 60 * 60 * 1000) {
                    throw new Error('Order data has expired');
                }
                
                orderData = JSON.parse(storedData);
                
                // Validate orderData structure
                if (!orderData.orderId || !orderData.pricing || !orderData.pricing.total || !orderData.customerInfo) {
                    throw new Error('Invalid order data structure: ' + JSON.stringify(orderData));
                }
                
                console.log('Order Data:', orderData);
                displayOrderData();
                
            } catch (error) {
                console.error('Error loading order data:', error);
                document.getElementById('error-message').innerText = error.message;
                document.getElementById('loading').style.display = 'none';
                document.getElementById('error').style.display = 'block';
            }
        }
        
        // Display order data in the page
        function displayOrderData() {
            if (!orderData) return;
            
            // Customer Information
            const customerInfo = document.getElementById('customer-info');
            customerInfo.innerHTML = `
                <div class="info-row">
                    <span><strong>Name:</strong></span>
                    <span>${orderData.customerInfo.firstName} ${orderData.customerInfo.lastName}</span>
                </div>
                <div class="info-row">
                    <span><strong>Email:</strong></span>
                    <span>${orderData.customerInfo.email}</span>
                </div>
                <div class="info-row">
                    <span><strong>Phone:</strong></span>
                    <span>${orderData.customerInfo.phone}</span>
                </div>
                <div class="info-row">
                    <span><strong>Address:</strong></span>
                    <span>${orderData.customerInfo.street}, ${orderData.customerInfo.city}, ${orderData.customerInfo.state} ${orderData.customerInfo.postalCode}, ${orderData.customerInfo.country}</span>
                </div>
                <div class="info-row">
                    <span><strong>Payment Method:</strong></span>
                    <span>${orderData.paymentMethod.toUpperCase()}</span>
                </div>
            `;
            
            // Cart Items
            const cartItems = document.getElementById('cart-items');
            cartItems.innerHTML = orderData.cartItems.map(item => `
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <img src="${item.image}" alt="${item.productName}" class="product-img">
                            <span>${item.productName}</span>
                        </div>
                    </td>
                    <td>${item.size}</td>
                    <td>${item.quantity}</td>
                    <td>${orderData.pricing.currency}${item.unitPrice.toFixed(2)}</td>
                    <td>${orderData.pricing.currency}${item.totalPrice.toFixed(2)}</td>
                </tr>
            `).join('');
            
            // Pricing Summary
            const pricingSummary = document.getElementById('pricing-summary');
            pricingSummary.innerHTML = `
                <div class="pricing-row">
                    <span>Subtotal:</span>
                    <span>${orderData.pricing.currency}${orderData.pricing.subtotal.toFixed(2)}</span>
                </div>
                <div class="pricing-row">
                    <span>Delivery Fee:</span>
                    <span>${orderData.pricing.currency}${orderData.pricing.deliveryFee.toFixed(2)}</span>
                </div>
                <div class="pricing-row total-row">
                    <span>Total:</span>
                    <span>${orderData.pricing.currency}${orderData.pricing.total.toFixed(2)}</span>
                </div>
            `;
            
            // Show content and hide loading
            document.getElementById('loading').style.display = 'none';
            document.getElementById('order-content').style.display = 'block';
            
            // If COD, change button text
            if (orderData.paymentMethod === 'cod') {
                document.getElementById('pay-button').innerHTML = 'Confirm Order (Cash on Delivery)';
            }
        }
        
        // Initiate payment
        function initiatePayment() {
            if (!orderData) {
                alert('No order data available. Please try again.');
                return;
            }
            
            if (orderData.paymentMethod === 'cod') {
                submitOrder(null, 'cod');
                return;
            }
            
            const payButton = document.getElementById('pay-button');
            payButton.disabled = true;
            payButton.innerHTML = 'Processing...';
            
            const totalAmount = parseFloat(orderData.pricing.total);
            console.log('Total Amount:', totalAmount, 'Order ID:', orderData.orderId);
            
            if (isNaN(totalAmount) || totalAmount <= 0) {
                alert('Invalid order amount: ' + orderData.pricing.total);
                payButton.disabled = false;
                payButton.innerHTML = 'Proceed to Payment';
                return;
            }
            
            if (!orderData.orderId) {
                alert('Invalid order ID: ' + orderData.orderId);
                payButton.disabled = false;
                payButton.innerHTML = 'Proceed to Payment';
                return;
            }
            
            fetch('<?php echo APP_URL; ?>/order/create_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    amount: totalAmount,
                    orderId: orderData.orderId
                })
            })
            .then(response => {
                console.log('Fetch Response Status:', response.status);
                console.log('Fetch Response Headers:', [...response.headers.entries()]);
                // Log raw response text for debugging
                return response.text().then(text => {
                    console.log('Raw Response Text:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error('Invalid JSON response: ' + e.message);
                    }
                });
            })
            .then(data => {
                console.log('Fetch Response Data:', data);
                if (data.success && data.order && data.order.amount) {
                    openRazorpay(data.order);
                } else {
                    alert('Failed to create payment order: ' + (data.message || 'Unknown error') + (data.inputReceived ? ' (Input: ' + data.inputReceived + ')' : ''));
                    payButton.disabled = false;
                    payButton.innerHTML = 'Proceed to Payment';
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                alert('Payment initialization failed: ' + error.message);
                payButton.disabled = false;
                payButton.innerHTML = 'Proceed to Payment';
            });
        }
        
        // Open Razorpay payment interface
        function openRazorpay(order) {
            console.log('Razorpay Order:', order);
            const options = {
                key: '<?php echo RAZORPAY_KEY_ID; ?>',
                amount: order.amount,
                currency: order.currency,
                name: '<?php echo APP_NAME; ?>',
                description: 'Order Payment (ID: ' + order.receipt + ')',
                order_id: order.id,
                prefill: {
                    name: `${orderData.customerInfo.firstName} ${orderData.customerInfo.lastName}`,
                    email: orderData.customerInfo.email,
                    contact: orderData.customerInfo.phone
                },
                theme: {
                    color: '#f37254'
                },
                handler: function(response) {
                    console.log('Payment Response:', response);
                    submitOrder(response, 'razorpay');
                },
                modal: {
                    ondismiss: function() {
                        console.log('Razorpay modal dismissed');
                        const payButton = document.getElementById('pay-button');
                        payButton.disabled = false;
                        payButton.innerHTML = 'Proceed to Payment';
                    }
                }
            };
            
            const rzp = new Razorpay(options);
            rzp.open();
        }
        
        // Submit order to backend
        function submitOrder(paymentResponse, paymentMethod) {
            const submitData = {
                orderData: orderData,
                paymentResponse: paymentResponse,
                paymentMethod: paymentMethod
            };
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'process_order.php';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'orderData';
            input.value = JSON.stringify(submitData);
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = csrfToken;
            
            form.appendChild(input);
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
        
        // Load data when page loads
        window.onload = function() {
            loadOrderData();
        };
    </script>
</body>
</html>