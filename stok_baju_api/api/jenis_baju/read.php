<?php
header("Content-Type: application/json");
require_once '../../db/connection.php';

$query = "SELECT * FROM jenis_baju";
$stmt = $conn->prepare($query);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results);
?>