<?php
header("Content-Type: application/json");
require_once '../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->nama_baju) && !empty($data->kategori) && !empty($data->harga) && !empty($data->stok)) {
    $query = "UPDATE baju SET nama_baju = :nama_baju, kategori = :kategori, harga = :harga, stok = :stok WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);
    $stmt->bindParam(":nama_baju", $data->nama_baju);
    $stmt->bindParam(":kategori", $data->kategori);
    $stmt->bindParam(":harga", $data->harga);
    $stmt->bindParam(":stok", $data->stok);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Baju berhasil diperbarui."]);
    } else {
        echo json_encode(["message" => "Gagal memperbarui baju."]);
    }
} else {
    echo json_encode(["message" => "Data tidak lengkap."]);
}
?>
