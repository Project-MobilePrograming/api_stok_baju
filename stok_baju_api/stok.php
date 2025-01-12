<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Update Barang</h1>
    <!-- Tombol Kembali ke Beranda -->
    <div class="mb-4">
        <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
    </div>
    <!-- Form Update Barang -->
    <?php if (isset($barang)): ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $barang['id']; ?>">
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="<?php echo $barang['nama_barang']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control" value="<?php echo $barang['stok']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Barang</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
                <?php if (!empty($barang['gambar'])): ?>
                    <img src="uploads/<?php echo $barang['gambar']; ?>" alt="<?php echo $barang['nama_barang']; ?>" style="width: 100px; height: 100px; margin-top: 10px;">
                <?php endif; ?>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Barang</button>
            <a href="stok_barang.php" class="btn btn-secondary">Kembali</a>
        </form>
    <!-- <?php else: ?> -->
        <!-- <div class="alert alert-danger">Data barang tidak ditemukan!</div> -->
    <!-- <?php endif; ?> -->
</div>

</body>
</html>
