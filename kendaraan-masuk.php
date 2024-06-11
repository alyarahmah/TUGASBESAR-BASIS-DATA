<?php
session_start();
if (!isset($_SESSION["login"])) {
    header('location: index.php');
    exit;
}
require('functions.php');

// Check if there's a search query
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = mysqli_real_escape_string($con, $_GET['search']);
}

// Modify the query to include search
$query = "SELECT k.id_kendaraan, k.plat, k.nama_pemilik, k.jenis_kendaraan, k.merk_kendaraan, p.jam_masuk, p.jam_keluar, p.total_bayar, a.nama_admin, k.status
          FROM kendaraan k
          LEFT JOIN parkir p ON k.id_kendaraan = p.id_kendaraan
          LEFT JOIN admin a ON p.id_admin = a.id_admin";

if ($search_query != "") {
    $query .= " WHERE k.plat LIKE '%$search_query%' 
                OR k.nama_pemilik LIKE '%$search_query%' 
                OR k.jenis_kendaraan LIKE '%$search_query%' 
                OR k.merk_kendaraan LIKE '%$search_query%'
                OR a.nama_admin LIKE '%$search_query%'";
}

$query .= " ORDER BY FIELD(k.status, 'masuk', 'keluar')";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kendaraan</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="home-btn m-2">
        <a class="btn btn-primary mx-auto p-2" href="dashboard.php" role="button"><img src="image/home.png" width="30px"></a>
        <h1 class="text-center mb-4">Daftar Kendaraan</h1>
    </div>

    <div class="container mt-2">

        <!-- Formulir Pencarian -->
        <form class="form-inline mb-3 d-flex align-items-center" action="kendaraan-masuk.php" method="GET">
            <input class="form-control me-2" type="search" placeholder="Search" autocomplete="off" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search_query); ?>">
            <button class="btn btn-outline-success me-2" type="submit">Search</button>
            <a class="btn btn-primary" href="tambah-kendaraan.php">Tambah Kendaraan</a>
        </form>



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
                    <th>Status</th>
                    <th>Aksi</th> <!-- Kolom untuk tombol hitung -->
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['plat']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_pemilik']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jenis_kendaraan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['merk_kendaraan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jam_masuk']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jam_keluar']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_bayar']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_admin']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        // Kolom untuk tombol hitung dengan parameter id kendaraan
                        echo "<td><a href='hitung-bayar.php?id_kendaraan=" . $row['id_kendaraan'] . "' class='btn btn-primary btn-sm'>Hitung</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11' class='text-center'>Tidak ada data kendaraan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>