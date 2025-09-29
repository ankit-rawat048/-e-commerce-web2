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

// Handle rename
if (isset($_POST['rename'])) {
    $oldName = $uploadDir . basename($_POST['oldName']);
    $newName = $uploadDir . basename($_POST['newName']);
    $ext = pathinfo($oldName, PATHINFO_EXTENSION);
    if (!str_ends_with($newName, ".$ext")) {
        $newName .= ".$ext"; // keep original extension
    }
    if (file_exists($oldName) && !file_exists($newName)) {
        rename($oldName, $newName);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ayurveda - Image Manager</title>
<?php include("../include/links.php") ?>
<style>
  /* Sidebar toggle */
  #sidebar { transition: transform 0.3s ease; }
  #sidebar.-translate-x-full { transform: translateX(-100%); }

  /* Modal */
  .modal { display: none; }
  .modal.active { display: flex; }
</style>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="flex">

  <!-- Sidebar -->
  <?php include('sidebar.php'); ?>

  <!-- Main Content -->
  <div class="flex-1 p-6">

    <div class="flex justify-between items-center mb-4">
      <button id="menuButton" class="md:hidden text-2xl text-black">
        <i class="fa-solid fa-bars"></i>
      </button>
      <h1 class="text-2xl font-bold">Image Manager</h1>
    </div>

    <hr class="border-2 border-black mb-4">

    <!-- Upload Form -->
    <?php if($msg): ?>
      <p class="mb-4 text-red-500 font-medium"><?= $msg ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data" class="my-6 flex flex-col sm:flex-row gap-4 justify-center items-center">
      <input type="file" name="image" accept="image/*" class="border border-gray-300 rounded px-3 py-2 w-full sm:w-auto">
      <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 shadow transition">Add Image</button>
    </form>

    <!-- Images Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-800 text-white">
          <tr>
            <th class="py-3 px-4 text-left">#</th>
            <th class="py-3 px-4 text-left">Image</th>
            <th class="py-3 px-4 text-left">Name</th>
            <th class="py-3 px-4 text-left">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php $counter = 1; ?>
          <?php foreach($images as $imgPath): ?>
          <tr class="hover:bg-gray-50 transition">
            <td class="py-3 px-4 font-medium"><?= $counter++ ?></td>
            <td class="py-2 px-4">
              <img src="<?= $imgPath ?>" class="w-24 h-24 object-cover rounded shadow-md">
            </td>
            <td class="py-3 px-4 font-medium text-gray-700"><?= basename($imgPath) ?></td>
            <td class="py-3 px-4 flex gap-2">
              <button onclick="openRenameModal('<?= basename($imgPath) ?>')"
                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 shadow transition">
                Edit Name
              </button>
              <a href="?delete=<?= urlencode(basename($imgPath)) ?>"
                onclick="return confirm('Are you sure you want to delete this image?');"
                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 shadow transition">
                Delete
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if(count($images) === 0): ?>
          <tr>
            <td colspan="4" class="py-6 px-4 text-center text-gray-500">No images uploaded yet.</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Rename Modal -->
    <div id="renameModal" class="modal fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white rounded-lg shadow-xl p-6 w-96">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Rename Image</h2>
        <form method="POST">
          <input type="hidden" name="oldName" id="oldName">
          <input type="text" name="newName" id="newName" class="border border-gray-300 rounded px-3 py-2 w-full mb-4" required>
          <div class="flex justify-end gap-3">
            <button type="button" onclick="closeRenameModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Cancel</button>
            <button type="submit" name="rename" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Rename</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<script>
  // Sidebar toggle
  const sidebar = document.getElementById('sidebar');
  const menuButton = document.getElementById('menuButton');
  const cancelBtn = document.querySelector(".cancelBtn");

cancelBtn.addEventListener("click", ()=> sidebar.classList.add("-translate-x-full"));
  menuButton.addEventListener("click", ()=> sidebar.classList.toggle("-translate-x-full"));


  // Rename modal
  function openRenameModal(filename) {
    document.getElementById('oldName').value = filename;
    document.getElementById('newName').value = filename;
    document.getElementById('renameModal').classList.add('active');
  }
  function closeRenameModal() {
    document.getElementById('renameModal').classList.remove('active');
  }
</script>

</body>
</html>
