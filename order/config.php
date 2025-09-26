<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'u713383587_shriganga');
define('DB_USER', 'u713383587_ashu');
define('DB_PASS', '5pC!|GVyU14B');

// Razorpay Configuration
define('RAZORPAY_KEY_ID', 'rzp_live_0IQIdqt2xHZ6ts');
define('RAZORPAY_KEY_SECRET', 'pxDbsQizY5aF48hOQwceK5LN');

// App Configuration
define('APP_NAME', 'Shri Ganga');
define('APP_URL', 'https://shrigangaherbal.com');
define('SUPPORT_EMAIL', 'official@medgallant.com');
define('SUPPORT_PHONE', '+91-7817871726');
define('WHATSAPP_NUMBER', '+91-7817871726');

// Currency
define('CURRENCY', 'INR');
define('CURRENCY_SYMBOL', '₹');

// Default Delivery Fee
define('DEFAULT_DELIVERY_FEE', 50.00);

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 0); // Disable to prevent HTML output
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Database Connection
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection failed. Please contact support at " . SUPPORT_EMAIL);
}

// Helper Functions
function formatCurrency($amount) {
    return CURRENCY_SYMBOL . number_format($amount, 2);
}

function generateOrderId() {
    return 'ORD_' . date('Ymd') . '_' . strtoupper(substr(uniqid(), -6));
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePhone($phone) {
    return preg_match('/^\+?[1-9]\d{9,14}$/', $phone);
}

// Order Status Constants
define('ORDER_STATUS_PENDING', 'pending');
define('ORDER_STATUS_CONFIRMED', 'confirmed');
define('ORDER_STATUS_PROCESSING', 'processing');
define('ORDER_STATUS_SHIPPED', 'shipped');
define('ORDER_STATUS_DELIVERED', 'delivered');
define('ORDER_STATUS_CANCELLED', 'cancelled');

// Payment Status Constants
define('PAYMENT_STATUS_PENDING', 'pending');
define('PAYMENT_STATUS_PAID', 'paid');
define('PAYMENT_STATUS_COD', 'cod');
define('PAYMENT_STATUS_FAILED', 'failed');
define('PAYMENT_STATUS_REFUNDED', 'refunded');

// Security
session_start();

// CSRF Protection
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Set security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
?>