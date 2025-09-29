<!-- bill.php -->
<?php
// Example data (you can fetch from DB or pass via GET params)
$customer = $_GET['customer'] ?? "Laravel LLC";
$product = $_GET['product'] ?? "E-commerce Platform";
$quantity = $_GET['quantity'] ?? 500;
$date = $_GET['date'] ?? "2025-09-25";
$status = $_GET['status'] ?? "Delivered";

// Example price
$price = 100;
$total = $quantity * $price;
$tax = $total * 0.10;
$grandTotal = $total + $tax;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center py-10">

  <div id="invoice" class="bg-white p-8 rounded-xl shadow-xl w-[800px]">
    <div class="flex justify-between items-start">
      <div>
        <h2 class="text-2xl font-bold text-blue-600">Tailwind Inc.</h2>
        <p class="text-gray-600">sales@tailwindcss.com<br>+41-442341232<br>VAT: 8657671212</p>
      </div>
      <div class="text-right">
        <p><strong>Invoice number:</strong> INV-2023786123</p>
        <p><strong>Invoice date:</strong> <?= date("d/m/Y") ?></p>
        <p><strong>Due date:</strong> 31/07/2023</p>
      </div>
    </div>

    <div class="mt-6">
      <p class="font-semibold">Bill to :</p>
      <p><?= $customer ?><br>102, San-Fransico, CA, USA<br>info@laravel.com</p>
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
          <td class="py-3 px-4">$<?= number_format($price,2) ?></td>
          <td class="py-3 px-4">$<?= number_format($total,2) ?></td>
        </tr>
      </tbody>
    </table>

    <div class="mt-6 flex justify-end">
      <div class="text-right">
        <p>Subtotal: $<?= number_format($total,2) ?></p>
        <p>Tax (10%): $<?= number_format($tax,2) ?></p>
        <p class="font-bold text-lg">Total: $<?= number_format($grandTotal,2) ?></p>
      </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-center space-x-4">
      <button onclick="downloadPDF()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
        Download PDF
      </button>
      <button onclick="cancelInvoice()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow">
        Cancel
      </button>
    </div>
  </div>

<script>
function downloadPDF() {
  const element = document.getElementById("invoice");
  html2pdf().from(element).save("invoice.pdf");
}

function cancelInvoice() {
  // If bill.php opened in new tab
  if (window.opener) {
    window.close();
  } else {
    // If opened inside same page
    window.location.href = "dashboard.php"; 
  }
}
</script>
</body>
</html>
