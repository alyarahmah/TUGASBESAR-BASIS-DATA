<?php
require('functions.php');

// Setel zona waktu
date_default_timezone_set('Asia/Jakarta');

if (isset($_GET['id_kendaraan'])) {
    $id_kendaraan = $_GET['id_kendaraan'];

    // Ambil data jam_masuk dari tabel parkir
    $query_get_parkir = "SELECT jam_masuk FROM parkir WHERE id_kendaraan = $id_kendaraan";
    $result_parkir = mysqli_query($con, $query_get_parkir);

    if (mysqli_num_rows($result_parkir) > 0) {
        $row = mysqli_fetch_assoc($result_parkir);
        $jam_masuk = strtotime($row['jam_masuk']);
        $jam_keluar = time(); // Waktu saat ini

        // Hitung durasi dalam jam, dibulatkan ke atas
        $durasi = ceil(($jam_keluar - $jam_masuk) / 3600);
        $tarif_per_jam = 2000; // Tarif per jam, ganti sesuai kebutuhan
        $total_bayar = $durasi * $tarif_per_jam;

        // Update jam_keluar dan total_bayar di tabel parkir
        $jam_keluar_formatted = date('Y-m-d H:i:s', $jam_keluar);
        $query_update_parkir = "UPDATE parkir SET jam_keluar = '$jam_keluar_formatted', total_bayar = $total_bayar WHERE id_kendaraan = $id_kendaraan";
        $query_update_status = "UPDATE kendaraan SET status = 'keluar' WHERE id_kendaraan = $id_kendaraan";

        // Eksekusi kedua query
        if (mysqli_query($con, $query_update_parkir) && mysqli_query($con, $query_update_status)) {
            header("Location: kendaraan-masuk.php"); // Redirect ke halaman daftar kendaraan keluar
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "Kendaraan tidak ditemukan.";
    }
} else {
    echo "Parameter id_kendaraan tidak diberikan.";
}
?>
