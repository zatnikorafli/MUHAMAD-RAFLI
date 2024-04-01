<?php 

    include "koneksi.php";

    $id = $_GET['id'];

    $cari = mysqli_query($konek, "select * from siswa where id='$id'");
    $hasil = mysqli_fetch_array($cari);


    if(isset($_POST['btnSimpan']))

    {
        $nokartu = $_POST['nokartu'];
        $kelas   = $_POST['kelas'];
        $jurusan = $_POST['jurusan'];
        $nama    = $_POST['nama'];
        $simpan = mysqli_query($konek, "UPDATE siswa SET nokartu='$nokartu', kelas='$kelas', jurusan='$jurusan', nama='$nama' WHERE id='$id'");


    if($simpan)
    {
            echo "
                <script>
                    alert('tersimpan');
                    location.replace('datasiswa.php');
                </script>";
    }
    
    else
    {
            echo "<script>
                    alert('gagal tersimpan');
                    location.replace('datasiswa.php');
            </script>";
    }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "header.php"; ?>
    <title>EDIT</title>
</head>
<body>
<?php include "menu.php"; ?>
<div class="container-fluid">
    <h3>EDIT DATA SISWA</h3>

        <form method="POST">
        <div class="form-group">
            <label>no.kartu</label>
            <input type="text" name="nokartu" id="nokartu" placeholder="nomor kartu RFID" class="form-control" style="width:200px" value="<?php echo $hasil['nokartu']; ?>">
            
        </div>

        <div class="form-group">
            <label>kelas</label>
            <select aria-label="Default select example" name="kelas" id="kelas" placeholder="kelas" class="form-control" style="width:200px" >
                <option value="XII">XII</option>
                <option value="XI">XI</option>
                <option value="X">X</option>
            </select value="<?php echo $hasil['kelas']; ?>">
            </div>

        <div class="form-group">
            <label>jurusan</label>
            <select aria-label="Default select example" name="jurusan" id="jurusan" placeholder="jurusan" class="form-control" style="width:200px" >
                <option value="PPLG">PPLG</option>
                <option value="TEI">TEI</option>
                <option value="ATPH">ATPH</option>
                <option value="AKL">AKL</option>
                <option value="OTKP">OTKP</option>
                <option value="TBSM">TBSM</option>
            </select value="<?php echo $hasil['jurusan']; ?>">
            

            </div>
        <div class="form-group">
            <label>nama</label>
            <input type="text" name="nama" id="nama" placeholder="nama" class="form-control" style="width:400px" value="<?php echo $hasil['nama']; ?>">       
            </div>
        <button class="btn btn-success" name="btnSimpan" id="btnSimpan">SIMPAN</button>
        </form>

</div>
<?php include "footer.php"; ?>
</body>
</html>