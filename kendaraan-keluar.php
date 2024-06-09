<?php
session_start();
if ( !isset($_SESSION["login"])){
    header('location: index.php');
    exit;
}
require('functions.php');

// Query untuk mengambil data kendaraan yang sudah keluar
$query = "SELECT k.id_kendaraan, k.plat, k.nama_pemilik, k.jenis_kendaraan, k.merk_kendaraan, p.jam_masuk, p.jam_keluar, a.nama_admin
          FROM kendaraan k
          LEFT JOIN parkir p ON k.id_kendaraan = p.id_kendaraan
          LEFT JOIN admin a ON p.id_admin = a.id_admin
          WHERE k.status = 'keluar'";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kendaraan Keluar</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="home-btn m-2">
        <a class="btn btn-primary mx-auto p-2" href="dashboard.php" role="button"><img src="image/home.png" width="30px"></a>
        <h1 class="text-center mb-4">Daftar Kendaraan Keluar</h1>
    </div>
    <div class="container mt-5">
       
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Plat Nomor</th>
                    <th>Nama Pemilik</th>
                    <th>Jenis Kendaraan</th>
                    <th>Merk Kendaraan</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Total Bayar</th>
                    <th>Admin</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Menghitung total bayar berdasarkan jam_masuk dan jam_keluar
                        $jam_masuk = strtotime($row['jam_masuk']);
                        $jam_keluar = strtotime($row['jam_keluar']);
                        $durasi = ceil(($jam_keluar - $jam_masuk) / 3600); // Durasi dalam jam, dibulatkan ke atas
                        $tarif_per_jam = 2000;
                        $total_bayar = $durasi * $tarif_per_jam;

                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['plat']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_pemilik']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jenis_kendaraan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['merk_kendaraan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jam_masuk']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jam_keluar']) . "</td>";
                        echo "<td>" . htmlspecialchars($total_bayar) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_admin']) . "</td>";
                        echo "<td><a href='hapus-kendaraan.php?id_kendaraan=" . $row['id_kendaraan'] . "' class='btn btn-primary btn-sm'>Hapus</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>Tidak ada data kendaraan keluar</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
