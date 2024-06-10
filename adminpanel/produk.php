<?php
require "session.php";
require "../koneksi.php";

$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahProduk = mysqli_num_rows($query);

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIZKLMNOPQRSTUVWXYZ';
    $characterslength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $characterslength - 1)];
    }
    return $randomString;
}

// cari artist dari nama artist/kunci
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
    $countData = mysqli_num_rows($queryProduk);
}
// cari artist dari kategori
else if (isset($_GET['kategori'])) {
    $queryGetKategoriId = mysqli_query($conn, "SELECT id FROM kategori WHERE nama LIKE '$_GET[kategori]'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);

    $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='$kategoriId[id]'");
    $countData = mysqli_num_rows($queryProduk);
}
// cari artist default
else {
    $queryProduk = mysqli_query($conn, "SELECT * FROM produk");

    $countData = mysqli_num_rows($queryProduk);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fa-solid fa-house"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Produk
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../cetak.php" target="_blank" style="text-decoration: none; color: black;"> <i class="fa-solid fa-print"></i> Cetak</a>
                </li>
            </ol>
        </nav>

        <!-- Tambah Produk -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Group</label>
                    <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" required>
                </div>

                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih satu</option>
                        <?php
                        while ($data = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?php echo $data['id'] ?>"><?php echo $data['nama'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="agensi">Agensi</label>
                    <input type="text" class="form-control" name="agensi" required>
                </div>

                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="5" class="form-control"></textarea>
                </div>

                <div>
                    <label for="fandom">Fandom</label>
                    <input type="text" class="form-control" name="fandom" required>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>

            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $agensi = htmlspecialchars($_POST['agensi']);
                $detail = htmlspecialchars($_POST['detail']);
                $fandom = htmlspecialchars($_POST['fandom']);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;

                if ($nama == '' || $kategori == '' || $agensi == '') {
            ?>
                    <div class="alert alert-warning mt3" role="alert">
                        Nama, Kategori dan Group wajib diisi
                    </div>
                    <?php
                } else {
                    if ($nama_file != '') {
                        if ($image_size > 500000) {
                    ?>

                            <div class="alert alert-warning mt3" role="alert">
                                File tidak boleh lebih dari 500kb
                            </div>

                            <?php
                        } else {
                            if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                            ?>

                                <div class="alert alert-warning mt3" role="alert">
                                    File wajib bertipe jpg, png atau gif
                                </div>

                        <?php
                            } else {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                            }
                        }
                    }
                    // query insert to produk table
                    $queryTambah = mysqli_query($conn, "INSERT INTO produk (kategori_id, nama, agensi, foto, detail, fandom) VALUES ('$kategori', '$nama', '$agensi', '$new_name', '$detail', '$fandom')");

                    if ($queryTambah) {
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Produk berhasil tersimpan
                        </div>

                        <meta http-equiv="refresh" content="0; url=produk.php" />
            <?php
                    } else {
                        echo mysqli_error($conn);
                    }
                }
            }
            ?>

        </div>

        <div class="mt-3">
            <h2>List Produk</h2>
            <form class="d-flex mt-3 mb-5" role="search" action="produk-detail.php" method="get">
                <input class="form-control me-2" type="text" name="keyword" placeholder="Search" aria-label="Search" autocomplete="off" id="keyword">
                <button class="btn" style="background-color: red;" type="submit" name="cari" id="tombol-cari">Search</button>
            </form>
            <div id="container">
                <div class="table-responsive mt-5 mb-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Group</th>
                                <th>Fandom</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($jumlahProduk == 0) {
                            ?>
                                <tr>
                                    <td colspan=6 class="text-center">Data Produk tidak tersedia</td>
                                </tr>
                                <?php
                            } else {
                                $jumlah = 1;
                                while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo $jumlah++; ?></td>
                                        <td><?php echo $data['nama']; ?></td>
                                        <td><?php echo $data['nama_kategori']; ?></td>
                                        <td><?php echo $data['agensi']; ?></td>
                                        <td><?php echo $data['fandom']; ?></td>
                                        <td>
                                            <a href="produk-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/69feecb069.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        var keyword = document.getElementById("keyword");
        var tombolCari = document.getElementById("tombol-cari");
        var container = document.getElementById("container");

        keyword.addEventListener("keyup", function() {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    container.innerHTML = xhr.responseText;
                }
            };

            xhr.open("GET", "../ajax/ajaxproduk.php?keyword=" + keyword.value, true);
            xhr.send();
        });
    </script>

</body>

</html>