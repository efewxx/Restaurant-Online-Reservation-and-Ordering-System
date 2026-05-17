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
    
    
    $sql = "UPDATE reservation SET status = 'approved' WHERE reservation_id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        
        header("Location: view_reservations.php?status=success");
    } else {
        echo "An Error Has Occured: " . mysqli_error($conn);
    }
}
?>