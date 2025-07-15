<?php session_start(); if (!isset($_SESSION['username'])) header("Location: admin/index.php"); ?>
<?php include '../partials/header.php'; ?>

<div class="p-6">
  <div class="mb-6">
    <!-- Carousel -->
    <div class="relative w-full overflow-hidden rounded-lg">
      <div class="flex transition-transform duration-500 ease-in-out" style="transform: translateX(0);">
        <img src="../assets/images/banner.jpg" class="w-full object-cover">
      </div>
    </div>
  </div>

  <div class="bg-white p-6 rounded shadow-md">
    <h2 class="text-xl font-bold mb-4">Tentang Website Kontrak</h2>
    <p class="text-gray-700">Website ini digunakan untuk membuat, mengelola, dan mencatat kontrak antara dua pihak. Semua data pihak dan isi kontrak dicatat secara digital dan bisa diakses melalui dashboard ini.</p>
  </div>
</div>

<?php include '../partials/footer.php'; ?>
