<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.html");
}
session_destroy();
echo ("<script LANGUAGE='JavaScript'>
        window.alert('Success Logout');
        window.location.href='./';
        </script>");
