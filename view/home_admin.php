<?php
include_once '../function/koneksi.php';
session_start();
// Dummy data untuk demo, ganti dengan query database sesuai kebutuhan
$totalUser = count(read("SELECT * FROM user"));
// $totalUser = 100; // Contoh jumlah user, ganti dengan query database
$totalPeminjaman = count(read("SELECT * FROM peminjaman"));
$totalKategori = count(read("SELECT * FROM kategoribuku"));
$totalBuku = count (read("SELECT * FROM buku"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-lg py-4 px-0 mb-6">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="Logo" class="w-10 h-10">
            <span class="text-2xl font-bold text-blue-700 tracking-wide">Perpustakaan</span>
        </div>  
        <div class="space-x-4 flex items-center">
            <a href="home_admin.php" class="text-blue-700 font-bold underline">Home</a>
            <a href="kategori.php" class="hover:text-blue-700 transition font-medium">Kategori</a>
            <a href="index.php" class="hover:text-blue-700 transition font-medium">User</a>
            <a href="admin_pengembalian.php" class="hover:text-blue-700 transition font-medium">Peminjaman</a>
            <a href="admin_buku.php" class="hover:text-blue-700 transition font-medium">Buku</a>
            <a href="logout.php" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 text-white font-semibold shadow transition">Logout</a>
        </div>
    </div>
</nav>

<!-- Header Dashboard -->
<div class="container mx-auto mb-8">
    <div class="text-center mt-8 mb-4">
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600 text-lg">Selamat datang di halaman admin. Kelola data perpustakaan dengan mudah dan cepat.</p>
    </div>
    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-blue-100 rounded-xl p-6 flex flex-col items-center shadow hover:scale-105 transition-transform duration-200">
            <div class="bg-blue-200 rounded-full p-3 mb-2">
                <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87m13-3.13a4 4 0 1 0-8 0 4 4 0 0 0 8 0zm-13 0a4 4 0 1 0 8 0 4 4 0 0 0-8 0z"/></svg>
            </div>
            <span class="text-3xl font-bold text-blue-700"><?php echo $totalUser; ?></span>
            <span class="text-gray-700 mt-2">Total User</span>
        </div>
        <div class="bg-green-100 rounded-xl p-6 flex flex-col items-center shadow hover:scale-105 transition-transform duration-200">
            <div class="bg-green-200 rounded-full p-3 mb-2">
                <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 17l4 4 4-4m-4-5v9"/></svg>
            </div>
            <span class="text-3xl font-bold text-green-700"><?php echo $totalPeminjaman; ?></span>
            <span class="text-gray-700 mt-2">Total Peminjaman</span>
        </div>
        <div class="bg-yellow-100 rounded-xl p-6 flex flex-col items-center shadow hover:scale-105 transition-transform duration-200">
            <div class="bg-yellow-200 rounded-full p-3 mb-2">
                <svg class="w-8 h-8 text-yellow-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            </div>
            <span class="text-3xl font-bold text-yellow-700"><?php echo $totalKategori; ?></span>
            <span class="text-gray-700 mt-2">Total Kategori</span>
        </div>
        <div class="bg-purple-100 rounded-xl p-6 flex flex-col items-center shadow hover:scale-105 transition-transform duration-200">
            <div class="bg-purple-200 rounded-full p-3 mb-2">
                <svg class="w-8 h-8 text-purple-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9M12 4h9M4 4h.01M4 20h.01M4 8h.01M4 16h.01"/></svg>
            </div>
            <span class="text-3xl font-bold text-purple-700"><?php echo $totalBuku; ?></span>
            <span class="text-gray-700 mt-2">Total Buku</span>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-white shadow-inner py-4 mt-12">
    <div class="container mx-auto text-center text-gray-500 text-sm">
        &copy; <?php echo date('Y'); ?> Perpustakaan Digital. All rights reserved.
    </div>
</footer>
</body>
</html>