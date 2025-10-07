<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("../include/title.php") ?>
    <?php include("../include/links.php") ?>
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

        <!-- Inputs -->
        <div class="space-y-4">
            <input type="email" placeholder="Email"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <input type="password" placeholder="Password"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Login Button -->
        <a href="dashboard.php"
            class="block text-center w-full mt-6 bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition">
            Log In
        </a>
    </div>

</body>

</html>
