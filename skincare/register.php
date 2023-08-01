<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['NamaRegister'];
    $email = $_POST['EmailRegister'];
    $username = $_POST['UsernameRegister'];
    $password1 = $_POST['PasswordRegister1'];
    $password2 = $_POST['PasswordRegister2'];
    $jenisKelamin = $_POST['GenderRegister'];
    $nomorHP = $_POST['PhoneRegister'];
    if ($password1 != $password2) {
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Password tidak sama');
        window.location.href='login.php';
        </script>");
    } else {
        // Format data yang akan disimpan
        $data = "Nama: $nama\nEmail: $email\nUsername: $username\nPassword: $password1\nJenis Kelamin: $jenisKelamin\nNomor HP: $nomorHP\n\n";

        // Buka file teks untuk ditulis (mode 'a' untuk append)
        $pwd_file = "database/user/password/" . $username . ".txt";
        //password
        $file = fopen($pwd_file, 'a');
        fwrite($file, $password1);
        fclose($file);
        //semua user
        $file = fopen('database/user/user.txt', 'a');
        fwrite($file, $username . "\n");
        fclose($file);
        //biodata 
        $bio = "database/user/biodata/" . $username . ".txt";
        $file = fopen($bio, 'a');
        fwrite($file, $data);
        fclose($file);

        // Redirect ke halaman berhasil mendaftar
        echo ("<script LANGUAGE='JavaScript'>
    window.alert('Register Success');
    window.location.href='login.html';
    </script>");
        exit();
    }
}
