<?php
session_start();
if ( !isset($_SESSION["login"])){
    header('location: index.php');
    exit;
    if (!isset($_SESSION['login']) || !is_admin()) {
        echo "Anda tidak memiliki akses untuk operasi ini!";
        exit;
    }
}
require('functions.php');

// cek apakah tombol submit (tambah) sudah ditekan atau belum
if (isset($_POST["submit"])) {
    // ambil data dari setiap elemen form 
    $plat = mysqli_real_escape_string($con, $_POST["plat"]);
    $nama_pemilik = mysqli_real_escape_string($con, $_POST["nama_pemilik"]);
    $jenis_kendaraan = mysqli_real_escape_string($con, $_POST["jenis_kendaraan"]);
    $merk_kendaraan = mysqli_real_escape_string($con, $_POST["merk_kendaraan"]);
    $jam_masuk = mysqli_real_escape_string($con, $_POST["jam_masuk"]);
    $id_admin = mysqli_real_escape_string($con, $_POST["id_admin"]);

    // Format datetime yang sesuai untuk MySQL
    $jam_masuk_formatted = date('Y-m-d H:i:s', strtotime($jam_masuk));

    // Query untuk menambahkan data kendaraan
    $query_kendaraan = "INSERT INTO kendaraan (plat, nama_pemilik, jenis_kendaraan, merk_kendaraan)
                        VALUES ('$plat', '$nama_pemilik', '$jenis_kendaraan', '$merk_kendaraan')";

    if (mysqli_query($con, $query_kendaraan)) {
        // Ambil id_kendaraan yang baru ditambahkan
        $id_kendaraan = mysqli_insert_id($con);

        // Query untuk menambahkan data parkir
        $query_parkir = "INSERT INTO parkir (id_kendaraan, jam_masuk, id_admin)
                         VALUES ('$id_kendaraan', '$jam_masuk_formatted', '$id_admin')";

        if (mysqli_query($con, $query_parkir)) {
            echo "Data kendaraan berhasil ditambahkan!";
        } else {
            echo "Error: " . $query_parkir . "<br>" . mysqli_error($con);
        }
    } else {
        echo "Error: " . $query_kendaraan . "<br>" . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan Masuk</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="home-btn m-2">
        <a class="btn btn-primary mx-auto p-2" href="dashboard.php" role="button"><img src="image/home.png" width="30px"></a>
        <h1 class="text-center mb-4">Tambah Kendaraan</h1>
    </div>

    
    <div class="container m-5">
        <form action="" method="POST" class="row g-3">
            <div class="col-md-6">
                <label for="plat" class="form-label">Plat Nomor</label>
                <input type="text" class="form-control" id="plat" name="plat" placeholder="EZ 2345 23" required>
            </div>
            <div class="col-md-6">
                <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" required>
            </div>
            <div class="col-md-6">
                <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                <select class="form-select" id="jenis_kendaraan" name="jenis_kendaraan" required>
                    <option value="Roda 2">Roda 2</option>
                    <option value="Roda 4">Roda 4</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="merk_kendaraan" class="form-label">Merk Kendaraan</label>
                <input type="text" class="form-control" id="merk_kendaraan" name="merk_kendaraan" required>
            </div>
            <div class="col-md-6">
                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                <input type="datetime-local" class="form-control" id="jam_masuk" name="jam_masuk" required>
            </div>
            <div class="col-md-6">
                <label for="id_admin" class="form-label">ID Admin</label>
                <input type="number" class="form-control" id="id_admin" name="id_admin" required>
            </div>
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
