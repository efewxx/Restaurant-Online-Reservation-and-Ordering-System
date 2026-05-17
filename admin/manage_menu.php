<?php 
include '../check_login.php'; 
include '../config/db.php'; 


if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['add_product'])) {
    $p_name = $_POST['product_name'];
    $p_price = $_POST['price'];
    $p_desc = $_POST['description'];
    $cat_id = $_POST['category_id'];
    $u_id = $_SESSION['user_id']; 

    $sql = "INSERT INTO menu (product_name, Price, description, category_id, user_id) 
            VALUES ('$p_name', '$p_price', '$p_desc', '$cat_id', '$u_id')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('The new product has been successfully added to the menu!'); window.location.href='manage_menu.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>
    <div style="max-width: 400px; margin: 50px auto; padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 8px;">
        <h2>Add New Item to Menu</h2>
        <form method="POST">
            <input type="text" name="product_name" placeholder="Product Name (e.g., Pizza)" required style="width:100%; padding:10px; margin:5px 0;"><br>
            <input type="number" step="0.01" name="price" placeholder="Price (e.g., 250)" required style="width:100%; padding:10px; margin:5px 0;"><br>
            <textarea name="description" placeholder="Product Description" style="width:100%; height:80px; margin:5px 0;"></textarea><br>
            
            <label>Category:</label>
            <select name="category_id" style="width:100%; padding:10px; margin:5px 0;">
                <option value="1">Main Courses</option>
                <option value="2">Drinks</option>
                <option value="3">Desserts</option>
            </select><br><br>
            
            <input type="submit" name="add_product" value="Add Product to Menu" style="width:100%; padding:10px; background: green; color:white; border:none; cursor:pointer;">
        </form>
        <br>
        <a href="../index.php">← Return to Home Page</a>
    </div>
</body>
</html>