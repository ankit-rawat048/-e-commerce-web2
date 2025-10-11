<?php
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $headers = "From: admin@yourdomain.com";

    // Check if a file is uploaded
    if (!empty($_FILES['attachment']['name'])) {
        $fileTmpPath = $_FILES['attachment']['tmp_name'];
        $fileName = $_FILES['attachment']['name'];
        $fileType = $_FILES['attachment']['type'];

        // Read file content for attachment
        $fileContent = chunk_split(base64_encode(file_get_contents($fileTmpPath)));

        // Generate a boundary
        $boundary = md5(time());

        // Headers for attachment
        $headers .= "\r\nMIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"";

        // Message with attachment
        $body = "--{$boundary}\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $message . "\r\n\r\n";

        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: {$fileType}; name=\"{$fileName}\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"{$fileName}\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $fileContent . "\r\n\r\n";
        $body .= "--{$boundary}--";

        // Send mail
        if (mail($to, $subject, $body, $headers)) {
            $success = "✅ Mail with attachment sent successfully to $to";
        } else {
            $error = "❌ Mail could not be sent.";
        }

    } else {
        // Send normal mail if no attachment
        if (mail($to, $subject, $message, $headers)) {
            $success = "✅ Mail sent successfully to $to";
        } else {
            $error = "❌ Mail could not be sent.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mailbox</title>
  <?php include("../include/links.php"); ?>
</head>
<body class="bg-gray-100">
  <div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">📧 Send Mail</h2>
    <?php if (!empty($success)): ?>
      <p class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4"><?= $success ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <p class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <label class="block font-semibold">To (Email)</label>
      <input type="email" name="email" required class="w-full border rounded px-3 py-2 mb-4">

      <label class="block font-semibold">Subject</label>
      <input type="text" name="subject" required class="w-full border rounded px-3 py-2 mb-4">

      <label class="block font-semibold">Message</label>
      <textarea name="message" rows="6" required class="w-full border rounded px-3 py-2 mb-4"></textarea>

      <label class="block font-semibold">Attachment (Image)</label>
      <input type="file" name="attachment" accept="image/*" class="w-full mb-4">

      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        Send Mail
      </button>
    </form>
  </div>
</body>
</html>
