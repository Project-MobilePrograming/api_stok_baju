<?php
header("Content-Type: application/json");
require_once '../../db/connection.php';

try {
    // Query membaca data dari tabel
    $query = "SELECT 
                baju.id AS id_baju, 
                baju.nama_baju, 
                jenis_baju.nama_jenis_baju AS jenis_baju, 
                ukuran_baju.ukuran_baju AS ukuran_baju, 
                baju.harga, 
                baju.stok
              FROM baju
              INNER JOIN jenis_baju ON baju.id_jenis_baju = jenis_baju.id
              INNER JOIN ukuran_baju ON baju.id_ukuran_baju = ukuran_baju.id";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Mengambil semua hasil query
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Cek jika data tidak ditemukan
    if (empty($results)) {
        echo json_encode(["message" => "Tidak ada data ditemukan"]);
    } else {
        echo json_encode($results);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
