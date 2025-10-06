<?php
$baseOrders = [
  ["customer" => "John Doe", "product" => "Coffee Beans", "quantity" => 2, "date" => "2025-09-25", "status" => "Delivered", "email" => "john@example.com"],
  ["customer" => "Jane Smith", "product" => "Patti Oil", "quantity" => 1, "date" => "2025-09-24", "status" => "Pending", "email" => "jane@example.com"],
  ["customer" => "Alex Lee", "product" => "Green Tea", "quantity" => 3, "date" => "2025-09-23", "status" => "Delivered", "email" => "alex@example.com"]
];

// ✅ Duplicate orders 10 times
$orders = [];
for ($i = 0; $i < 10; $i++) {
  $orders = array_merge($orders, $baseOrders);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include("../include/links.php"); ?>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script> -->
  <style>
    /* ✅ Fix for option color visibility (browser dependent) */
    .status-select option[value="Delivered"] { background-color: #dcfce7; color: #15803d; }
    .status-select option[value="Pending"] { background-color: #fef9c3; color: #a16207; }
    .status-select option[value="In-Progress"] { background-color: #dbeafe; color: #1e40af; }
    .status-select option[value="Cancelled"] { background-color: #fee2e2; color: #b91c1c; }

    /* ✅ Basic modal styling (missing before) */
    .modal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 50;
    }
    .modal.active {
      display: flex;
    }
    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 8px;
      position: relative;
      width: 90%;
      max-width: 600px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="flex flex-col md:flex-row">
  <?php include('sidebar.php'); ?>

  <div class="flex-1 p-4 md:p-6">
    <div class="flex justify-between items-center my-2">
        <button id="menuButton" class="md:hidden text-2xl text-black">
          <i class="fa-solid fa-bars"></i>
        </button>
        <h2 class="text-2xl font-bold">Dashboard</h2>
    </div>

    <hr class="border-2 border-black mb-4">

    <?php include 'cards.php'; ?>

    <div class="mt-10">
      <h3 class="text-xl font-semibold mb-2">Customer Orders</h3>
      <hr class="border border-black mb-4">

      <div class="overflow-y-auto max-h-[500px] overflow-x-auto max-w-[500px] lg:max-w-full bg-white rounded shadow">
        <table class="min-w-full border-collapse">
          <thead class="bg-gray-800 text-white sticky top-0 z-10 shadow-md">
            <tr>
              <th class="py-3 px-4">#</th>
              <th class="py-3 px-4">Customer</th>
              <th class="py-3 px-4">Product</th>
              <th class="py-3 px-4">Quantity</th>
              <th class="py-3 px-4">Date</th>
              <th class="py-3 px-4">Status</th>
              <th class="py-3 px-4">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 text-sm">
            <?php foreach ($orders as $index => $o): ?>
              <tr class="hover:bg-gray-100 even:bg-gray-50 transition"
                  data-customer="<?= htmlspecialchars($o['customer']) ?>" 
                  data-product="<?= htmlspecialchars($o['product']) ?>">
                <td class="py-3 px-4"><?= $index + 1 ?></td>
                <td class="py-3 px-4"><?= htmlspecialchars($o['customer']) ?></td>
                <td class="py-3 px-4"><?= htmlspecialchars($o['product']) ?></td>
                <td class="py-3 px-4"><?= htmlspecialchars($o['quantity']) ?></td>
                <td class="py-3 px-4"><?= htmlspecialchars($o['date']) ?></td>
                <td class="py-3 px-4">
                  <select class="status-select px-3 py-1 rounded-full text-xs font-medium border">
                    <option value="Delivered" <?= $o['status'] == "Delivered" ? "selected" : "" ?>>Delivered</option>
                    <option value="Pending" <?= $o['status'] == "Pending" ? "selected" : "" ?>>Pending</option>
                    <option value="Cancelled" <?= $o['status'] == "Cancelled" ? "selected" : "" ?>>Cancelled</option>
                    <option value="In-Progress" <?= $o['status'] == "In-Progress" ? "selected" : "" ?>>In-Progress</option>
                  </select>
                </td>
                <td class="py-3 px-4 flex gap-2">
                  <button onclick="openMailModal('<?= $o['email'] ?>')" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs flex items-center gap-1 shadow">
                    <i class="fa-solid fa-envelope"></i> Mail
                  </button>
                  <button onclick="openBillModal('<?= $o['customer'] ?>','<?= $o['product'] ?>','<?= $o['quantity'] ?>','<?= $o['date'] ?>','<?= $o['status'] ?>')"
                    class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded text-xs flex items-center gap-1 shadow">
                    <i class="fa-solid fa-file-invoice"></i> Bill
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Mail Modal -->
<div id="mailModal" class="modal">
  <div class="modal-content">
    <h2 class="text-xl font-semibold mb-4">📧 Send Mail</h2>
    <form id="mailForm" onsubmit="sendMail(event)">
      <label>To</label>
      <input type="email" id="mailTo" readonly class="w-full border rounded px-3 py-2 mb-3">
      <label>Subject</label>
      <input type="text" id="mailSubject" required class="w-full border rounded px-3 py-2 mb-3">
      <label>Message</label>
      <textarea id="mailMessage" rows="4" required class="w-full border rounded px-3 py-2 mb-3"></textarea>
      <label>Attachment (Image)</label>
      <input type="file" id="mailAttachment" accept="image/*" class="w-full mb-3">
      <img id="previewAttachment" class="hidden mb-3 w-full object-contain max-h-40 border rounded" />
      <div class="flex justify-between">
        <button type="button" onclick="closeMailModal()" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Send</button>
      </div>
    </form>
  </div>
</div>

<!-- ✅ Bill Modal -->
<div id="billModal" class="modal">
  <div class="modal-content">
    <button onclick="closeBillModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl font-bold">X</button>
    <div id="billContent" class="max-h-[80vh] overflow-y-auto"></div>
    <div class="mt-4 flex justify-center space-x-4 no-print">
      <button onclick="downloadPDF()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">Download PDF</button>
    </div>
  </div>
</div>

<script src="samescript.js"></script>
<script>
  // ✅ Status persistence using localStorage
  document.querySelectorAll(".status-select").forEach(select => {
    const row = select.closest("tr");
    const customer = row.dataset.customer;
    const product = row.dataset.product;
    const key = `orderStatus_${customer}_${product}`;
    const savedStatus = localStorage.getItem(key);
    if (savedStatus) select.value = savedStatus;
    updateSelectStyle(select);

    select.addEventListener("change", function() {
      localStorage.setItem(key, this.value);
      updateSelectStyle(this);
    });
  });

  function updateSelectStyle(select) {
    const s = select.value;
    select.className = `status-select px-3 py-1 rounded-full text-xs font-medium border ${
      s === 'Delivered' ? 'bg-green-100 text-green-700 border-green-300' :
      s === 'Pending' ? 'bg-yellow-100 text-yellow-700 border-yellow-300' :
      s === 'In-Progress' ? 'bg-blue-100 text-blue-700 border-blue-300' :
      'bg-red-100 text-red-700 border-red-300'
    }`;
  }

  // ✅ Mail Modal
  function openMailModal(email) {
    const modal = document.getElementById("mailModal");
    document.getElementById("mailTo").value = email;
    modal.classList.add("active");

    // close madal if click outside
    window,addEventListener("click", function handler(e) {
      if  (e.target === modal) {
        closeMailModal();
        window.removeEventListener("click", handler); // remove listener after closing
      }
    });
  }

  function closeMailModal() {
    const modal = document.getElementById("mailModal");
    modal.classList.remove("active");
    document.getElementById("mailForm").reset();
    document.getElementById("previewAttachment").classList.add("hidden");
  }
  function sendmail(e) {
    e.preventDefault();
    alert(`Mail sent to ${document.getElementById("mailTo").value}`);
    closeMailModal();
  }
  document.getElementById("mailAttachment").addEventListener("change",function() {
    const file =this.files[0];
    const p = document.getElementById("previewAttachment");
    if (file) {
      p.src = URL.createObjectURL(file);
      p.classList.remove("hidden");
    } else {
      p.classList.add("hidden");
    }
  });


  // ✅ Bill Modal
  function openBillModal(c, p, q, d, s) {
    const modal = document.getElementById("billModal");
    fetch(`bill.php?customer=${encodeURIComponent(c)}&product=${encodeURIComponent(p)}&quantity=${q}&date=${d}&status=${s}`)
    .then(res => res.text())
    .then(html => {
      document.getElementById("billContent").innerHTML = html;
      modal.classList.add("active");

      // close modal if click outside
      window.addEventListener("click", function handler(e) {
        if (e.target === modal) {
          closeBillModal();
          window.removeEventListener("click", handler); 
        }
      });
    });
  }

  function closeBillModal() {
    const modal = document.getElementById("billModal");
    modal.classList.remove("active");
    document.getElementById("billContent").innerHTML = '';
  }

  // ✅ Download PDF
  function downloadPDF() {
    const el = document.getElementById("invoice");
    if (!el) { alert("Invoice not found!"); return; }
    html2pdf()
      .set({
        margin: 10,
        filename: 'invoice.pdf',
        image: { type: 'png', quality: 0.98 },
        html2canvas: { scale: 2, logging: false, letterRendering: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
      })
      .from(el)
      .save();
  }
</script>

</body>
</html>
