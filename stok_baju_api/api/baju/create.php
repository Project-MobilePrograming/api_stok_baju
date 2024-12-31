<?php
header("Content-Type: application/json");
require_once '../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nama_baju) && !empty($data->id_jenis_baju) && !empty($data->id_ukuran_baju) && !empty($data->harga) && !empty($data->stok)) {
    $query = "INSERT INTO baju (nama_baju, id_jenis_baju, id_ukuran_baju, harga, stok) VALUES (:nama_baju, :id_jenis_baju, :id_ukuran_baju, :harga, :stok)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":nama_baju", $data->nama_baju);
    $stmt->bindParam(":id_jenis_baju", $data->id_jenis_baju);
    $stmt->bindParam(":id_ukuran_baju", $data->id_ukuran_baju);
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
