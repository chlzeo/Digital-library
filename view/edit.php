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
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Edit User</h2>
        <form action="" method="post" class="space-y-5">
            <input type="hidden" name="id" value="<?php echo $query["UserID"] ?>">
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="<?php echo $query["NamaLengkap"]  ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="<?php echo $query["Email"] ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"><?php echo $query["Alamat"] ?></textarea>
            </div>
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Role</label>
                <select name="role" id="role" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="admin" <?php echo $query["role"] == "admin" ? "selected" : ""; ?>>Admin</option>
                    <option value="petugas" <?php echo $query["role"] == "petugas" ? "selected" : ""; ?>>Petugas</option>
                    <option value="peminjam" <?php echo $query["role"] == "peminjam" ? "selected" : ""; ?>>peminjam</option>
                </select>
            </div>
            <button type="submit" name="submit" class="w-full py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">Simpan</button>
        </form>
        <a href="index.php" class="block mt-4 text-center bg-gray-300 text-blue-700 font-semibold py-2 rounded-lg hover:bg-gray-400 transition">Kembali</a>
    </div>
</body>
</html>