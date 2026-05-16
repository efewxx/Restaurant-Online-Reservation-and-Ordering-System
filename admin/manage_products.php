<?php
session_start();
include __DIR__ . '/../config/db.php';
/** @var mysqli $conn */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// ÜRÜN SİLME İŞLEMİ (Güvenli ID filtresi eklendi)
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $delete_sql = "DELETE FROM menu WHERE product_id = $id";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: manage_products.php?msg=deleted");
        exit();
    }
}

// TÜM ÜRÜNLERİ ÇEK
$sql = "SELECT m.*, c.category_name FROM menu m 
        JOIN categories c ON m.category_id = c.category_id
        ORDER BY m.product_id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu Management | Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* CSS dosyanıza ek yük getirmemesi için butonların yan yana şık durmasını sağlıyoruz */
        .action-links { display: flex; justify-content: center; gap: 8px; }
        .btn-update { background-color: #3498db; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: 500; }
        .btn-update:hover { background-color: #2980b9; }
    </style>
</head>
<body>
    <div class="admin-navbar">
        <h2>Restaurant Management</h2>
        <div class="nav-links">
            <a href="dashboard.php">← Dashboard</a>
            <a href="../logout.php" style="color: #ff6b6b;">Logout</a>
        </div>
    </div>

    <div class="admin-container">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1>📋 Product List</h1>
                <p>You can manage and control all menu items from here.</p>
            </div>
            <a href="add_product.php" class="btn btn-add" style="background-color: #2ecc71; color: white; padding: 10px 15px; border-radius: 6px; text-decoration: none; font-weight: 600;">+ Add New Product</a>
        </header>

        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['product_name']); ?></strong></td>
                        <td style="color: #2e7d32; font-weight: 600;"><?php echo $row['Price']; ?> TL</td>
                        <td><span style="background: #eee; padding: 4px 10px; border-radius: 20px; font-size: 12px;"><?php echo htmlspecialchars($row['category_name']); ?></span></td>
                        <td style="text-align: center;">
                            <div class="action-links">
                                <a href="update_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-update">✏️ Edit</a>
                                
                                <a href="manage_products.php?delete_id=<?php echo $row['product_id']; ?>" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('Are you sure you want to delete this product?')">🗑️ Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: #999;">No products found in the menu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>