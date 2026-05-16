<?php
session_start();
include __DIR__ . '/../config/db.php';
/** @var mysqli $conn */

// GÜVENLİK: Admin değilse giriş sayfasına postala
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// URL'den gelen bir ID var mı kontrol et
if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit();
}

$product_id = mysqli_real_escape_string($conn, $_GET['id']);

// GÜNCELLENECEK ÜRÜNÜN ESKİ VERİLERİNİ VERİTABANINDAN ÇEK
$sql_get = "SELECT * FROM menu WHERE product_id = '$product_id'";
$res_get = mysqli_query($conn, $sql_get);
$product = mysqli_fetch_assoc($res_get);

// Eğer böyle bir ürün yoksa listeye geri gönder
if (!$product) {
    header("Location: manage_products.php");
    exit();
}

// FORM POST EDİLDİ Mİ? (GÜNCELLEME MOTORU)
if (isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $price = $_POST['p_price'];
    $desc = mysqli_real_escape_string($conn, $_POST['p_desc']);
    $category = $_POST['p_category'];

    // Mevcut görsel adını koruyoruz (eğer yeni resim yüklenmezse değişmeyecek)
    $image_name = $product['image_url'];

    // YENİ GÖRSEL YÜKLENDİ Mİ?
    if (isset($_FILES['p_image']) && $_FILES['p_image']['error'] == 0) {
        $file_tmp = $_FILES['p_image']['tmp_name'];
        $original_name = $_FILES['p_image']['name'];
        $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        
        $allowed_extensions = array("jpg", "jpeg", "png", "webp");

        if (in_array($file_ext, $allowed_extensions)) {
            // Çakışmayı önlemek için zaman damgalı yeni isim üretiyoruz
            $image_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $original_name);
            $target_dir = __DIR__ . '/../images/';
            $target_file = $target_dir . $image_name;

            if (!move_uploaded_file($file_tmp, $target_file)) {
                $image_name = $product['image_url']; // Taşıma başarısız olursa eskisini koru
            }
        }
    }

    // UPDATE SORGUSU
    $sql_update = "UPDATE menu SET 
                    product_name = '$name', 
                    Price = '$price', 
                    description = '$desc', 
                    category_id = '$category', 
                    image_url = '$image_name' 
                   WHERE product_id = '$product_id'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Product successfully updated! ✏️🚀'); window.location.href='manage_products.php';</script>";
        exit();
    } else {
        echo "Update Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product | Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-navbar">
        <h2>Restaurant Management</h2>
        <div class="nav-links">
            <a href="manage_products.php">← Cancel & Go Back</a>
        </div>
    </div>

    <div class="admin-container">
        <div class="admin-form">
            <div style="font-size: 40px; text-align: center; margin-bottom: 10px;">✏️</div>
            <h2 style="text-align: center; margin-bottom: 30px;">Edit Menu Product</h2>
            
            <form method="POST" enctype="multipart/form-data">
                <label>Product Name</label>
                <input type="text" name="p_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                
                <label>Price (TL)</label>
                <input type="number" step="0.01" name="p_price" value="<?php echo $product['Price']; ?>" required>
                
                <label>Description</label>
                <textarea name="p_desc" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                
                <label>Category</label>
                <select name="p_category" required>
                    <option value="1" <?php if($product['category_id'] == 1) echo 'selected'; ?>>Ana Yemekler</option>
                    <option value="2" <?php if($product['category_id'] == 2) echo 'selected'; ?>>İçecekler</option>
                    <option value="3" <?php if($product['category_id'] == 3) echo 'selected'; ?>>Tatlılar</option>
                </select>

                <label style="margin-top: 15px; display: block;">Current Image</label>
                <div style="margin-bottom: 10px;">
                    <?php 
                        $current_img = !empty($product['image_url']) ? '../images/' . $product['image_url'] : '../images/default-food.png';
                    ?>
                    <img src="<?php echo $current_img; ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                </div>

                <label>Change Product Image (Optional)</label>
                <input type="file" name="p_image" accept="image/*" style="border: 1px dashed #ccc; padding: 10px; background: #fff; cursor: pointer;">
                <small style="color: #666; display: block; margin-bottom: 15px;">Leave blank to keep the current image.</small>
                
                <button type="submit" name="update_product" class="btn btn-primary" style="width: 100%; margin-top: 10px; background-color: #3498db;">✨ Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>