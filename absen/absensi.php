<?php
include "koneksi.php";

// Fungsi untuk membuat pilihan tanggal
function combotgl($awal, $akhir, $var, $terpilih)
{
    echo "<select name=$var>";
    for ($i = $awal; $i <= $akhir; $i++) {
        $lebar = strlen($i);
        switch ($lebar) {
            case 1:
                $g = "0" . $i;
                break;
            case 2:
                $g = $i;
                break;
        }
        if ($i == $terpilih)
            echo "<option value=$g selected>$g</option>";
        else
            echo "<option value=$g>$g</option>";
    }
    echo "</select> ";
}

// Fungsi untuk membuat pilihan bulan
function combobln($awal, $akhir, $var, $terpilih)
{
    echo "<select name=$var>";
    for ($bln = $awal; $bln <= $akhir; $bln++) {
        $lebar = strlen($bln);
        switch ($lebar) {
            case 1:
                $b = "0" . $bln;
                break;
            case 2:
                $b = $bln;
                break;
        }
        if ($bln == $terpilih)
            echo "<option value=$b selected>$b</option>";
        else
            echo "<option value=$b>$b</option>";
    }
    echo "</select> ";
}

// Fungsi untuk membuat pilihan tahun
function combothn($awal, $akhir, $var, $terpilih)
{
    echo "<select name=$var>";
    for ($i = $awal; $i <= $akhir; $i++) {
        if ($i == $terpilih)
            echo "<option value=$i selected>$i</option>";
        else
            echo "<option value=$i>$i</option>";
    }
    echo "</select> ";
}

date_default_timezone_set('Asia/Jakarta');

// Default rentang waktu adalah bulan ini
$bulan_ini = date('m');
$tahun_ini = date('Y');
$tanggal_ini = date('d');

// Jika form dikirim, gunakan nilai yang dikirimkan
if (isset($_POST['submit'])) {
    $bulan_ini = $_POST['bln'];
    $tahun_ini = $_POST['thn'];
    if (isset($_POST['tgl'])) {
        $tanggal_ini = $_POST['tgl'];
    }
}

// Tambahkan penanganan absensi di sini
if (isset($_POST['absensi'])) {
    // Misalnya, Anda mendapatkan data absensi seperti ini
    $nokartu = $_POST['nokartu'];
    $jam_masuk = $_POST['jam_masuk'];
    $jam_pulang = $_POST['jam_pulang'];

    // Ambil tanggal saat ini
    $tanggal_sekarang = date('Y-m-d');

    // Cek apakah siswa sudah absen pada tanggal tersebut
    $query_cek_absensi = mysqli_query($konek, "SELECT * FROM siswa WHERE nokartu = '$nokartu' AND tanggal = '$tanggal_sekarang'");
    $jumlah_absensi = mysqli_num_rows($query_cek_absensi);

    if ($jumlah_absensi > 0) {
        // Jika sudah absen, perbarui entri
        $query_update_absensi = mysqli_query($konek, "UPDATE absensi SET jam_masuk = '$jam_masuk', jam_pulang = '$jam_pulang' WHERE nokartu = '$nokartu' AND tanggal = '$tanggal_sekarang'");
    } else {
        // Jika belum absen, tambahkan entri baru
        $query_tambah_absensi = mysqli_query($konek, "INSERT INTO absensi (nokartu, tanggal, jam_masuk, jam_pulang) VALUES ('$nokartu', '$tanggal_sekarang', '$jam_masuk', '$jam_pulang')");
    }
}

// Filter absensi berdasarkan rentang waktu yang dipilih
$sql = mysqli_query($konek, "SELECT b.kelas, b.jurusan, b.nama, a.tanggal,
                        a.jam_masuk, a.jam_pulang FROM absensi a
                        INNER JOIN siswa b ON a.id = b.nokartu 
                        WHERE DAY(a.tanggal) = '$tanggal_ini'
                        AND MONTH(a.tanggal) = '$bulan_ini'
                        AND YEAR(a.tanggal) = '$tahun_ini'
                        ORDER BY a.tanggal DESC");

$no = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php"; ?>
    <title>REKAPITULASI</title>
</head>

<body>
    <?php include "menu.php"; ?>

    <div class="container-fluid">
        <h3>REKAPITULASI SISWA</h3>
        <p></p>
        <!-- Form untuk memilih rentang waktu -->
        <form method="post" action="">
            Pilih Tanggal: <?php combotgl(1, 31, 'tgl', $tanggal_ini); ?>
            Pilih Bulan: <?php combobln(1, 12, 'bln', $bulan_ini); ?>
            Pilih Tahun: <?php combothn(2020, 2030, 'thn', $tahun_ini); ?>
            <input type="submit" name="submit" value="Submit">
            <P></P>
        </form>

      

        <table class="table table-bordered">
            <thead>
                <tr style="background: #4682B4; color: #fff;">
                    <th style="width: 10px; text-align:center">NO</th>
                    <th style="width: 10px; text-align:center">KELAS</th>
                    <th style="width: 10px; text-align:center">JURUSAN</th>
                    <th style="width: 200px; text-align:center">NAMA</th>
                    <th style="width: 10px; text-align:center">TANGGAL</th>
                    <th style="width: 10px; text-align:center">JAM MASUK</th>
                    <th style="width: 10px; text-align:center">JAM PULANG</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_array($sql)) {
                    $no++;
                ?>
                    <tr style="background-color: #ffff;">
                        <td style="text-align: center;"><?php echo $no; ?></td>
                        <td style="text-align: center;"><?php echo $data['kelas']; ?></td>
                        <td style="text-align: center;"><?php echo $data['jurusan']; ?></td>
                        <td style="text-align: center;"><?php echo $data['nama']; ?></td>
                        <td style="text-align: center;"><?php echo $data['tanggal']; ?></td>
                        <td style="text-align: center;"><?php echo $data['jam_masuk']; ?></td>
                        <td style="text-align: center;"><?php echo $data['jam_pulang']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="export_excel.php" style="background-color: #4682B4; padding: 5px 10px; text-decoration: none; color: #fff; border-radius: 5px; box-shadow: 3px 3px 5px white;">EXPORT TO EXCEL</a>

    </div>
    <?php include "footer.php"; ?>
</body>

</html>
