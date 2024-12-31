<?php
header("Content-Type: application/json");
require_once '../../db/connection.php';

$query = "SELECT baju.id, baju.nama_baju, jenis_baju.nama_jenis, ukuran_baju.ukuran, baju.harga, baju.stok
          FROM baju
          INNER JOIN jenis_baju ON baju.id_jenis_baju = jenis_baju.id
          INNER JOIN ukuran_baju ON baju.id_ukuran = ukuran_baju.id";
$stmt = $conn->prepare($query);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results);
?>
