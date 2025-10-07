<?php
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Handle deletion
if (isset($_GET['delete'])) {
    $fileToDelete = $uploadDir . basename($_GET['delete']);
    if (file_exists($fileToDelete)) {
        unlink($fileToDelete);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle rename + replace
if (isset($_POST['update'])) {
    $oldName = $uploadDir . basename($_POST['oldName']);
    $newName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', basename($_POST['newName']));
    $ext = pathinfo($oldName, PATHINFO_EXTENSION);

    // Ensure same extension for rename
    if (substr_compare($newName, ".$ext", -strlen(".$ext")) !== 0) {
        $newName .= ".$ext";
    }

    $newPath = $uploadDir . $newName;

    // If replacing image
    if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] === 0) {
        $extNew = strtolower(pathinfo($_FILES['newImage']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extNew, $allowed)) {
            // Move new file and replace old
            if (move_uploaded_file($_FILES['newImage']['tmp_name'], $newPath)) {
                if ($oldName !== $newPath && file_exists($oldName)) {
                    unlink($oldName);
                }
            }
        }
    } else {
        // Rename only
        if ($oldName !== $newPath && file_exists($oldName)) {
            rename($oldName, $newPath);
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle upload
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $filename = time() . '_' . basename($file['name']);
    $targetFile = $uploadDir . $filename;

    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowed)) {
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $msg = "Error uploading image!";
        }
    } else {
        $msg = "Only JPG, PNG, GIF files are allowed.";
    }
}

// Get all uploaded images
$images = glob($uploadDir . "*");

// Function to get absolute URL of file
function getImageUrl($path)
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    return $protocol . "://" . $host . $baseDir . "/" . $path;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayurveda - Image Manager</title>
    <?php include("../include/links.php") ?>
    <link rel="stylesheet" href="sameStyle.css">
    <style>
        .modal {
            display: none;
        }

        .modal.active {
            display: flex;
        }

        .table-size {
            width: 100%;
            overflow-x: auto;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex flex-col md:flex-row">

        <!-- Sidebar -->
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <div class="flex-1 p-4 md:p-6">

            <div class="flex justify-between items-center my-2">
                <button id="menuButton" class="md:hidden text-2xl text-black">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="text-2xl font-bold">Image Manager</h1>
            </div>

            <hr class="border-2 border-black mb-4">

            <?php include 'cards.php'; ?>

            <!-- Upload Form -->
            <?php if ($msg): ?>
            <p class="mb-4 text-red-500 font-medium">
                <?= $msg ?>
            </p>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data"
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 my-6 bg-gray-50 flex flex-col items-center gap-4 text-center shadow-sm hover:shadow-md transition">
                <label
                    class="cursor-pointer inline-flex items-center gap-2 bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-lg shadow transition">
                    <i class="fa-solid fa-file-arrow-up"></i>
                    <span>Choose Files</span>
                    <input type="file" name="image" accept="image/*" class="hidden" onchange="this.form.submit()">
                </label>
                <p class="text-sm text-gray-600">Drag & Drop or Select Image</p>
            </form>

            <!-- Images Table -->
            <div class="table-size overflow-y-auto max-h-[500px] overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="w-full md:min-w-[700px] lg:min-w-[900px] divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white sticky top-0 z-10">
                        <tr>
                            <th class="py-3 px-4 text-left text-sm">#</th>
                            <th class="py-3 px-4 text-left text-sm">Image</th>
                            <th class="py-3 px-4 text-left text-sm">Name</th>
                            <th class="py-3 px-4 text-left text-sm">URL</th>
                            <th class="py-3 px-4 text-left text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $counter = 1; ?>
                        <?php foreach ($images as $imgPath): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4 font-medium text-gray-800 text-center">
                                <?= $counter++ ?>
                            </td>
                            <td class="py-2 px-4">
                                <div class="flex justify-center">
                                    <img src="<?= $imgPath ?>"
                                        class="w-20 h-20 md:w-24 md:h-24 object-cover rounded-lg shadow-md border border-gray-200">
                                </div>
                            </td>
                            <td class="py-3 px-4 font-medium text-gray-700 truncate max-w-[150px] sm:max-w-[200px]">
                                <?= basename($imgPath) ?>
                            </td>
                            <td class="py-3 px-4">
                                <div class="w-full text-center flex justify-between items-center gap-2">
                                    <button onclick="openEditModal('<?= basename($imgPath) ?>')"
                                        class="w-[30%] px-3 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 shadow transition">Edit</button>

                                    <button onclick="copyToClipboard('<?= getImageUrl($imgPath) ?>')"
                                        class="w-[30%] px-3 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 shadow transition">Copy</button>

                                    <a href="?delete=<?= urlencode(basename($imgPath)) ?>"
                                        onclick="return confirm('Are you sure you want to delete this image?');"
                                        class="w-[30%] px-3 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-600 shadow transition">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (count($images) === 0): ?>
                        <tr>
                            <td colspan="4" class="py-6 px-4 text-center text-gray-500">No images uploaded yet.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- ✅ Combined Rename + Replace Modal -->
            <div id="editModal" class="modal fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-2">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Edit Image</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="oldName" id="oldName">
                        <label class="block mb-2 font-medium text-gray-700">Rename Image</label>
                        <input type="text" name="newName" id="newName"
                            class="border border-gray-300 rounded px-3 py-2 w-full mb-4" required>

                        <label class="block mb-2 font-medium text-gray-700">Replace Image (optional)</label>
                        <input type="file" name="newImage" accept="image/*"
                            class="border border-gray-300 rounded px-3 py-2 w-full mb-4">

                        <img id="previewImg" src="" class="w-full max-h-48 object-contain mb-4 rounded border hidden">

                        <div class="flex justify-end gap-3 flex-wrap">
                            <button type="button" onclick="closeEditModal()"
                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition w-full sm:w-auto">Cancel</button>
                            <button type="submit" name="update"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition w-full sm:w-auto">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script src="samescript.js"></script>
    <script>
        function openEditModal(filename) {
            document.getElementById('oldName').value = filename;
            document.getElementById('newName').value = filename;
            const img = document.getElementById('previewImg');
            img.src = 'uploads/' + filename;
            img.classList.remove('hidden');
            document.getElementById('editModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        // close modal when clicking outside of it 
        window.addEventListener("click", function (event) {
            const modal = document.getElementById("editModal");
            if (event.target === modal) {
                closeEditModal();
            }
        });

        function copyToClipboard(url) {
            navigator.clipboard.writeText(url)
                .then(() => alert('Image URL copied: ' + url))
                .catch(err => alert('Failed to copy URL: ' + err));
        }
    </script>

</body>

</html>