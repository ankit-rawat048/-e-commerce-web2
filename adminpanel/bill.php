<?php
// Example data (fetch from DB or via GET params safely)
$customer = htmlspecialchars($_GET['customer'] ?? "Laravel LLC");
$product  = htmlspecialchars($_GET['product'] ?? "E-commerce Platform");
$quantity = (int)($_GET['quantity'] ?? 500);
$date     = htmlspecialchars($_GET['date'] ?? "2025-09-25");
$status   = htmlspecialchars($_GET['status'] ?? "Delivered");

// Example price
$price = 100;
$total = $quantity * $price;
$tax = $total * 0.10;
$grandTotal = $total + $tax;

// Generate invoice details
$invoiceNumber = "INV-" . time(); // simple unique invoice no.
$invoiceDate   = date("d/m/Y");
$dueDate       = date("d/m/Y", strtotime("+7 days")); // auto add 7 days
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
@media print {
  .no-print {
    display: none !important;
  }
}
</style>

</head>
<body class="bg-gray-100 flex items-center justify-center py-10">

  <div id="invoice" class="bg-white p-8 rounded-xl shadow-xl w-full max-w-3xl">
    <div class="flex justify-between items-start">
      <!-- Left side: Logo -->
      <div class="flex items-start gap-4">
        <?php if (file_exists("../images/logo.png")): ?>
          <img src="../images/logo.png" alt="Company Logo" class="h-24 w-24 object-contain">
        <?php else: ?>
          <h2 class="text-2xl font-bold">My Company</h2>
        <?php endif; ?>
      </div>
      
      <!-- Right side: Invoice details -->
      <div class="text-right">
        <p><strong>Invoice number:</strong> <?= $invoiceNumber ?></p>
        <p><strong>Invoice date:</strong> <?= $invoiceDate ?></p>
        <p><strong>Due date:</strong> <?= $dueDate ?></p>
        <p class="text-gray-600">
          sales@tailwindcss.com<br>
          +41-442341232<br>
          VAT: 8657671212
        </p>
      </div>
    </div>

    <div class="mt-6">
      <p class="font-semibold">Bill to :</p>
      <p><?= $customer ?><br>102, San-Francisco, CA, USA<br>info@laravel.com</p>
    </div>

    <table class="w-full mt-8 border-t border-b">
      <thead>
        <tr class="text-left bg-gray-100">
          <th class="py-3 px-4">Item</th>
          <th class="py-3 px-4">Quantity</th>
          <th class="py-3 px-4">Price</th>
          <th class="py-3 px-4">Amount</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-t">
          <td class="py-3 px-4"><?= $product ?></td>
          <td class="py-3 px-4"><?= $quantity ?></td>
          <td class="py-3 px-4">$<?= number_format($price, 2) ?></td>
          <td class="py-3 px-4">$<?= number_format($total, 2) ?></td>
        </tr>
      </tbody>
    </table>

    <div class="mt-6 flex justify-end">
      <div class="text-right">
        <p>Subtotal: $<?= number_format($total, 2) ?></p>
        <p>Tax (10%): $<?= number_format($tax, 2) ?></p>
        <p class="font-bold text-lg">Total: $<?= number_format($grandTotal, 2) ?></p>
      </div>
    </div>

    <!-- Buttons
    <div class="mt-8 flex justify-center space-x-4 no-print">
      <button onclick="downloadPDF()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow no-print">
        Download PDF
      </button>
    </div> -->
  </div>

<!-- <script>
function downloadPDF() {
  const element = document.getElementById("invoice");
  html2pdf().set({
    margin: 10,
    filename: 'invoice.pdf',
    image: { type: 'png', quality: 0.98 },
    html2canvas: { 
      scale: 2, 
      logging: false, 
      letterRendering: true,
      ignoreElements: (el) => el.classList.contains('no-print') 
    },
    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
  }).from(element).save();
}
</script> -->
</body>
</html>
