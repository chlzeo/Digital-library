<?php
session_start();
include '../function/koneksi.php';
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
$id = $_GET['id'];
$kategori = read("SELECT * FROM kategoribuku");
$relasi = read("SELECT * FROM kategoribuku_relasi WHERE BukuID = $id");
$kategori_id = $relasi? $relasi[0]['KategoriID'] : null;
$buku = read("SELECT * FROM buku WHERE BukuID = $id")[0];
if (isset($_POST["submit"])){
    if (isset($_POST["submit"])){
        $result = buku_edit($_POST);
        if($result !== false){
            echo "<script>
                    alert('Data berhasil diubah!');
                    window.location.href = 'admin_buku.php';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Data gagal diubah!');
                  </script>";
        }}
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tambah_buku</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $buku["BukuID"]?>">
    <input type="hidden" name="Foto_lama" value="<?php echo $buku["Foto"]?>">
    <h2>Tambah Buku</h2><br>
    <label for="Judul">Judul Buku</label><br>
    <input type="text" name="Judul" id="Judul" required value="<?php echo $buku["Judul"]?>" ><br>
    <label for="Penulis">Penulis</label><br>
    <input type="text" name="Penulis" id="Penulis" required value="<?php echo $buku["Penulis"]?>" ><br>
    <label for="Penerbit">Penerbit</label><br>
    <input type="text" name="Penerbit" id="Penerbit" required value="<?php echo $buku["Penerbit"]?>" ><br>
    <label for="TahunTerbit">Tahun Terbit</label><br>
    <input type="text" name="TahunTerbit" id="TahunTerbit" required value="<?php echo $buku["Judul"]?>" ><br>
    <label for="KategoriID">Kategori</label><br>
    <select name="KategoriID" id="KategoriID" required>
        <?php
        foreach ($kategori as $k) : ?>
    <option value="<?= $k['KategoriID']; ?>" <?= ($k['KategoriID'] ==$kategori_id) ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['NamaKategori']); ?>
        </option>
        <?php endforeach; ?>
    </select><br>
    <label for="Sinopsis">Sinopsis</label><br>
    <textarea name="Sinopsis" id="Sinopsis" required> <?php echo $buku["Deskripsi"]?></textarea><br>
    <label for="Gambar">Gambar</label><br>
    <input type="file" name="Gambar" id="Gambar"><br>
        <img src="img/<?php echo $buku['Foto'] ?>" alt="foto_lama"/>
</div>
    <button type="submit" name="submit">kirim</button>

    </form>
</body>
</html>