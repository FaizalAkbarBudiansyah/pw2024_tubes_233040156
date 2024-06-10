<?php
function koneksiDB()
{
    $db = mysqli_connect('localhost', 'root', '', 'pw2024_tubes_b_233040156');
    return $db;
}

function query($sql)
{
    $conn = koneksiDB();
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function cari($data)
{
    $query = "SELECT * FROM produk WHERE nama LIKE '%$data%'";
    return query($query);
}

function registrasi($data)
{
    $conn = mysqli_connect('localhost', 'root', '', 'pw2024_tubes_b_233040156');

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $query = "SELECT * FROM users WHERE username = '$username'";



    // cek username sudah ada atau belum
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('username sudah digunakan!');
        </script>";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
        alert('konfirmasi password tidak sesuai!');
        </script>";
        return false;
    }
    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO users VALUES(NULL, '$username', '$password')");

    return mysqli_affected_rows($conn);
}
