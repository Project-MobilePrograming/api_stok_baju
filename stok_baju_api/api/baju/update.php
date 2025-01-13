<?php
header("Content-Type: application/json"); // Set header untuk respons JSON
require_once __DIR__ . '/../../db/connection.php';

try {
    // Validasi input data utama
    if (
        empty($_POST['id']) || empty($_POST['nama_baju']) || empty($_POST['id_jenis_baju']) || 
        empty($_POST['id_ukuran_baju']) || empty($_POST['harga']) || empty($_POST['stok'])
    ) {
        throw new Exception("Input tidak valid. Pastikan semua data sudah diisi.");
    }

    // Ambil data utama dari form
    $id = intval($_POST['id']);
    $nama_baju = htmlspecialchars($_POST['nama_baju']);
    $id_jenis_baju = intval($_POST['id_jenis_baju']);
    $id_ukuran_baju = intval($_POST['id_ukuran_baju']);
    $harga = floatval($_POST['harga']);
    $stok = intval($_POST['stok']);
    $gambar_url = null;

    // Ambil data lama dari database
    $query = "SELECT gambar_url FROM baju WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $baju = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$baju) {
        throw new Exception("Data baju tidak ditemukan.");
    }

    $gambar_lama = $baju['gambar_url'];

    // Validasi dan upload gambar baru (jika ada)
    if (isset($_FILES['gambar_url']) && $_FILES['gambar_url']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/../../uploads/";

        // Buat folder uploads jika belum ada
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            throw new Exception("Gagal membuat folder uploads.");
        }

        // Generate nama unik untuk file baru
        $fileName = time() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $_FILES['gambar_url']['name']);
        $uploadPath = $uploadDir . $fileName;

        // Validasi ekstensi file
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($_FILES['gambar_url']['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception("File harus berupa gambar dengan ekstensi JPG, JPEG, PNG, atau GIF.");
        }

        // Validasi tipe MIME
        $fileMimeType = mime_content_type($_FILES['gambar_url']['tmp_name']);
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($fileMimeType, $allowedMimeTypes)) {
            throw new Exception("File harus berupa gambar dengan format JPEG, PNG, atau GIF.");
        }

        // Validasi ukuran file (maksimal 2MB)
        $maxSize = 2 * 1024 * 1024;
        if ($_FILES['gambar_url']['size'] > $maxSize) {
            throw new Exception("Ukuran file maksimal adalah 2MB.");
        }

        // Pindahkan file baru ke folder uploads
        if (!move_uploaded_file($_FILES['gambar_url']['tmp_name'], $uploadPath)) {
            throw new Exception("Gagal mengunggah gambar baru.");
        }

        // Hapus gambar lama jika ada
        if (!empty($gambar_lama)) {
            $oldImagePath = str_replace("http://localhost/uploads/", $uploadDir, $gambar_lama);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $gambar_url = "http://localhost/uploads/" . $fileName; // Set URL untuk gambar baru
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $gambar_url = $gambar_lama;
    }

    // Query untuk memperbarui data
    $query = "UPDATE baju 
              SET nama_baju = :nama_baju, id_jenis_baju = :id_jenis_baju, id_ukuran_baju = :id_ukuran_baju, 
                  harga = :harga, stok = :stok, gambar_url = :gambar_url 
              WHERE id = :id";
    $stmt = $conn->prepare($query);

    // Bind parameter
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":nama_baju", $nama_baju);
    $stmt->bindParam(":id_jenis_baju", $id_jenis_baju);
    $stmt->bindParam(":id_ukuran_baju", $id_ukuran_baju);
    $stmt->bindParam(":harga", $harga);
    $stmt->bindParam(":stok", $stok);
    $stmt->bindParam(":gambar_url", $gambar_url);

    // Eksekusi query
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Baju berhasil diperbarui.",
            "data" => [
                "id" => $id,
                "nama_baju" => $nama_baju,
                "id_jenis_baju" => $id_jenis_baju,
                "id_ukuran_baju" => $id_ukuran_baju,
                "harga" => $harga,
                "stok" => $stok,
                "gambar_url" => $gambar_url
            ]
        ]);
    } else {
        throw new Exception("Gagal memperbarui baju. Periksa query SQL Anda.");
    }
} catch (Exception $e) {
    // Tangani error
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>
