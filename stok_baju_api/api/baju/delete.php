<?php
header("Content-Type: application/json");
require_once '../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    try {
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
                unlink($gambar_path);
            }
        }

        // Hapus data dari database
        $query = "DELETE FROM baju WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $data->id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Baju berhasil dihapus."]);
        } else {
            throw new Exception("Gagal menghapus baju.");
        }
    } catch (Exception $e) {
        echo json_encode(["message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["message" => "ID tidak diberikan."]);
}
?>