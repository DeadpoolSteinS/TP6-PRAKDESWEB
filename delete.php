<?php
require 'functions.php';

if ($_GET["table"] == "dosen") {
    $id = $_GET["id"];
    $data = select("SELECT * FROM mahasiswa WHERE dosen_id=$id");
    if (count($data) > 0) {
        header("Location: dosen.php?status=mempunyai koneksi");
        exit;
    }
}

$status = delete($_GET["id"], $_GET["table"]);

if ($_GET["table"] == "mahasiswa") {
    header("Location: index.php?status=$status" . " dihapus");
} else {
    header("Location: dosen.php?status=$status" . " dihapus");
}
exit;
