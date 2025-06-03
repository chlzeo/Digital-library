<?php
include '../function/koneksi.php';
if(isset($_POST['submit'])){
    if(sign($_POST) > 0){
        echo "<script>alert('User baru berhasil ditambahkan!');window.location='login.php';</script>";
        exit;
    } else {
        echo "<script>alert('User baru gagal ditambahkan!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-xs bg-gray-200 rounded-2xl p-8 flex flex-col items-center">
        <h1 class="text-3xl font-bold text-[#232b5d] mb-6 text-center">Digital Library</h1>
        <form action="" method="post" class="w-full flex flex-col gap-4">
            <input type="text" name="nama_lengkap" placeholder="Full Name" required class="w-full px-4 py-2 bg-white rounded-none border-none focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-500">
            <input type="email" name="email" placeholder="Email Address" required class="w-full px-4 py-2 bg-white rounded-none border-none focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-500">
            <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-2 bg-white rounded-none border-none focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-500">
            <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 bg-white rounded-none border-none focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-500">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full px-4 py-2 bg-white rounded-none border-none focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-500">
            <input type="text" name="alamat" placeholder="Alamat" required class="w-full px-4 py-2 bg-white rounded-none border-none focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-500">
            <button type="submit" name="submit" class="w-full py-2 mt-2 rounded-none bg-[#232b5d] text-white font-semibold hover:bg-[#1a2045] transition">Register</button>
        </form>
        <a href="login.php" class="w-full mt-4 inline-block text-center py-2 rounded-none bg-blue-700 text-white font-semibold hover:bg-blue-800 transition">Login</a>
    </div>
</body>
</html>