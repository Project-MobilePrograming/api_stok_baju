<?php
// Memulai sesi PHP jika diperlukan
session_start();

// Fungsi untuk menangani bagian header HTML
function renderHeader($title) {
    echo "<head>\n";
    echo "    <meta charset='UTF-8'>\n";
    echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
    echo "    <title>$title</title>\n";
    echo "    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>\n";
    echo "    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>\n";
    echo "</head>\n";
}

// Fungsi untuk bagian navigasi
function renderNavbar() {
    echo "<nav class='navbar navbar-expand-lg navbar-light bg-light'>\n";
    echo "    <div class='container-fluid'>\n";
    echo "        <a class='navbar-brand' href='index.php'>StockManager</a>\n";
    echo "        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>\n";
    echo "            <span class='navbar-toggler-icon'></span>\n";
    echo "        </button>\n";
    echo "        <div class='collapse navbar-collapse' id='navbarNav'>\n";
    echo "            <ul class='navbar-nav'>\n";
    echo "                <li class='nav-item'><a class='nav-link' href='index.php'>Home</a></li>\n";
    echo "                <li class='nav-item'><a class='nav-link' href='update_barang.php'>Update Barang</a></li>\n";
    echo "                <li class='nav-item'><a class='nav-link' href='stok.php'>Stok Barang</a></li>\n";
    echo "            </ul>\n";
    echo "        </div>\n";
    echo "    </div>\n";
    echo "</nav>\n";
}

// Fungsi untuk footer
function renderFooter() {
    echo "<footer class='text-center mt-4'>\n";
    echo "    <p>&copy; " . date('Y') . " StockManager. All Rights Reserved.</p>\n";
    echo "</footer>\n";
}
?>

<!DOCTYPE html>
<html lang="en">
<?php renderHeader('Beranda'); ?>
<body>
    <?php renderNavbar(); ?>

    <main class='container mt-4'>
        <div class='text-center'>
            <h1>Selamat Datang di Halaman Beranda</h1>
            <p class='lead'>Kelola stok barang Anda dengan mudah dan efisien.</p>
        </div>
        <section class='mt-5'>
            <h2>Menu Utama</h2>
            <div class='row'>
                <div class='col-md-6'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'>Update Barang</h5>
                            <p class='card-text'>Tambahkan atau perbarui data barang Anda.</p>
                            <a href='update_barang.php' class='btn btn-primary'>Ke Halaman Update Barang</a>
                        </div>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'>Stok Barang</h5>
                            <p class='card-text'>Lihat dan kelola stok barang yang tersedia.</p>
                            <a href='stok.php' class='btn btn-primary'>Ke Halaman Stok Barang</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php renderFooter(); ?>
</body>
</html>
