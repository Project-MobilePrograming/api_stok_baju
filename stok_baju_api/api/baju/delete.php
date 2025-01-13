<?php
header("Content-Type: application/json"); // Set header untuk respons JSON
header("Access-Control-Allow-Origin: *"); // Izinkan akses dari semua domain
header("Access-Control-Allow-Methods: DELETE"); // Izinkan metode DELETE
header("Access-Control-Allow-Headers: Content-Type"); // Izinkan header Content-Type

require_once __DIR__ . '/../../db/connection.php';

try {
    // Ambil ID dari query parameters
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception("ID tidak diberikan.");
    }

    $id = intval($_GET['id']); // Ambil ID dan konversi ke integer

    // Ambil path gambar dari database sebelum menghapus data
    $query = "SELECT gambar_url FROM baju WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $baju = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($baju && !empty($baju['gambar_url'])) {
        // Hapus file gambar dari folder uploads
        $gambar_path = __DIR__ . "/../../uploads/" . basename($baju['gambar_url']);
        if (file_exists($gambar_path)) {
            if (!unlink($gambar_path)) {
                throw new Exception("Gagal menghapus file gambar.");
            }
        }
    }

    // Hapus data dari database
    $query = "DELETE FROM baju WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Baju berhasil dihapus."
        ]);
    } else {
        throw new Exception("Gagal menghapus baju.");
    }
} catch (Exception $e) {
    // Tangani error dan kirim respons JSON
    http_response_code(400); // Kirim status HTTP 400 untuk error
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>