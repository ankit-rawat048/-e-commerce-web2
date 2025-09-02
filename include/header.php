<header class="bg-white shadow-md px-6 py-4 flex items-center justify-between">
  <!-- Logo -->
  <div class="flex items-center space-x-4">
    <img src="https://shrigangaherbal.com/assets/logo-new-DYO2f-fG.png" alt="logo" class="h-24 w-auto">
</div>


  <!-- Desktop Navigation Links -->
  <ul class="hidden md:flex space-x-6 text-gray-700 font-semibold items-center">
    <li><a href="index.php" class="hover:text-green-600">HOME</a></li>
    <li><a href="collection.php" class="hover:text-green-600">COLLECTION</a></li>
    <li><a href="about.php" class="hover:text-green-600">ABOUT</a></li>
    <li><a href="contact.php" class="hover:text-green-600">CONTACT</a></li>
  </ul>

  <!-- Desktop Icons -->
  <div class="hidden md:flex space-x-4 text-gray-700 text-xl items-center">
    <a href="signup.php"><i class="fa-regular fa-user hover:text-green-600 cursor-pointer"></i></a>
    <i class="fa-solid fa-bag-shopping hover:text-green-600 cursor-pointer"></i>
  </div>

  <!-- Mobile Hamburger Icon -->
  <div class="md:hidden flex items-center space-x-4">
    <a href="signup.php"><i class="fa-regular fa-user text-gray-700 text-xl hover:text-green-600 cursor-pointer"></i></a>
    <i class="fa-solid fa-bag-shopping text-gray-700 text-xl hover:text-green-600 cursor-pointer"></i>
    <button id="menu-btn" class="focus:outline-none">
      <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
  </div>
</header>

<!-- Mobile Menu -->
<nav id="mobile-menu" class="hidden md:hidden bg-white shadow-md px-6 py-4 space-y-4">
  <a href="index.php" class="block text-gray-700 font-semibold hover:text-green-600">HOME</a>
  <a href="collection.php" class="block text-gray-700 font-semibold hover:text-green-600">COLLECTION</a>
  <a href="about.php" class="block text-gray-700 font-semibold hover:text-green-600">ABOUT</a>
  <a href="contact.php" class="block text-gray-700 font-semibold hover:text-green-600">CONTACT</a>
</nav>

<script>
  // Toggle mobile menu
  const btn = document.getElementById("menu-btn");
  const menu = document.getElementById("mobile-menu");

  btn.addEventListener("click", () => {
    menu.classList.toggle("hidden");
  });
</script>
