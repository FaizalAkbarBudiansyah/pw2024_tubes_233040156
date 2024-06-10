<?php
require "koneksi.php";

$nama = htmlspecialchars($_GET['nama']);
$queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama='$nama'");
$produk = mysqli_fetch_array($queryProduk);

$queryArtistTerkait = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]' LIMIT 4");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kpop Fans | Artist Detail</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid py-5 warna4">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <img src="image/<?php echo $produk['foto']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $produk['nama']; ?></h1>
                    <p class="fs-5">
                        Dari <?php echo $produk['agensi']; ?>
                    </p>

                    <p class="fs-5">
                        <?php echo $produk['detail']; ?>
                    </p>

                    <p class="fs-5">
                        Fandom : <?php echo $produk['fandom']; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- artist terkait -->
    <div class="container-fluid py-5" style="background-color: red;">
        <div class="container">
            <h2 class="text-center mb-5" style="color: black;">Artist Terkait</h2>

            <div class="row">
                <?php while ($data = mysqli_fetch_array($queryArtistTerkait)) { ?>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="artist-detail.php?nama=<?php echo $data['nama']; ?>">
                            <img src="image/<?php echo $data['foto']; ?>" class="img-fluid img-thumbnail" style="height: 100%; width: 100%; object-fit: cover; object-position: center;" alt="">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php"; ?>

    <script src="https://kit.fontawesome.com/69feecb069.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>