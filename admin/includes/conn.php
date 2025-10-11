<?php
session_start();
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'u713383587_shriganga');
// define('DB_USER', 'u713383587_ashu');
// define('DB_PASS', '5pC!|GVyU14B');

define('DB_HOST', 'localhost');
define('DB_NAME', 'shriganga');
define('DB_USER', 'root');
define('DB_PASS', '');

//admin details: 
// Email: admin@shrigangaherbal.com
// Pass: @admin@shrigangaherbal@1726

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>