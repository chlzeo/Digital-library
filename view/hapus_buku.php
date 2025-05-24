<?php
$id = $_GET['id'];
include '../function/koneksi.php';  
if(hapus_buku($id) > 0){
    echo "<script>alert('Data berhasil dihapus!');window.location='admin_buku.php';</script>";
} else {
    echo "<script>alert('Data gagal dihapus!');window.location='admin_buku.php';</script>";
}