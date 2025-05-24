<?php
$id = $_GET['id'];
include '../function/koneksi.php';  

if(hapus($id) > 0){
    echo "<script>alert('User berhasil dihapus!');window.location='index.php';</script>";
} else {
    echo "<script>alert('User gagal dihapus!');window.location='index.php';</script>";
}
?>
