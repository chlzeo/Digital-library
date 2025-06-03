<?php
// Mulai session untuk autentikasi
session_start();
// Import fungsi select data dari database
include '../function/koneksi.php';
// Jika tombol kembalikan ditekan
if (isset($_POST['kembali'])) {
    // Import fungsi kembalikan buku
    $id = $_POST["id"];
    // Jika kembalikan berhasil
    if (kembalikan($id) > 0) {
        echo "<script>alert('Buku berhasil dikembalikan!');</script>";
        echo "<script>location='admin_pengembalian.php';</script>";
    } else {
        echo "<script>alert('Gagal mengembalikan buku!');</script>";
    }
}
// Cek apakah user sudah login, jika belum redirect ke login
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
// Cek role user, hanya admin/petugas yang boleh akses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas') {
    header("Location: ../view/katalog.php");
    exit;
}
// Ambil data peminjaman beserta relasi user dan buku
$peminjaman = read("SELECT * FROM peminjaman 
    INNER JOIN user ON peminjaman.UserID = user.UserID 
    INNER JOIN buku ON peminjaman.BukuID = buku.BukuID
");
$user = read("SELECT * FROM user");
$buku = read("SELECT * FROM buku");
// Tambahkan ambil data kategori
$kategori = read("SELECT * FROM kategoribuku");
// Ambil nama admin dari session
$admin_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f5f5] min-h-screen">
    <!-- Navbar di paling atas -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-20">
            <div class="flex items-center gap-3">
                <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="Logo" class="w-10 h-10">
                <span class="text-2xl font-bold text-blue-700 tracking-wide">Perpustakaan</span>
            </div>
            <div class="flex items-center space-x-6">
                <a href="kategori.php" class="hover:text-blue-700 transition font-medium">Kategori</a>
                <a href="index.php" class="hover:text-blue-700 transition font-medium">User</a>
                <a href="admin_pengembalian.php" class="text-blue-700 font-bold underline">Peminjaman</a>
                <a href="admin_buku.php" class="hover:text-blue-700 transition font-medium">Buku</a>
                <a href="logout.php" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 text-white font-semibold shadow transition ml-2">Logout</a>
            </div>
        </div>
    </nav>
    <!-- Konten utama -->
    <div class="w-full max-w-4xl mx-auto mt-10 flex flex-col items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full">
            <h2 class="text-3xl font-bold text-[#232366] mb-6 text-center">Pengembalian Buku</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead class="bg-[#232366] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-gray-200">No</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-gray-200">Nama Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-gray-200">Judul Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-gray-200">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-gray-200">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-gray-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $no = 1; foreach($peminjaman as $row): ?>
                        <tr class="<?= $no % 2 == 0 ? 'bg-gray-50' : 'bg-white' ?>">
                            <td class="px-6 py-4"><?= $no++; ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($row['NamaLengkap']); ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($row['Judul']); ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($row['TanggalPeminjaman']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($row["StatusPeminjaman"] === "dipinjam"): ?>
                                    <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold text-xs">Belum Dikembalikan</span>
                                <?php else: ?>
                                    <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-xs">Dikembalikan</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($row["StatusPeminjaman"] == "dipinjam"): ?>
                                    <form action="" method="post" >
                                        <input type="hidden" name="id" value="<?= $row['PeminjamanID'] ?>">
                                        <button type="submit" name="kembali" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow transition-all duration-200 hover:from-red-600 hover:to-red-700">Kembalikan</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-gray-500">Sudah Dikembalikan</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>