<?php
session_start();
require('functions.php');

// Query untuk mengambil data kendaraan keluar
$query_keluar = "SELECT k.id_kendaraan, k.plat, k.nama_pemilik, k.jenis_kendaraan, k.merk_kendaraan, p.jam_masuk, p.jam_keluar, p.total_bayar, a.nama_admin, k.status
                 FROM kendaraan k
                 LEFT JOIN parkir p ON k.id_kendaraan = p.id_kendaraan
                 LEFT JOIN admin a ON p.id_admin = a.id_admin
                 WHERE p.jam_keluar IS NOT NULL";

$result_keluar = mysqli_query($con, $query_keluar);
$jml_keluar = mysqli_num_rows($result_keluar);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Income</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="home-btn m-2">
        <a class="btn btn-primary mx-auto p-2" href="dashboard.php" role="button"><img src="image/home.png" width="30px"></a>
    </div>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title">Total Pendapatan dari Kendaraan Keluar</h1>
            </div>
            <div class="card-body">
                <p class="card-text">Jumlah kendaraan keluar: <span class="fw-bold"><?php echo $jml_keluar; ?></span></p>
                <p class="card-text">Total Pendapatan: <span class="fw-bold">
                    <?php
                    // Menginisialisasi total pendapatan
                    $total_pendapatan = 0;

                    // Mengambil total pendapatan dari setiap kendaraan yang keluar
                    while ($row = mysqli_fetch_assoc($result_keluar)) {
                        // Total bayar dari setiap kendaraan
                        $total_bayar = $row['total_bayar'];
                        // Menambahkan total bayar ke total pendapatan
                        $total_pendapatan += $total_bayar;
                    }

                    // Menampilkan total pendapatan
                    echo number_format($total_pendapatan, 2, ',', '.');
                    ?>
                </span></p>
            </div>
            <div class="card-footer text-muted">
                <p class="mb-0">Data diperbarui pada: <?php echo date('d-m-Y H:i:s'); ?></p>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
