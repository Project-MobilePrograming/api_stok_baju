<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../db/connection.php';

try {
    // Ambil parameter query string
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

    // Validasi input
    if (empty($keyword)) {
        throw new Exception("Kata kunci pencarian tidak boleh kosong.");
    }

    // Query pencarian
    $query = "SELECT baju.id, baju.nama_baju, jenis_baju.nama_jenis_baju, ukuran_baju.ukuran_baju, baju.harga, baju.stok, baju.gambar_url
              FROM baju 
              INNER JOIN jenis_baju ON baju.id_jenis_baju = jenis_baju.id 
              INNER JOIN ukuran_baju ON baju.id_ukuran_baju = ukuran_baju.id
              WHERE baju.nama_baju LIKE :keyword 
                 OR jenis_baju.nama_jenis_baju LIKE :keyword 
                 OR ukuran_baju.ukuran_baju LIKE :keyword";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(":keyword", "%$keyword%");

    // Eksekusi query
    if (!$stmt->execute()) {
        throw new Exception("Gagal mengeksekusi query.");
    }

    // Ambil hasil pencarian
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Jika tidak ada hasil
    if (empty($result)) {
        echo json_encode([
            "status" => "success",
            "message" => "Tidak ada data yang ditemukan.",
            "data" => []
        ]);
        exit;
    }

    // Jika ada hasil
    echo json_encode([
        "status" => "success",
        "message" => "Data berhasil ditemukan.",
        "data" => $result
    ]);
} catch (Exception $e) {
    // Tangani error
    http_response_code(400); // Bad Request
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>