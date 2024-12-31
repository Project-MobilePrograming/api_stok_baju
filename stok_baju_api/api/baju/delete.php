<?php
header("Content-Type: application/json");
require_once '../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $query = "DELETE FROM baju WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Baju berhasil dihapus."]);
    } else {
        echo json_encode(["message" => "Gagal menghapus baju."]);
    }
} else {
    echo json_encode(["message" => "ID tidak diberikan."]);
}
?>