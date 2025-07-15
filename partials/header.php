<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<nav class="bg-blue-600 p-4 text-white">
    <div class="flex justify-between">
        <div class="font-bold text-lg">KontrakApp</div>
        <div class="space-x-4 flex items-center">
            <a href="dashboard.php" class="hover:underline">Dashboard</a>
            <a href="kontrak.php" class="hover:underline">Kontrak</a>
            <a href="pihak.php" class="hover:underline">Pihak</a>
            <a href="user.php" class="hover:underline">User</a>
            <a
                href="logout.php"
                onclick="return confirm('Apakah Anda yakin ingin logout?');"
                class="bg-red-600 px-3 py-1 rounded hover:bg-red-700 transition text-white">
                Logout
            </a>
        </div>
    </div>
</nav>