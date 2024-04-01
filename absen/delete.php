<?php
include "koneksi.php";

$id = $_GET['id'];

$hapus = mysqli_query($konek, "DELETE FROM siswa WHERE id='$id'");
if ($hapus) {
    header("Location: datasiswa.php"); // Mengarahkan kembali ke halaman datasiswa.php setelah penghapusan berhasil dilakukan
    exit(); // Menghentikan eksekusi skrip setelah mengarahkan pengguna kembali
} else {
    echo "
        <script>
            alert('Gagal menghapus data');
            window.history.back(); // Kembali ke halaman sebelumnya jika terjadi kesalahan dalam penghapusan
        </script>";
}
