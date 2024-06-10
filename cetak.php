<?php
require "adminpanel/session.php";
require "koneksi.php";
$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Artist</title>
</head>
<body>
    <h1>List Artist</h1>
    <table border="1" cellpadding="10" cellspacing"0" class="table">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Group</th>
                <th>Fandom</th>
            </tr>';

$i = 1;
foreach ($query as $data) {
    $html .= '<tr>
                <td>' . $i++ . '</td>
                <td>' . $data["nama"] . '</td>
                <td>' . $data["nama_kategori"] . '</td>
                <td>' . $data["agensi"] . '</td>
                <td>' . $data["fandom"] . '</td>
            </tr>';
}

$html .= '</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('List-Artist.pdf', 'I');
$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->Output();
