<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant System</title>
    <link rel="stylesheet" href="css/style.css"> </head>
<body>
<nav style="background: #333; color: #fff; padding: 15px;">
    <a href="index.php" style="color:white; margin-right:20px;">Menü</a>
    <a href="reservation.php" style="color:white; margin-right:20px;">Rezervasyon Yap</a>
    <a href="order_summary.php" style="color:white; margin-right:20px;">Siparişlerim</a>
    
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
    <a href="admin/dashboard.php" style="color:orange;">Admin Paneli</a>
<?php endif; ?>
    
    <a href="logout.php" style="color:red; float:right;">Çıkış Yap</a>
    <span style="float:right; margin-right:15px;">Hoş geldin, <?php echo $_SESSION['name']; ?></span>
</nav>