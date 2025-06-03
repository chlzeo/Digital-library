<?php
session_start();
include '../function/koneksi.php';
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
$user = read("SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin_buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-orange-50 min-h-screen text-gray-800">
<nav class="bg-white shadow-lg py-4 px-0 mb-6">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="Logo" class="w-10 h-10">
            <span class="text-2xl font-bold text-blue-700 tracking-wide">Perpustakaan</span>
        </div>  
        <div class="space-x-4 flex items-center">
             <a href="kategori.php" class="hover:text-blue-700 transition font-medium">Kategori</a>
            <a href="index.php" class="text-blue-700 font-bold underline">User</a>
            <a href="admin_pengembalian.php" class="hover:text-blue-700 transition font-medium">Peminjaman</a>
            <a href="admin_buku.php" class="hover:text-blue-700 transition font-medium">Buku</a>
            <a href="logout.php" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 text-white font-semibold shadow transition">Logout</a>
        </div>
    </div>
</nav>
<div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-blue-800 mb-1">Daftar User</h1>
            <p class="text-gray-500">Kelola data user perpustakaan dengan mudah.</p>
        </div>
    </div>
    <div class="overflow-x-auto rounded-lg shadow-lg bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-4 py-3 text-center text-sm font-bold text-blue-800">No</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-blue-800">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-blue-800">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-blue-800">Role</th>
                    <th class="px-6 py-3 text-center text-sm font-bold text-blue-800">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php 
                $no = 1; 
                foreach($user as $u):
                if($u['UserID'] == $_SESSION['UserID']) {
                    continue; // Skip the logged-in user
                }
                ?>
                <tr class="hover:bg-orange-50 transition">
                    <td class="px-4 py-4 text-center"><?php echo $no++; ?></td>
                    <td class="px-6 py-4"><?php echo $u["NamaLengkap"]; ?></td>
                    <td class="px-6 py-4"><?php echo $u["Email"]; ?></td>
                    <td class="px-6 py-4"><?php echo $u["role"]; ?></td>
                    <td class="px-6 py-4 text-center">
                        <a href="edit.php?id=<?php echo $u["UserID"]; ?>" class="text-blue-600 hover:underline font-semibold">Edit</a>
                        <span class="mx-1 text-gray-400">|</span>
                        <a href="hapus_user.php?id=<?= $u["UserID"]; ?>" class="text-red-600 hover:underline font-semibold" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(count($user) == 0): ?>
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-400">Tidak ada data user.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<footer class="mt-12 py-4 text-center text-gray-400 text-sm">
    &copy; <?= date('Y') ?> Perpustakaan Digital. All rights reserved.
</footer>
</body>
</html>