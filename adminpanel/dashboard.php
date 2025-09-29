<?php
$orders = [
  ["customer"=>"John Doe","product"=>"Coffee Beans","quantity"=>2,"date"=>"2025-09-25","status"=>"Delivered","email"=>"john@example.com"],
  ["customer"=>"Jane Smith","product"=>"Patti Oil","quantity"=>1,"date"=>"2025-09-24","status"=>"Pending","email"=>"jane@example.com"],
  ["customer"=>"Alex Lee","product"=>"Green Tea","quantity"=>3,"date"=>"2025-09-23","status"=>"Delivered","email"=>"alex@example.com"],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include("../include/links.php") ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" 
    integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" 
    crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100">

<div class="flex">
  <!-- Sidebar -->
  <?php include('sidebar.php'); ?>

  <!-- Main Content -->
  <div class="flex-1 p-6 ml-0">
    <div class="flex justify-between items-center">
      <div class="md:hidden mb-4">
        <button id="menuButton" class="text-2xl text-black">
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>
      <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
    </div>

    <hr class="border-2 border-black mb-4">

    <!-- Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
      <?php
      $cards = [
        ["title"=>"Total Orders Today", "value"=>"128 Orders", "bg"=>"card1.jpg", "link"=>"orders.php"],
        ["title"=>"Total Revenue", "value"=>"$4,520", "bg"=>"card2.jpg", "link"=>"revenue.php"],
        ["title"=>"Best-Selling Product", "value"=>"Coffee Beans", "bg"=>"card3.jpg", "link"=>"bestseller.php"],
        ["title"=>"Pending Appointments", "value"=>"42", "bg"=>"card4.jpg", "link"=>"appointments.php"]
      ];
      foreach($cards as $card): ?>
        <div class="relative rounded-xl shadow-lg h-40 text-white overflow-hidden transform hover:scale-105 transition duration-300"
          style="background-image: url('../images/<?= $card['bg'] ?>'); background-size: cover; background-position: center;">
          <div class="absolute inset-0 bg-black bg-opacity-50"></div>
          <div class="relative p-4 h-full flex flex-col justify-between">
            <h2 class="text-lg sm:text-xl font-semibold"><?= $card['title'] ?></h2>
            <h1 class="text-2xl sm:text-3xl font-bold"><?= $card['value'] ?></h1>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Orders Table -->
    <div class="mt-10">
      <h3 class="text-xl font-semibold">Customer Orders</h3>
      <hr class="border-1 border-black mt-2 mb-6">

      <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full border-collapse">
          <thead class="bg-gray-800 text-white sticky top-0 z-10 shadow-md">
            <tr>
              <th class="py-3 px-4 hidden sm:table-cell">#</th>
              <th class="py-3 px-4">Customer</th>
              <th class="py-3 px-4">Product</th>
              <th class="py-3 px-4">Quantity</th>
              <th class="py-3 px-4">Date</th>
              <th class="py-3 px-4">Status</th>
              <th class="py-3 px-4">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 text-sm">
            <?php foreach($orders as $index=>$o): ?>
            <tr class="hover:bg-gray-100 even:bg-gray-50 transition" data-customer="<?= $o['customer'] ?>" data-product="<?= $o['product'] ?>">
              <td class="py-3 px-4 hidden sm:table-cell"><?= $index+1 ?></td>
              <td class="py-3 px-4"><?= $o['customer'] ?></td>
              <td class="py-3 px-4"><?= $o['product'] ?></td>
              <td class="py-3 px-4"><?= $o['quantity'] ?></td>
              <td class="py-3 px-4"><?= $o['date'] ?></td>
              <td class="py-3 px-4">
                <select class="status-select px-3 py-1 rounded-full text-xs font-medium border">
                  <option value="Delivered">Delivered</option>
                  <option value="Pending">Pending</option>
                  <option value="Cancelled">Cancelled</option>
                </select>
              </td>
              <td class="py-3 px-4 flex gap-2">
                <div class="hidden md:flex gap-2">
                  <button onclick="openMailModal('<?= $o['email'] ?>')" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs flex items-center gap-1 shadow">
                    <i class="fa-solid fa-envelope"></i> Mail
                  </button>
                  <button onclick="openBillModal('<?= $o['customer'] ?>','<?= $o['product'] ?>','<?= $o['quantity'] ?>','<?= $o['date'] ?>','<?= $o['status'] ?>')"
                    class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded text-xs flex items-center gap-1 shadow">
                    <i class="fa-solid fa-file-invoice"></i> Bill
                  </button>
                </div>
                <div class="relative md:hidden">
                  <button onclick="toggleMenu(this)" class="p-2 text-gray-600 hover:text-black">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                  </button>
                  <div class="hidden absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg z-20">
                    <button onclick="openMailModal('<?= $o['email'] ?>')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">📧 Mail</button>
                    <button onclick="openBillModal('<?= $o['customer'] ?>','<?= $o['product'] ?>','<?= $o['quantity'] ?>','<?= $o['date'] ?>','<?= $o['status'] ?>')"
                      class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">🧾 Bill</button>
                  </div>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Mail Modal -->
<div id="mailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] md:w-[450px] text-center relative">
    <h2 class="text-xl font-semibold mb-4">📧 Send Mail</h2>
    <form id="mailForm" onsubmit="sendMail(event)" class="text-left">
      <label class="block font-semibold">To</label>
      <input type="email" id="mailTo" name="to" class="w-full border rounded px-3 py-2 mb-4" readonly>
      <label class="block font-semibold">Subject</label>
      <input type="text" id="mailSubject" name="subject" class="w-full border rounded px-3 py-2 mb-4" required>
      <label class="block font-semibold">Message</label>
      <textarea id="mailMessage" name="message" rows="5" class="w-full border rounded px-3 py-2 mb-4" required></textarea>
      <label class="block font-semibold">Attachment (Image)</label>
      <input type="file" id="mailAttachment" accept="image/*" class="w-full mb-4">
      <img id="previewAttachment" class="hidden mb-4 w-full object-contain max-h-40 border rounded" />
      <div class="flex justify-between">
        <button type="button" onclick="closeMailModal()" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Send</button>
      </div>
    </form>
  </div>
</div>

<!-- Bill Modal -->
<div id="billModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white rounded-lg shadow-lg p-6 w-[95%] md:w-[700px] text-center relative">
    <button onclick="closeBillModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black">
      <i class="fa-solid fa-xmark"></i>
    </button>
    <div id="invoiceContent" class="max-w-3xl mx-auto p-6 bg-white rounded shadow-sm my-6"></div>
    <button onclick="printInvoice()" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
      Print Invoice
    </button>
  </div>
</div>

<script>
// Sidebar toggle
const sidebar = document.getElementById("sidebar");
const menuButton = document.getElementById("menuButton");
const cancelBtn = document.querySelector(".cancelBtn");

cancelBtn.addEventListener("click", ()=> sidebar.classList.add("-translate-x-full"));
menuButton.addEventListener("click", ()=> sidebar.classList.toggle("-translate-x-full"));

// Mobile menu toggle
function toggleMenu(button) {
  const menu = button.nextElementSibling;
  document.querySelectorAll("td .absolute").forEach(m => { if (m !== menu) m.classList.add("hidden"); });
  menu.classList.toggle("hidden");
}
document.addEventListener("click", function(e) {
  if (!e.target.closest("td")) document.querySelectorAll("td .absolute").forEach(m => m.classList.add("hidden"));
});

// Status with localStorage
function getStatusKey(customer, product) { return `orderStatus_${customer}_${product}`; }
document.querySelectorAll(".status-select").forEach(select => {
  const row = select.closest("tr");
  const customer = row.dataset.customer;
  const product = row.dataset.product;
  const key = getStatusKey(customer, product);

  const savedStatus = localStorage.getItem(key);
  if (savedStatus) select.value = savedStatus;
  updateSelectStyle(select);

  select.addEventListener("change", function() {
    localStorage.setItem(key, this.value);
    updateSelectStyle(this);
  });
});
function updateSelectStyle(select) {
  const status = select.value;
  select.className = `status-select px-3 py-1 rounded-full text-xs font-medium border ${
    status === 'Delivered' ? 'bg-green-100 text-green-700 border-green-300' :
    status === 'Pending' ? 'bg-yellow-100 text-yellow-700 border-yellow-300' :
    'bg-red-100 text-red-700 border-red-300'
  }`;
}

// Mailbox functions
function openMailModal(email) {
  document.getElementById("mailTo").value = email;
  document.getElementById("mailModal").classList.remove("hidden");
}
function closeMailModal() {
  document.getElementById("mailModal").classList.add("hidden");
  document.getElementById("mailForm").reset();
  document.getElementById("previewAttachment").classList.add("hidden");
}
function sendMail(e) {
  e.preventDefault();
  const to = document.getElementById("mailTo").value;
  const subject = document.getElementById("mailSubject").value;
  const message = document.getElementById("mailMessage").value;
  const file = document.getElementById("mailAttachment").files[0];
  const fileName = file ? file.name : "No attachment";
  alert(`📩 Mail sent to ${to}\nSubject: ${subject}\nMessage: ${message}\nAttachment: ${fileName}`);
  closeMailModal();
}
document.getElementById("mailAttachment").addEventListener("change", function() {
  const file = this.files[0];
  const preview = document.getElementById("previewAttachment");
  if(file) { preview.src = URL.createObjectURL(file); preview.classList.remove("hidden"); } 
  else { preview.classList.add("hidden"); }
});

// Bill functions
function openBillModal(customer, product, quantity, date, status) {
  const invoice = `<div class="grid grid-cols-2 items-center"> ... </div>`; // shortened for brevity
  document.getElementById("invoiceContent").innerHTML = invoice;
  document.getElementById("billModal").classList.remove("hidden");
}
function closeBillModal() { document.getElementById("billModal").classList.add("hidden"); }
function printInvoice() { const doc = new jsPDF(); doc.fromHTML(document.getElementById("invoiceContent"), 15, 15, { 'width': 170 }); doc.save("invoice.pdf"); }
</script>

</body>
</html>
