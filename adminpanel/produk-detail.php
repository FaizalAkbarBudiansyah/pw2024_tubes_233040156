<?php
require "session.php";
require "../koneksi.php";

if (isset($_GET['p'])) {
    $id = $_GET['p'];

    $query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");
} else {
    // Jika parameter 'p' tidak ada, Anda bisa mengarahkan ulang atau menampilkan pesan error
    echo "ID produk tidak ditemukan.";
    exit;
}
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIZKLMNOPQRSTUVWXYZ';
    $characterslength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $characterslength - 1)];
    }
}

$query1 = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahArtist = mysqli_num_rows($query1);

$queryKategori1 = mysqli_query($conn, "SELECT * FROM kategori");

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
    <title>Produk Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <h2>Detail Produk</h2>

        <div class="col-12 col-md-6 mb-5">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Group</label>
                    <input type="text" name="nama" value="<?php echo $data['nama']; ?>" id="nama" class="form-control" autocomplete="off" required>
                </div>

                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori']; ?></option>
                        <?php
                        while ($dataKategori = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?php echo $dataKategori['id'] ?>"><?php echo $dataKategori['nama'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="agensi">Agensi</label>
                    <input type="text" name="agensi" value="<?php echo $data['agensi']; ?>" id="agensi" class="form-control" autocomplete="off" required>
                </div>

                <div>
                    <label for="currentFoto" style="padding-bottom: 5px;">Foto Produk Sekarang</label><br>
                    <img src="../image/<?php echo $data['foto'] ?>" alt="">
                </div>

                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="5" class="form-control">
                    <?php echo $data['detail'] ?>
                    </textarea>
                </div>

                <div>
                    <label for="fandom">Fandom</label>
                    <input type="text" name="fandom" value="<?php echo $data['fandom']; ?>" id="fandom" class="form-control" autocomplete="off" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
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
                        Nama, Kategori dan Group wajib di isi
                    </div>

                    <?php
                } else {
                    $queryUpdate = mysqli_query($conn, "UPDATE produk SET kategori_id='$kategori', nama='$nama', agensi='$agensi', detail='$detail', fandom='$fandom' WHERE id=$id");
                    if ($queryUpdate) {
                    ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Produk Berhasil Diupdate
                        </div>
                        <meta http-equiv="refresh" content="2; url=produk.php" />
                        <?php
                    }

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

                                $queryUpdate = mysqli_query($conn, "UPDATE produk SET foto='$new_name' WHERE id='$id'");

                                if ($queryUpdate) {
                                ?>
                                    <div class="alert alert-primary mt-3" role="alert">
                                        Produk Berhasil Diupdate
                                    </div>

                                    <meta http-equiv="refresh" content="0; url=produk.php" />
                    <?php
                                }
                            }
                        }
                    }
                }
            }

            if (isset($_POST['delete'])) {
                $queryDelete = mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");

                if ($queryDelete) {
                    ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Produk Berhasil Dihapus
                    </div>
                    <meta http-equiv="refresh" content="2; url=produk.php" />
            <?php
                } else {
                    echo mysqli_error($conn);
                }
            }
            ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>