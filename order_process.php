<?php
session_start();
if (isset($_GET['id'])) {
    $p_id = $_GET['id'];
    
    // Eğer sepet (cart) yoksa oluştur, varsa içine ekle
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    $_SESSION['cart'][] = $p_id;
    
    echo "<script>alert('Ürün sepete eklendi!'); window.location.href='index.php';</script>";
}
?>