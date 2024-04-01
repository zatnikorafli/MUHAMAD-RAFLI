<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php" ?>

    <title>absen</title>
</head>

<body>

    <?php include "menu.php" ?>
   
            <div class="container-fluid">
                <h2 style="color:black">DATA SISWA</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr style="background: #4682B4; color: #fff;">
                            <th style="width: 10px; text-align:center">NO</th>
                            <th style="width: 50px; text-align:center">NOKARTU</th>
                            <th style="width: 50px; text-align:center">KELAS</th>
                            <th style="width: 100px; text-align:center">JURUSAN</th>
                            <th style="width: 200px; text-align:center">NAMA</th>
                            <th style="width: 10px; text-align:center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include "koneksi.php";
                        $sql = mysqli_query($konek, "SELECT * FROM siswa ORDER BY nama ASC");
                        $no = 0;
                        while ($data = mysqli_fetch_array($sql)) {
                            $no++;
                        ?>
                            <tr style="  background-color: #ffff;">
                                <td style="text-align: center; "> <?php echo $no; ?></td>
                                <td style="text-align: center;"> <?php echo $data['nokartu']; ?></td>
                                <td style="text-align: center;"> <?php echo $data['kelas']; ?></td>
                                <td style="text-align: center;"> <?php echo $data['jurusan']; ?></td>
                                <td style="text-align: center;"> <?php echo $data['nama']; ?></td>
                                <td style="text-align: center;">
                                    <a href="edit.php?id=<?php echo $data['id']; ?>">EDIT</a> |
                                    <a href="delete.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">HAPUS</a>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <a href="tambah.php" style="background-color: #4682B4; padding: 5px 10px; text-decoration: none; color: #fff; border-radius: 5px; box-shadow: 3px 3px 5px white;">TAMBAH DATA SISWA</a>
            </div>
       
    <?php include "footer.php" ?>

</body>

</html>