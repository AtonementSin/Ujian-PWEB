<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" 
integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
<link rel="stylesheet" href="index.css">
</head>
<title>
    CRUD</title>
<body>
    <nav class="navbar navbar-dark bg-dark">
            <span class="navbar-brand mb-0 h1">SIMPLE CRUD</span>
        </div>
    </nav>
<div class="container">
    <br>
    <h4><center>Tabel Inventory</center></h4>
<?php

    include "koneksi.php";

    //Cek apakah ada kiriman form dari method post
    if (isset($_GET['id_barang'])) {
      
        $id_barang = $_GET['id_barang'];

        $sql="delete from inventory where id_barang='$id_barang' ";
        $hasil=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak
            if ($hasil) {
                header("Location:index.php");

            }
            else {
                echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";

            }
        }
?>


     <tr class="table-danger">
            <br>
        <thead>
        <tr>
       <table class="my-3 table table-bordered">
            <tr class="table-primary">           
            <th>No</th>
            <th>Nama</th>
            <th>Supplier</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>Gambar</th>
            <th colspan='2'>Aksi</th>

        </tr>
        </thead>

        <?php
        include "koneksi.php";
        $sql="select * from inventory order by id_barang desc";

        $hasil=mysqli_query($kon,$sql);
        $no=0;
        while ($data = mysqli_fetch_assoc($hasil)) {
            $no++;

            ?>
            <tbody>
            <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $data["nama"]; ?></td>
                <td><?php echo $data["supplier"];   ?></td>
                <td><?php echo $data["alamat"];   ?></td>
                <td><?php echo $data["email"];   ?></td>
                <td>
                    <img src="<?php echo "uploads/".$data["gambar"];?>" width=200>
                </td>
                <td>
                    <a href="update.php?id_barang=<?php echo $data['id_barang']; ?>
                    " class="btn btn-warning" role="button">Edit</a>
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>
                    ?id_barang=<?php echo $data['id_barang']; ?>" class="btn btn-danger" role="button">Delete</a>
                </td>
            </tr>
            </tbody>
            <?php
        }
        ?>
    </table>
    <a href="create.php" class="btn btn-primary" role="button">Tambah Data</a>
</div>
</body>
</html>
