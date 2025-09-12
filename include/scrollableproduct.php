<div id="categories-wrapper" class="container mx-auto px-4"></div>

<script>
  // 1. Product data
  const categories = [
    {
      name: "OIL",
      products: [
        { id: 1, name: "Herbal Hair Oil", price: 150, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 2, name: "Ayurvedic Oil", price: 250, img: "https://shrigangaherbal.com/assets/p_img65-jtLWbZUI.png" },
        { id: 3, name: "Pain Relief Oil", price: 349, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
         { id: 1, name: "Herbal Hair Oil", price: 150, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 2, name: "Ayurvedic Oil", price: 250, img: "https://shrigangaherbal.com/assets/p_img65-jtLWbZUI.png" },
        { id: 3, name: "Pain Relief Oil", price: 349, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
      
      ]
    },
    {
      name: "SHAMPOO",
      products: [
        { id: 4, name: "Neem Shampoo", price: 120, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 5, name: "Amla Shampoo", price: 180, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 6, name: "Aloe Vera Shampoo", price: 150, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },{ id: 4, name: "Neem Shampoo", price: 120, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 5, name: "Amla Shampoo", price: 180, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 6, name: "Aloe Vera Shampoo", price: 150, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
      ]
    },
    {
      name: "TABLET",
      products: [
        { id: 7, name: "Ashwagandha Tablet", price: 299, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 8, name: "Neem Tablet", price: 199, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 9, name: "Tulsi Tablet", price: 250, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 4, name: "Neem Shampoo", price: 120, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 5, name: "Amla Shampoo", price: 180, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 6, name: "Aloe Vera Shampoo", price: 150, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
      ]
    }
  ];

  // 2. Get wrapper
  const wrapper = document.getElementById("categories-wrapper");

  // 3. Loop through categories & inject HTML
  categories.forEach(cat => {
    const section = document.createElement("div");
    section.className = "my-16";

    section.innerHTML = `
      <div class="flex items-center space-x-3 mb-4">
        <h1 class="mx-6 border-b-2 border-black text-center text-2xl font-bold">${cat.name}</h1>
      </div>

      <div class="gallery-wrapper relative w-full overflow-hidden max-w-6xl mx-auto">
        <!-- Left Button -->
        <button onclick="scrollGallery(this, -1)"
          class="absolute -left-2 top-1/2 -translate-y-1/2 bg-gray-700/70 hover:bg-gray-900 text-white px-3 py-2 rounded-full z-10">
          <i class="fa-solid fa-chevron-left"></i>
        </button>

        <!-- Scrollable Gallery -->
        <div class="gallery flex items-center gap-4 p-4 transition-transform duration-500">
          ${cat.products.map(p => `
            <a href="product.php?id=${p.id}" 
              class="bg-white border-2 border-green-300 p-3 sm:p-4 md:p-4 lg:p-5 rounded-lg shadow hover:shadow-lg transition flex-shrink-0 w-40 sm:w-44 md:w-48 lg:w-52">
              <img src="${p.img}" alt="${p.name}" 
                class="w-full border-2 border-blue-500 rounded-lg h-40 object-contain mb-3">
              <hr class="border-t-2 border-orange-300 my-4">
              <p class="font-semibold text-[0.85rem] sm:text-sm md:text-base lg:text-base">${p.name}</p>
              <p class="text-green-600 font-bold text-sm md:text-base">₹${p.price}</p>
            </a>
          `).join("")}
        </div>

        <!-- Right Button -->
        <button onclick="scrollGallery(this, 1)"
          class="absolute -right-2 top-1/2 -translate-y-1/2 bg-gray-700/70 hover:bg-gray-900 text-white px-3 py-2 rounded-full z-10">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    `;
    wrapper.appendChild(section);
  });

  // 4. Scroll function
  function scrollGallery(btn, dir) {
    const gallery = btn.parentElement.querySelector(".gallery");
    const scrollAmount = 220;
    gallery.scrollBy({ left: dir * scrollAmount, behavior: "smooth" });
  }
</script>
