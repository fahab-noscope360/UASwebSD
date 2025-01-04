<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "sd_db";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data produk berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM newsgallery WHERE id = $id";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();

    if (!$data) {
        die("Data tidak ditemukan.");
    }
}

// Update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $foto_lama = $data['foto'];

    // Proses file baru jika di-upload
    if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] !== "") {
        $foto_baru = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $target_dir = "uploads";

        // Hapus foto lama jika ada file baru
        if (file_exists($target_dir . $foto_lama)) {
            unlink($target_dir . $foto_lama);
        }

        // Pindahkan file baru ke folder tujuan
        move_uploaded_file($foto_tmp, $target_dir . $foto_baru);
    } else {
        // Jika tidak ada file baru, gunakan file lama
        $foto_baru = $foto_lama;
    }

    // Query update
    $query = "UPDATE data_wisata SET 
              judul = '$judul', 
              deskripsi = '$deskripsi', 
              foto = '$foto_baru', 
              tanggal_update = CURRENT_TIMESTAMP 
              WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        echo "Data berhasil diperbarui. <a href='list_wisata.php'>Kembali ke daftar wisata</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Produk Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="padding: 2.5rem;">
    <h1>Update Produk Wisata</h1>
    <form action="proses_upload.php" method="POST" enctype="multipart/form-data">
        <label for="Judul">Judul Berita:</label><br>
        <input class="form-control" type="text" name="judul" id="judul" required><br><br>
        
        <label for="deskripsi">Deskripsi:</label><br>
        <textarea class="form-control" name="deskripsi" id="deskripsi" required></textarea><br><br>
        
        <label for="foto">Foto:</label><br>
        <input class="form-control" type="file" name="foto" id="foto" accept="image/*" required><br><br>
        
        <button class="btn btn-primary" type="submit">Upload</button>
    </form>
    <br>
    <br>
    <button class="btn btn-danger" onclick="window.location.href='dashboard.php';">Kembali ke List</button>

</body>
</html>
<?php $conn->close(); ?>
