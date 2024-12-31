<?php
header("Content-Type: application/json");
require_once '../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->nama_jenis_baju)) {
    $query = "UPDATE jenis_baju SET nama_jenis = :nama_jenis_baju WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);
    $stmt->bindParam(":nama_jenis_baju", $data->nama_jenis_baju);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Jenis baju berhasil diperbarui."]);
    } else {
        echo json_encode(["message" => "Gagal memperbarui jenis baju."]);
    }
} else {
    echo json_encode(["message" => "ID atau nama jenis baju tidak boleh kosong."]);
}
?>
