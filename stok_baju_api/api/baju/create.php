<?php
header("Content-Type: application/json"); // Set header untuk respons JSON
require_once __DIR__ . '/../../db/connection.php';

try {
    // Validasi input data utama
    if (empty($_POST['nama_baju']) || empty($_POST['id_jenis_baju']) || 
        empty($_POST['id_ukuran_baju']) || empty($_POST['harga']) || empty($_POST['stok'])) {
        throw new Exception("Input tidak valid. Pastikan semua data sudah diisi.");
    }

    // Ambil data utama dari form
    $nama_baju = $_POST['nama_baju'];
    $id_jenis_baju = $_POST['id_jenis_baju'];
    $id_ukuran_baju = $_POST['id_ukuran_baju'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $gambar_url = "http://localhost/uploads/default.jpg"; // Gambar default

    // Validasi dan upload gambar (jika ada)
    if (isset($_FILES['gambar_url']) && $_FILES['gambar_url']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/../../uploads/"; // Path relatif dari create.php

        // Buat folder uploads jika belum ada
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("Gagal membuat folder uploads.");
            }
        }

        // Generate nama unik untuk file
        $fileName = time() . "_" . basename($_FILES['gambar_url']['name']);
        $uploadPath = $uploadDir . $fileName;

        // Validasi tipe file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['gambar_url']['type'], $allowedTypes)) {
            throw new Exception("File harus berupa gambar dengan format JPEG, PNG, atau GIF.");
        }

        // Validasi ukuran file (maksimal 2MB)
        $maxSize = 2 * 1024 * 1024; // 2MB
        if ($_FILES['gambar_url']['size'] > $maxSize) {
            throw new Exception("Ukuran file maksimal adalah 2MB.");
        }

        // Pindahkan file ke folder upload
        if (move_uploaded_file($_FILES['gambar_url']['tmp_name'], $uploadPath)) {
            $gambar_url = "http://localhost/uploads/" . $fileName; // URL untuk akses gambar
        } else {
            throw new Exception("Gagal mengunggah gambar.");
        }
    }

    // Query untuk memasukkan data ke tabel `baju`
    $query = "INSERT INTO baju (nama_baju, id_jenis_baju, id_ukuran_baju, harga, stok, gambar_url) 
              VALUES (:nama_baju, :id_jenis_baju, :id_ukuran_baju, :harga, :stok, :gambar_url)";
    $stmt = $conn->prepare($query);

    // Bind parameter ke query
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
            "message" => "Baju berhasil ditambahkan.",
            "data" => [
                "nama_baju" => $nama_baju,
                "id_jenis_baju" => $id_jenis_baju,
                "id_ukuran_baju" => $id_ukuran_baju,
                "harga" => $harga,
                "stok" => $stok,
                "gambar_url" => $gambar_url
            ]
        ]);
    } else {
        throw new Exception("Gagal menambahkan baju.");
    }
} catch (Exception $e) {
    // Tangani error dan kirim respons JSON
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>