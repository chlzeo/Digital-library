<?php
session_start();
include '../function/koneksi.php';
$user_id = $_SESSION['UserID'];

// Data dummy peminjaman
$peminjaman = read("SELECT p.*, b.Judul, b.Foto 
    FROM peminjaman p 
    JOIN buku b ON p.BukuID = b.BukuID 
    WHERE p.UserID = $user_id
    ORDER BY p.PeminjamanID DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f5f5] min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg px-8 py-4 flex items-center justify-between sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="Logo" class="w-10 h-10">
        </div>
        <div class="md:hidden"></div>
        <div id="menu" class="flex-1 flex-col md:flex md:flex-row md:justify-center md:items-center gap-8 items-center text-lg font-medium absolute md:static top-20 left-0 w-full md:w-auto bg-white md:bg-transparent z-20 hidden md:flex">
            <ul class="flex flex-col md:flex-row gap-8 items-center w-full md:w-auto">
                <li><a href="buku.php" class="text-[#232366] hover:underline transition">Home</a></li>
                <li><a href="peminjaman_user.php" class="text-[#232366] hover:underline transition font-bold">Peminjaman</a></li>
                <li><a href="koleksi.php" class="text-[#232366] hover:underline transition">koleksi</a></li>
            </ul>
        </div>
        <a href="/perpustakaan/view/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg font-semibold transition hidden md:block shadow">
            Logout
        </a>
    </nav>
    <div class="flex-1 px-4 md:px-12 py-8">
        <h1 class="text-3xl font-bold text-[#232366] mb-6">History Peminjaman Buku</h1>
        <div class="bg-white rounded-xl shadow p-6">
            <?php if (empty($peminjaman)): ?>
                <div class="text-center text-gray-500 py-10">Belum ada riwayat peminjaman buku.</div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead>
                        <tr class="bg-[#e6ecf5] text-[#232366]">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Cover</th>
                            <th class="py-3 px-4">Judul Buku</th>
                            <th class="py-3 px-4">Tanggal Pinjam</th>
                            <th class="py-3 px-4">Tanggal Kembali</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($peminjaman as $i => $row): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4"><?= $i+1 ?></td>
                            <td class="py-2 px-4">
                                <img src="img/<?= htmlspecialchars($row['Foto']) ?>" alt="<?= htmlspecialchars($row['Judul']) ?>" class="w-12 h-16 object-cover rounded shadow">
                            </td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['Judul']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['TanggalPeminjaman']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['TanggalPengembalian']) ?></td>
                            <td class="py-2 px-4">
                                <?php
                                    if ($row['StatusPeminjaman'] == 'kembali') {
                                        echo '<span class="text-green-600 font-semibold">Selesai</span>';
                                    } else {
                                        echo '<span class="text-yellow-600 font-semibold">Dipinjam</span>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
     <footer class="bg-[#dedede] text-center py-3 text-gray-600 text-sm mt-auto shadow-inner">
        © 2025 perpustakaan digital | Powered by perpustakaan digital
    </footer>
</body>
</html>