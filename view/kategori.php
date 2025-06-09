<?php 
session_start();
include '../function/koneksi.php';
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
if(isset($_POST['submit'])) {
    $id_hapus = $_POST['id_hapus'];
    if (hapus_kategori($id_hapus) > 0) {
        echo "<script>alert('Kategori berhasil dihapus!');window.location='kategori.php';</script>";
    } else {
        echo "<script>alert('Kategori gagal dihapus!');window.location='kategori.php';</script>";
    }
}
$kategori = read("SELECT * FROM kategoribuku");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kategori</title>
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
                <a href="home_admin.php" class="hover:text-blue-700 transition font-medium">Home</a>
                 <a href="kategori.php" class="text-blue-700 font-bold underline">Kategori</a>
                <a href="index.php" class="hover:text-blue-700 transition font-medium">User</a>
                <a href="admin_pengembalian.php" class="hover:text-blue-700 transition font-medium">Peminjaman</a>
                <a href="admin_buku.php" class="hover:text-blue-700 transtion font-medium">Buku</a>
                <a href="logout.php" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 text-white font-semibold shadow transition">Logout</a>
            </div>
        </div>
    </nav>
    <div class="max-w-2xl mx-auto mt-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-700">Daftar Kategori Buku</h2>
            <a href="tambah_kategori.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition">Tambah Kategori</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-gray-200">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-gray-200">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $no = 1; foreach($kategori as $row): ?>
                    <tr class="<?= $no % 2 == 0 ? 'bg-gray-50' : 'bg-white' ?>">
                        <td class="px-6 py-4"><?= $no++; ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($row['NamaKategori']); ?></td>
                        <td class="px-6 py-4">
                            <form action="" method="post" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');" class="inline">
                                <input type="hidden" name="id_hapus" value="<?= $row['KategoriID']; ?>">
                                <button type="submit" name="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-bold shadow transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>