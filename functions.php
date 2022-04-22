<?php
// https://novaldis.c120.me/tp6-prakdesweb/login.php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_universitas");

function select($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);

    // save every data/row on $rows array
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) $rows[] = $row;

    // return 2d array where [row][column]
    return $rows;
}

function insertMahasiswa()
{
    global $conn;
    $nim           = htmlspecialchars($_POST["nim"]);
    $nama          = htmlspecialchars($_POST["nama"]);
    $tempat_lahir  = htmlspecialchars($_POST["tempat_lahir"]);
    $tanggal_lahir = htmlspecialchars($_POST["tanggal_lahir"]);
    $jenis_kelamin = (isset($_POST["jenis_kelamin"])) ? htmlspecialchars($_POST["jenis_kelamin"]) : "";
    $fakultas      = htmlspecialchars($_POST["fakultas"]);
    $jurusan       = htmlspecialchars($_POST["jurusan"]);
    $ipk           = htmlspecialchars($_POST["ipk"]);
    $dosen_id      = htmlspecialchars($_POST["dosen_id"]);

    $query = "INSERT INTO mahasiswa VALUES (NULL, '$nim', '$nama', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$ipk', '$fakultas', '$jurusan', '$dosen_id')";
    mysqli_query($conn, $query);

    return (mysqli_affected_rows($conn) > 0) ? "berhasil" : "gagal";
    // return (mysqli_affected_rows($conn) > 0) ? ["berhasil", "Mahasiswa dengan nama \"$nama\" dan NIM \"$nim\" sudah berhasil ditambahkan"] : ["gagal", "Mahasiswa dengan nama \"$nama\" dan NIM \"$nim\" sudah gagal ditambahkan"];
}

function updateMahasiswa($id)
{
    global $conn;
    $nim           = htmlspecialchars($_POST["nim"]);
    $nama          = htmlspecialchars($_POST["nama"]);
    $tempat_lahir  = htmlspecialchars($_POST["tempat_lahir"]);
    $tanggal_lahir = htmlspecialchars($_POST["tanggal_lahir"]);
    $jenis_kelamin = (isset($_POST["jenis_kelamin"])) ? htmlspecialchars($_POST["jenis_kelamin"]) : "";
    $fakultas      = htmlspecialchars($_POST["fakultas"]);
    $jurusan       = htmlspecialchars($_POST["jurusan"]);
    $ipk           = htmlspecialchars($_POST["ipk"]);
    $dosen_id      = htmlspecialchars($_POST["dosen_id"]);

    $query = "UPDATE mahasiswa SET nim='$nim', nama='$nama', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', jenis_kelamin='$jenis_kelamin', ipk='$ipk', fakultas='$fakultas', jurusan='$jurusan', dosen_id='$dosen_id' WHERE id=$id";
    mysqli_query($conn, $query);

    return (mysqli_affected_rows($conn) > 0) ? "berhasil" : "gagal";
}

function insertDosen()
{
    global $conn;
    $nim           = htmlspecialchars($_POST["nim"]);
    $nama          = htmlspecialchars($_POST["nama"]);
    $tempat_lahir  = htmlspecialchars($_POST["tempat_lahir"]);
    $tanggal_lahir = htmlspecialchars($_POST["tanggal_lahir"]);
    $jenis_kelamin = (isset($_POST["jenis_kelamin"])) ? htmlspecialchars($_POST["jenis_kelamin"]) : "";
    $fakultas      = htmlspecialchars($_POST["fakultas"]);
    $jurusan       = htmlspecialchars($_POST["jurusan"]);

    $query = "INSERT INTO dosen VALUES (NULL, '$nim', '$nama', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$fakultas', '$jurusan')";
    mysqli_query($conn, $query);

    return (mysqli_affected_rows($conn) > 0) ? "berhasil" : "gagal";
}

function updateDosen($id)
{
    global $conn;
    $nim           = htmlspecialchars($_POST["nim"]);
    $nama          = htmlspecialchars($_POST["nama"]);
    $tempat_lahir  = htmlspecialchars($_POST["tempat_lahir"]);
    $tanggal_lahir = htmlspecialchars($_POST["tanggal_lahir"]);
    $jenis_kelamin = (isset($_POST["jenis_kelamin"])) ? htmlspecialchars($_POST["jenis_kelamin"]) : "";
    $fakultas      = htmlspecialchars($_POST["fakultas"]);
    $jurusan       = htmlspecialchars($_POST["jurusan"]);

    $query = "UPDATE dosen SET nim='$nim', nama='$nama', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', jenis_kelamin='$jenis_kelamin', fakultas='$fakultas', jurusan='$jurusan' WHERE id=$id";
    mysqli_query($conn, $query);

    return (mysqli_affected_rows($conn) > 0) ? "berhasil" : "gagal";
}

function delete($id, $table)
{
    global $conn;
    $query = "DELETE FROM $table WHERE id=$id";
    mysqli_query($conn, $query);
    return (mysqli_affected_rows($conn) > 0) ? "berhasil" : "gagal";
}

function checkCookie()
{
    if (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
        $username = $_COOKIE["username"];
        $data = select("SELECT * FROM admin WHERE username='$username'");
        if ($data != NULL) {
            if ($data[0]["password"] == $_COOKIE["password"]) $_SESSION["login"] = true;
        }
    }
}

function login()
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    $dataUsername = select("SELECT * FROM admin WHERE username='$username'");
    if ($dataUsername == NULL) return "Username is not registered!";
    if ($password != $dataUsername[0]["password"]) return "Password is wrong";

    $_SESSION["login"] = true;
    setcookie("username", $username, time() + 3600);
    setcookie("password", $dataUsername[0]["password"], time() + 3600);

    header("Location: index.php");
    exit;

    return "Login Successful";
}

function signup()
{
    global $conn;
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm  = $_POST["confirm"];

    $dataUsername = select("SELECT * FROM admin WHERE username='$username'");
    if ($dataUsername != NULL) return "Username is taken";
    else if ($password !== $confirm) return "Password is not same";

    mysqli_query($conn, "INSERT INTO admin VALUES (NULL, '$username', '$password')");

    return "Registration Successful";
}
