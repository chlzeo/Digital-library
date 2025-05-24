<?php 

$koneksi = mysqli_connect("localhost","root","","digitalibrary");

if (mysqli_connect_errno()){

echo "Koneksi database gagal : " . mysqli_connect_error(); 
}

function sign($post_data){
    global $koneksi;
    $username = htmlspecialchars($post_data['username']);
    $password = htmlspecialchars($post_data['password']);
    $confirm_password = htmlspecialchars($post_data['confirm_password']);
    $email = htmlspecialchars($post_data['email']);
    $nama_lengkap = htmlspecialchars($post_data['nama_lengkap']);
    $alamat = htmlspecialchars($post_data['alamat']);
    $result = mysqli_query($koneksi, "SELECT username from user where username = '$username'");
    $row = mysqli_fetch_assoc($result);
    if($row) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
        return false;
    }
    if($password !== $confirm_password) {
        echo "<script>alert('Password dan Confirm Password tidak sama!');</script>";
        return false;
    }
    $result = mysqli_query($koneksi, "SELECT email from user where email = '$email'");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email sudah terdaftar!');</script>";
        return false;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query_insert = "INSERT INTO user VALUES('','$username', '$password', '$email', '$nama_lengkap', '$alamat','peminjam')";
    mysqli_query($koneksi, $query_insert);
    return mysqli_affected_rows($koneksi);
}

