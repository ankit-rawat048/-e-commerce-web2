<?php
require('config.php'); // Same directory
require('razorpay-php/Razorpay.php'); // Assumes razorpay-php folder is in /order

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

try {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        throw new Exception('Invalid CSRF token');
    }
    
    // Get and validate POST data
    if (!isset($_POST['orderData'])) {
        throw new Exception('Order data not received');
    }
    
    $submitData = json_decode($_POST['orderData'], true);
    if (!$submitData) {
        throw new Exception('Invalid order data format');
    }
    
    $orderData = $submitData['orderData'];
    $paymentResponse = $submitData['paymentResponse'];
    $paymentMethod = $submitData['paymentMethod'];
    
    // Validate order data structure
    if (!isset($orderData['customerInfo']) || !isset($orderData['cartItems']) || !isset($orderData['pricing'])) {
        throw new Exception('Incomplete order data');
    }
    
    $customerInfo = $orderData['customerInfo'];
    $cartItems = $orderData['cartItems'];
    $pricing = $orderData['pricing'];
    
    // Validate required customer information
    $requiredFields = ['firstName', 'lastName', 'email', 'street', 'city', 'state', 'postalCode', 'country'];
    foreach ($requiredFields as $field) {
        if (empty($customerInfo[$field])) {
            throw new Exception("Missing customer information: $field");
        }
    }
    
    // Validate email
    if (!validateEmail($customerInfo['email'])) {
        throw new Exception('Invalid email address');
    }
    
    // Validate phone
    if (!isset($customerInfo['phone']) || !validatePhone($customerInfo['phone'])) {
        throw new Exception('Invalid phone number');
    }
    
    // Validate cart items
    if (empty($cartItems) || !is_array($cartItems)) {
        throw new Exception('No items in cart');
    }
    
    // Validate pricing
    if (!isset($pricing['total']) || $pricing['total'] <= 0) {
        throw new Exception('Invalid total amount');
    }
    
    $paymentId = null;
    $razorpayOrderId = null;
    $paymentStatus = PAYMENT_STATUS_PENDING;
    
    // Process payment based on method
    if ($paymentMethod === 'razorpay') {
        if (!$paymentResponse || !isset($paymentResponse['razorpay_payment_id'])) {
            throw new Exception('Payment response not received');
        }
        
        // Verify Razorpay payment signature
        $attributes = [
            'razorpay_order_id' => $paymentResponse['razorpay_order_id'],
            'razorpay_payment_id' => $paymentResponse['razorpay_payment_id'],
            'razorpay_signature' => $paymentResponse['razorpay_signature']
        ];
        
        try {
            $api->utility->verifyPaymentSignature($attributes);
        } catch (SignatureVerificationError $e) {
            throw new Exception('Payment signature verification failed: ' . $e->getMessage());
        }
        
        // Get payment details
        $payment = $api->payment->fetch($paymentResponse['razorpay_payment_id']);
        
        if ($payment['status'] !== 'captured') {
            throw new Exception('Payment not successful: ' . $payment['status']);
        }
        
        $paymentId = $paymentResponse['razorpay_payment_id'];
        $razorpayOrderId = $paymentResponse['razorpay_order_id'];
        $paymentStatus = PAYMENT_STATUS_PAID;
        
    } elseif ($paymentMethod === 'cod') {
        $paymentStatus = PAYMENT_STATUS_COD;
    } else {
        throw new Exception('Invalid payment method: ' . $paymentMethod);
    }
    
    // Begin database transaction
    $pdo->beginTransaction();
    
    try {
        // Insert main order
        $stmt = $pdo->prepare("
            INSERT INTO orders (
                order_id, customer_name, customer_email, customer_phone, customer_address,
                subtotal, delivery_fee, total_amount, payment_method, payment_status,
                payment_id, razorpay_order_id, created_at, updated_at
            ) VALUES (
                :order_id, :customer_name, :customer_email, :customer_phone, :customer_address,
                :subtotal, :delivery_fee, :total_amount, :payment_method, :payment_status,
                :payment_id, :razorpay_order_id, NOW(), NOW()
            )
        ");
        
        $customerName = sanitizeInput($customerInfo['firstName'] . ' ' . $customerInfo['lastName']);
        $customerAddress = sanitizeInput(
            $customerInfo['street'] . ', ' . $customerInfo['city'] . ', ' . 
            $customerInfo['state'] . ' ' . $customerInfo['postalCode'] . ', ' . 
            $customerInfo['country']
        );
        
        $stmt->execute([
            ':order_id' => $orderData['orderId'],
            ':customer_name' => $customerName,
            ':customer_email' => sanitizeInput($customerInfo['email']),
            ':customer_phone' => sanitizeInput($customerInfo['phone']),
            ':customer_address' => $customerAddress,
            ':subtotal' => $pricing['subtotal'],
            ':delivery_fee' => $pricing['deliveryFee'],
            ':total_amount' => $pricing['total'],
            ':payment_method' => $paymentMethod,
            ':payment_status' => $paymentStatus,
            ':payment_id' => $paymentId,
            ':razorpay_order_id' => $razorpayOrderId
        ]);
        
        $orderDbId = $pdo->lastInsertId();
        
        // Insert order items
        $itemStmt = $pdo->prepare("
            INSERT INTO order_items (
                order_id, product_id, product_name, size, quantity, unit_price, total_price, product_image
            ) VALUES (
                :order_id, :product_id, :product_name, :size, :quantity, :unit_price, :total_price, :product_image
            )
        ");
        
        foreach ($cartItems as $item) {
            $itemStmt->execute([
                ':order_id' => $orderDbId,
                ':product_id' => $item['productId'],
                ':product_name' => sanitizeInput($item['productName']),
                ':size' => sanitizeInput($item['size']),
                ':quantity' => $item['quantity'],
                ':unit_price' => $item['unitPrice'],
                ':total_price' => $item['totalPrice'],
                ':product_image' => $item['image']
            ]);
        }
        
        // Commit transaction
        $pdo->commit();
        
        // Log successful order
        error_log("Order Created Successfully: Order ID: " . $orderData['orderId'] . ", Payment Method: " . $paymentMethod . ", Amount: " . $pricing['total']);
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Database error: " . $e->getMessage() . " | Order ID: " . $orderData['orderId']);
        throw new Exception('Failed to save order. Please contact support at ' . SUPPORT_EMAIL);
    }
    
    // Success - redirect to thank you page
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Successful - <?php echo APP_NAME; ?></title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                margin: 0;
                padding: 20px;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .success-container {
                background: white;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                text-align: center;
                max-width: 600px;
                width: 100%;
            }
            .success-icon {
                width: 100px;
                height: 100px;
                background: #4CAF50;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 30px;
                font-size: 50px;
                color: white;
            }
            .success-title {
                color: #4CAF50;
                font-size: 2.5rem;
                margin-bottom: 15px;
                font-weight: bold;
            }
            .success-message {
                color: #666;
                font-size: 1.2rem;
                margin-bottom: 30px;
                line-height: 1.6;
            }
            .order-details {
                background: #f8f9fa;
                padding: 25px;
                border-radius: 10px;
                margin-bottom: 30px;
                text-align: left;
            }
            .detail-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 12px;
                padding-bottom: 8px;
                border-bottom: 1px solid #eee;
            }
            .detail-row:last-child {
                border-bottom: none;
                margin-bottom: 0;
            }
            .detail-label {
                font-weight: bold;
                color: #333;
            }
            .detail-value {
                color: #666;
            }
            .amount-highlight {
                color: #4CAF50;
                font-weight: bold;
                font-size: 1.3rem;
            }
            .contact-info {
                background: #e8f5e8;
                color: #2e7d32;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 30px;
            }
            .contact-info h3 {
                margin-bottom: 10px;
                color: #1b5e20;
            }
            .whatsapp-number {
                font-weight: bold;
                font-size: 1.1rem;
            }
            .home-button {
                background: linear-gradient(90deg, #f37254, #fba919);
                color: white;
                border: none;
                padding: 15px 30px;
                border-radius: 10px;
                font-size: 1rem;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                transition: all 0.3s ease;
                margin: 0 10px;
            }
            .home-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(243, 114, 84, 0.4);
            }
            @media (max-width: 600px) {
                .success-container {
                    padding: 30px 20px;
                    margin: 0 10px;
                }
                .success-title {
                    font-size: 2rem;
                }
                .detail-row {
                    flex-direction: column;
                    align-items: flex-start;
                }
                .detail-value {
                    margin-top: 5px;
                }
            }
        </style>
    </head>
    <body>
        <div class="success-container">
            <div class="success-icon">✓</div>
            <h1 class="success-title">Order Successful!</h1>
            <p class="success-message">
                Thank you for your order! We have received your order and will process it shortly.
            </p>
            
            <div class="order-details">
                <div class="detail-row">
                    <span class="detail-label">Order ID:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($orderData['orderId']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Customer Name:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($customerInfo['firstName'] . ' ' . $customerInfo['lastName']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($customerInfo['email']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($customerInfo['phone']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value"><?php echo strtoupper($paymentMethod); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Status:</span>
                    <span class="detail-value" style="color: #4CAF50; font-weight: bold;"><?php echo strtoupper($paymentStatus); ?></span>
                </div>
                <?php if ($paymentId): ?>
                <div class="detail-row">
                    <span class="detail-label">Payment ID:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($paymentId); ?></span>
                </div>
                <?php endif; ?>
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value amount-highlight"><?php echo htmlspecialchars($pricing['currency']); ?><?php echo number_format($pricing['total'], 2); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Order Date:</span>
                    <span class="detail-value"><?php echo date('F j, Y - g:i A'); ?></span>
                </div>
            </div>
            
            <div class="contact-info">
                <h3>📞 Order Status Updates</h3>
                <p>We will contact you within <strong>1 hour</strong> on WhatsApp for order status updates.</p>
                <p>WhatsApp Number: <span class="whatsapp-number"><?php echo WHATSAPP_NUMBER; ?></span></p>
                <p>If you don't receive any update within 1 hour, please call us directly.</p>
                <p>Customer Support: <?php echo SUPPORT_PHONE; ?></p>
            </div>
            
            <div>
                <a href="<?php echo APP_URL; ?>" class="home-button">Continue Shopping</a>
                <a href="<?php echo APP_URL; ?>/my-orders" class="home-button">View My Orders</a>
            </div>
        </div>
        
        <script>
            localStorage.removeItem('orderData');
            localStorage.removeItem('orderTimestamp');
            console.log('Order completed successfully. Cart data cleared.');
        </script>
    </body>
    </html>
    <?php
    
} catch(SignatureVerificationError $e) {
    error_log("Payment Verification Failed: " . $e->getMessage() . " | Order ID: " . ($orderData['orderId'] ?? 'unknown'));
    showErrorPage("Payment verification failed. This could indicate a security issue.", "payment-verification-failed");
    
} catch(Exception $e) {
    error_log("Order Processing Error: " . $e->getMessage() . " | Order ID: " . ($orderData['orderId'] ?? 'unknown'));
    showErrorPage($e->getMessage(), "order-processing-error");
}

// Function to show error page
function showErrorPage($message, $errorType) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Failed - <?php echo APP_NAME; ?></title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
                margin: 0;
                padding: 20px;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .error-container {
                background: white;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                text-align: center;
                max-width: 500px;
                width: 100%;
            }
            .error-icon {
                width: 80px;
                height: 80px;
                background: #e74c3c;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px;
                font-size: 40px;
                color: white;
            }
            .error-title {
                color: #e74c3c;
                font-size: 2rem;
                margin-bottom: 10px;
                font-weight: bold;
            }
            .error-message {
                color: #666;
                font-size: 1.1rem;
                margin-bottom: 20px;
            }
            .error-details {
                background: #ffebee;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 30px;
                color: #c62828;
                font-size: 0.9rem;
            }
            .action-buttons {
                display: flex;
                gap: 15px;
                justify-content: center;
                flex-wrap: wrap;
            }
            .action-button {
                background: linear-gradient(90deg, #f37254, #fba919);
                color: white;
                border: none;
                padding: 12px 25px;
                border-radius: 8px;
                font-size: 0.9rem;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                transition: all 0.3s ease;
            }
            .action-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(243, 114, 84, 0.4);
            }
            .contact-info {
                margin-top: 20px;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 8px;
                color: #666;
                font-size: 0.9rem;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-icon">✗</div>
            <h2 class="error-title">Order Failed!</h2>
            <p class="error-message">We're sorry, but we couldn't process your order.</p>
            
            <div class="error-details">
                <strong>Error:</strong> <?php echo htmlspecialchars($message); ?>
            </div>
            
            <div class="action-buttons">
                <a href="<?php echo APP_URL; ?>/order/payment.php" class="action-button">Try Again</a>
                <a href="<?php echo APP_URL; ?>" class="action-button">Go Home</a>
            </div>
            
            <div class="contact-info">
                If you continue to face issues, please contact our support team.<br>
                <strong>Phone:</strong> <?php echo SUPPORT_PHONE; ?><br>
                <strong>Email:</strong> <?php echo SUPPORT_EMAIL; ?>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>