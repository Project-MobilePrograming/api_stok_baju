<?php
// Masukkan koneksi database
include_once '../db/connection.php';

// Ambil data input (GET/POST)
$data = json_decode(file_get_contents("php://input"));

// Periksa apakah ada input pencarian
if (!empty($data->search)) {
    $search = "%{$data->search}%"; // Menggunakan wildcard untuk LIKE query
    $query = "SELECT * FROM baju WHERE nama_baju LIKE :search OR kategori LIKE :search";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':search', $search);

    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo json_encode(["message" => "Pencarian gagal"]);
    }
} else {
    echo json_encode(["message" => "Kata kunci pencarian tidak ditemukan"]);
}
?>
