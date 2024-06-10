<?php
require '../koneksi.php';
$keyword = $_GET["keyword"];

$queryProduk = "SELECT u.*, k.nama AS nama_kategori
            FROM produk u
            JOIN kategori k ON u.kategori_id = k.id
            WHERE u.nama LIKE '%$keyword%'";

$result = mysqli_query($conn, $queryProduk);

$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahProduk = mysqli_num_rows($query);
?>

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
            while ($data = mysqli_fetch_array($result)) {
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