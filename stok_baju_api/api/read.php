<?php
header("Content-Type: application/json");
require_once '../db/connection.php';

$query = "SELECT * FROM baju ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(["message" => "Tidak ada data baju."]);
}
?>