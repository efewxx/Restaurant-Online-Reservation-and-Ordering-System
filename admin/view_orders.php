<?php
session_start();
include __DIR__ . '/../config/db.php';

// Güvenlik kontrolü
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Siparişleri, kullanıcı isimleri ve ürün isimleriyle beraber çekelim
$sql = "SELECT o.order_id, u.user_name, m.product_name, o.order_date 
        FROM orders o 
        JOIN users u ON o.user_id = u.user_id 
        JOIN menu m ON o.product_id = m.product_id 
        ORDER BY o.order_date DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gelen Siparişler - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Gelen Siparişler</h2>
    <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
        <tr style="background-color: #f2f2f2;">
            <th>Sipariş ID</th>
            <th>Müşteri Adı</th>
            <th>Ürün</th>
            <th>Tarih</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>#<?php echo $row['order_id']; ?></td>
            <td><?php echo $row['user_name']; ?></td>
            <td><?php echo $row['product_name']; ?></td>
            <td><?php echo $row['order_date']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="dashboard.php">← Dashboard'a Dön</a>
</body>
</html>