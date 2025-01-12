<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $query = "DELETE FROM ukuran_baju WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Ukuran baju berhasil dihapus."]);
    } else {
        echo json_encode(["message" => "Gagal menghapus ukuran baju."]);
    }
} else {
    echo json_encode(["message" => "ID tidak boleh kosong."]);
}
?>
