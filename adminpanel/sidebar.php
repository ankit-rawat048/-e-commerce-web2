<?php
$sidebarLinks = [
    ["label"=>"Dashboard", "href"=>"dashboard.php", "icon"=>"fa-gauge-high"],
    ["label"=>"Products", "href"=>"products.php", "icon"=>"fa-box-open"],
    ["label"=>"Add Images", "href"=>"addimages.php", "icon"=>"fa-image"],
    ["label"=>"Manage SCO", "href"=>"users.php", "icon"=>"fa-users"],
    // ["label"=>"Reports", "href"=>"reports.php", "icon"=>"fa-chart-line"],
    ["label"=>"Settings", "href"=>"settings.php", "icon"=>"fa-gear"],
    ["label"=>"Logout", "href"=>"logout.php", "icon"=>"fa-right-from-bracket", "class"=>"mt-auto text-red-400 hover:bg-red-600"]
];
?>

<div id="sidebar" class="bg-black text-white w-64 p-6 flex-shrink-0 fixed md:relative top-0 left-0 min-h-screen max-h-[150vh] transition-transform transform -translate-x-full md:translate-x-0 z-50 flex flex-col">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-2xl font-bold">For Admin</h3>
        <button class="cancelBtn text-white lg:hidden text-xl" type="button">×</button>
    </div>

    <hr class="border-gray-600 mb-4">

    <!-- Links -->
    <div class="flex flex-col gap-2 flex-1">
        <?php foreach($sidebarLinks as $link): ?>
            <a href="<?= $link['href'] ?>"
               class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition-colors <?= $link['class'] ?? '' ?>">
               <i class="fa-solid <?= $link['icon'] ?>"></i>
               <?= $link['label'] ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
