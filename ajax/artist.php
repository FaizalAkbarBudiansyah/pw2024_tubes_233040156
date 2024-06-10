<?php
require '../koneksi.php';
$keyword = $_GET["keyword"];


$queryArtist = "SELECT u.*, k.nama AS nama_kategori
                FROM universitas u
                JOIN kategori k ON u.kategori_id = k.id
                WHERE u.nama LIKE '%$keyword%'";

$result = mysqli_query($conn, $queryArtist);

?>
<link rel="stylesheet" href="../css/style.css">

<div class=" container-fluid col-lg-9" id="artist">
    <div class="container">
        <h3 class="text-center" style="color: red;">Artist</h3>
        <div class="row">
            <?php while ($data = mysqli_fetch_array($result)) { ?>
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