function read($query){
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}
function edit_user($post_data){
    global $koneksi;
    $id = $post_data['id'];
    $nama = htmlspecialchars($post_data['nama']);
    $email = htmlspecialchars($post_data['email']);
    $alamat = htmlspecialchars($post_data['alamat']);
    $query_update = "UPDATE user SET NamaLengkap = '$nama', Email = '$email', Alamat = '$alamat' WHERE UserID = $id";
    mysqli_query($koneksi, $query_update);
    return mysqli_affected_rows($koneksi);
}
function buku_tambah($data_post){
    global $koneksi;
    $judul = htmlspecialchars($data_post["Judul"]);
    $pengarang = htmlspecialchars($data_post["Penulis"]);
    $penerbit = htmlspecialchars($data_post["Penerbit"]);
    $tahun = htmlspecialchars($data_post["TahunTerbit"]);
    $kategori_id = intval($data_post["KategoriID"]);
    $uploud_gambar = uploud($_FILES);
    $sinopsis = htmlspecialchars($data_post["Sinopsis"]);
    if(!$uploud_gambar){
        return false;
    }
    // Insert buku
    $query = "INSERT INTO buku VALUES('','$judul','$pengarang','$penerbit','$tahun','$uploud_gambar','$sinopsis')";
    mysqli_query($koneksi, $query);

    // Ambil ID buku terakhir yang baru dimasukkan
    $buku_id = mysqli_insert_id($koneksi);

    $query_relasi = "INSERT INTO kategoribuku_relasi (KategoriID, BukuID) VALUES ('$kategori_id', '$buku_id')";
    mysqli_query($koneksi, $query_relasi);

    return mysqli_affected_rows($koneksi);
}
function uploud ($gambar){
    $nama_gambar = $gambar["Gambar"]["name"];
    $lokasi_gambar = $gambar["Gambar"]["tmp_name"];
    $error = $gambar["Gambar"]["error"];
    $ukuran_gambar = $gambar["Gambar"]["size"];
    $gambar_valid = ['jpg','jfif','png','jpeg'];
    $ekstensi_gambar = explode('.',$nama_gambar);
    $ekstensi_gambar = strtolower(end($ekstensi_gambar));
    if(!in_array($ekstensi_gambar, $gambar_valid)){
        echo "<script>alert('yang anda uploud bukan gambar!');</script>";
        return false;
    }
    
    $nama_gambar_baru = uniqid();
    $nama_gambar_baru .= '.';
    $nama_gambar_baru .= $ekstensi_gambar;
    move_uploaded_file($lokasi_gambar, '../view/img/' . $nama_gambar_baru);
    return $nama_gambar_baru;
}
function hapus_buku($id){
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM ulasanbuku WHERE BukuID = $id");
    mysqli_query($koneksi, "DELETE FROM kategoribuku_relasi WHERE BukuID = $id");
    mysqli_query($koneksi, "DELETE FROM buku WHERE BukuID = $id");
    return mysqli_affected_rows($koneksi);
}
function buku_edit($data_post){
    global $koneksi;
    $id = intval($data_post["id"]);
    $judul = htmlspecialchars($data_post["Judul"]);
    $pengarang = htmlspecialchars($data_post["Penulis"]);
    $penerbit = htmlspecialchars($data_post["Penerbit"]);
    $tahun = htmlspecialchars($data_post["TahunTerbit"]);
    $kategori_id = intval($data_post["KategoriID"]);
    $sinopsis = htmlspecialchars($data_post["Sinopsis"]);
    $foto_lama = htmlspecialchars($data_post["Foto_lama"]);
    $error_upload = $_FILES['Gambar']['error'];
    if($error_upload === 4){
        // Jika tidak ada gambar yang diupload, gunakan gambar lama
        $uploud_gambar = $foto_lama;
    }else{
        $uploud_gambar = uploud($_FILES);
        if(!$uploud_gambar){
            // Jika upload gagal, gunakan gambar lama
            $uploud_gambar = $foto_lama;
        }
    }
    // Update buku
    $query = "UPDATE buku SET Judul='$judul', Penulis='$pengarang', Penerbit='$penerbit', TahunTerbit='$tahun', Foto='$uploud_gambar', Deskripsi='$sinopsis' WHERE BukuID=$id";
    mysqli_query($koneksi, $query);

    // Update relasi kategori
    mysqli_query($koneksi, "UPDATE kategoribuku_relasi SET KategoriID=$kategori_id WHERE BukuID=$id");

    return mysqli_affected_rows($koneksi);
}
function tambah_ulasan($data_post){
    global $koneksi;
    $ulasan = mysqli_real_escape_string($koneksi, $_POST['komen']);
    $rating = intval($_POST['rating']);
    $user_id = $_SESSION["UserID"];
    $buku_id = intval($_GET["id_buku"]);
    $query = "INSERT INTO ulasanbuku (UserID, BukuID, Ulasan, Rating) VALUES ('$user_id', '$buku_id', '$ulasan', '$rating')";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
function cari ($keyword){
    $query = "SELECT buku.*, kategoribuku.NamaKategori 
    FROM buku
    LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
    LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
    WHERE Judul LIKE '%$keyword%' OR Penulis LIKE '%$keyword%' OR Penerbit LIKE '%$keyword%'";
    return read($query);
}
function hapus($id){
    global $koneksi;
    mysqli_query($koneksi, "DELETE from koleksipribadi where UserID = $id");
    mysqli_query($koneksi, "DELETE from peminjaman where UserID = $id");
    mysqli_query($koneksi, "DELETE from ulasanbuku where UserID = $id");
    mysqli_query($koneksi, "DELETE from user where UserID = $id");
    return mysqli_affected_rows($koneksi);
}
function pinjam($buku_id, $user_id){
    global $koneksi;
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = mysqli_real_escape_string($koneksi, $_POST['tanggal_kembali']);
    $status = 'dipinjam';
    $query = "INSERT INTO peminjaman (UserID, BukuID, TanggalPeminjaman, TanggalPengembalian, StatusPeminjaman)
              VALUES ('$user_id', '$buku_id', '$tanggal_pinjam', '$tanggal_kembali', '$status')";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
function dikembalikan($id){
    global $koneksi;
    $tanggal_kembali = date('Y-m-d');
    $query_update = "UPDATE peminjaman SET StatusPeminjaman = 'selesai', TanggalPengembalian = '$tanggal_kembali' WHERE PeminjamanID = $id";
    mysqli_query($koneksi, $query_update);
    return mysqli_affected_rows($koneksi);
}
function edit_ulasan($data) {
    global $koneksi;
    $ulasan_id = intval($data['ulasan_id']);
    $ulasan = htmlspecialchars($data['komen']);
    $rating = intval($data['rating']);
    $query = "UPDATE ulasanbuku SET Ulasan='$ulasan', Rating=$rating WHERE UlasanID=$ulasan_id";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
function hapus_ulasan($data_post){
    $id = intval($data_post["ulasan_id"]);
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM ulasanbuku WHERE UlasanID = $id");
    return mysqli_affected_rows($koneksi);
}
function tambah_koleksi($user_id, $buku_id){
    global $koneksi;
    
    // Cek apakah buku sudah ada di koleksi
    $cek = mysqli_query($koneksi, "SELECT * FROM koleksipribadi WHERE UserID = '$user_id' AND BukuID = '$buku_id'");
    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('Buku sudah ada di koleksi Anda!');</script>";
        return false;
    }

    // Tambahkan buku ke koleksi
    $query = "INSERT INTO koleksipribadi (UserID, BukuID) VALUES ('$user_id', '$buku_id')";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
function hapus_kategori($id_hapus){
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM kategoribuku_relasi WHERE KategoriID = $id_hapus");
    mysqli_query($koneksi, "DELETE FROM kategoribuku WHERE KategoriID = $id_hapus");
    return mysqli_affected_rows($koneksi);
}
function tambah_kategori($data_post){
    global $koneksi;
    $nama_kategori = htmlspecialchars($data_post["nama"]);
    $query = "INSERT INTO kategoribuku VALUES ('','$nama_kategori')";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
?> 
