<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    
    // header("Location: ../login.php"); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Restaurant</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div class="admin-navbar">
        <h2>Restaurant Management</h2>
        <div class="nav-links">
            <a href="../index.php" target="_blank">View Site</a>
            <a href="../logout.php" style="color: #ff6b6b;">Logout</a>
        </div>
    </div>

    <div class="admin-container">
        <header style="margin-bottom: 40px;">
            <h1>Welcome, Admin!</h1>
            <p style="color: #666;">You can easily manage your restaurant's data from here.</p>
        </header>

        <div class="dashboard-grid">
            
            <div class="admin-card">
                <div style="font-size: 40px; margin-bottom: 10px;">🍔</div>
                <h3>Add Product</h3>
                <p>Add new items to the menu.</p><br>
                <a href="add_product.php" class="btn btn-primary">Add Now</a>
            </div>

            <div class="admin-card">
                <div style="font-size: 40px; margin-bottom: 10px;">📋</div>
                <h3>Manage Products</h3>
                <p>Update prices or delete products.</p><br>
                <a href="manage_products.php" class="btn btn-primary">View List</a>
            </div>

            <div class="admin-card">
                <div style="font-size: 40px; margin-bottom: 10px;">📅</div>
                <h3>Reservations</h3>
                <p>Track customer reservations.</p><br>
                <a href="view_reservations.php" class="btn btn-primary">View</a>
            </div>

            <div class="admin-card">
                <div style="font-size: 40px; margin-bottom: 10px;">🛒</div>
                <h3>Orders</h3>
                <p>Check the status of incoming orders.</p><br>
                <a href="view_orders.php" class="btn btn-primary">View Orders</a>
            </div>

        </div>
    </div>

</body>
</html>