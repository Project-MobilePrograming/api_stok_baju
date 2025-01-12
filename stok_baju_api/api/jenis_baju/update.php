<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

try {
    if (!empty($data->id) && !empty($data->nama_jenis_baju)) {
        $query = "UPDATE jenis_baju SET nama_jenis_baju = :nama_jenis_baju WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $data->id);
        $stmt->bindParam(":nama_jenis_baju", $data->nama_jenis_baju);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Jenis baju berhasil diperbarui.",
                "data" => null
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal memperbarui jenis baju.",
                "data" => null
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "ID atau nama jenis baju tidak boleh kosong.",
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