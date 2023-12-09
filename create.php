<!DOCTYPE html>
<html>
<head>
    <title>Inventory Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <?php
    // Include file koneksi, untuk koneksikan ke database
    include "koneksi.php";

    // Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    // Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nama=input($_POST["nama"]);
        $supplier=input($_POST["supplier"]);
        $alamat=input($_POST["alamat"]);
        $email=input($_POST["email"]);

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
        if ($gambar["size"] > 500000) {
            echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
            $uploadOk = 0;
        }

        // Cek apakah $uploadOk set ke 0 karena error
        if ($uploadOk == 0) {
            echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
        } else {
            // jika semua ok, coba upload file
            if (move_uploaded_file($gambar["tmp_name"], $targetFile)) {
                // Insert data into the database, termasuk nama file
                $sql = "INSERT INTO inventory (id_barang, nama, supplier, alamat, email, gambar) 
                VALUES (null, '$nama', '$supplier', '$alamat', '$email', '" . basename($gambar["name"]) . "')";
                $result = mysqli_query($kon, $sql);

                if ($result) {
                    echo "Data berhasil ditambahkan.";
                    header("Location: index.php");
                } else {
                    echo "Gagal menambah data: " . mysqli_error($kon);
                }
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah.";
            }
        }
    }
    ?>
    <h2>Input Data</h2>

    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype ="multipart/form-data">
        <div class="form-group">
            <label>Nama Barang:</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Barang" required />

        </div>
        <div class="form-group">
            <label>Supplier:</label>
            <input type="text" name="supplier" class="form-control" placeholder="Masukkan Nama supplier" required/>
        </div>
       <div class="form-group">
            <label>Alamat :</label>
            <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat" required/>
        </div>
                </p>
        <div class="form-group">
            <label>E-mail:</label>
            <input type="text" name="email" class="form-control" placeholder="Masukkan E-mail" required/>
        </div>
        <div class="form-group">
            <label>Gambar:</label>
            <input type="file" name="gambar" class="form-control" rows="5"placeholder="Masukkan Gambar" required></input>
        </div>       

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>