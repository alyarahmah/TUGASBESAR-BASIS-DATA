<?php

session_start();
if ( !isset($_SESSION["login"])){
    header('location: index.php');
    exit;
}

require('functions.php');

// Periksa apakah parameter id_kendaraan telah diberikan
// Periksa apakah parameter id_kendaraan telah diberikan
if (isset($_GET['id_kendaraan'])) {
    $id_kendaraan = $_GET['id_kendaraan'];

    // Query untuk menghapus entri dari tabel parkir terkait
    $query_delete_parkir = "DELETE FROM parkir WHERE id_kendaraan = $id_kendaraan";
    if (mysqli_query($con, $query_delete_parkir)) {
        // Setelah menghapus entri parkir terkait, lanjutkan dengan menghapus kendaraan
        $query_delete_kendaraan = "DELETE FROM kendaraan WHERE id_kendaraan = $id_kendaraan";
        if (mysqli_query($con, $query_delete_kendaraan)) {
            echo "Kendaraan berhasil dihapus";
        } else {
            echo "Error: " . $query_delete_kendaraan . "<br>" . mysqli_error($con);
        }
    } else {
        echo "Error: " . $query_delete_parkir . "<br>" . mysqli_error($con);
    }
} else {
    echo "Parameter id_kendaraan tidak diberikan";
}

?>
