<?php
session_start();
include '../function/koneksi.php';
$id = $_GET['id'];
$query = read("SELECT * FROM user WHERE UserID = $id")[0];
if (isset($_POST["submit"])){
    if(edit_user($_POST) > 0){
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
              </script>";
    } elseif(edit_user($_POST) < 0) {
        echo "<script>
                alert('Data gagal diubah!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit</title>
</head>
<body>
    <form action="" method="post">
    <label>Nama Lengkap</label><br>
        <input type="hidden" name="id" value="<?php echo $query["UserID"] ?>">
        <input type="text" name="nama" value="<?php echo $query["NamaLengkap"]  ?>"><br><br>
        <label>Email</label><br>
        <input type="email" name="email" value="<?php echo $query["Email"] ?>"><br><br>
        <label>Alamat</label><br>
        <textarea name="alamat"><?php echo $query["Alamat"] ?></textarea><br><br>
        <button type="submit" name="submit">Simpan</button>
    </form>
</body>
</html>