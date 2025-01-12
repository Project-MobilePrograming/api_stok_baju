<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

try {
    if (!empty($data->id) && !empty($data->ukuran_baju)) {
        $query = "UPDATE ukuran_baju SET ukuran_baju = :ukuran_baju WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $data->id);
        $stmt->bindParam(":ukuran_baju", $data->ukuran_baju);

        if ($stmt->execute()) {
            $response = new stdClass();
            $response->status = "success";
            $response->message = "Ukuran baju berhasil diperbarui.";
            echo json_encode($response);
        } else {
            $response = new stdClass();
            $response->status = "error";
            $response->message = "Gagal memperbarui ukuran baju.";
            echo json_encode($response);
        }
    } else {
        $response = new stdClass();
        $response->status = "error";
        $response->message = "ID atau ukuran tidak boleh kosong.";
        $response->data = null;
        echo json_encode($response);
    }
} catch (PDOException $e) {
    $response = new stdClass();
    $response->status = "error";
    $response->message = $e->getMessage();

    echo json_encode($response);
}
?>