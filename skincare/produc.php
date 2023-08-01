<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.html");
} else {
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


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $namab = $_POST['namab'];
        $namap = $_POST['namap'];
        $username = $_POST['username'];
        $idproduc = $_POST['id'];
        $hargab = $_POST['hargab'];
        $gambar = $_POST['gambar'];
        $des = $_POST['des'];
        $count = $_POST['count'];
        $id = base64_encode(rand());
        // Nama file database
        $filename = 'database/beli/produc.txt';

        // Membaca data dari file database (jika ada)
        $database = [];
        if (file_exists($filename)) {
            $database = readDataFromDB($filename);
        }

        // Melakukan operasi database
        // Misalnya, menambahkan data baru
        $newData = [
            'id' => $id,
            'username' => $username,
            'namab' => $namab,
            'namap' => $namap,
            'idproduc' => $idproduc,
            'hargab' => $hargab,
            'gambar' => $gambar,
            'des' => $des,
            'count' => $count
        ];

        $database[] = $newData;

        // Menulis data ke file database
        writeDataToDB($filename, $database);
        header("Location:./");
    }
}
