<?php
session_start();
include __DIR__ . '/../config/db.php';
// GÜVENLİK: Admin değilse giriş sayfasına postala
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// FORM GÖNDERİLDİ Mİ?
if (isset($_POST['submit_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $price = $_POST['p_price'];
    $desc = mysqli_real_escape_string($conn, $_POST['p_desc']);
    $category = $_POST['p_category'];
    $user_id = $_SESSION['user_id']; // Giriş yapan adminin ID'si

    $sql = "INSERT INTO menu (product_name, Price, description, category_id, user_id) 
            VALUES ('$name', '$price', '$desc', '$category', '$user_id')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Ürün başarıyla eklendi!'); window.location.href='add_product.php';</script>";
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Ürün Ekle | Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-navbar">
        <h2>Restoran Yönetimi</h2>
        <div class="nav-links">
            <a href="dashboard.php">← Dashboard</a>
        </div>
    </div>

    <div class="admin-container">
        <div class="admin-form">
            <div style="font-size: 40px; text-align: center; margin-bottom: 10px;">👨‍🍳</div>
            <h2 style="text-align: center; margin-bottom: 30px;">Yeni Lezzet Ekle</h2>
            
            <form method="POST">
                <label>Yemek Adı</label>
                <input type="text" name="p_name" placeholder="Örn: Karışık Pizza" required>
                
                <label>Fiyat (TL)</label>
                <input type="number" step="0.01" name="p_price" placeholder="0.00" required>
                
                <label>Açıklama</label>
                <textarea name="p_desc" rows="4" placeholder="İçindekiler ve porsiyon bilgisi..."></textarea>
                
                <label>Kategori</label>
                <select name="p_category" required>
                    <option value="1">Ana Yemekler</option>
                    <option value="2">İçecekler</option>
                    <option value="3">Tatlılar</option>
                </select>
                
                <button type="submit" name="submit_product" class="btn btn-primary" style="width: 100%; margin-top: 10px;">✨ Ürünü Menüye Ekle</button>
            </form>
        </div>
    </div>
</body>
</html>