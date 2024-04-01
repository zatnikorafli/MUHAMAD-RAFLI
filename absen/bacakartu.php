<?php
include "koneksi.php";

// Fungsi untuk mendapatkan waktu sekarang dalam format jam
function getJamNow()
{
    date_default_timezone_set('Asia/Jakarta');
    return date('H:i');
}

// Mendapatkan waktu sekarang
$jam_sekarang = getJamNow();

// Fungsi untuk mendapatkan mode absensi berdasarkan waktu sekarang
function getModeAbsen($jam)
{
    // Jika waktu sekarang antara jam 07:00 pagi dan 15:00 sore, mode absen adalah "Masuk"
    if ($jam >= '07:00' && $jam < '15:00') {
        return "Masuk";
    }
    // Jika waktu sekarang antara jam 15:00 sore dan 05:00 subuh, mode absen adalah "Pulang"
    else if (($jam >= '15:00' && $jam <= '23:59') || ($jam >= '00:00' && $jam < '05:00')) {
        return "Pulang";
    }
    // Selain itu, kembalikan mode absen kosong
    else {
        return "";
    }
}

// Mendapatkan mode absensi
$mode_absen = getModeAbsen($jam_sekarang);
//baca tabel status untuk modeabsensi
$sql = mysqli_query($konek, "select * from status");
$data = mysqli_fetch_array($sql);
$mode_absen = $data['mode'];

//uji mode absen
$mode = "";
if ($mode_absen == 1)
    $mode = "MASUK";
else if ($mode_absen == 2)
    $mode = "PULANG";


//baca tabel rfid
$baca_kartu = mysqli_query($konek, "select * from tmprfid");
$data_kartu = mysqli_fetch_array($baca_kartu);
//$nokartu    = $data_kartu['nokartu'];
$nokartu    = isset($data_kartu['nokartu']) ? $data_kartu['nokartu'] : '';
?>

<div class="container-fluid" style="text-align: center;">
    <?php if ($nokartu == "") { ?>

        <h3>ABSEN: <?php echo $mode;  ?> </h3>
        <h3>SILAKAN TEMPELKAN KARTU RFID ANDA</h3>
        <img src="images/rfid.png" style="width: 200px;">
        <br>
        <img src="images/animasi2.gif" style="width: 200px;">

    <?php } else {
        //cek nomor kartu rfid apakah terdaftar

        $cari_siswa = mysqli_query($konek, "select * from siswa where nokartu='$nokartu'");
        $jumlah_data = mysqli_num_rows($cari_siswa);
        if ($jumlah_data == 0)
            echo "<h1>Maaf kartu tidak di kenali</h1>";
        else {
            //ambil nama siswa
            $data_siswa = mysqli_fetch_array($cari_siswa);
            $nama = $data_siswa['nama'];

            //tanggal dan jumlah hari
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d');
            $jam     = date('H:i:s');

            //CEK DI TABLE ABSENSI APAKAH SUDAH SESUAI TANGGAL SAAT INI ,APABILA BELUM ADA ,MAKA DIANGGAP
            //ABSEN MASUK,TAPI KALAU ADA ,MAKA UPDATE DATA SESUAI MODE ABSEN

            $cari_absen = mysqli_query($konek, "select * from absensi where id='$nokartu' and tanggal='$tanggal'");
            //hitung jumlah datanya 

            $jumlah_absen = mysqli_num_rows($cari_absen);

            if ($jumlah_absen == 0) {
                echo "<h1>selamat datang <b>$nama</b></h1>";
                mysqli_query($konek, "insert into absensi(id,tanggal,jam_masuk)values('$nokartu','$tanggal', '$jam')");
                //} else if ($jumlah_absen == 1) {
                //  echo "<h1>sudah absen</h1>";
            } else    if ($jumlah_absen == 1) {
                echo "<h1>sudah absen</h1>";
                // update sesuai pilihan mode
                if ($mode_absen == 2) {
                    echo "<h1>hati hati di jalan <br> $nama </h1>";
                    mysqli_query($konek, "update absensi set jam_pulang='$jam ' where id='$nokartu' and tanggal='$tanggal'");
                }
            }
        }
        //kosongkan table rfid
        mysqli_query($konek, "delete from tmprfid");
    }  ?>
</div>