<?php
include('includes/conn.php');

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please login first"); window.location.href = "https://shrigangaherbal.com/";</script>';
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$orders = [];
try {
    $stmt = $pdo->query("
        SELECT 
            o.id AS order_id, 
            o.customer_name AS customer, 
            o.customer_email AS email, 
            GROUP_CONCAT(oi.product_name) AS products, 
            GROUP_CONCAT(oi.quantity) AS quantities, 
            o.created_at AS date, 
            o.order_status AS status
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        GROUP BY o.id, o.customer_name, o.customer_email, o.created_at, o.order_status
        ORDER BY o.created_at DESC
        LIMIT 30
    ");
    $orders = $stmt->fetchAll();
} catch (PDOException $e) {
    echo '<p class="text-red-500">Error fetching orders: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("../include/links.php"); ?>
    <link rel="stylesheet" href="sameStyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZNvSGne9U3CfarzuMpBbsIhqWXvK9RbKpT1OK3ZNLk1k0qWmXTJ8Xavbp4De4F1jBsn6P+pt09zNkgSNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .status-select option[value="Delivered"] {
            background-color: #dcfce7;
            color: #15803d;
        }
        .status-select option[value="Pending"] {
            background-color: #fef9c3;
            color: #a16207;
        }
        .status-select option[value="In-Progress"] {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-select option[value="Cancelled"] {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex flex-col md:flex-row">
        <?php 
        if (file_exists('sidebar.php')) {
            include('sidebar.php'); 
        } else {
            echo '<p class="text-red-500">Error: sidebar.php not found</p>';
        }
        ?>
        <div class="flex-1 p-4 md:p-6">
            <div class="flex justify-between items-center my-2">
                <button id="menuButton" class="md:hidden text-2xl text-black">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h2 class="text-2xl font-bold">Dashboard</h2>
            </div>
            <hr class="border-2 border-black mb-4">
            <?php 
            if (file_exists('cards.php')) {
                include('cards.php'); 
            } else {
                echo '<p class="text-red-500">Error: cards.php not found</p>';
            }
            ?>
            <div class="mt-10">
                <div class="my-2 flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Customer Orders</h3>
                    <input type="text" id="searchInput" placeholder="Search by ID or Name"
                        class="border border-gray-400 focus:border-green-500 focus:ring-1 focus:ring-green-400 rounded-lg px-3 py-2 text-sm sm:w-60 outline-none transition" />
                </div>
                <hr class="border border-black mb-4">
                <div class="table-size overflow-y-auto overflow-x-auto max-h-[500px] bg-white rounded-lg shadow-lg">
                    <table class="w-full md:min-w-[700px] lg:min-w-[900px] divide-y divide-gray-200">
                        <thead class="bg-gray-800 text-white sticky top-0 z-10 shadow-md">
                            <tr>
                                <th class="py-3 px-4">#</th>
                                <th class="py-3 px-4">Customer</th>
                                <th class="py-3 px-4">Products</th>
                                <th class="py-3 px-4">Quantities</th>
                                <th class="py-3 px-4">Date</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            <?php foreach ($orders as $index => $o): ?>
                            <tr class="hover:bg-gray-100 even:bg-gray-50 transition"
                                data-customer="<?= htmlspecialchars($o['customer']) ?>"
                                data-products="<?= htmlspecialchars($o['products']) ?>"
                                data-order-id="<?= $o['order_id'] ?>">
                                <td class="py-3 px-4"><?= $index + 1 ?></td>
                                <td class="py-3 px-4"><?= htmlspecialchars($o['customer']) ?></td>
                                <td class="py-3 px-4"><?= htmlspecialchars($o['products']) ?></td>
                                <td class="py-3 px-4"><?= htmlspecialchars($o['quantities']) ?></td>
                                <td class="py-3 px-4"><?= htmlspecialchars(date('Y-m-d', strtotime($o['date']))) ?></td>
                                <td class="py-3 px-4">
                                    <select class="status-select px-3 py-1 rounded-full text-xs font-medium border"
                                            data-order-id="<?= $o['order_id'] ?>">
                                        <option value="Delivered" <?= $o['status'] == "Delivered" ? "selected" : "" ?>>Delivered</option>
                                        <option value="Pending" <?= $o['status'] == "Pending" ? "selected" : "" ?>>Pending</option>
                                        <option value="Cancelled" <?= $o['status'] == "Cancelled" ? "selected" : "" ?>>Cancelled</option>
                                        <option value="In-Progress" <?= $o['status'] == "In-Progress" ? "selected" : "" ?>>In-Progress</option>
                                    </select>
                                </td>
                                <td class="py-3 px-4 flex gap-2">
                                    <button onclick="openMailModal('<?= htmlspecialchars($o['email']) ?>')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs flex items-center gap-1 shadow">
                                        <i class="fa-solid fa-envelope"></i> Mail
                                    </button>
                                    <button
                                        onclick="openBillModal('<?= htmlspecialchars($o['customer']) ?>','<?= htmlspecialchars($o['products']) ?>','<?= htmlspecialchars($o['quantities']) ?>','<?= htmlspecialchars(date('Y-m-d', strtotime($o['date']))) ?>','<?= htmlspecialchars($o['status']) ?>','<?= $o['order_id'] ?>')"
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

    <!-- Mail Modal -->
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
                    <button type="button" onclick="closeMailModal()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Send</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bill Modal -->
    <div id="billModal" class="modal">
        <div class="modal-content">
            <button onclick="closeBillModal()"
                class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl font-bold">X</button>
            <div id="billContent" class="max-h-[80vh] overflow-y-auto"></div>
            <div class="mt-4 flex justify-center space-x-4 no-print">
                <button onclick="downloadPDF()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">Download PDF</button>
            </div>
        </div>
    </div>

    <script src="samescript.js"></script>
    <script>
        document.querySelectorAll(".status-select").forEach(select => {
            const row = select.closest("tr");
            const customer = row.dataset.customer;
            const products = row.dataset.products;
            const orderId = select.dataset.orderId;
            const key = `orderStatus_${customer}_${orderId}`;
            const savedStatus = localStorage.getItem(key);
            if (savedStatus) select.value = savedStatus;
            updateSelectStyle(select);

            select.addEventListener("change", function () {
                const newStatus = this.value;
                localStorage.setItem(key, newStatus);
                updateSelectStyle(this);

                fetch('update_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `order_id=${encodeURIComponent(orderId)}&status=${encodeURIComponent(newStatus)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Failed to update status: ' + data.error);
                        select.value = savedStatus || select.dataset.originalStatus;
                        updateSelectStyle(select);
                    }
                })
                .catch(error => {
                    alert('Error updating status: ' + error);
                    select.value = savedStatus || select.dataset.originalStatus;
                    updateSelectStyle(select);
                });
            });
        });

        function updateSelectStyle(select) {
            const s = select.value;
            select.className = `status-select px-3 py-1 rounded-full text-xs font-medium border ${s === 'Delivered' ? 'bg-green-100 text-green-700 border-green-300' :
                s === 'Pending' ? 'bg-yellow-100 text-yellow-700 border-yellow-300' :
                s === 'In-Progress' ? 'bg-blue-100 text-blue-700 border-blue-300' :
                'bg-red-100 text-red-700 border-red-300'
            }`;
        }

        function openMailModal(email) {
            const modal = document.getElementById("mailModal");
            document.getElementById("mailTo").value = email;
            modal.classList.add("active");
            window.addEventListener("click", function handler(e) {
                if (e.target === modal) {
                    closeMailModal();
                    window.removeEventListener("click", handler);
                }
            });
        }

        function closeMailModal() {
            const modal = document.getElementById("mailModal");
            modal.classList.remove("active");
            document.getElementById("mailForm").reset();
            document.getElementById("previewAttachment").classList.add("hidden");
        }

        function sendMail(e) {
            e.preventDefault();
            alert(`Mail sent to ${document.getElementById("mailTo").value}`);
            closeMailModal();
        }

        document.getElementById("mailAttachment").addEventListener("change", function () {
            const file = this.files[0];
            const p = document.getElementById("previewAttachment");
            if (file) {
                p.src = URL.createObjectURL(file);
                p.classList.remove("hidden");
            } else {
                p.classList.add("hidden");
            }
        });

        function openBillModal(c, p, q, d, s, orderId) {
            const modal = document.getElementById("billModal");
            fetch(`bill.php?order_id=${encodeURIComponent(orderId)}`)
                .then(res => {
                    if (!res.ok) throw new Error('Failed to fetch bill');
                    return res.text();
                })
                .then(html => {
                    document.getElementById("billContent").innerHTML = html;
                    modal.classList.add("active");
                    window.addEventListener("click", function handler(e) {
                        if (e.target === modal) {
                            closeBillModal();
                            window.removeEventListener("click", handler);
                        }
                    });
                })
                .catch(error => {
                    document.getElementById("billContent").innerHTML = '<p class="text-red-500">Error loading bill: ' + error.message + '</p>';
                    modal.classList.add("active");
                });
        }

        function closeBillModal() {
            const modal = document.getElementById("billModal");
            modal.classList.remove("active");
            document.getElementById("billContent").innerHTML = '';
        }

        function downloadPDF() {
    const el = document.querySelector("#billContent #invoice");
    if (!el) {
        alert("Invoice not found!");
        return;
    }

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


        document.getElementById("searchInput").addEventListener("input", function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll("tbody tr").forEach(row => {
                const name = row.dataset.customer.toLowerCase();
                const products = row.dataset.products.toLowerCase();
                row.style.display = (name.includes(query) || products.includes(query)) ? "" : "none";
            });
        });
    </script>
</body>
</html>