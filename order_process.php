<?php
session_start();
if (isset($_GET['id'])) {
    $p_id = $_GET['id'];
    
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    $_SESSION['cart'][] = $p_id;
    
    echo "<script>alert('Product added to cart!'); window.location.href='index.php';</script>";
}
?>