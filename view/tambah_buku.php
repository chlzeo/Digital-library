<?php
session_start();
include '../function/koneksi.php';
$kategori = read("SELECT * FROM kategoribuku");
if (isset($_POST["submit"])){
    if(buku_tambah($_POST) > 0){
        echo "<script>alert('Buku baru berhasil ditambahkan!');window.location='admin_buku.php';</script>";
        exit;
    } else {
        echo "<script>alert('Buku baru gagal ditambahkan!');</script>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tambah_buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f5f5] min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-lg">
        <h2 class="text-3xl font-bold text-[#232366] mb-6 text-center">Tambah Buku</h2>
        <form action="" method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="Judul" class="block font-semibold text-gray-700 mb-1">Judul Buku</label>
                <input type="text" name="Judul" id="Judul" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#232366]">
            </div>
            <div>
                <label for="Penulis" class="block font-semibold text-gray-700 mb-1">Penulis</label>
                <input type="text" name="Penulis" id="Penulis" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#232366]">
            </div>
            <div>
                <label for="Penerbit" class="block font-semibold text-gray-700 mb-1">Penerbit</label>
                <input type="text" name="Penerbit" id="Penerbit" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#232366]">
            </div>
            <div>
                <label for="TahunTerbit" class="block font-semibold text-gray-700 mb-1">Tahun Terbit</label>
                <input type="text" name="TahunTerbit" id="TahunTerbit" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#232366]">
            </div>
            <div>
                <label for="KategoriID" class="block font-semibold text-gray-700 mb-1">Kategori</label>
                <select name="KategoriID" id="KategoriID" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#232366]">
                    <?php foreach($kategori as $row): ?>
                        <option value="<?= $row["KategoriID"]; ?>"><?= $row["NamaKategori"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="Sinopsis" class="block font-semibold text-gray-700 mb-1">Sinopsis</label>
                <textarea name="Sinopsis" id="Sinopsis" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#232366]"></textarea>
            </div>
            <div>
                <label for="Gambar" class="block font-semibold text-gray-700 mb-1">Gambar</label>
                <input type="file" name="Gambar" id="Gambar" required class="w-full text-gray-700">
            </div>
            <button type="submit" name="submit" class="w-full bg-[#232366] text-white py-2 rounded-lg font-semibold hover:bg-[#4343a3] transition">Kirim</button>
        </form>
    </div>
</body>
</html>