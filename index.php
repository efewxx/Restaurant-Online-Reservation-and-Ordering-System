<?php 
include 'config/db.php'; 
include 'check_login.php'; // Ozan'ın güvenlik kontrolü (Session burada başlar)
include 'includes/header.php'; 
?>

<div style="padding: 20px;">
    <h1>Lezzet Menümüz</h1>
    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        <?php
        // Efe'nin tablosuna göre sorgu: menu tablosundan çekiyoruz
        $sql = "SELECT * FROM menu";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div style='border: 1px solid #ddd; padding: 15px; border-radius: 8px; width: 250px;'>";
                echo "<h3>" . $row['product_name'] . "</h3>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<strong>Fiyat: " . $row['Price'] . " TL</strong><br><br>";
                // Sipariş ekleme linki (ID gönderiyoruz)
                echo "<a href='order_process.php?id=" . $row['product_id'] . "' 
                        style='background:green; color:white; padding:8px; text-decoration:none; border-radius:5px;'>
                        Siparişe Ekle</a>";
                echo "</div>";
            }
        } else {
            echo "Henüz menüye yemek eklenmemiş.";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>