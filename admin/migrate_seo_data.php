<?php
include('includes/conn.php');

$seoFile = "seo_product_seo.json";
if (file_exists($seoFile)) {
    $seoData = json_decode(file_get_contents($seoFile), true);
    try {
        foreach ($seoData as $productName => $seo) {
            $stmt = $pdo->prepare("
                UPDATE products 
                SET brand_name = ?, image = ?, meta_title = ?, meta_description = ?, meta_keywords = ?
                WHERE name = ?
            ");
            $stmt->execute([
                $seo['company_name'] ?? '',
                $seo['image'] ?? '',
                $seo['meta_title'] ?? '',
                $seo['meta_description'] ?? '',
                $seo['keywords'] ?? '',
                $productName
            ]);
            echo "Migrated SEO for product: $productName\n";
        }
        echo "Migration completed.";
    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "No SEO JSON file found.";
}
?>