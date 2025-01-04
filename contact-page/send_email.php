<?php
// Include autoloader dari Composer
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Periksa apakah form dikirim menggunakan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $namaPengirim = htmlspecialchars($_POST['name']);
    $emailPengirim = htmlspecialchars($_POST['email']);
    $pesan = htmlspecialchars($_POST['message']);

    // Buat instance PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fadilah.habibi09@gmail.com'; // Ganti dengan email Anda
        $mail->Password = 'pyrn agub uveh dikc';    // Ganti dengan password aplikasi
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Pengirim
        $mail->setFrom($emailPengirim, $namaPengirim);

        // Penerima (Email Anda)
        $mail->addAddress('fadilah.habibi09@gmail.com', 'SD-Pelita Bangsa');

        // Konten Email
        $mail->isHTML(true);
        $mail->Subject = "Pesan dari $namaPengirim";
        $mail->Body    = "
            <h3>Anda menerima pesan baru dari website Anda:</h3>
            <p><strong>Nama:</strong> $namaPengirim</p>
            <p><strong>Email:</strong> $emailPengirim</p>
            <p><strong>Pesan:</strong><br>$pesan</p>
        ";
        $mail->AltBody = "Nama: $namaPengirim\nEmail: $emailPengirim\nPesan:\n$pesan";

        // Kirim email
        $mail->send();
        echo "<script>
        alert('Pesan berhasil dikirim! Kami akan segera membalas!');
        window.location.href = '../docs/index.php'; // Redirect kembali ke form
      </script>";
} catch (Exception $e) {
// Pop-up pesan gagal
echo "<script>
        alert('Pesan gagal dikirim. Error: {$mail->ErrorInfo}');
        window.history.back(); // Kembali ke halaman sebelumnya
      </script>";
}
} else {
// Pop-up untuk form yang belum dikirim
echo "<script>
    alert('Form belum dikirim!');
    window.history.back(); // Kembali ke halaman sebelumnya
  </script>";
}