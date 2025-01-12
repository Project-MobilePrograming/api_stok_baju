<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

try {
    if (!empty($data->id)) {
        $query = "DELETE FROM jenis_baju WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $data->id);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Jenis baju berhasil dihapus.",
                "data" => null
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal menghapus jenis baju.",
                "data" => null
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "ID tidak boleh kosong.",
            "data" => null
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage(),
        "data" => null
    ]);
}
?>