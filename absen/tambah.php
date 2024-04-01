<?php

include "koneksi.php";
if (isset($_POST['btnSimpan'])) {
  $nokartu = $_POST['nokartu'];
  $kelas   = $_POST['kelas'];
  $jurusan = $_POST['jurusan'];
  $nama    = $_POST['nama'];

  $simpan = mysqli_query($konek, "insert into siswa(nokartu,kelas,jurusan,nama)
    values('$nokartu','$kelas','$jurusan','$nama')");

  if ($simpan) {
    echo "
              <script>
                  alert('tersimpan');
                  location.replace('datasiswa.php');
              </script>";
  } else {
    echo "<script>
                  alert('gagal tersimpan');
                  location.replace('datasiswa.php');
          </script>";
  }
}
mysqli_query($konek, "delete from tmprfid");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "header.php"; ?>
  <title>tambah data siswa</title>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <!-- pembacaan no kartu otomatis -->
  <script type="text/javascript">
    $(document).ready(function() {
      setInterval(function() {
        $("#norfid").load('nokartu.php')
      }, 0);
    });
  </script>

</head>

<body>

  <?php include "menu.php"; ?>
  <div class="container-fluid">
    <h3>TAMBAH DATA SISWA</h3>

    <form method="POST">
      <div id="norfid"></div>


      <div class="form-group">
        <label>kelas</label>
        <select aria-label="Default select example" name="kelas" id="kelas" placeholder="kelas" class="form-control" style="width:200px">
          <option value="XII">XII</option>
          <option value="XI">XI</option>
          <option value="X">X</option>
        </select>
      </div>

      <div class="form-group">
        <label>jurusan</label>
        <select aria-label="Default select example" name="jurusan" id="jurusan" placeholder="jurusan" class="form-control" style="width:200px">
          <option value="PPLG">PPLG</option>
          <option value="TEI">TEI</option>
          <option value="ATPH">ATPH</option>
          <option value="AKL">AKL</option>
          <option value="OTKP">OTKP</option>
          <option value="TBSM">TBSM</option>
        </select>
        </select>

      </div>
      <div class="form-group">
        <label>nama</label>
        <input type="text" name="nama" id="nama" placeholder="masukan nama" class="form-control" style="width:400px">
      </div>
      <button class="btn btn-success" name="btnSimpan" id="btnSimpan">SIMPAN</button>
    </form>

  </div>
  <?php include "footer.php"; ?>

</body>

</html>