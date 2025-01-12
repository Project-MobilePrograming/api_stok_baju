<?php
// Mengaktifkan pelaporan error untuk semua jenis error (E_ALL)
error_reporting(E_ALL);

// Mengatur agar error ditampilkan di layar (berguna untuk debugging)
ini_set('display_errors', 1);

// Mendapatkan request dari URL
$uri = $_SERVER['REQUEST_URI'];
$base_path = '/PPSB/stok_baju_api'; // Sesuaikan dengan base path Anda
$request = str_replace($base_path, '', $uri); // Hapus base path dari URL

// Hilangkan query string dari URL (jika ada)
$request = strtok($request, '?');

// Route berdasarkan $request
switch ($request) {
    // Route untuk CRUD tabel baju
    case '/api/baju/create':
        require_once __DIR__ . '/api/baju/create.php';
        break;
    case '/api/baju/read':
        require_once __DIR__ . '/api/baju/read.php';
        break;
    case '/api/baju/update':
        require_once __DIR__ . '/api/baju/update.php';
        break;
    case '/api/baju/delete':
        require_once __DIR__ . '/api/baju/delete.php';
        break;

    // Route untuk CRUD tabel jenis_baju
    case '/api/jenis_baju/create':
        require_once __DIR__ . '/api/jenis_baju/create.php';
        break;
    case '/api/jenis_baju/read':
        require_once __DIR__ . '/api/jenis_baju/read.php';
        break;
    case '/api/jenis_baju/update':
        require_once __DIR__ . '/api/jenis_baju/update.php';
        break;
    case '/api/jenis_baju/delete':
        require_once __DIR__ . '/api/jenis_baju/delete.php';
        break;

    // Route untuk CRUD tabel ukuran_baju
    case '/api/ukuran_baju/create':
        require_once __DIR__ . '/api/ukuran_baju/create.php';
        break;
    case '/api/ukuran_baju/read':
        require_once __DIR__ . '/api/ukuran_baju/read.php';
        break;
    case '/api/ukuran_baju/update':
        require_once __DIR__ . '/api/ukuran_baju/update.php';
        break;
    case '/api/ukuran_baju/delete':
        require_once __DIR__ . '/api/ukuran_baju/delete.php';
        break;

    case '/favicon.ico': // Untuk favicon request
        http_response_code(204); // No Content
        exit;

    default:
        http_response_code(404);  // Not Found
        echo json_encode(["error" => "Route tidak ditemukan"]);
        break;
}
?>