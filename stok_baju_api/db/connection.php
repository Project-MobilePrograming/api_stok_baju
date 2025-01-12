<?php
// Konfigurasi koneksi ke database
$host = "localhost"; // Alamat host server database (localhost untuk server lokal)
$dbname = "stok_baju"; // Nama database yang ingin diakses
$username = "root";  // Username untuk koneksi ke database (root adalah default di XAMPP/MAMP)
$password = "";      // Password untuk koneksi ke database (kosong secara default di XAMPP/MAMP)

try {
    // Membuat koneksi ke database menggunakan PDO
    // Format DSN: mysql:host=nama_host;dbname=nama_database;charset=utf8
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8", // Alamat database dan konfigurasi charset UTF-8
        $username,                                        // Username untuk login ke database
        $password                                         // Password untuk login ke database
    );

    // Mengatur mode error agar PDO melempar pengecualian (exception) jika terjadi error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Jika koneksi berhasil, tidak ada tindakan tambahan
} catch (PDOException $e) {
    // Jika koneksi gagal, tangkap error dan tampilkan pesan
    echo "Koneksi gagal: " . $e->getMessage(); 
    exit(); // Hentikan script untuk mencegah error lebih lanjut
}

// Fungsi untuk menjalankan query SQL
// Digunakan untuk menghindari pengulangan kode SQL
function runQuery($query, $params = []) {
    global $conn; // Variabel global untuk menggunakan koneksi di luar fungsi

    try {
        // Mempersiapkan query menggunakan PDO::prepare()
        // Query ini bisa berisi parameter placeholder seperti ":param"
        $stmt = $conn->prepare($query); 

        // Menjalankan query dengan parameter yang disediakan (jika ada)
        $stmt->execute($params); 

        // Jika sukses, kembalikan objek statement untuk diolah
        return $stmt; 
    } catch (PDOException $e) {
        // Jika ada error saat query, tangkap error dan tampilkan pesan
        echo "Query error: " . $e->getMessage(); 
        return false; // Jika error, kembalikan false
    }
}
?>
