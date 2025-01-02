<?php
header("Content-Type: application/json");
require_once '../../db/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nama_baju) && !empty($data->id_jenis_baju) && !empty($data->id_ukuran_baju) && !empty($data->harga) && !empty($data->stok)) {
    $query = "INSERT INTO baju (nama_baju, id_jenis_baju, id_ukuran_baju, harga, stok) VALUES (:nama_baju, :id_jenis_baju, :id_ukuran_baju, :harga, :stok)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":nama_baju", $data->nama_baju);
    $stmt->bindParam(":id_jenis_baju", $data->id_jenis_baju);
    $stmt->bindParam(":id_ukuran_baju", $data->id_ukuran_baju);
    $stmt->bindParam(":harga", $data->harga);
    $stmt->bindParam(":stok", $data->stok);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Baju berhasil ditambahkan."]);
    } else {
        echo json_encode(["message" => "Gagal menambahkan baju."]);
    }
} else {
    echo json_encode(["message" => "Data tidak lengkap."]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            throw new Exception("ID produk tidak boleh kosong.");
        }
        $id = $_POST['id'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = "../../uploads/";
            $fileName = time() . "_" . basename($_FILES['image']['name']);
            $uploadPath = $uploadDir . $fileName;

            // Validasi file gambar
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                throw new Exception("File harus berupa gambar (JPEG, PNG, GIF).");
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $gambar_url = "http://localhost/uploads/" . $fileName;

                $query = "UPDATE baju SET gambar_url = :gambar_url WHERE id = :id";
                $params = [
                    ':gambar_url' => $gambar_url,
                    ':id' => $id
                ];
                $stmt = runQuery($query, $params);

                if ($stmt) {
                    echo json_encode(["success" => true, "message" => "Gambar berhasil diupload.", "url" => $gambar_url]);
                } else {
                    throw new Exception("Gagal memperbarui data di database.");
                }
            } else {
                throw new Exception("Gagal mengupload gambar.");
            }
        } else {
            throw new Exception("Tidak ada file gambar yang diupload.");
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Metode request tidak valid."]);
}
?>