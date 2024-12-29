<?php
header("Content-Type: application/json");
require_once '../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nama_baju) && !empty($data->kategori) && !empty($data->harga) && !empty($data->stok)) {
    $query = "INSERT INTO baju (nama_baju, kategori, harga, stok) VALUES (:nama_baju, :kategori, :harga, :stok)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":nama_baju", $data->nama_baju);
    $stmt->bindParam(":kategori", $data->kategori);
    $stmt->bindParam(":harga", $data->harga);
    $stmt->bindParam(":stok", $data->stok);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Baju berhasil ditambahkan."]);
    } else {
        echo json_encode(["message" => "Gagal menambahkan baju."]);
    }
} else {
    echo json_encode(["message" => "Data tidak lengkap."]);
}
?>
