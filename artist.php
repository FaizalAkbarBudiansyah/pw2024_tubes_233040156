<?php
require "koneksi.php";

$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahArtist = mysqli_num_rows($query);

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");

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
    <title>Kpop Fans | Artist</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- banner -->
    <div class="container-fluid banner-artist d-flex align-items-center">
        <div class="container">
            <h1 class="text text-center">Korean Pop</h1>
        </div>
    </div>

    <!-- body -->
    <div class="full-body warna1">
        <div class="container py-5" style="background-color: black;">
            <form class="d-flex mt-3 mb-5" role="search" method="post" action="">
                <input class="form-control me-2" type="text" name="keyword" placeholder="Search" autocomplete="off" id="keyword">
                <button class="btn" style="background-color: red;" type="submit" name="cari" id="tombol-cari">Search</button>
            </form>
            <div class="row text-center">
                <div class="col-lg-3 mb-5">
                    <h3 style="color: red;">Kategori</h3>
                    <ul class="list-group">
                        <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                            <a class="no-decoration" href="artist.php?kategori=<?php echo $kategori['nama'] ?>">
                                <li class="list-group-item" style="background-color: #a0a0a0;"><?php echo $kategori['nama'] ?></li>
                            </a>
                        <?php } ?>
                    </ul>
                </div>
                <div class=" container-fluid col-lg-9" id="artist">
                    <div class="container">
                        <h3 class="text-center" style="color: red;">Artist</h3>
                        <div class="row">
                            <?php
                            if ($countData < 1) {
                            ?>
                                <h4 class="text-center my-5" style="color: red;">Kategori yang anda masukan tidak terdaftar</h4>
                            <?php
                            }
                            ?>
                            <?php while ($produk = mysqli_fetch_array($queryProduk)) { ?>
                                <div class="col-md-4 mb-4"> >
                                    <div class="card border-3 border-danger text-center" style="background-color: #404040;">
                                        <div class="image-box">
                                            <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-5 warna1" style="color: red;"><?php echo $produk['nama']; ?></h5>
                                            <p class="card-p fw-bold text">Dari <?php echo $produk['agensi']; ?></p>
                                            <p class="card-p fw-bold text">Fandom "<?php echo $produk['fandom']; ?>"</p>
                                            <a href="artist-detail.php?nama=<?php echo $produk['nama']; ?>" class="btn" style="background-color: red; color: black;"> Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php"; ?>

    <script src="https://kit.fontawesome.com/69feecb069.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- <script src="js/script.js"></script> -->

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

            xhr.open("GET", "ajax/index2.php?keyword=" + keyword.value, true);
            xhr.send();
        });
    </script>

</body>

</html>