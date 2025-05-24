<?php
session_start();
include '../function/koneksi.php';
if (isset($_POST['kembali'])) {
    $id = $_POST['id'];
    if (dikembalikan($id) > 0) {
        echo "<script>alert('Buku berhasil dikembalikan!');window.location='pengembalian.php';</script>";
    } else {
        echo "<script>alert('Buku gagal dikembalikan!');window.location='pengembalian.php';</script>";
    }
}
$peminjam =read("SELECT * FROM peminjaman 
    INNER JOIN user ON peminjaman.UserID = user.UserID 
    INNER JOIN buku ON peminjaman.BukuID = buku.BukuID");
?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
 </head>
 <body>
    <nav class="bg-white shadow-lg py-4 px-0 mb-6">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="Logo" class="w-10 h-10">
                <span class="text-2xl font-bold text-blue-700 tracking-wide">Perpustakaan</span>
            </div>
            <div class="space-x-4 flex items-center">
                 <a href="kategori.php" class="hover:text-blue-700 transition font-medium">Kategori</a>
                <a href="index.php" class="hover:text-blue-700 transition font-medium">User</a>
                <a href="admin_pengembalian.php" class="text-blue-700 font-bold underline">Peminjaman</a>
                <a href="admin_buku.php" class="hover:text-blue-700 transition font-medium">Buku</a>
                <a href="logout.php" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 text-white font-semibold shadow transition">Logout</a>
            </div>
        </div>
    </nav>
    <div class="overflow-x-auto mx-4">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
            <thead class="bg-blue-700 text-white sticky top-0">
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
                <?php $no = 1; foreach($peminjam as $row): ?>
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
 </body>
 </html>