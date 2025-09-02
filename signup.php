<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("include/title.php") ?>
  <?php include("include/links.php") ?>
</head>
<body class="px-4 sm:px-[5vw] md:px-[7vw] lg:px-[9vw]
">
  <?php include("include/header.php") ?>

  <main class="my-8 flex flex-1 items-center justify-center px-4 sm:px-[5vw] md:px-[7vw] lg:px-[9vw]">
    <form class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
      <!-- Title -->
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Sign Up</h1>
        <span class="text-3xl text-indigo-500">-</span>
      </div>

      <!-- Inputs -->
      <div class="space-y-4">
        <input 
          type="text" 
          placeholder="Name" 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
        <input 
          type="email" 
          placeholder="Email" 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
        <input 
          type="password" 
          placeholder="Password" 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
      </div>

      <!-- Links -->
      <div class="flex justify-between items-center text-sm text-gray-600 mt-4">
        <p class="hover:underline cursor-pointer">Forgot your password?</p>
        <a href="/toLogin" class="text-indigo-600 hover:underline">Login Here</a>
      </div>

      <!-- Button -->
      <button 
        type="submit" 
        class="w-full mt-6 bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition"
      >
        Sign Up
      </button>
    </form>
  </main>

  <?php include("include/footer.php") ?>
</body>
</html>
