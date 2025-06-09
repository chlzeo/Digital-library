<?php
session_start();
include '../function/koneksi.php';
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
$buku = read("SELECT * FROM buku");

// Tambahan: Query untuk total user, kategori, dan peminjaman
$total_user = count(read("SELECT * FROM user"));
$total_kategori = count(read("SELECT * FROM kategoribuku"));
$total_peminjaman = count(read("SELECT * FROM peminjaman"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Buku | Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-orange-50 min-h-screen text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg py-4 px-0 mb-6">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="Logo" class="w-10 h-10">
                <span class="text-2xl font-bold text-blue-700 tracking-wide">Perpustakaan</span>
            </div>
            <div class="space-x-4 flex items-center">
                <a href="home_admin.php" class="hover:text-blue-700 transition font-medium">Home</a>
                 <a href="kategori.php" class="hover:text-blue-700 transition font-medium">Kategori</a>
                <a href="index.php" class="hover:text-blue-700 transition font-medium">User</a>
                <a href="admin_pengembalian.php" class="hover:text-blue-700 transition font-medium">Peminjaman</a>
                <a href="admin_buku.php" class="text-blue-700 font-bold underline">Buku</a>
                <a href="logout.php" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 text-white font-semibold shadow transition">Logout</a>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-blue-800 mb-1">Daftar Buku</h1>
                <p class="text-gray-500">Kelola data buku perpustakaan dengan mudah.</p>
            </div>
            <a href="tambah_buku.php" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 font-semibold shadow transition">+ Tambah Buku</a>
        </div>
        <!-- Card Jumlah Buku -->
        <div class="flex flex-col md:flex-row justify-center gap-6 mb-8">
            <!-- Card Total Buku -->
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center w-full max-w-xs">
                <div class="bg-blue-100 rounded-full p-3 mb-2">
                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M17 20V4a2 2 0 00-2-2H7a2 2 0 00-2 2v16"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-800">
                    <?php echo count($buku) ?? "data buku kosong" ?>
                </div>
                <div class="text-gray-500">Total Buku</div>
            </div>
            <!-- Card Total User -->
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center w-full max-w-xs">
                <div class="bg-green-100 rounded-full p-3 mb-2">
                    <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V4a2 2 0 00-2-2H4a2 2 0 00-2 2v16h5"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                        <path d="M6 20v-2a4 4 0 014-4h0a4 4 0 014 4v2"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-800">
                    <?php echo $total_user; ?>
                </div>
                <div class="text-gray-500">Total User</div>
            </div>
            <!-- Card Total Kategori -->
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center w-full max-w-xs">
                <div class="bg-yellow-100 rounded-full p-3 mb-2">
                    <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                        <path d="M9 9h6v6H9z"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-800">
                    <?php echo $total_kategori; ?>
                </div>
                <div class="text-gray-500">Total Kategori</div>
            </div>
            <!-- Card Total Peminjaman -->
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center w-full max-w-xs">
                <div class="bg-red-100 rounded-full p-3 mb-2">
                    <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-800">
                    <?php echo $total_peminjaman; ?>
                </div>
                <div class="text-gray-500">Total Peminjaman</div>
            </div>
        </div>
        <div class="overflow-x-auto rounded-lg shadow-lg bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-3 text-center text-sm font-bold text-blue-800">No</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-blue-800">Judul Buku</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-blue-800">Pengarang</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-blue-800">Penerbit</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-blue-800">Tahun Terbit</th>
                        <th class="px-6 py-3 text-center text-sm font-bold text-blue-800">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php 
                    $no = 1; 
                    foreach($buku as $row): ?>
                    <tr class="hover:bg-orange-50 transition">
                        <td class="px-4 py-4 text-center"><?php echo $no++; ?></td>
                        <td class="px-6 py-4"><?php echo $row["Judul"]; ?></td>
                        <td class="px-6 py-4"><?php echo $row["Penulis"]; ?></td>
                        <td class="px-6 py-4"><?php echo $row["Penerbit"]; ?></td>
                        <td class="px-6 py-4"><?php echo $row["TahunTerbit"]; ?></td>
                        <td class="px-6 py-4 text-center">
                            <a href="edit_buku.php?id=<?php echo $row["BukuID"]; ?>" class="text-blue-600 hover:underline font-semibold">Edit</a>
                            <span class="mx-1 text-gray-400">|</span>
                            <a href="hapus_buku.php?id=<?= $row["BukuID"]; ?>" class="text-red-600 hover:underline font-semibold" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(count($buku) == 0): ?>
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400">Tidak ada data buku.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Footer -->
    <footer class="mt-12 py-4 text-center text-gray-400 text-sm">
        &copy; <?= date('Y') ?> Perpustakaan Digital. All rights reserved.
    </footer>
</body>
</html>