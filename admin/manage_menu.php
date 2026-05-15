<?php 
include '../check_login.php'; // Giriş kontrolü
include '../config/db.php'; 

// Sadece admin girebilsin
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['add_product'])) {
    $p_name = $_POST['product_name'];
    $p_price = $_POST['price'];
    $p_desc = $_POST['description'];
    $cat_id = $_POST['category_id'];
    $u_id = $_SESSION['user_id']; // Giriş yapan adminin ID'si

    $sql = "INSERT INTO menu (product_name, Price, description, category_id, user_id) 
            VALUES ('$p_name', '$p_price', '$p_desc', '$cat_id', '$u_id')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Yeni ürün başarıyla menüye eklendi!'); window.location.href='manage_menu.php';</script>";
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Yönetimi</title>
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>
    <div style="max-width: 400px; margin: 50px auto; padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 8px;">
        <h2>Menüye Yeni Ürün Ekle</h2>
        <form method="POST">
            <input type="text" name="product_name" placeholder="Ürün Adı (Örn: Pizza)" required style="width:100%; padding:10px; margin:5px 0;"><br>
            <input type="number" step="0.01" name="price" placeholder="Fiyatı (Örn: 250)" required style="width:100%; padding:10px; margin:5px 0;"><br>
            <textarea name="description" placeholder="Ürün Açıklaması" style="width:100%; height:80px; margin:5px 0;"></textarea><br>
            
            <label>Kategori:</label>
            <select name="category_id" style="width:100%; padding:10px; margin:5px 0;">
                <option value="1">Main Courses (Ana Yemekler)</option>
                <option value="2">Drinks (İçecekler)</option>
                <option value="3">Desserts (Tatlılar)</option>
            </select><br><br>
            
            <input type="submit" name="add_product" value="Ürünü Menüye Kaydet" style="width:100%; padding:10px; background: green; color:white; border:none; cursor:pointer;">
        </form>
        <br>
        <a href="../index.php">← Ana Sayfaya Dön</a>
    </div>
</body>
</html>