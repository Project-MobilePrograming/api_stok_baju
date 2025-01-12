<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../db/connection.php';

try {
    $query = "SELECT * FROM ukuran_baju";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        $response = new stdClass();
        $response->status = "success";
        $response->message = "Data berhasil diambil.";
        echo json_encode($response);
    } else {
        $response = new stdClass();
        $response->status = "success";
        $response->message = "Tidak ada data ditemukan.";
        echo json_encode($response);
    }
} catch (PDOException $e) {
    $response = new stdClass();
    $response->status = "error";
    $response->message = $e->getMessage();
    echo json_encode($response);
}
?>