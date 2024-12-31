<?php
header("Content-Type: application/json");
require_once '../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nama_jenis_baju)) {
    $query = "INSERT INTO jenis_baju (nama_jenis_baju) VALUES (:nama_jenis_baju)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":nama_jenis_baju", $data->nama_jenis_baju);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Jenis baju berhasil ditambahkan."]);
    } else {
        echo json_encode(["message" => "Gagal menambahkan jenis baju."]);
    }
} else {
    echo json_encode(["message" => "Nama jenis baju tidak boleh kosong."]);
}
?>