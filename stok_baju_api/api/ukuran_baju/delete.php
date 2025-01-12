<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

try {
    if (!empty($data->id)) {
        $query = "DELETE FROM ukuran_baju WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $data->id);

        if ($stmt->execute()) {
            $response = new stdClass();
            $response->status = "success";
            $response->message = "Ukuran baju berhasil dihapus.";
            echo json_encode($response);
        } else {
            $response = new stdClass();
            $response->status = "error";
            $response->message = "Gagal menghapus ukuran baju.";
            echo json_encode($response);
        }
    } else {
        $response = new stdClass();
        $response->status = "error";
        $response->message = "ID tidak boleh kosong.";
        $response->data = null;
        echo json_encode($response);
    }
} catch (PDOException $e) {
    $response = new stdClass();
    $response->status = "error";
    $response->message = $e->getMessage();
    $response->data = null;
    echo json_encode($response);
}
?>