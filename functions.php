    <?php
    // Koneksi ke database
    $con = mysqli_connect("localhost", "root", "", "parkiran");

    if (mysqli_connect_errno()) {
        echo "Koneksi database gagal: " . mysqli_connect_error();
        exit();
    }

    function query($query) {
        global $con;
        $result = mysqli_query($con, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function is_admin() {
        return isset($_SESSION['role']) && $_SESSION['roles'] === 'admin';
    }
    
    function is_owner() {
        return isset($_SESSION['role']) && $_SESSION['roles'] === 'owners';
    }


 //fungsi cari 
 function cari($keyword)  {
    $query = "SELECT k.id_kendaraan, k.plat, k.nama_pemilik, k.jenis_kendaraan, k.merk_kendaraan, p.jam_masuk, p.jam_keluar, p.total_bayar, a.nama_admin, k.status
          FROM kendaraan k
          LEFT JOIN parkir p ON k.id_kendaraan = p.id_kendaraan
          LEFT JOIN admin a ON p.id_admin = a.id_admin
          WHERE plat = $keyword";
        return query($query);
 }
    
    
?>
