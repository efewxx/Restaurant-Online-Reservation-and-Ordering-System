<?php 
include 'config/db.php'; 
include 'check_login.php'; 
include 'includes/header.php'; 
?>

<header class="index-hero">
    <h1 style="font-size: 3rem; color: white;">The City's Best Flavors Await You</h1>
    <p style="font-size: 1.2rem; margin-top: 10px;">High-quality ingredients, expert chefs.</p>
</header>

<div class="menu-section">
    <div class="admin-container">
        <h2 style="text-align: center; margin-bottom: 40px;">🍴 Our Delicious Menu</h2>
        
        <div class="dashboard-grid">
            <?php
            $sql = "SELECT * FROM menu";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    // Resim yolu kontrolü: Boşsa default görseli yapıştırıyoruz
                    $img_src = !empty($row['image_url']) ? 'images/' . $row['image_url'] : 'images/default-food.png';
                    ?>
                    <div class="food-card" style="display: flex; flex-direction: column; overflow: hidden; background: #fff; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        
                        <div class="food-image-container" style="width: 100%; height: 200px; background: #eee; overflow: hidden;">
                            <img src="<?php echo htmlspecialchars($img_src); ?>" 
                                 alt="<?php echo htmlspecialchars($row['product_name']); ?>" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <h3 style="color: #2c3e50; margin: 0;"><?php echo htmlspecialchars($row['product_name']); ?></h3>
                                <p style="color: #777; font-size: 0.9rem; margin: 10px 0; min-height: 40px;">
                                    <?php echo htmlspecialchars($row['description']); ?>
                                </p>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                                <span style="font-weight: bold; font-size: 1.2rem; color: #333;">
                                    <?php echo $row['Price']; ?> TL
                                </span>
                                
                                <a href="order_process.php?id=<?php echo $row['product_id']; ?>" 
                                   class="btn btn-primary" style="background-color: #ff9800;">
                                    Add to Order
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p style='text-align:center; width: 100%;'>The menu is still empty.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>