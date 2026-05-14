<?php
session_start();
include __DIR__ . '/../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// ÜRÜN SİLME İŞLEMİ
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM menu WHERE product_id = $id";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: manage_products.php?msg=deleted");
    }
}

// TÜM ÜRÜNLERİ ÇEK
$sql = "SELECT m.*, c.category_name FROM menu m 
        JOIN categories c ON m.category_id = c.category_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Menü Yönetimi | Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-navbar">
        <h2>Restoran Yönetimi</h2>
        <div class="nav-links">
            <a href="dashboard.php">← Dashboard</a>
            <a href="../logout.php" style="color: #ff6b6b;">Çıkış Yap</a>
        </div>
    </div>

    <div class="admin-container">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1>📋 Ürün Listesi</h1>
                <p>Menüdeki tüm ürünleri buradan kontrol edebilirsin.</p>
            </div>
            <a href="add_product.php" class="btn btn-add">+ Yeni Ürün Ekle</a>
        </header>

        <table>
            <thead>
                <tr>
                    <th>Ürün Adı</th>
                    <th>Fiyat</th>
                    <th>Kategori</th>
                    <th style="text-align: center;">İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><strong><?php echo $row['product_name']; ?></strong></td>
                    <td><?php echo $row['Price']; ?> TL</td>
                    <td><span style="background: #eee; padding: 4px 10px; border-radius: 20px; font-size: 12px;"><?php echo $row['category_name']; ?></span></td>
                    <td style="text-align: center;">
                        <a href="manage_products.php?delete_id=<?php echo $row['product_id']; ?>" 
                           class="btn btn-delete" 
                           onclick="return confirm('Bu ürünü silmek istediğine emin misin?')">🗑️ Sil</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>