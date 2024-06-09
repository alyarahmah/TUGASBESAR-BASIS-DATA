<?php
session_start();
if (!isset($_SESSION["login"])) {
    header('location: index.php');
    exit;
}



require('functions.php');

// Query untuk mengambil data kendaraan keluar
$query_keluar = "SELECT k.id_kendaraan, k.plat, k.nama_pemilik, k.jenis_kendaraan, k.merk_kendaraan, p.jam_masuk, p.jam_keluar, p.total_bayar, a.nama_admin, k.status
          FROM kendaraan k
          LEFT JOIN parkir p ON k.id_kendaraan = p.id_kendaraan
          LEFT JOIN admin a ON p.id_admin = a.id_admin
          WHERE p.jam_keluar IS NOT NULL";

// Query untuk mengambil data kendaraan masuk
$query_masuk = "SELECT k.id_kendaraan, k.plat, k.nama_pemilik, k.jenis_kendaraan, k.merk_kendaraan, p.jam_masuk, p.jam_keluar, p.total_bayar, a.nama_admin, k.status
          FROM kendaraan k
          LEFT JOIN parkir p ON k.id_kendaraan = p.id_kendaraan
          LEFT JOIN admin a ON p.id_admin = a.id_admin
          WHERE p.jam_keluar IS NULL";

// Query untuk mengambil data kendaraan masuk
$query_kendaraan = "SELECT k.id_kendaraan, k.plat, k.nama_pemilik, k.jenis_kendaraan, k.merk_kendaraan, p.jam_masuk, p.jam_keluar, p.total_bayar, a.nama_admin, k.status
          FROM kendaraan k
          LEFT JOIN parkir p ON k.id_kendaraan = p.id_kendaraan
          LEFT JOIN admin a ON p.id_admin = a.id_admin";

// Eksekusi query
$result_keluar = mysqli_query($con, $query_keluar);
$jml_keluar = mysqli_num_rows($result_keluar);

$result_masuk = mysqli_query($con, $query_masuk);
$jml_masuk = mysqli_num_rows($result_masuk);

$result_kendaraan = mysqli_query($con, $query_kendaraan);
$jml_kendaraan = mysqli_num_rows($result_kendaraan);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Parkir Kerkhof</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css2/stylesidebar.css">
</head>

<body>

    <?php
    include 'includes/navbar.php'
    ?>

    <!-- ini sidebar -->

    <div id="sidebar-collapse" class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">Kerkhof Garut</a>
                </div>
            </div>
            <ul class="sidebar-nav">

                <li class="sidebar-item">
                    <a href="kendaraan-masuk.php" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Kendaraan masuk</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="kendaraan-keluar.php" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Kendaraan keluar</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-protection"></i>
                        <span>Laporan</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="total-income.php" class="sidebar-link">Income hari ini</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="history.php" class="sidebar-link">History parkir</a>
                        </li>
                    </ul>
                </li>


                <li class="sidebar-item">
                    <a href="logout.php" class="sidebar-link">
                        <i class="lni lni-exit"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">

            </div>
        </aside>
        <div class="main p-3 ">

            <!-- akhir sidebar -->

            <div class="">
                <h1 class="text-center fs-2 mt-2 mb-5">
                    Selamat Datang di <br> Sistem Pengelolaan Parkir kerkhof!
                </h1>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                        <div class="card h-100 text-bg-primary mb-3">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center">
                                    <p class="text-center fs-1"><?php echo $jml_kendaraan; ?></p>
                                    <h1 class="text-center card-title mb-3">Total Kendaraan <br> Masuk</h1>
                                    <img class="img-fluid" src="image/parking.png" alt="">
                                    <H1></H1>
                                </div>
                            </div>
                            <div class="card-footer">
                                <small class="text-body-secondary">Refresh to Update</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 text-bg-danger mb-3">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center">
                                    <p class="text-center fs-1"><?php echo $jml_keluar; ?></p>
                                    <h1 class="text-center card-title mb-3">Total Kendaraan <br> Keluar</h1>
                                    <img class="img-fluid" src="image/parking.png" alt="">
                                    <H1></H1>
                                </div>
                            </div>
                            <div class="card-footer">
                                <small class="text-body-secondary">Refresh to Update</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 text-bg-success mb-3">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center">
                                    <p class="text-center fs-1"><?php echo $jml_masuk; ?></p>
                                    <h1 class="text-center card-title mb-3">Total Kendaraan <br> Ter saat ini</h1>
                                    <img class="img-fluid" src="image/parking.png" alt="">
                                    <H1></H1>
                                </div>
                            </div>
                            <div class="card-footer">
                                <small class="text-body-secondary">Refresh to Update</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="js/scriptsidebar.js"></script>
</body>

</html>