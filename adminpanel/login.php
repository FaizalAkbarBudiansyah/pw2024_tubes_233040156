<?php
session_start();
require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<style>
    .main {
        height: 100vh;
    }

    .login-box {
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 10px;
        background-color: #252525;
        margin-left: 50%;
        position: absolute;
    }

    body {
        position: relative;
        background: url(../image/bglogin.jpg);
        background-size: cover;
        background-position: center;
    }

    .text {
        margin-right: 45%;
        font-weight: bold;
        line-height: 1.1;
        letter-spacing: 2px;
    }

    .text h1 {
        color: red;
        font-size: 4rem;
        font-weight: 600;
        text-shadow: 8px 8px 10px rgba(0, 0, 0, 0);
    }

    .text h3 {
        color: red;
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 20px;
        text-shadow: 8px 8px 10px rgba(0, 0, 0, 0);
    }

    span {
        padding: 4px;
        color: black;
        background-color: red;
        border-radius: 10px;
    }
</style>

<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="text">
            <h3>Hello, Welcome</h3>
            <h1>Fanboy and <span>Fangirl</span></h1>
        </div>
        <div class="login-box p-5 shadow">
            <form action="" method="post">
                <div class="mb-2">
                    <label for="username" style="color: red;">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="mb-1">
                    <label for="password" style="color: red;">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div>
                    <button class="btn btn-success form-control mt-3" type="submit" name="loginbtn" style="color: red;">Login</button>
                </div>
            </form>
        </div>
        <div class="mt-3" style="width: 500px;">
            <?php
            if (isset($_POST['loginbtn'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $query = mysqli_query($conn, "SELECT * FROM users WHERE
                    username='$username'");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);

                if ($countdata > 0) {
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['login'] = true;
                        header('location: ../adminpanel');
                    } else {
            ?>
                        <div class="alert alert-dark" role="alert">
                            Password Salah!
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-dark" role="alert">
                        Akun Tidak Tersedia
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>

</html>