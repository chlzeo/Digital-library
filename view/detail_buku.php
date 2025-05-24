<?php
session_start();
include '../function/koneksi.php';
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
$alert = '';
if(isset($_POST['submit'])) {
    if (!empty($_POST['ulasan_id'])) {
        // Edit ulasan
        if(edit_ulasan($_POST) > 0) {
            header("Location: detail_buku.php?id_buku=" . $_GET['id_buku'] . "&success=3");
            exit;
        } else {
            $alert = '<div>Ulasan gagal diedit!</div>';
        }
    } else {
        // Tambah ulasan baru
        if(tambah_ulasan($_POST) > 0) {
            header("Location: detail_buku.php?id_buku=" . $_GET['id_buku'] . "&success=1");
            exit;
        } else {
            $alert = '<div>Komentar gagal ditambahkan!</div>';
        }
    }
}
if (isset($_GET['success']) && $_GET['success'] == 3) {
    $alert = '<div>Ulasan berhasil diedit!</div>';
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $alert = '<div>Komentar berhasil ditambahkan!</div>';
}
if (isset($_GET['success']) && $_GET['success'] == 2) {
    $alert = '<div>Ulasan berhasil dihapus!</div>';
}
$peminjam_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
$id_buku = $_GET["id_buku"];
$kategori = read("SELECT kb.NamaKategori 
    FROM kategoribuku_relasi kr
    JOIN kategoribuku kb ON kr.KategoriID = kb.KategoriID
    WHERE kr.BukuID = $id_buku");
    $data_kate['NamaKategori'] = array_column($kategori, 'NamaKategori');
$data_buku = read("SELECT * FROM buku WHERE BukuID = $id_buku")[0];
$comments = read("SELECT u.UlasanID, u.Ulasan, u.Rating, us.NamaLengkap 
    FROM ulasanbuku u 
    JOIN user us ON u.UserID = us.UserID 
    WHERE u.BukuID = $id_buku
    ORDER BY u.UlasanID DESC");

if(isset($_POST['delete_ulasan'])) {
    $hapus_result = hapus_ulasan($_POST);
    if ($hapus_result > 0){
        $alert = '<div>Ulasan berhasil dihapus!</div>';
        header("Location: detail_buku.php?id_buku=" . $_GET['id_buku'] . "&success=2");
        exit;
    } else {
        $alert = '<div>Ulasan gagal dihapus!</div>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Buku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4f6fa] min-h-screen">
<!-- Navbar -->
    <nav class="bg-white shadow px-8 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="Logo" class="w-12 h-12">
            <div>
                <div class="text-2xl font-bold text-[#232366] leading-5">DIRY</div>
                <div class="text-xs text-gray-500 tracking-widest">DIGITAL LIBRARY</div>
            </div>
        </div>
        <div class="flex-1 flex justify-center">
            <ul class="flex gap-8 items-center text-lg font-medium">
                <li><a href="buku.php" class="text-[#232366] hover:underline">Home</a></li>
                <li><a href="peminjaman_user.php" class="text-[#232366] hover:underline">Peminjaman</a></li>
                <li><a href="koleksi.php" class="text-[#232366] hover:underline">Koleksi</a></li>
            </ul>
        </div>
        <a href="/perpustakaan/view/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg font-semibold transition">
            Logout
        </a>
    </nav>
    <!-- Main Content -->
    <div class="flex flex-col md:flex-row gap-12 max-w-5xl mx-auto mt-10">
        <!-- Book Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center w-full md:w-[340px]">
            <img src="img/<?= htmlspecialchars($data_buku['Foto']) ?>" alt="<?= htmlspecialchars($data_buku['Judul']) ?>" class="w-44 h-64 object-cover rounded-lg shadow mb-4" />
            <div class="flex gap-3 mt-2">
                <a href="pinjam_buku.php?id=<?php echo $id_buku?>" class="bg-[#23235b] text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">Pinjam</a>
                <a href="tambah_koleksi.php?id=<?php echo $id_buku ?>" class="bg-indigo-100 text-[#23235b] px-4 py-2 rounded-lg font-medium hover:bg-indigo-200 transition">Tambah ke Koleksi</a>
            </div>
        </div>
        <!-- Book Detail & Comments -->
        <div class="flex-1 bg-white rounded-xl shadow-lg p-8">
            <?php if(!empty($alert)) echo '<div class="bg-yellow-100 text-yellow-800 rounded px-4 py-2 mb-4 text-base">'.$alert.'</div>'; ?>
            <div>
                <h2 class="text-2xl font-bold text-[#23235b] mb-1"><?= htmlspecialchars($data_buku['Judul']) ?></h2>
                <div class="text-gray-700 mb-2"><?= htmlspecialchars($data_buku['Deskripsi']) ?></div>
                <div class="text-gray-500 mb-4">by <?= htmlspecialchars($data_buku['Penulis']) ?></div>
            </div>
            <div class="flex flex-wrap gap-8 mb-6">
                <div>
                    <div class="text-gray-400 text-sm">Penerbit</div>
                    <div class="text-gray-700"><?= htmlspecialchars($data_buku['Penerbit']) ?></div>
                </div>
                <div>
                    <div class="text-gray-400 text-sm">Tahun Terbit</div>
                    <div class="text-gray-700"><?= htmlspecialchars($data_buku['TahunTerbit']) ?></div>
                </div>
                <div>
                    <div class="text-gray-400 text-sm">Kategori</div>
                    <div class="flex flex-wrap gap-2 mt-1">
                        <?php foreach($data_kate['NamaKategori'] as $kat): ?>
                            <span class="bg-indigo-100 text-indigo-700 rounded px-2 py-0.5 text-xs"><?= ($kat) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- Comments -->
            <div class="mt-8">
                <div class="font-semibold text-[#23235b] mb-3">Comments:</div>
                <?php foreach($comments as $c): ?>
                <div class="flex gap-3 mb-5 items-start">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($c['NamaLengkap']) ?>" alt="avatar" class="w-10 h-10 rounded-full" />
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-[#23235b]"><?= htmlspecialchars($c['NamaLengkap']) ?></span>
                            <div class="flex gap-0.5">
                                <?php foreach(range(1,5) as $i): ?>
                                    <svg class="w-5 h-5 <?= $i <= $c['Rating'] ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20"><polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36"/></svg>
                                <?php endforeach; ?>
                            </div>
                            <?php if($c['NamaLengkap'] == $peminjam_name): ?>
                            <form method="post" class="inline">
                                <input type="hidden" name="ulasan_id" value="<?= $c['UlasanID'] ?>">
                                <button name="submit_edit" type="button" onclick="editUlasan('<?= htmlspecialchars($c['Ulasan']) ?>', <?= $c['Rating'] ?>, <?= $c['UlasanID'] ?>)" class="text-indigo-600 hover:underline text-xs ml-2">Edit</button>
                            </form>
                            <form method="post" class="inline" onsubmit="return confirmDeleteUlasan(event, this);">
                                <input type="hidden" name="ulasan_id" value="<?= $c['UlasanID'] ?>">
                                <button type="submit" name="delete_ulasan" class="text-red-500 hover:underline text-xs ml-1">Hapus</button>
                            </form>
                            <?php endif; ?>
                        </div>
                        <div class="text-gray-700 mt-1"><?= htmlspecialchars($c['Ulasan']) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Comment Form -->
                <form id="commentForm" method="post" action="" class="bg-[#f4f6fa] rounded-lg p-4 mt-6">
                    <textarea rows="2" placeholder="Tulis ulasan di sini..." name="komen" id="komenInput" class="w-full rounded border border-gray-300 px-3 py-2 mb-2 text-base"></textarea>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-gray-700 text-sm">Rating Anda:</span>
                        <div id="starRating" class="flex gap-1">
                            <?php for($i=1;$i<=5;$i++): ?>
                                <svg data-star="<?= $i ?>" class="star w-6 h-6 text-gray-300 cursor-pointer transition-colors" fill="currentColor" viewBox="0 0 20 20"><polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36"/></svg>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="0" />
                        <input type="hidden" name="ulasan_id" id="ulasanIdInput" value="" />
                    </div>
                    <button type="submit" name="submit" class="bg-[#23235b] text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">Kirim</button>
                </form>
            </div>
        </div>
    </div>
    <div class="text-center text-gray-400 text-sm mt-16 mb-4">
        &copy; 2025 perpustakaan digital | Powered by perpustakaan digital
    </div>
    <script>
    // Interaktif bintang rating
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#starRating .star');
        const ratingInput = document.getElementById('ratingInput');
        let currentRating = 0;

        stars.forEach((star, idx) => {
            star.addEventListener('mouseenter', () => {
                highlightStars(idx + 1);
            });
            star.addEventListener('mouseleave', () => {
                highlightStars(currentRating);
            });
            star.addEventListener('click', () => {
                currentRating = idx + 1;
                ratingInput.value = currentRating;
                highlightStars(currentRating);
            });
        });

        function highlightStars(rating) {
            stars.forEach((star, i) => {
                if (i < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }
    });

    // Tambahkan fungsi untuk mengisi form saat klik edit
    function editUlasan(ulasan, rating, ulasanId) {
        document.getElementById('komenInput').value = ulasan;
        document.getElementById('ratingInput').value = rating;
        document.getElementById('ulasanIdInput').value = ulasanId;
        // Highlight bintang sesuai rating
        const stars = document.querySelectorAll('#starRating .star');
        stars.forEach((star, i) => {
            if (i < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    </script>
</body>
</html>