<?php
// https://novaldis.c120.me/tp6-prakdesweb/login.php
require 'functions.php';

checkCookie();
if (!isset($_SESSION["login"])) {
    $query = "You are not logged in";
    header("Location: login.php?message=$query");
    exit;
}

$data = select("SELECT * FROM dosen");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container p-4">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-2">
            <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Mahasiswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="dosen.php">Dosen</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <h1 class="text-center">Data Dosen</h1>

        <a href="createUpdateDosen.php" class="addButtonArea float-end position-relative me-4" style="margin-top: 10px; margin-bottom: 10px; z-index: 10;">
            <button type="button" class="btn btn-primary">Add</button>
        </a>

        <?php if (isset($_GET["status"])) : ?>
            <div class="alert alert-<?= ($_GET["status"][0] == "b") ? 'success' : 'danger' ?>" role="alert">Dosen <?= $_GET["status"]; ?></div>
        <?php endif; ?>

        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>#</th>
            </tr>
            <?php $no = 1;
            foreach ($data as $row) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row["nim"]; ?></td>
                    <td><?= $row["nama"]; ?></td>
                    <td><?= $row["tempat_lahir"]; ?></td>
                    <td><?= $row["tanggal_lahir"]; ?></td>
                    <td><?= $row["jenis_kelamin"]; ?></td>
                    <td><?= $row["fakultas"]; ?></td>
                    <td><?= $row["jurusan"]; ?></td>
                    <td>
                        <a href="createUpdateDosen.php?id=<?= $row['id']; ?>" class="addButtonArea">
                            <button type="button" class="btn btn-info">Update</button>
                        </a>
                        <a href="delete.php?id=<?= $row['id']; ?>&table=dosen" class="addButtonArea">
                            <button type="button" class="btn btn-danger">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>