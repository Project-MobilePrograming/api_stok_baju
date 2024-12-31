<?php
header("Content-Type: application/json");
require_once '../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->ukuran_baju)) {
    $query = "INSERT INTO ukuran_baju (ukuran_baju) VALUES (:ukuran_baju)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":ukuran_baju", $data->ukuran_baju);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Ukuran baju berhasil ditambahkan."]);
    } else {
        echo json_encode(["message" => "Gagal menambahkan ukuran baju."]);
    }
} else {
    echo json_encode(["message" => "Ukuran baju tidak boleh kosong."]);
}
?>
