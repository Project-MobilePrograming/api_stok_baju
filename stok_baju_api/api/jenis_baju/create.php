<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nama_jenis_baju)) {
    $query = "INSERT INTO jenis_baju (nama_jenis_baju) VALUES (:nama_jenis_baju)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":nama_jenis_baju", $data->nama_jenis_baju);

    if ($stmt->execute()) {
        // Create a response object
        $response = new stdClass();
        $response->message = "Jenis baju berhasil ditambahkan.";
        echo json_encode($response);
    } else {
        // Create a response object for failure
        $response = new stdClass();
        $response->message = "Gagal menambahkan jenis baju.";
        echo json_encode($response);
    }
} else {
    // Create a response object for empty nama_jenis_baju
    $response = new stdClass();
    $response->message = "Nama jenis baju tidak boleh kosong.";
    echo json_encode($response);
}
?>