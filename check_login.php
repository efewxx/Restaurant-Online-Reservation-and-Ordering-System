<?php
session_start();

// Eğer session içinde user_id yoksa, kullanıcı giriş yapmamış demektir
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>