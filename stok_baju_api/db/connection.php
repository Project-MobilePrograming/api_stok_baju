<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "stok_baju";

try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
    exit();
}

// Fungsi untuk eksekusi query secara umum
function runQuery($query, $params = []) {
    global $conn;
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        echo "Query error: " . $e->getMessage();
        return false;
    }
}
?>
