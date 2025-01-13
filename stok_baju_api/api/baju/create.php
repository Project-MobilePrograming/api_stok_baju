<?php
header("Content-Type: application/json"); // Set header untuk respons JSON
header("Access-Control-Allow-Origin: *"); // Izinkan akses dari semua domain
header("Access-Control-Allow-Methods: POST"); // Izinkan metode POST
header("Access-Control-Allow-Headers: Content-Type"); // Izinkan header Content-Type

require_once __DIR__ . '/../../db/connection.php';

try {
    // Validasi input data utama
    if (empty($_POST['nama_baju']) || empty($_POST['id_jenis_baju']) || 
        empty($_POST['id_ukuran_baju']) || empty($_POST['harga']) || empty($_POST['stok'])) {
        throw new Exception("Input tidak valid. Pastikan semua data sudah diisi.");
    }

    // Ambil data utama dari form
    $nama_baju = htmlspecialchars($_POST['nama_baju']); // Gunakan htmlspecialchars untuk mencegah XSS
    $id_jenis_baju = intval($_POST['id_jenis_baju']); // Konversi ke integer
    $id_ukuran_baju = intval($_POST['id_ukuran_baju']); // Konversi ke integer
    $harga = floatval($_POST['harga']); // Konversi ke float
    $stok = intval($_POST['stok']); // Konversi ke integer
    $gambar_url = "https://0685-2001-448a-500c-1d64-a998-a616-8616-92bf.ngrok-free.app/PPSB/stok_baju_api/uploads/default.jpg"; // Gambar default

    // Validasi dan upload gambar (jika ada)
    if (isset($_FILES['gambar_url']) && $_FILES['gambar_url']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/../../uploads/"; // Path relatif dari create.php

        // Validasi dan buat folder uploads jika belum ada
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("Gagal membuat folder uploads.");
            }
        }

        // Fungsi untuk memproses upload gambar
        $gambar_url = prosesUploadGambar($_FILES['gambar_url'], $uploadDir);
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
    http_response_code(400); // Kirim status HTTP 400 untuk error
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

// Fungsi untuk memproses upload gambar
function prosesUploadGambar($file, $uploadDir) {
    // Generate nama unik untuk file
    $fileName = time() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file['name']);
    $uploadPath = $uploadDir . $fileName;

    // Validasi ekstensi file
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        throw new Exception("File harus berupa gambar dengan ekstensi JPG, JPEG, PNG, atau GIF.");
    }

    // Validasi tipe MIME menggunakan fungsi `mime_content_type`
    $fileMimeType = mime_content_type($file['tmp_name']);
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($fileMimeType, $allowedMimeTypes)) {
        throw new Exception("File harus berupa gambar dengan format JPEG, PNG, atau GIF.");
    }

    // Validasi ukuran file (maksimal 2MB)
    $maxSize = 2 * 1024 * 1024; // 2MB
    if ($file['size'] > $maxSize) {
        throw new Exception("Ukuran file maksimal adalah 2MB.");
    }

    // Debugging informasi file
    error_log("Nama File: " . $file['name']);
    error_log("Tipe MIME: " . $fileMimeType);
    error_log("Ekstensi: " . $fileExtension);
    error_log("Ukuran: " . $file['size']);

    // Pindahkan file ke folder upload
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return "https://0685-2001-448a-500c-1d64-a998-a616-8616-92bf.ngrok-free.app/PPSB/stok_baju_api/uploads/" . $fileName;
    } else {
        throw new Exception("Gagal mengunggah gambar.");
    }
}
