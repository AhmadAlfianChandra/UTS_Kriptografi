<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Data</title>
</head>
<body>
    <h1>Pencarian Data</h1>

    <form action="" method="get">
        <label for="search">Cari Data:</label>
        <input type="text" id="search" name="search" required>
        <button type="submit">Cari</button>
    </form>

    <?php
    // Gabungkan dengan file koneksi.php
    include 'koneksi.php';
    require ("playfaircipher.php");
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
            echo "<h2>Hasil Pencarian untuk '$id_anggota':</h2>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . playfairDecrypt($row['username'],$key). "</li>";
                echo "<li>" . playfairDecrypt($row['alamat'],$key) . "</li>";
                echo "<li>" . playfairDecrypt($row['email'],$key) . "</li>";
                echo "<li>" . $row['no_hp'] . "</li>";
                // Tambahkan kolom-kolom lain sesuai kebutuhan
            }
            echo "</ul>";
        } else {
            echo "<p>Tidak ada hasil pencarian untuk '$id_anggota'.</p>";
        }

        // Tutup statement
        $stmt->close();
    }

    // Tutup koneksi
    $kon->close();
    ?>

</body>
</html>
