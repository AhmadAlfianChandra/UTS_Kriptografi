<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Data</title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tambahkan gaya tambahan jika diperlukan */
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Pencarian Data</h1>

        <form action="" method="get" class="mb-4">
            <div class="input-group">
                <label for="search" class="visually-hidden">Cari Data:</label>
                <input type="text" id="search" name="search" class="form-control" placeholder="Cari data..." required>
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <?php
        // Gabungkan dengan file koneksi.php
        include 'koneksi.php';
        require "playfaircipher.php";
        $key = "key";
        // Proses pencarian ketika formulir dikirim
        if(isset($_GET['search'])) {
            // Ambil data dari formulir pencarian
            $id_anggota = $_GET['search'];

            // Gunakan prepared statement untuk menghindari SQL injection
            $query = "SELECT * FROM anggota WHERE id_anggota LIKE ?";
            $stmt = $kon->prepare($query);
            $stmt->bind_param("s", $id_anggota);
            $stmt->execute();
            $result = $stmt->get_result();

            // Tampilkan hasil pencarian
            if ($result->num_rows > 0) {
                echo "<h2 class='mb-3'>Hasil Pencarian untuk $id_anggota :</h2>";
                echo "<ul class='list-group'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item'>" . decrypt($row['username'],$key). "</li>";
                    echo "<li class='list-group-item'>" . decrypt($row['alamat'],$key) . "</li>";
                    echo "<li class='list-group-item'>" . decrypt($row['email'],$key) . "</li>";
                    echo "<li class='list-group-item'>" . $row['no_hp'] . "</li>";
                    // Tambahkan kolom-kolom lain sesuai kebutuhan
                }
                echo "</ul>";
                // Tambahkan tombol kembali
                echo "<a href='form-pendaftaran.php' class='btn btn-secondary mt-3'>Kembali</a>";
            } else {
                echo "<p class='mt-3'>Tidak ada hasil pencarian untuk '$id_anggota'.</p>";
                // Tambahkan tombol kembali
                echo "<a href='form-pendaftaran.php' class='btn btn-secondary mt-3'>Kembali</a>";
            }

            // Tutup statement
            $stmt->close();
        }

        // Tutup koneksi
        $kon->close();
        ?>

    </div>

    <!-- Tambahkan link Bootstrap JS dan Popper.js (diperlukan untuk beberapa komponen Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
