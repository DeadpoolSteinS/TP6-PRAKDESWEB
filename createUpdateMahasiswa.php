<?php
// https://novaldis.c120.me/tp6-prakdesweb/login.php
require 'functions.php';

checkCookie();
if (!isset($_SESSION["login"])) {
    $query = "You are not logged in";
    header("Location: login.php?message=$query");
    exit;
}

if (isset($_POST["submit"])) {
    if (isset($_GET["id"])) {
        $status = updateMahasiswa($_GET["id"]);
        header("Location: index.php?status=$status" . " diupdate");
    } else {
        $status = insertMahasiswa();
        header("Location: index.php?status=$status" . " ditambahkan");
    }
    exit;
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $data = select("SELECT * FROM mahasiswa WHERE id=$id")[0];
} else {
    $data = [
        "nim" => "",
        "nama" => "",
        "tempat_lahir" => "",
        "tanggal_lahir" => "",
        "jenis_kelamin" => "",
        "fakultas" => "",
        "jurusan" => "",
        "ipk" => "",
        "dosen_id" => 0
    ];
}
$dosens = select("SELECT id, nama FROM dosen");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container p-4">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-2">
            <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Mahasiswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dosen.php">Dosen</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <h1 class="text-center">Form Mahasiswa</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" value="<?= $data['nim']; ?>">
                <div id="nimHelp" class="form-text">(7 digit angka)</div>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama']; ?>">
            </div>
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $data['tempat_lahir']; ?>">
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $data['tanggal_lahir']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki" <?php if ($data['jenis_kelamin'] == 'Laki-laki') echo "checked"; ?>>
                    <label class="form-check-label" for="laki_laki">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" <?php if ($data['jenis_kelamin'] == 'Perempuan') echo "checked"; ?>>
                    <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="fakultas" class="form-label">Fakultas</label>
                <select class="form-select" name="fakultas">
                    <option value="FIP" <?php if ($data["fakultas"] == "FIP") echo "selected"; ?>>FIP</option>
                    <option value="FPIPS" <?php if ($data["fakultas"] == "FPIPS") echo "selected"; ?>>FPIPS</option>
                    <option value="FBPS" <?php if ($data["fakultas"] == "FBPS") echo "selected"; ?>>FBPS</option>
                    <option value="FPSD" <?php if ($data["fakultas"] == "FPSD") echo "selected"; ?>>FPSD</option>
                    <option value="FPMIPA" <?php if ($data["fakultas"] == "FPMIPA") echo "selected"; ?>>FPMIPA</option>
                    <option value="FPTK" <?php if ($data["fakultas"] == "FPTK") echo "selected"; ?>>FPTK</option>
                    <option value="FPEB" <?php if ($data["fakultas"] == "FPEB") echo "selected"; ?>>FPEB</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= $data['jurusan']; ?>">
            </div>
            <div class="mb-3">
                <label for="ipk" class="form-label">IPK</label>
                <input type="number" class="form-control" id="ipk" name="ipk" step="any" value="<?= $data['ipk']; ?>" required>
                <div id="ipkHelp" class="form-text">(angka desimal dipisah dengan karakter titik ".")</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Dosen Pembimbing</label>
                <select class="form-select" name="dosen_id">
                    <?php foreach ($dosens as $dosen) : ?>
                        <option value="<?= $dosen["id"]; ?>" <?php if ($data["dosen_id"] == $dosen["id"]) echo "selected"; ?>><?= $dosen["nama"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>