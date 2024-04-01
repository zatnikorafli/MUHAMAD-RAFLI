<?php
include "koneksi.php";
//baca isi tabel tmprfid
$sql = mysqli_query($konek, "select * from tmprfid");
$data = mysqli_fetch_array($sql);
//baca no kartu
if ($data) {
    // baca no kartu
    $nokartu = $data['nokartu'];
} else {
    $nokartu = ""; // atau nilai default lainnya
}
?>

<div class="form-group">
    <label>no.kartu</label>
    <input type="text" name="nokartu" id="nokartu" placeholder="nomor 
    kartu RFID" class="form-control" style="width:200px" value="<?php echo $nokartu; ?>">
</div>