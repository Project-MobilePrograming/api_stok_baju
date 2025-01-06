<?php
header("Content-Type: application/json");
require_once '../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->ukuran_baju)) {
    $query = "UPDATE ukuran_baju SET ukuran_baju = :ukuran_baju WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);
    $stmt->bindParam(":ukuran_baju", $data->ukuran_baju);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Ukuran baju berhasil diperbarui."]);
    } else {
        echo json_encode(["message" => "Gagal memperbarui ukuran baju."]);
    }
} else {
    echo json_encode(["message" => "ID atau ukuran tidak boleh kosong."]);
}
?>