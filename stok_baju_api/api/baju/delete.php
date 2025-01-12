<?php
header("Content-Type: application/json"); // Set header untuk respons JSON
require_once __DIR__ . '/../../db/connection.php';

try {
    // Ambil data dari input JSON
    $data = json_decode(file_get_contents("php://input"));

    // Validasi input ID
    if (empty($data->id)) {
        throw new Exception("ID tidak diberikan.");
    }

    // Ambil path gambar dari database sebelum menghapus data
    $query = "SELECT gambar_url FROM baju WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);
    $stmt->execute();

    $baju = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($baju && !empty($baju['gambar_url'])) {
        // Hapus file gambar dari folder uploads
        $gambar_path = str_replace("http://localhost/uploads/", "../../uploads/", $baju['gambar_url']);
        if (file_exists($gambar_path)) {
            if (!unlink($gambar_path)) {
                throw new Exception("Gagal menghapus file gambar.");
            }
        }
    }

    // Hapus data dari database
    $query = "DELETE FROM baju WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);

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
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>