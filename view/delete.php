<?php
session_start();
include '../function/koneksi.php';
$id = $_GET['id'];
if(hapus_user($id) > 0){
    echo "<script>alert('Data berhasil dihapus!');window.location='index.php';</script>";
} else {
    echo "<script>alert('Data gagal dihapus!');window.location='index.php';</script>";
}
?>