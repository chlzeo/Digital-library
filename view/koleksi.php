<?php 
include '../function/koneksi.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: view/login.php");
    exit;
}

$user_id = $_SESSION['UserID'];

$favorit = read("
    SELECT koleksipribadi.KoleksiID, buku.*
    FROM koleksipribadi 
    JOIN buku ON koleksipribadi.BukuID = buku.BukuID
    WHERE koleksipribadi.UserID = $user_id

");

$peminjam_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Favorit Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex flex-col">
    <div class="w-full bg-white shadow sticky top-0 z-20">
    <nav class="bg-white shadow-lg px-8 py-4 flex items-center justify-between sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <img src="/perpustakaan/view/img/anjai.svg" alt="Logo" class="w-10 h-10">
        </div>
        <!-- Hamburger button for mobile -->
        <div class="md:hidden">
            <!-- Optional: Hamburger icon for mobile -->
        </div>
        <div id="menu" class="flex-1 flex-col md:flex md:flex-row md:justify-center md:items-center gap-8 items-center text-lg font-medium absolute md:static top-20 left-0 w-full md:w-auto bg-white md:bg-transparent z-20 hidden md:flex">
            <ul class="flex flex-col md:flex-row gap-8 items-center w-full md:w-auto">
                <li><a href="buku.php" class="text-[#232366] hover:underline transition">Home</a></li>
                <li><a href="peminjaman_user.php" class="text-[#232366] hover:underline transition">Peminjaman</a></li>
                <li><a href="koleksi.php" class="text-[#232366] hover:underline transition">koleksi</a></li>
            </ul>
        </div>
        <a href="/perpustakaan/view/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg font-semibold transition hidden md:block shadow">
            Logout
        </a>
    </nav>
    </div>

    <div class="max-w-7xl mx-auto flex-1 w-full flex flex-col items-center px-4">
        <div class="mt-12 mb-8 text-center">
            <h1 class="text-6xl font-extrabold text-[#232366] mb-6 tracking-wide drop-shadow">Koleksi Saya</h1>
            <!-- Search bar -->
        
        </div>
        <?php if (count($favorit) > 0): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-x-12 gap-y-10 w-full justify-items-center">
            <?php foreach($favorit as $b): ?>
                <div class="flex flex-col items-center">
                    <div class="relative mb-2">
                        <img src="img/<?= htmlspecialchars($b['Foto']); ?>" alt="<?= htmlspecialchars($b['Judul']); ?>" class="w-36 h-52 object-cover rounded-lg border shadow bg-gray-100" />
                        <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-white border rounded-full shadow px-2 py-1 flex items-center gap-1 text-xs font-semibold text-[#232366]">
                            <svg class="w-5 h-5 text-[#232366]" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 9.25C2.003 5.798 5.134 3 9 3s6.997 2.798 6.997 6.25c0 2.86-2.28 5.197-5.197 7.197a1.75 1.75 0 01-1.6 0C4.283 14.447 2.003 12.11 2.003 9.25z"/></svg>
                            Favorit
                        </span>
                    </div>
                    <div class="text-center mt-4">
                        <div class="font-bold text-base text-[#232366] mb-1 w-36 truncate" title="<?= htmlspecialchars($b['Judul']); ?>">
                            <?= htmlspecialchars($b['Judul']); ?>
                        </div>
                        <div class="text-xs text-gray-600 mb-2 w-36 truncate"><?= htmlspecialchars($b['Penulis']); ?></div>
                    </div>
                    <div class="flex gap-2 w-36">
                        <a href="pinjam.php?id_buku=<?= $b['BukuID']; ?>" class="flex-1 bg-gradient-to-r from-blue-700 to-blue-400 text-white px-2 py-1 rounded-lg hover:from-blue-800 hover:to-blue-500 text-center font-semibold transition shadow text-xs flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                            Pinjam
                        </a>
                        <a href="hapus_koleksi.php?id=<?= $b['KoleksiID']; ?>" onclick="return confirm('Yakin ingin menghapus?');" class="flex-1 bg-gradient-to-r from-red-100 to-red-200 text-red-700 px-2 py-1 rounded-lg hover:from-red-200 hover:to-red-300 text-center font-semibold transition shadow border border-red-200 flex items-center justify-center gap-1 text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                            Hapus
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="flex flex-col items-center mt-20">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="Empty" class="w-32 h-32 mb-4 opacity-60">
                <p class="text-gray-600 text-lg text-center">Belum ada buku favorit.<br>Tambahkan buku ke favorit dari halaman katalog.</p>
            </div>
        <?php endif; ?>
    </div>
    <footer class="bg-[#dedede] text-center py-3 text-gray-600 text-sm mt-auto shadow-inner">
        © 2025 perpustakaan digital | Powered by perpustakaan digital
    </footer>
</body>
</html>