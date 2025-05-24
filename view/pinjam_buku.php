<?php
session_start();
include '../function/koneksi.php';
$id = $_GET['id'];
$user_id = $_SESSION['UserID'];
if (isset($_POST['submit'])) {
    $pinjam = pinjam($id, $user_id);
    if ($pinjam > 0) {
        echo "<script>alert('Buku berhasil dipinjam!');window.location='buku.php';</script>";
    } else {
        echo "<script>alert('Buku gagal dipinjam!');window.location='buku.php';</script>";
    }
}
// Ambil data buku
$buku = read("SELECT * FROM buku WHERE BukuID = '$id'");
$buku = $buku ? $buku[0] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f5f5] min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg px-8 py-4 flex items-center justify-between sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <img src="/perpustakaan/view/img/anjai.svg" alt="Logo" class="w-10 h-10">
        </div>
        <div class="md:hidden">
            <!-- Optional: Hamburger icon for mobile -->
        </div>
        <div id="menu" class="flex-1 flex-col md:flex md:flex-row md:justify-center md:items-center gap-8 items-center text-lg font-medium absolute md:static top-20 left-0 w-full md:w-auto bg-white md:bg-transparent z-20 hidden md:flex">
            <ul class="flex flex-col md:flex-row gap-8 items-center w-full md:w-auto">
                <li><a href="buku.php" class="text-[#232366] hover:underline transition">Home</a></li>
                <li><a href="#" class="text-[#232366] hover:underline transition">Peminjaman</a></li>
                <li><a href="laporan.php" class="text-[#232366] hover:underline transition">Laporan</a></li>
            </ul>
        </div>
        <a href="/perpustakaan/view/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg font-semibold transition hidden md:block shadow">
            Logout
        </a>
    </nav>
    <div class="w-full max-w-5xl mx-auto flex flex-col md:flex-row items-start gap-10 p-4 flex-1">
        <!-- Kiri: Judul dan Form -->
        <div class="flex-1">
            <h1 class="text-5xl font-extrabold text-[#232366] mb-2">Digital Library</h1>
            <p class="text-lg text-gray-700 mb-8">Access thousands of book<br>online</p>
            <div class="bg-[#e6ecf5] rounded-xl p-8 shadow flex flex-col items-center w-full max-w-xl">
                <div class="text-center mb-6">
                    <div class="text-2xl font-bold text-gray-900 mb-1">Pengambilan</div>
                    <div class="text-base text-gray-700">Tanggal Peminjaman</div>
                </div>
                <form action="" method="post" class="w-full flex flex-col items-center">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                    <div class="relative w-full max-w-md mb-6">
                        <input
                            type="date"
                            name="tanggal_kembali"
                            required
                            class="border-2 border-[#232366] rounded-lg w-full pl-4 pr-12 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-[#232366] placeholder-gray-400"
                            min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                            placeholder="DD/MM/YY"
                            onfocus="this.type='date'"
                            onblur="if(this.value===''){this.type='text'}"
                            style="font-family: inherit;"
                       
                            viewBox="0 0 24 24" stroke="currentColor">
                                <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                                <path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </span>
                    </div>
                    <button
                        type="submit"
                        name="submit"
                        class="absolute right-0 bottom-[-50px] md:static md:mb-0 bg-[#232366] hover:bg-[#4343a3] text-white px-8 py-2 rounded-lg font-semibold transition shadow text-base"
                        style="width:99px;height:39px"
                    >
                        Pinjam
                    </button>
                </form>
            </div>
        </div>
        <!-- Kanan: Cover Buku -->
        <?php if($buku): ?>
        <div class="flex flex-col items-center w-full md:w-64">
            <div class="w-48 h-72 bg-gray-200 rounded-lg overflow-hidden shadow mb-4">
                <img src="img/<?= htmlspecialchars($buku['Foto']) ?>" alt="<?= htmlspecialchars($buku['Judul']) ?>" class="w-full h-full object-cover">
            </div>
            <div class="text-lg font-bold text-gray-900 text-center"><?= htmlspecialchars($buku['Judul']) ?></div>
            <div class="text-sm text-gray-600 text-center"><?= htmlspecialchars($buku['Penulis']) ?></div>
        </div>
        <?php endif; ?>
    </div>
    <script>
        // Placeholder DD/MM/YY untuk input date
        document.querySelectorAll('input[type="date"]').forEach(function(input){
            input.addEventListener('input', function(){
                input.classList.toggle('text-gray-400', !input.value);
            });
        });
    </script>
</body>
</html>

