<?php
header("Content-Type: application/json");
require_once '../connection.php';

$query = "SELECT * FROM ukuran_baju";
$stmt = $conn->prepare($query);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results);
?>
