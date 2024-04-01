<?php 
        include "koneksi.php";
        
        //baca nomer kartu dari nodemcu
        $nokartu = $_GET['nokartu'];
        //kosongkan tabel rfid
        mysqli_query($konek, "delete from tmprfid");

        //simpam nomer kartu baru ke tabel tmprfid
        $simpan = mysqli_query($konek, "insert into tmprfid(nokartu)values('$nokartu')");
        if($simpan)
            echo "berhasil";
        else
            echo "gagal";
?>