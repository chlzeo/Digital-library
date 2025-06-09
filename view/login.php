<?php 
session_start();
include '../function/koneksi.php';
if(isset($_POST["submit"])){
    $name = $_POST["username"];
    $password = $_POST["password"];
    $result  = mysqli_query($koneksi, "SELECT*FROM user WHERE Username = '$name'");
    $row = mysqli_fetch_assoc($result);
    if($row > 0 ){
        if(password_verify($password, $row["Password"])){
            $_SESSION["name"] = $row['NamaLengkap'];
            $_SESSION["role"] = $row['role'];
            $_SESSION["login"] = true;
            $_SESSION["UserID"] = $row['UserID'];
            if($row['role'] === 'admin' || $row['role'] === 'petugas'){
            header("location: home_admin.php");
            }elseif($row["role"] === "peminjam"){
                header("Location: buku.php");
            }
            exit;
        }
        $error = true;
    } $error1 = true;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-md rounded-lg p-8 w-96">
        <h1 class="text-2xl font-bold text-center text-blue-800 mb-6">Digital Library</h1>
        <?php if(isset($error)): ?>
            <p class="text-red-500 text-sm text-center">Username salah</p>
        <?php elseif(isset($error1)): ?>
            <p class="text-red-500 text-sm text-center"> Password salah</p>
        <?php endif; ?>
        <form action="" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">User name</label>
                <input type="text" name="username" id="username" placeholder="User name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-between">
                <button type="submit" name="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Login</button>
                <a href="sign.php" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Register</a>
            </div>
        </form>
    </div>
</body>
</html>