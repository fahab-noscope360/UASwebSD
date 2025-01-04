<?php
// Koneksi ke database
$host = "localhost";
$user = "root"; // Ganti sesuai dengan username database Anda
$password = ""; // Ganti sesuai dengan password database Anda
$database = "sd_db"; // Ganti dengan nama database Anda

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari tabel wisata
$query = "SELECT * FROM newsgallery";
$result = $conn->query($query);
?>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p id="gallery" class="fs-5 fw-bold text-primary">Dokumentasi Kegiatan</p>
            <h1 class="display-5 mb-5" id="news">Berita dan Galeri</h1>
        </div>
        <div class="row wow fadeInUp" data-wow-delay="0.3s">
            <div class="col-12 text-center">
                <ul class="list-inline rounded mb-5" id="portfolio-flters">
                    <li class="mx-2 active" data-filter="*">Semua</li>
                    <li class="mx-2" data-filter=".first">Complete</li>
                    <li class="mx-2" data-filter=".second">Ongoing</li>
                </ul>
            </div>
        </div>
        <div class="row g-4 portfolio-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-lg-4 col-md-6 portfolio-item first wow fadeInUp" data-wow-delay="0.1s">
                <div class="portfolio-inner rounded position-relative">
                    <!-- Gambar -->
                    <img 
                        class="img-fluid" 
                        src="../admin/uploads/<?= htmlspecialchars($row['foto'], ENT_QUOTES, 'UTF-8'); ?>" 
                        alt="<?= htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8'); ?>" 
                        loading="lazy">
                    
                    <!-- Overlay untuk teks -->
                    <div class="portfolio-text">
                        <h4 class="text-white mb-4"><?= htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8'); ?></h4>
                        <div class="d-flex">
                            <a 
                                class="btn btn-lg-square rounded-circle mx-2" 
                                href="../admin/uploads/<?= htmlspecialchars($row['foto'], ENT_QUOTES, 'UTF-8'); ?>" 
                                data-lightbox="portfolio" 
                                aria-label="View image <?= htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8'); ?>">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a 
                                class="btn btn-lg-square rounded-circle mx-2" 
                                href="#" 
                                aria-label="Visit <?= htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8'); ?>">
                                <i class="fa fa-link"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="portfolio-description text-center text-white p-3">
                        <?= htmlspecialchars($row['deskripsi'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-12 text-center">
            <p class="text-muted">Tidak ada data yang tersedia.</p>
        </div>
    <?php endif; ?>
</div>
    </div>
</div>
<style>
    .portfolio-description {
    opacity: 0; /* Awalnya tidak terlihat */
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.466); /* Latar belakang semi-transparan */
    color: white; /* Warna teks */
    padding: 10px;
    font-size: 12px;
    z-index: 1; /* Pastikan deskripsi berada di atas gambar */
    transition: opacity 0.4s ease, transform 0.4s ease; /* Efek transisi untuk kemunculan */
    transform: translateY(10px); /* Posisi awal sedikit di bawah */
}

/* Tampilkan deskripsi saat hover */
.portfolio-inner:hover .portfolio-description {
    opacity: 1; /* Munculkan deskripsi */
    transform: translateY(0); /* Geser ke posisi normal */
}
</style>

<?php $conn->close(); ?>
