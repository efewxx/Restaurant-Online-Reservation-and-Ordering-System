<?php
session_start();
include __DIR__ . '/../config/db.php';
/** @var mysqli $conn */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


if (isset($_POST['submit_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $price = $_POST['p_price'];
    $desc = mysqli_real_escape_string($conn, $_POST['p_desc']);
    $category = $_POST['p_category'];
    $user_id = $_SESSION['user_id']; 

    
    $image_name = "default-food.png";

    
    if (isset($_FILES['p_image']) && $_FILES['p_image']['error'] == 0) {
        $file_tmp = $_FILES['p_image']['tmp_name']; 
        $original_name = $_FILES['p_image']['name'];
        $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        
        
        $allowed_extensions = array("jpg", "jpeg", "png", "webp");

        if (in_array($file_ext, $allowed_extensions)) {
            $image_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $original_name);
            
            $target_dir = __DIR__ . '/../images/';
            $target_file = $target_dir . $image_name;

            if (!move_uploaded_file($file_tmp, $target_file)) {
                $image_name = "default-food.png"; 
            }
        }
    }

    
    $sql = "INSERT INTO menu (product_name, Price, description, category_id, user_id, image_url) 
            VALUES ('$name', '$price', '$desc', '$category', '$user_id', '$image_name')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product and image added succesfully! 🍔🚀'); window.location.href='add_product.php';</script>";
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add new product | Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-navbar">
        <h2>Restaurant Management</h2>
        <div class="nav-links">
            <a href="dashboard.php">← Dashboard</a>
        </div>
    </div>

    <div class="admin-container">
        <div class="admin-form">
            <div style="font-size: 40px; text-align: center; margin-bottom: 10px;">👨‍🍳</div>
            <h2 style="text-align: center; margin-bottom: 30px;">Add A New Item</h2>
            
            <form method="POST" enctype="multipart/form-data">
                <label>Food Name</label>
                <input type="text" name="p_name" placeholder="Ex: Mix Pizza" required>
                
                <label>Price (TL)</label>
                <input type="number" step="0.01" name="p_price" placeholder="0.00" required>
                
                <label>Description</label>
                <textarea name="p_desc" rows="4" placeholder="Ingredients and serving information..."></textarea>
                
                <label>Category</label>
                <select name="p_category" required>
                    <option value="1">Main Dishes</option>
                    <option value="2">Drinks</option>
                    <option value="3">Desserts</option>
                </select>

                <label style="margin-top: 15px; display: block;">Product Image</label>
                <input type="file" name="p_image" accept="image/*" style="border: 1px dashed #ccc; padding: 10px; background: #fff; cursor: pointer;">
                <small style="color: #666; display: block; margin-bottom: 15px;">Extensions: JPG, JPEG, PNG, WEBP</small>
                
                <button type="submit" name="submit_product" class="btn btn-primary" style="width: 100%; margin-top: 10px;">✨ Add product to menu</button>
            </form>
        </div>
    </div>
</body>
</html>