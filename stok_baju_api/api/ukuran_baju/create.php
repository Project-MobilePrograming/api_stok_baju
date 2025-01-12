<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

try {
    if (!empty($data->ukuran_baju)) {
        $query = "INSERT INTO ukuran_baju (ukuran_baju) VALUES (:ukuran_baju)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":ukuran_baju", $data->ukuran_baju);

        if ($stmt->execute()) {
            $response = new stdClass();
            $response->status = "success";
            $response->message = "Ukuran baju berhasil ditambahkan.";
            echo json_encode($response);
        } else {
            $response = new stdClass();
            $response->status = "error";
            $response->message = "Gagal menambahkan ukuran baju.";
            echo json_encode($response);
        }
    } else {
        $response = new stdClass();
        $response->status = "error";
        $response->message = "Ukuran baju tidak boleh kosong.";
        echo json_encode($response);
    }
} catch (PDOException $e) {
    $response = new stdClass();
    $response->status = "error";
    $response->message = $e->getMessage();
    echo json_encode($response);
}
?>