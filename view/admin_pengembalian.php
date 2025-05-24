<?php
session_start();
include '../function/koneksi.php';
if (isset($_POST['kembali'])) {
    $id = $_POST['id'];
    if (dikembalikan($id) > 0) {
        echo "<script>alert('Buku berhasil dikembalikan!');window.location='pengembalian.php';</script>";
    } else {
        echo "<script>alert('Buku gagal dikembalikan!');window.location='pengembalian.php';</script>";
    }
}
$peminjam =read("SELECT * FROM peminjaman 
    INNER JOIN user ON peminjaman.UserID = user.UserID 
    INNER JOIN buku ON peminjaman.BukuID = buku.BukuID");
?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 </head>
 <body>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Aksi</th>   
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($peminjam as $row): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['NamaLengkap']); ?></td>
                <td><?= htmlspecialchars($row['Judul']); ?></td>
                <td><?= htmlspecialchars($row['TanggalPeminjaman']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($row["StatusPeminjaman"] === "dipinjam"): ?>
                                <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold text-xs">Belum Dikembalikan</span>
                            <?php else: ?>
                                <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-xs">Dikembalikan</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($row["StatusPeminjaman"] == "dipinjam"): ?>
                                <form action="" method="post" >
                                    <input type="hidden" name="id" value="<?= $row['PeminjamanID'] ?>">
                                    <button type="submit" name="kembali" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow transition-all duration-200 hover:from-red-600 hover:to-red-700">Kembalikan</button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-500">Sudah Dikembalikan</span>
                            <?php endif; ?>
                        </td>

            </tr>
            <?php endforeach; ?>
    </table>
 </body>
 </html>