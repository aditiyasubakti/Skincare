<?php require "layout/header.php";
// Fungsi untuk membaca data dari file database
function readDataFromDB($filename)
{
    $data = file_get_contents($filename); // Membaca seluruh isi file
    $dataArray = unserialize($data); // Mengubah data menjadi array

    return $dataArray;
}

// Fungsi untuk menulis data ke file database
function writeDataToDB($filename, $dataArray)
{
    $data = serialize($dataArray); // Mengubah array menjadi data serial
    file_put_contents($filename, $data); // Menulis data ke file
}

if (isset($_POST['upload'])) {
    $nameba = $_POST['namaB'];
    $des = $_POST['desB'];
    $harga = $_POST['hargaB'];
    $gambarname = $_FILES['gambarB']['name'];
    $tmp = $_FILES['gambarB']['tmp_name'];
    $tipe = $_FILES['gambarB']['type'];
    $folder = "img/produc/";
    $id = base64_encode(rand());
    $upload = move_uploaded_file($tmp, $folder . $gambarname);
    if ($upload) {
        // Nama file database
        $filename = 'database/produc/produc.txt';

        // Membaca data dari file database (jika ada)
        $database = [];
        if (file_exists($filename)) {
            $database = readDataFromDB($filename);
        }

        // Melakukan operasi database
        // Misalnya, menambahkan data baru
        $newData = [
            'id' => $id,
            'namab' => $nameba,
            'des' => $des,
            'harga' => $harga,
            'gambar' => $gambarname
        ];

        $database[] = $newData;

        // Menulis data ke file database
        writeDataToDB($filename, $database);
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Successfully Updated');
        window.location.href='dashboard.php';
        </script>");
    }
}
?>
<!-- Form Tambah Data -->
<form method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
    <h5>Tambah Data</h5>
    <div class="form-group">
        <label for="nama">Nama Barang:</label>
        <input type="text" class="form-control" id="nama" name="namaB">
    </div>
    <div class="form-group">
        <label for="nama">Deskripsi Barang:</label>
        <textarea name="desB" id="deskripsi" class="form-control" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <label for="harga">Harga Barang:</label>
        <input type="text" class="form-control" id="harga" name="hargaB">
    </div>
    <div class="form-group">
        <label for="gambar">Gambar Barang:</label>
        <input type="file" class="form-control-file" id="gambar" name="gambarB" onchange="previewImage(event)">
        <img id="preview" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
    </div>
    <button type="submit" name="upload" class="btn btn-primary">Tambah</button>
</form>
<?php require "layout/footer.php" ?>