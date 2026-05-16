<?php
session_start();
include __DIR__ . '/../config/db.php';
/** @var mysqli $conn */

// Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// --- ORDER STATUS UPDATE ENGINE ---
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $action = mysqli_real_escape_string($conn, $_GET['action']);
    
    $yeni_durum = '';
    if ($action === 'hazirla') $yeni_durum = 'Hazırlanıyor';
    if ($action === 'yola_cikar') $yeni_durum = 'Yolda';
    if ($action === 'teslim_et') $yeni_durum = 'Teslim Edildi';
    
    if (!empty($yeni_durum)) {
        $update_sql = "UPDATE orders SET order_status = '$yeni_durum' WHERE order_id = '$id'";
        mysqli_query($conn, $update_sql);
        header("Location: view_orders.php?status=updated");
        exit();
    }
}

// --- DATABASE SQL QUERY ---
// u.name sütunu tam olarak Efe'nin veritabanıyla eşleştirildi!
$sql = "SELECT o.order_id, u.name AS customer_name, o.total_price, o.order_status,
               GROUP_CONCAT(CONCAT(oi.quantity, 'x ', m.product_name) SEPARATOR ', ') AS urunler
        FROM orders o 
        JOIN users u ON o.user_id = u.user_id 
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN menu m ON oi.product_id = m.product_id 
        GROUP BY o.order_id
        ORDER BY o.order_id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Incoming Orders - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif; background-color: #f4f6f9;
            margin: 0; padding: 40px; color: #333;
        }
        .container { max-width: 1200px; margin: 0 auto; }
        h2 { color: #2c3e50; font-weight: 600; margin-bottom: 30px; }
        
        .table-responsive {
            background: #fff; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background-color: #2c3e50; color: #fff; padding: 15px 20px; font-weight: 500; }
        td { padding: 15px 20px; border-bottom: 1px solid #eee; font-size: 0.95rem; vertical-align: middle; }
        tr:hover { background-color: #f8f9fa; }
        
        /* Status Badges */
        .status-badge {
            padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;
            display: inline-block; text-align: center; min-width: 110px;
        }
        .status-pending { background-color: #ffeaa7; color: #d63031; } 
        .status-shipping { background-color: #81ecec; color: #0984e3; } 
        .status-completed { background-color: #55efc4; color: #00b894; } 

        /* Action Buttons */
        .action-btn {
            padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 500;
            text-decoration: none; color: white; display: inline-block; margin-right: 5px;
            transition: 0.2s;
        }
        .btn-prep { background-color: #e67e22; }
        .btn-prep:hover { background-color: #d35400; }
        .btn-ship { background-color: #3498db; }
        .btn-ship:hover { background-color: #2980b9; }
        .btn-done { background-color: #2ecc71; }
        .btn-done:hover { background-color: #27ae60; }

        .back-link {
            display: inline-block; margin-top: 25px; color: #2c3e50;
            text-decoration: none; font-weight: 500; transition: 0.2s;
        }
        .back-link:hover { color: #ff9800; }
    </style>
</head>
<body>

<div class="container">
    <h2>🍽️ Order Management</h2>
    
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Items (Products)</th>
                    <th>Total Price</th>
                    <th>Current Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): 
                        // Translation and CSS selection based on DB value
                        $status_class = 'status-pending';
                        $display_status = 'Preparing';
                        
                        if ($row['order_status'] === 'Yolda') {
                            $status_class = 'status-shipping';
                            $display_status = 'On the Way';
                        } elseif ($row['order_status'] === 'Teslim Edildi') {
                            $status_class = 'status-completed';
                            $display_status = 'Delivered';
                        }
                    ?>
                    <tr>
                        <td><strong>#<?php echo $row['order_id']; ?></strong></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['urunler']); ?></td>
                        <td style="color: #2e7d32; font-weight: 600;"><?php echo $row['total_price']; ?> TL</td>
                        <td>
                            <span class="status-badge <?php echo $status_class; ?>">
                                <?php echo $display_status; ?>
                            </span>
                        </td>
                        <td>
                            <a href="view_orders.php?action=hazirla&id=<?php echo $row['order_id']; ?>" class="action-btn btn-prep" title="Set to Preparing">Prepare</a>
                            <a href="view_orders.php?action=yola_cikar&id=<?php echo $row['order_id']; ?>" class="action-btn btn-ship" title="Set to On the Way">Ship</a>
                            <a href="view_orders.php?action=teslim_et&id=<?php echo $row['order_id']; ?>" class="action-btn btn-done" title="Set to Delivered">Deliver</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #999; padding: 30px;">No incoming orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>