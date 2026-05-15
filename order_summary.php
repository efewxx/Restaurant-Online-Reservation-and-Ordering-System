<?php 
include 'config/db.php'; 
include 'check_login.php'; 
include 'includes/header.php'; 
?>

<div style="padding: 20px;">
    <h1>Sipariş Özetiniz</h1>
    <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
        <tr>
            <th>Food Name</th>
            <th>Price</th>
        </tr>
        <?php
        $total = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id) {
                $sql = "SELECT * FROM menu WHERE product_id = $id";
                $res = mysqli_query($conn, $sql);
                $item = mysqli_fetch_assoc($res);
                
                echo "<tr>";
                echo "<td>" . $item['product_name'] . "</td>";
                echo "<td>" . $item['Price'] . " TL</td>";
                echo "</tr>";
                $total += $item['Price'];
            }
        } else {
            echo "<tr><td colspan='2'>Sepetiniz boş.</td></tr>";
        }
        ?>
        <tr style="background: #eee; font-weight: bold;">
            <td>TOPLAM</td>
            <td><?php echo $total; ?> TL</td>
        </tr>
    </table>
    <br>
    <button onclick="alert('Siparişiniz alındı!')" style="padding: 10px 20px; background: orange; border: none; cursor: pointer;">
        Siparişi Tamamla
    </button>
</div>