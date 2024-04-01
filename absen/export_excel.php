<?php
include "koneksi.php";
// Fungsi untuk membuat pilihan tanggal
function combotgl($awal, $akhir, $var, $terpilih)
{
    echo "<select name='$var'>";
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
            echo "<option value='$g' selected>$g</option>";
        else
            echo "<option value='$g'>$g</option>";
    }
    echo "</select> ";
}

// Fungsi untuk membuat pilihan bulan
function combobln($awal, $akhir, $var, $terpilih)
{
    echo "<select name='$var'>";
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
            echo "<option value='$b' selected>$b</option>";
        else
            echo "<option value='$b'>$b</option>";
    }
    echo "</select> ";
}

// Fungsi untuk membuat pilihan tahun
function combothn($awal, $akhir, $var, $terpilih)
{
    echo "<select name='$var'>";
    for ($i = $awal; $i <= $akhir; $i++) {
        if ($i == $terpilih)
            echo "<option value='$i' selected>$i</option>";
        else
            echo "<option value='$i'>$i</option>";
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

    // Filter absensi berdasarkan rentang waktu yang dipilih
    $sql = mysqli_query($konek, "SELECT b.kelas, b.jurusan, b.nama, a.tanggal,
                        a.jam_masuk, a.jam_pulang FROM absensi a
                        INNER JOIN siswa b ON a.id = b.nokartu 
                        WHERE DAY(a.tanggal) = '$tanggal_ini'
                        AND MONTH(a.tanggal) = '$bulan_ini'
                        AND YEAR(a.tanggal) = '$tahun_ini'
                        ORDER BY a.tanggal DESC");

    // Header untuk eksport ke Excel
    header("Content-Type: application/vnd-ms-excel");
    $nama_file = "REKAPITULASI_SISWA_" . date('Ymd') . ".xls";
    header("Content-Disposition: attachment; filename=\"$nama_file\"");

    // Output data ke Excel
    echo "<table border='1'>
            <tr>
                <th>NO</th>
                <th>KELAS</th>
                <th>JURUSAN</th>
                <th>NAMA</th>
                <th>TANGGAL</th>
                <th>JAM MASUK</th>
                <th>JAM PULANG</th>
            </tr>";
    $no = 0;
    while ($data = mysqli_fetch_array($sql)) {
        $no++;
        echo "<tr>
                <td>" . $no . "</td>
                <td>" . $data['kelas'] . "</td>
                <td>" . $data['jurusan'] . "</td>
                <td>" . $data['nama'] . "</td>
                <td>" . $data['tanggal'] . "</td>
                <td>" . $data['jam_masuk'] . "</td>
                <td>" . $data['jam_pulang'] . "</td>
            </tr>";
    }
    echo "</table>";
    exit; // Keluar dari skrip setelah eksport ke Excel selesai
}
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

        
    </div>
    <?php include "footer.php"; ?>
</body>

</html>