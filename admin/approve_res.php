<?php
include '../config/db.php';
/** @var mysqli $conn */
include '../check_login.php';

// Güvenlik: Sadece adminler işlem yapabilir
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // SQL'i değiştirmeden sadece veriyi güncelliyoruz
    $sql = "UPDATE reservation SET status = 'approved' WHERE reservation_id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        // İşlem bitince listeye geri dön
        header("Location: view_reservations.php?status=success");
    } else {
        echo "Hata oluştu: " . mysqli_error($conn);
    }
}
?>