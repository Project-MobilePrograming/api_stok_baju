<?php
header("Content-Type: application/json");
require_once '../connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $query = "DELETE FROM jenis_baju WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Jenis baju berhasil dihapus."]);
    } else {
        echo json_encode(["message" => "Gagal menghapus jenis baju."]);
    }
} else {
    echo json_encode(["message" => "ID tidak boleh kosong."]);
}
?>
