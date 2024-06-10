<?php
require 'function.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
                alert('user baru berhasil ditambahkan!');
                document.location.href = 'login.php'
                </script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<style>
    .register-box {
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 10px;
        background-color: #252525;

    }

    body {
        position: relative;
        background: url(../image/bglogin.jpg);
        background-size: cover;
        background-position: center;
    }
</style>
</head>

<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">

        <h3 style="color: red;"><a href="login.php"><i class="fa-solid fa-backward" style="margin-right: 25px; color: red; padding-top: 50%;"></i></a>REGISTRASI ADMIN</h3>
        <div class="register-box py-3 px-5 shadow mt-4">
            <form action="" method="post">
                <div class="mb-1" style="color: red;">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username"></input>
                </div>
                <div class="mb-1" style="color: red;">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password"></input>
                </div>
                <div class="mb-2" style="color: red;">
                    <label for="password2">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password2" id="password2"></input>
                </div>
                <div>
                    <button type="submit" class="btn btn-success form-control" name="register" style="margin-top: 20px; background-color: red;">Register</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/796f8abcad.js" crossorigin="anonymous"></script>
</body>

</html>