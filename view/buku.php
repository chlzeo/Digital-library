<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}
include '../function/koneksi.php';
$buku = read("
    SELECT buku.*, kategoribuku.NamaKategori 
    FROM buku
    LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
    LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
");
if(isset($_POST['submit'])){
    $buku = cari($_POST['key']);
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Digital Library</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f5f5] min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg px-8 py-4 flex items-center justify-between sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <img src="/perpustakaan/view/img/anjai.svg" alt="Logo" class="w-10 h-10">
        </div>
        <!-- Hamburger button for mobile -->
        <div class="md:hidden">
            <!-- Optional: Hamburger icon for mobile -->
        </div>
        <div id="menu" class="flex-1 flex-col md:flex md:flex-row md:justify-center md:items-center gap-8 items-center text-lg font-medium absolute md:static top-20 left-0 w-full md:w-auto bg-white md:bg-transparent z-20 hidden md:flex">
            <ul class="flex flex-col md:flex-row gap-8 items-center w-full md:w-auto">
                <li><a href="buku.php" class="text-[#232366] hover:underline transition">Home</a></li>
                <li><a href="peminjaman_user.php" class="text-[#232366] hover:underline transition">Peminjaman</a></li>
                <li><a href="koleksi.php" class="text-[#232366] hover:underline transition">koleksi</a></li>
            </ul>
        </div>
        <a href="/perpustakaan/view/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg font-semibold transition hidden md:block shadow">
            Logout
        </a>
    </nav>
    <script>
        // Responsive menu toggle
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('menu');
        btn && btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center px-4 md:px-12 pt-8 pb-4 bg-white shadow-sm">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold text-[#232366] mb-2">Digital Library</h1>
            <p class="text-lg text-gray-700 mb-4">Access thousands of book<br>online</p>
            <div class="flex items-center w-full max-w-md bg-[#dedede] rounded-lg px-4 py-2 shadow-inner">
                <form action="" method="POST" class="flex items-center w-full gap-2">
                    <input type="text" placeholder="Search books" name="key" class="flex-1 bg-transparent outline-none text-lg text-gray-700 placeholder-gray-500 px-2 py-1 rounded focus:bg-white focus:ring-2 focus:ring-[#232366] transition">
                    <button type="submit" name="submit" class="bg-[#232366] hover:bg-[#4343a3] text-white px-4 py-2 rounded-lg font-semibold transition shadow">
                        Search 
                    </button>
                </form>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" fill="none"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
    </div>
    <!-- Buku List -->
    <div class="flex-1 px-4 md:px-12 py-8 bg-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <?php foreach($buku as $b): ?>
                <a href="detail_buku.php?id_buku=<?= $b['BukuID'] ?>" class="no-underline text-gray-800 hover:text-blue-600 transition">
                    <div class="flex flex-col items-center bg-[#f9f9fa] rounded-xl shadow-md hover:shadow-xl transition duration-300 p-4 group">
                        <div class="w-36 h-52 bg-gray-200 rounded-lg overflow-hidden shadow group-hover:scale-105 transition duration-300">
                            <img src="img/<?php echo $b["Foto"] ?>" alt="<?= $b['Judul'] ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="mt-3 text-base font-semibold text-gray-800 text-center line-clamp-2"><?= $b['Judul'] ?></div>
                        <div class="text-sm text-gray-500 text-center"><?= $b['Penulis'] ?></div>
                        <div class="flex items-center justify-center mt-1 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M12 20h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M17 20V4a2 2 0 00-2-2H7a2 2 0 00-2 2v16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span class="text-xs">Book</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-[#dedede] text-center py-3 text-gray-600 text-sm mt-auto shadow-inner">
        © 2025 perpustakaan digital | Powered by perpustakaan digital
    </footer>
</body>
</html>