<?php
include '../config/db.php';
/** @var mysqli $conn */
include '../check_login.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Satırı tamamen siliyoruz
    $sql = "DELETE FROM reservation WHERE reservation_id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: view_reservations.php?status=deleted");
    } else {
        echo "Hata oluştu: " . mysqli_error($conn);
    }
}
?>