<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["UserID"])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href = '../login.php';</script>";
    exit;
}

// Panggil koneksi & fungsi
require '../function/koneksi.php';

$buku_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$user_id = $_SESSION["UserID"];

// Cek validitas ID buku
if ($buku_id <= 0) {
    echo "<script>alert('ID Buku tidak valid!'); window.history.back();</script>";
    exit;
}

// Cek apakah buku ada di database
$query_buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE BukuID = $buku_id");
if (mysqli_num_rows($query_buku) === 0) {
    echo "<script>alert('Buku tidak ditemukan di database!'); window.history.back();</script>";
    exit;
}

// Cek apakah buku sudah ada di koleksi user
$query_cek = mysqli_query($koneksi, "SELECT * FROM koleksipribadi WHERE UserID = $user_id AND BukuID = $buku_id");
if (mysqli_num_rows($query_cek) > 0) {
    echo "<script>alert('Buku sudah ada di koleksi Anda!'); window.history.back();</script>";
    exit;
}

// Tambah koleksi
$query_tambah = mysqli_query($koneksi, "INSERT INTO koleksipribadi (UserID, BukuID) VALUES ('$user_id', '$buku_id')");

if ($query_tambah) {
    echo "<script>alert('Buku berhasil ditambahkan ke koleksi!'); window.location.href = 'koleksi.php';</script>";
} else {
    echo "<script>alert('Gagal menambahkan buku ke koleksi.'); window.history.back();</script>";
}
?>
