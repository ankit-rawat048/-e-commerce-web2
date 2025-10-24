<?php
// Start the session
session_start();

// Destroy all session data
session_unset();  // Unset all session variables
session_destroy();  // Destroy the session

// Redirect the user to the admin page
header("Location: https://shrigangaherbal.com/admin");
exit();
?>
