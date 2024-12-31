<?php
header("Content-Type: application/json");
require_once '../db/connection.php';

// Ambil parameter query string
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$query = "SELECT baju.id_baju, baju.nama_baju, jenis_baju.nama_jenis_baju, ukuran_baju.ukuran, baju.harga, baju.stok 
          FROM baju 
          INNER JOIN jenis_baju ON baju.id_jenis_baju = jenis_baju.id_jenis_baju 
          INNER JOIN ukuran_baju ON baju.id_ukuran = ukuran_baju.id_ukuran 
          WHERE baju.nama_baju LIKE :keyword";
$stmt = $conn->prepare($query);
$stmt->bindValue(":keyword", "%$keyword%");

if ($stmt->execute()) {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} else {
    echo json_encode(["message" => "Gagal mencari data baju."]);
}
?>
