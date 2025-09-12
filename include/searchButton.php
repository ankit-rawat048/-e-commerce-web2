<!-- 🔍 Search Overlay -->
<div id="searchOverlay"
  class="hidden fixed inset-0 bg-gray-500/90 flex items-start justify-center z-50 
         p-4 sm:p-[6vh] md:p-[10vh] lg:p-[12vh]">

  <div id="searchBox"
    class="bg-white w-[600px] lg:max-w-[90%] sm:max-w-[100%] rounded-xl shadow-xl p-6 transform scale-95 opacity-0 transition-all duration-300">

    <!-- Search Input -->
    <div class="flex items-center space-x-3 border-b pb-3 mb-4">
      <i class="fa-solid fa-magnifying-glass text-gray-500 text-lg"></i>
      <input type="text" id="searchInput" placeholder="Search products..."
        class="flex-1 text-lg focus:outline-none">
      <button id="closeSearch" class="text-gray-400 hover:text-red-500 font-bold text-xl">&times;</button>
    </div>

    <!-- Results -->
    <div id="searchResults" class="max-h-[400px] overflow-y-auto space-y-2">
      <p class="text-gray-400 text-center">Start typing to search...</p>
    </div>
  </div>
</div>


<script>
  const searchBtn = document.getElementById("searchBtn"); // desktop button
  const searchOverlay = document.getElementById("searchOverlay");
  const searchBox = document.getElementById("searchBox");
  const closeSearch = document.getElementById("closeSearch");
  const input = document.getElementById("searchInput");
  const results = document.getElementById("searchResults");

  // Sample products (frontend only for now)
  const products = [
    { id: 1, name: "Ayurvedic Oil", desc: "Herbal massage oil" },
    { id: 2, name: "Herbal Shampoo", desc: "Aloe vera based shampoo" },
    { id: 3, name: "Neem Soap", desc: "Organic soap for skincare" },
    { id: 4, name: "Tulsi Drops", desc: "Immunity booster drops" },
    { id: 5, name: "Chyawanprash", desc: "Classic health supplement" },
  ];

  // Function to open popup
  function openSearch() {
    searchOverlay.classList.remove("hidden");
    setTimeout(() => {
      searchBox.classList.remove("opacity-0", "scale-95");
      searchBox.classList.add("opacity-100", "scale-100");
    }, 50);
    input.focus();
  }

  // Function to close popup
  function closePopup() {
    searchBox.classList.add("opacity-0", "scale-95");
    searchBox.classList.remove("opacity-100", "scale-100");
    setTimeout(() => {
      searchOverlay.classList.add("hidden");
    }, 300);
  }

  // Open from desktop
  if (searchBtn) searchBtn.addEventListener("click", openSearch);

  // Open from mobile
  const mobileBtn = document.getElementById("mobileSearchBtn");
  if (mobileBtn) mobileBtn.addEventListener("click", openSearch);

  // Close
  closeSearch.addEventListener("click", closePopup);
  searchOverlay.addEventListener("click", (e) => {
    if (e.target === searchOverlay) closePopup();
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !searchOverlay.classList.contains("hidden")) {
      closePopup();
    }
  });

  // Update results (frontend only)
  function updateResults(query) {
    results.innerHTML = "";

    if (!query) {
      results.innerHTML = `<p class="text-gray-400 text-center">Start typing to search...</p>`;
      return;
    }

    const filtered = products.filter(p =>
      p.name.toLowerCase().includes(query.toLowerCase())
    );

    if (filtered.length === 0) {
      results.innerHTML = `<p class="text-gray-500 text-center">No results found</p>`;
      return;
    }

    filtered.forEach(p => {
      const item = document.createElement("a");
      item.href = `product.php?id=${p.id}`;
      item.className = "block p-3 rounded-lg hover:bg-gray-100 cursor-pointer";
      item.innerHTML = `<h2 class="font-semibold">${p.name}</h2>
                        <p class="text-sm text-gray-600">${p.desc}</p>`;
      results.appendChild(item);
    });
  }

  input.addEventListener("input", (e) => updateResults(e.target.value));
</script>
