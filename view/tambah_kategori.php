<?php
session_start();
include '../function/koneksi.php';
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
if (isset($_POST['submit'])) {
    if (tambah_kategori($_POST) > 0) {
        echo "<script>alert('Kategori berhasil ditambahkan!');window.location='kategori.php';</script>";
    } else {
        echo "<script>alert('Kategori gagal ditambahkan!');window.location='tambah_kategori.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-md mx-auto mt-16 bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-blue-700">Tambah Kategori Buku</h2>
        <form action="" method="post" class="space-y-4">
            <div>
                <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
                <input type="text" id="nama" name="nama" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="flex justify-between items-center">
                <a href="kategori.php" class="text-blue-600 hover:underline">Kembali</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow transition" name="submit">Tambah</button>
            </div>
        </form>
    </div>
</body>
</html>
