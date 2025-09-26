<?php
// Start output buffering to prevent stray output
ob_start();

// Set JSON content type
header('Content-Type: application/json');

require('config.php'); // Same directory
require('razorpay-php/Razorpay.php'); // Assumes razorpay-php folder is in /order

use Razorpay\Api\Api;
use Razorpay\Api\Errors\BadRequestError;

try {
    // Check if Razorpay SDK is loaded
    if (!class_exists('Razorpay\Api\Api')) {
        throw new Exception('Razorpay SDK not found. Ensure razorpay-php/Razorpay.php is in the order/razorpay-php directory.');
    }

    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    // Get JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data || !isset($data['amount']) || !isset($data['orderId'])) {
        throw new Exception('Invalid request data: ' . ($input ?: 'No input received'));
    }
    
    $amount = floatval($data['amount']);
    $orderId = sanitizeInput($data['orderId']);
    
    if ($amount <= 0) {
        throw new Exception('Invalid amount: ' . $amount);
    }
    
    if (empty($orderId)) {
        throw new Exception('Invalid order ID: ' . $orderId);
    }
    
    // Validate amount format (positive number with up to 2 decimal places)
    if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
        throw new Exception('Invalid amount format: ' . $amount);
    }
    
    // Create Razorpay order
    try {
        $order = $api->order->create([
            'receipt' => $orderId,
            'amount' => $amount * 100, // Convert to paise
            'currency' => 'INR',
            'payment_capture' => 1
        ]);
        
        // Clear output buffer and send JSON response
        ob_end_clean();
        echo json_encode([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'amount' => $order->amount,
                'currency' => $order->currency,
                'receipt' => $orderId
            ]
        ]);
    } catch (BadRequestError $e) {
        throw new Exception('Razorpay API error: ' . $e->getMessage());
    }
    
} catch (Exception $e) {
    // Log error and clear output buffer
    error_log("Create Order Error: " . $e->getMessage() . " | Input: " . $input);
    ob_end_clean();
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'inputReceived' => $input
    ]);
}

// Ensure no trailing output
exit();
?>