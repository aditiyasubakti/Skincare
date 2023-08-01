<?php
require "layout/header.php";
function readDataFromDB($filename)
{
    $data = file_get_contents($filename); // Membaca seluruh isi file
    $dataArray = unserialize($data); // Mengubah data menjadi array

    return $dataArray;
}
$pd = 'database/beli/produc.txt';
$database1 = [];
if (file_exists($pd)) {
    $database1 = readDataFromDB($pd);
}
?>
<!-- content -->
<div class="container">
    <h2>Tabel Barang</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Pembeli</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($database1 as $beli) { ?>
                <tr>
                    <td><img src="img/produc/<?= $beli['gambar'] ?>" alt="Gambar Barang 1" class="barang-img"></td>
                    <td><?= $beli['namap'] ?></td>
                    <td><?= $beli['namab'] ?></td>
                    <td><?= $beli['hargab'] ?></td>
                    <td><span class="badge badge-success">Terjual</span></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php require "layout/footer.php" ?>