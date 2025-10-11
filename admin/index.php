<?php
include('includes/conn.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Initialize attempts if not set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['login_attempts'] >= 3) {
        $error = 'Too many failed attempts. Please try again later.';
    } else {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (!empty($email) && !empty($password)) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM login WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    // Successful login
                    $_SESSION['login_attempts'] = 0;
                    $_SESSION['user_id'] = $user['id'];
                    $success = true;
                } else {
                    $_SESSION['login_attempts']++;
                    $error = 'Invalid email or password.';
                }
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        } else {
            $error = 'Please fill in both fields.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("../include/title.php") ?>
    <?php include("../include/links.php") ?>
    <!-- Assuming links.php includes Font Awesome for eye icon, if not, add: <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> -->
</head>

<body class="flex justify-center items-center px-4 sm:px-[5vw] md:px-[7vw] lg:px-[9vw] h-[100vh] bg-gray-100">

    <!-- Login form design -->
    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md relative">
        
        <!-- Logo + Title -->
        <div class="text-center mb-6">
            <img src="../images/logo.png" alt="Logo" class="mx-auto mb-4 w-24 h-24 object-contain rounded-full shadow-md">
            <h1 class="text-2xl font-bold text-gray-800">Login</h1>
            <span class="text-3xl text-indigo-500">-</span>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div id="success-msg" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                Login successful! Redirecting...
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = 'dashboard.php';
                }, 2000);
            </script>
        <?php else: ?>
            <!-- Form -->
            <form method="POST" class="space-y-4">
                <input type="email" name="email" placeholder="Email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePassword()">
                        <i id="eye-icon" class="fas fa-eye text-gray-500"></i>
                    </span>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="block text-center w-full mt-6 bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition">
                    Log In
                </button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>