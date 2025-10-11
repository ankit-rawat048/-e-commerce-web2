// Sidebar toggle
    const sidebar = document.getElementById('sidebar');
    const menuButton = document.getElementById('menuButton');
    const cancelBtn = document.querySelector(".cancelBtn");

    menuButton.addEventListener("click", () => sidebar.classList.toggle("-translate-x-full"));
    cancelBtn.addEventListener("click", () => sidebar.classList.add("-translate-x-full"));

// Mobile menu toggle
function toggleMenu(button) {
  const menu = button.nextElementSibling;
  document.querySelectorAll("td .absolute").forEach(m => { if (m !== menu) m.classList.add("hidden"); });
  menu.classList.toggle("hidden");
}