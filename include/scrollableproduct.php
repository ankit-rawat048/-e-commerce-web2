<div id="categories-wrapper" class="container mx-auto px-4"></div>

<script>
  // Product data
  const categories = [
    {
      name: "OIL",
      products: [
        { id: 1, name: "Herbal Hair Oil", price: 150, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 2, name: "Ayurvedic Oil", price: 250, img: "https://shrigangaherbal.com/assets/p_img65-jtLWbZUI.png" },
        { id: 3, name: "Pain Relief Oil", price: 349, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 4, name: "Neem Shampoo", price: 120, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 5, name: "Amla Shampoo", price: 180, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 6, name: "Aloe Vera Shampoo", price: 150, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
      ]
    },
    {
      name: "SHAMPOO",
      products: [
         { id: 1, name: "Herbal Hair Oil", price: 150, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 2, name: "Ayurvedic Oil", price: 250, img: "https://shrigangaherbal.com/assets/p_img65-jtLWbZUI.png" },
        { id: 3, name: "Pain Relief Oil", price: 349, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 4, name: "Neem Shampoo", price: 120, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 5, name: "Amla Shampoo", price: 180, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 6, name: "Aloe Vera Shampoo", price: 150, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
      ]
    },
    {
      name: "TABLET",
      products: [
        { id: 4, name: "Neem Shampoo", price: 120, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 5, name: "Amla Shampoo", price: 180, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 6, name: "Aloe Vera Shampoo", price: 150, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 7, name: "Ashwagandha Tablet", price: 299, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 8, name: "Neem Tablet", price: 199, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
        { id: 9, name: "Tulsi Tablet", price: 250, img: "https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png" },
      ]
    }
  ];

  // Get wrapper
  const wrapper = document.getElementById("categories-wrapper");

  // Loop through categories & inject HTML
  categories.forEach(cat => {
    const section = document.createElement("div");
    section.className = "my-16";

    section.innerHTML = `
      <div class="flex items-center space-x-3 mb-6">
        <h1 class="mx-6 border-b-4 border-green-500 text-center text-3xl font-extrabold text-gray-800">${cat.name}</h1>
      </div>

      <div class="gallery-wrapper relative w-full overflow-hidden max-w-7xl mx-auto">
        <!-- Left Button -->
        <button onclick="scrollGallery(this, -1)"
          class="absolute left-2 top-1/2 text-white px-4 py-3 rounded-full z-10 transition duration-300 transform">
          <i class="fa-solid fa-chevron-left"></i>
        </button>

        <!-- Scrollable Gallery -->
        <div class="gallery flex gap-6 p-4 transition-transform duration-500">
          ${cat.products.map(p => `
            <a href="product.php?id=${p.id}" 
              class="product-card bg-white border-2 border-green-600 p-4 rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105 flex-shrink-0 w-52 sm:w-56 lg:w-60">
              <img src="${p.img}" alt="${p.name}" 
                class="w-full rounded-lg border-2 border-blue-500 h-40 object-contain mb-3">
              <hr class="border-t-2 border-orange-300 my-4">
              <p class="font-semibold text-lg text-gray-700">${p.name}</p>
              <p class="text-orange-600 font-bold text-xl">₹${p.price}</p>
            </a>
          `).join("")}
        </div>

        <!-- Right Button -->
        <button onclick="scrollGallery(this, 1)"
          class="absolute right-2 top-1/2 text-white hover:text-gray-300 px-4 py-3 rounded-full z-10 transition duration-300 transform">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    `;
    wrapper.appendChild(section);
  });

  // Scroll function
  function scrollGallery(btn, dir) {
    const gallery = btn.parentElement.querySelector(".gallery");
    const scrollAmount = 200;
    gallery.scrollBy({ left: dir * scrollAmount, behavior: "smooth" });
  }
</script>

<style>
  .gallery-wrapper {
    position: relative;
    display: flex;
    /* justify-content: center; */
  }

  .product-card {
    /* background-color: #fff; */
    /* border: 2px solid #4CAF50; */
    padding: 16px;
    border-radius: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .product-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transform: scale(1.05);
  }

  .gallery {
    display: flex;
    gap: 20px;
    padding: 16px;
    transition: transform 0.5s ease-in-out;
  }

  .gallery-wrapper button {
    background-color: rgba(0, 0, 0, 0.4);
    /* border-radius: 50%; */
    /* padding: 12px; */
    font-size: 18px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 10;
  }

 /* .gallery-wrapper button:hover {
    background-color: rgba(0, 0, 0, 0.6);
    transform: scale(1.1);
  }  */

  .gallery-wrapper button i {
    color: #fff;
  }
</style>
