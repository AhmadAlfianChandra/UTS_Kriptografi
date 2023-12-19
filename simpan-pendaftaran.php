<?php
// Include file koneksi ke database
include "koneksi.php";
require "playfaircipher.php";
$key = "key";

// Menerima nilai dari kiriman form pendaftaran
$username = encrypt($_POST["username"],$key);
$nama = encrypt($_POST["nama"],$key);
$alamat = encrypt($_POST["alamat"],$key);
$email = encrypt($_POST["email"],$key);
$no_hp = $_POST["no_hp"];

// Query input menginput data ke dalam tabel anggota
	$sql = "insert into anggota (username, nama, alamat, email, no_hp) values
        ('$username', '$nama', '$alamat', '$email', '$no_hp')";

// Mengeksekusi/menjalankan query di atas
	$hasil=mysqli_query($kon,$sql);
// Kondisi apakah berhasil atau tidak
if ($hasil) {
    // Jika berhasil, ambil ID terakhir yang dimasukkan
    $id_anggota = mysqli_insert_id($kon);

    // Tampilkan hasil ID
    echo "Berhasil simpan data anggota. ID terakhir: $id_anggota";

    // Tambahkan tombol Kembali
    echo "<br><br><a href='form-pendaftaran.php'>Kembali</a>";
    exit;
} else {
    echo "Gagal simpan data anggota";

    // Tambahkan tombol Kembali
    echo "<br><br><a href='form-pendaftaran.php'>Kembali</a>";
    exit;
}
?>
