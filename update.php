<!DOCTYPE html>
<html>
<head>
    <title>Inventory Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <?php
    //Include file koneksi, untuk koneksikan ke database
    include "koneksi.php";

    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Cek apakah ada value yang terkirim dengan  GET method dengan nama id_barang
    if (isset($_GET['id_barang'])) {
        $id_barang = input($_GET["id_barang"]);

        $sql = "SELECT * FROM inventory WHERE id_barang=$id_barang";
        $hasil = mysqli_query($kon, $sql);
        $data = mysqli_fetch_assoc($hasil);
    }

    //Cek apakah ada form submission yang menggunakan POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_barang = input($_POST["id_barang"]);
        $nama = input($_POST["nama"]);
        $supplier = input($_POST["supplier"]);
        $alamat = input($_POST["alamat"]);
        $email = input($_POST["email"]);
        
        // File upload handling
        $gambar = $_FILES["gambar"];
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($gambar["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Cek apakah valid tipe image 
        $allowedTypes = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedTypes)) {
            echo "<div class='alert alert-danger'>Hanya file JPG, JPEG, dan PNG yang diperbolehkan.</div>";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($gambar["size"] > 200000) {
            echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
            $uploadOk = 0;
        }

        // Cek apakah $uploadOk set ke 0 karena error
        if ($uploadOk == 0) {
            echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
        } else {
            // ika semua ok, coba upload file
            if (move_uploaded_file($gambar["tmp_name"], $targetFile)) {
                // Update data in the database, termasuk nama file
                $sql = "UPDATE inventory SET nama='$nama', supplier='$supplier', alamat='$alamat', email='$email', 
                gambar='" . basename($gambar["name"]) . "' WHERE id_barang=$id_barang";
                $result = mysqli_query($kon, $sql);

                if ($result) {
                    echo "Data updated successfully.";
                    header("Location: index.php");
                } else {
                    echo "Error updating data: " . mysqli_error($kon);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    ?>
    <h2>Update Data</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Barang:</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Barang" value="<?php echo $data['nama']; ?>" required />
        </div>
        <div class="form-group">
            <label>Supplier:</label>
            <input type="text" name="supplier" class="form-control" placeholder="Masukkan Nama Supplier" value="<?php echo $data['supplier']; ?>" required/>
        </div>
        <div class="form-group">
            <label>Alamat :</label>
            <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat" value="<?php echo $data['alamat']; ?>" required/>
        </div>
        <div class="form-group">
            <label>E-mail:</label>
            <input type="text" name="email" class="form-control" placeholder="Masukkan E-mail" value="<?php echo $data['email']; ?>" required/>
        </div>
        <div class="form-group">
            <label>Gambar:</label>
            <input type="file" name="gambar" class="form-control" placeholder="Masukkan Gambar" required>
        </div>

        <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
