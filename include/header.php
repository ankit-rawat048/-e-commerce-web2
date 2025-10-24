<header class="bg-white shadow-md flex pr-4 items-center justify-between relative">
  <!-- Logo -->
  <div class="flex items-center space-x-4">
    <a href="index.php">
      <img src="images/logo.png" alt="logo" class="h-24 p-[1rem] w-auto">
    </a>
  </div>

  <!-- Desktop Navigation Links -->
  <ul class="hidden md:flex space-x-6 text-gray-700 font-semibold items-center">
    <li><a href="index.php" class="hover:text-green-600">HOME</a></li>

    <!-- PRODUCTS Dropdown -->
    <li class="dropdown-one relative">
      <span class="cursor-pointer font-semibold">PRODUCTS</span>
      <div class="hoverDiv absolute top-full left-0">
        <a href="products.php" class="block px-4 py-2 hover:text-green-600">By Category</a>
        <a href="disease.php" class="block px-4 py-2 hover:text-green-600">By Disease</a>
      </div>
    </li>

    <li><a href="about.php" class="hover:text-green-600">ABOUT</a></li>
    <li><a href="contact.php" class="hover:text-green-600">CONTACT</a></li>
  </ul>

  <!-- Desktop Icons -->
  <div class="hidden md:flex space-x-4 text-gray-700 text-xl items-center">
    <button id="searchBtn" class="hover:text-green-600 cursor-pointer">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
    <a href="cart.php"><i class="fa-solid fa-bag-shopping hover:text-green-600 cursor-pointer"></i></a>
  </div>

  <!-- Mobile Icons -->
  <div class="md:hidden flex items-center space-x-4">
    <button id="mobileSearchBtn" class="text-gray-700">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
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

  <!-- Mobile Dropdown -->
  <div class="relative">
    <button class="w-full text-left font-semibold text-gray-700 hover:text-green-600 flex justify-between items-center">
      PRODUCTS &gt;
    </button>
    <div class="mobileDropdown hidden flex-col mt-2 space-y-1">
      <a href="products.php" class="block px-4 py-2 text-gray-700 hover:text-green-600">By Category</a>
      <a href="disease.php" class="block px-4 py-2 text-gray-700 hover:text-green-600">By Disease</a>
    </div>
  </div>

  <a href="about.php" class="block text-gray-700 font-semibold hover:text-green-600">ABOUT</a>
  <a href="contact.php" class="block text-gray-700 font-semibold hover:text-green-600">CONTACT</a>
</nav>

<?php include("searchButton.php"); ?>

<script>
  // Toggle mobile menu
  const btn = document.getElementById("menu-btn");
  const menu = document.getElementById("mobile-menu");

  btn.addEventListener("click", () => {
    menu.classList.toggle("hidden");
  });

  // Toggle mobile PRODUCTS dropdown
  const mobileDropdownBtn = menu.querySelector("button");
  const mobileDropdown = menu.querySelector(".mobileDropdown");

  mobileDropdownBtn.addEventListener("click", () => {
    mobileDropdown.classList.toggle("hidden");
  });
</script>

<style>
  /* Desktop hover dropdown */
  .dropdown-one {
    position: relative;
    display: inline-block;
  }

  .hoverDiv {
    display: flex;
    flex-direction: column;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    padding: 12px 16px;
    gap: 8px;
    min-width: 200px;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;

    opacity: 0;
    transform: translateY(10px);
    pointer-events: none;
    transition: opacity 0.3s ease, transform 0.3s ease;
  }

  .dropdown-one:hover .hoverDiv {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
  }

  /* Mobile Dropdown */
  .mobileDropdown a {
    border-radius: 4px;
    transition: background 0.2s;
  }

  .mobileDropdown a:hover {
    background-color: #f0fdf4; /* light green background */
  }
</style>