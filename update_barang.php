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

    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
    </div>

    <!-- Form Tambah/Edit Barang -->
    <form method="POST" action="" enctype="multipart/form-data" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="hidden" name="id" id="id">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label for="gambar" class="form-label">Gambar Barang</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div>
                    <button type="submit" name="add" class="btn btn-primary">Tambah</button>
                    <button type="submit" name="edit" class="btn btn-success">Update</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Tabel Data Barang -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama_barang']; ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td><img src="uploads/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_barang']; ?>" style="width: 50px; height: 50px;"></td>
                <td>
                    <a href="javascript:void(0)" onclick="editBarang(<?php echo htmlspecialchars(json_encode($row)); ?>)" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    function editBarang(barang) {
        document.getElementById('id').value = barang.id;
        document.getElementById('nama_barang').value = barang.nama_barang;
        document.getElementById('stok').value = barang.stok;
        document.getElementById('gambar').value = ""; // Kosongkan input file saat edit
    }
</script>
</body>
</html>
