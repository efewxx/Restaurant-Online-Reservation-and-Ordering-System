<?php
session_start();
// Güvenlik: Admin değilse login'e at (Efe ile konuşacağın kısım)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Şimdilik test için burayı yorum satırı yapabilirsin ama normalde aktif olmalı
    // header("Location: ../login.php"); 
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli | Restoran</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div class="admin-navbar">
        <h2>Restoran Yönetimi</h2>
        <div class="nav-links">
            <a href="../index.php" target="_blank">Siteyi Gör</a>
            <a href="../logout.php" style="color: #ff6b6b;">Çıkış Yap</a>
        </div>
    </div>

    <div class="admin-container">
        <header style="margin-bottom: 40px;">
            <h1>Hoş geldin, Admin!</h1>
            <p style="color: #666;">Restoranının verilerini buradan kolayca yönetebilirsin.</p>
        </header>

        <div class="dashboard-grid">
            
            <div class="admin-card">
                <div style="font-size: 40px; margin-bottom: 10px;">🍔</div>
                <h3>Ürün Ekle</h3>
                <p>Menüye yeni lezzetler dahil et.</p><br>
                <a href="add_product.php" class="btn btn-primary">Hemen Ekle</a>
            </div>

            <div class="admin-card">
                <div style="font-size: 40px; margin-bottom: 10px;">📋</div>
                <h3>Ürünleri Yönet</h3>
                <p>Fiyatları güncelle veya ürün sil.</p><br>
                <a href="manage_products.php" class="btn btn-primary">Listeyi Gör</a>
            </div>

            <div class="admin-card">
                <div style="font-size: 40px; margin-bottom: 10px;">📅</div>
                <h3>Rezervasyonlar</h3>
                <p>Müşteri randevularını takip et.</p><br>
                <a href="view_reservations.php" class="btn btn-primary">Görüntüle</a>
            </div>

            <div class="admin-card">
                <div style="font-size: 40px; margin-bottom: 10px;">🛒</div>
                <h3>Siparişler</h3>
                <p>Gelen siparişlerin durumuna bak.</p><br>
                <a href="view_orders.php" class="btn btn-primary">Siparişleri Gör</a>
            </div>

        </div>
    </div>

</body>
</html>