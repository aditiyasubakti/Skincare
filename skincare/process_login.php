<?php
session_start();
error_reporting(0);
if (isset($_POST['Login'])) {
    $username = $_POST['UsernameLogin'];
    $password = $_POST['PasswordLogin'];
    $file_user = 'database/user/user.txt';
    $line = file($file_user, FILE_IGNORE_NEW_LINES);
    if (in_array(trim($username), $line)) {
        $user = "database/user/password/" . $username . ".txt";
        $bio = "database/user/biodata/" . $username . ".txt";
        $content = file_get_contents($bio);
        $data = explode("\n", $content);
        $userData = [];
        foreach ($data as $line) {
            $lineData = explode(": ", $line);
            $key = $lineData[0];
            $value = $lineData[1];
            $userData[$key] = $value;
        }
        $cek = fopen($user, 'r');
        $pwd = fread($cek, filesize($user));
        fclose($cek);
        if ($pwd == $password) {
            $_SESSION['login'] = true;
            $_SESSION['nama'] = $userData['Nama'];
            $_SESSION['username'] = $username;
            echo ("<script LANGUAGE='JavaScript'>
        window.alert('Success Login');
        window.location.href='dashboard.php';
        </script>");
        } else {
            echo ("<script LANGUAGE='JavaScript'>
        window.alert('Password failed');
        window.location.href='login.html';
        </script>");
        }
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    window.alert('login failed');
    window.location.href='login.html';
    </script>");
    }
} else {
    header("Location: login.html");
}
