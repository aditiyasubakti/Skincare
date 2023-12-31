<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
} else {
    function readDataFromDB($filename)
    {
        $data = file_get_contents($filename); // Membaca seluruh isi file
        $dataArray = unserialize($data); // Mengubah data menjadi array

        return $dataArray;
    }

    function saveDataToDB($filename, $data)
    {
        $serializedData = serialize($data); // Mengubah array menjadi data serialisasi
        file_put_contents($filename, $serializedData); // Menyimpan data ke dalam file
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $filename = 'database/beli/produc.txt';
        if (file_exists($filename)) {
            $database = readDataFromDB($filename);
        } else {
            $database = [];
        }

        // Kriteria pencarian untuk menemukan data yang akan dihapus
        $namaCari = $id;

        // Menemukan data berdasarkan kriteria pencarian
        $keyToDelete = null;
        foreach ($database as $key => $data) {
            if ($data['id'] === $namaCari) {
                $keyToDelete = $key;
                break;
            }
        }

        // Menghapus data yang ditemukan dari database
        if ($keyToDelete !== null) {
            unset($database[$keyToDelete]); // Menghapus data dari array
            $database = array_values($database); // Mengatur ulang indeks array
            saveDataToDB($filename, $database); // Menyimpan data yang telah dihapus ke dalam file
            header("Location: ./");
        } else {
            echo "Data dengan nama '$namaCari' tidak ditemukan.";
        }
    }
}
