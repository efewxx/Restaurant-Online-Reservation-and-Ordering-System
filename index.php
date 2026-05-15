<?php 
include 'config/db.php'; 
include 'check_login.php'; 
include 'includes/header.php'; 
?>

<header class="index-hero">
    <h1 style="font-size: 3rem; color: white;">Şehrin En İyi Lezzetleri Sizi Bekliyor</h1>
    <p style="font-size: 1.2rem; margin-top: 10px;">Kaliteli malzemeler, usta şefler.</p>
</header>

<div class="menu-section">
    <div class="admin-container">
        <h2 style="text-align: center; margin-bottom: 40px;">🍴 Lezzet Menümüz</h2>
        
        <div class="dashboard-grid">
            <?php
            $sql = "SELECT * FROM menu";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="food-card">
                        <div class="food-image-placeholder">🍽️</div> <div style="padding: 20px;">
                            <h3 style="color: #2c3e50;"><?php echo $row['product_name']; ?></h3>
                            <p style="color: #777; font-size: 0.9rem; margin: 10px 0; min-height: 40px;">
                                <?php echo $row['description']; ?>
                            </p>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                                <span style="font-weight: bold; font-size: 1.2rem; color: #333;">
                                    <?php echo $row['Price']; ?> TL
                                </span>
                                
                                <a href="order_process.php?id=<?php echo $row['product_id']; ?>" 
                                   class="btn btn-primary" style="background-color: #ff9800;">
                                    Siparişe Ekle
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p style='text-align:center;'>Menü henüz boş.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>