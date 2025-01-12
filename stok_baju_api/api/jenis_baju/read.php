<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../db/connection.php';

try {
    $query = "SELECT * FROM jenis_baju";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        echo json_encode([
            "status" => "success",
            "message" => "Data berhasil diambil.",
            "data" => $results
        ]);
    } else {
        echo json_encode([
            "status" => "success",
            "message" => "Tidak ada data ditemukan.",
            "data" => []
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