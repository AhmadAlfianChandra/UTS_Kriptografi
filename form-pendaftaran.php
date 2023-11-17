<!DOCTYPE html>
<html>
<head>
<title>Form Pendaftaran Anggota</title>
    <!-- Load file CSS Bootstrap offline -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<h2>Form Pendaftaran Anggota</h2>
    <form action="simpan-pendaftaran.php" method="post">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" placeholder="Masukan Username" />
        </div>
		<div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" />
        </div>
		<div class="form-group">
			<label>Alamat:</label>
			<textarea name="alamat" class="form-control" rows="5"placeholder="Masukan Alamat" ></textarea>
		</div> 
		<div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan Email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Masukkan alamat email yang valid"/>
        </div>
		<div class="form-group">
            <label>No HP:</label>
            <input type="text" name="no_hp" class="form-control" placeholder="Masukan No HP" />
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <a href="cari-data.php" class="button">Cari Data</a>


    </form>
</div>
</body>
</html>