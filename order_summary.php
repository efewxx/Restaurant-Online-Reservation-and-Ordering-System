<?php 
include 'config/db.php'; 
include 'check_login.php'; 
/** @var mysqli $conn */

// --- ORDER COMPLETION MOTOR ---
if (isset($_POST['complete_order'])) {
    $user_id = $_SESSION['user_id'];
    $total_price = mysqli_real_escape_string($conn, $_POST['total_price']);
    $order_status = 'Hazırlanıyor'; // Arka plandaki Türkçe motor bozulmuyor

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // STEP 1: Insert the main order info into 'orders' table
        $sql_order = "INSERT INTO orders (user_id, total_price, order_status) VALUES ('$user_id', '$total_price', '$order_status')";
        
        if (mysqli_query($conn, $sql_order)) {
            // Get the unique ID of the newly inserted order
            $new_order_id = mysqli_insert_id($conn);

            // STEP 2: Loop through items in cart and insert into 'order_items'
            foreach ($_SESSION['cart'] as $id) {
                $sql_menu = "SELECT Price FROM menu WHERE product_id = $id";
                $res_menu = mysqli_query($conn, $sql_menu);
                $menu_item = mysqli_fetch_assoc($res_menu);
                $unit_price = $menu_item['Price'];
                $quantity = 1; 

                $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, unit_price) 
                             VALUES ('$new_order_id', '$id', '$quantity', '$unit_price')";
                mysqli_query($conn, $sql_item);
            }

            // STEP 3: Clear the cart after order is successfully placed
            unset($_SESSION['cart']);

            // Elegant browser alert and redirect in English
            echo "<script>
                    alert('Your order has been successfully placed! Our chef has started preparing your meal. 👨‍🍳🍽️');
                    window.location.href = 'index.php';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Database Error: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Your cart is empty. Order could not be completed.');</script>";
    }
}

include 'includes/header.php'; 
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    .order-container {
        font-family: 'Poppins', sans-serif; max-width: 800px; margin: 40px auto;
        background: #fff; padding: 30px; border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05); color: #333;
    }
    .order-container h1 { color: #2c3e50; font-weight: 600; margin-bottom: 25px; font-size: 1.8rem; }
    
    .order-table { width: 100%; border-collapse: collapse; text-align: left; margin-bottom: 25px; }
    .order-table th { background-color: #2c3e50; color: #fff; padding: 12px 15px; font-weight: 500; }
    .order-table td { padding: 12px 15px; border-bottom: 1px solid #eee; vertical-align: middle; }
    .order-table tr:hover { background-color: #f8f9fa; }
    
    /* Image and Layout Rules */
    .product-img {
        width: 60px; height: 60px; border-radius: 8px; object-fit: cover; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); background: #eee;
    }
    .product-cell { display: flex; align-items: center; gap: 15px; }
    
    .total-row { background: #f1f2f6; font-weight: 600; font-size: 1.1rem; }
    .total-price-text { color: #2e7d32; font-weight: bold; }
    
    .complete-btn {
        background: #ff9800; color: white; padding: 15px 30px; border: none;
        border-radius: 8px; font-weight: 600; font-size: 1.05rem; cursor: pointer;
        transition: 0.3s; display: inline-block; width: 100%; box-sizing: border-box; text-align: center;
    }
    .complete-btn:hover { background: #e68a00; transform: translateY(-2px); box-shadow: 0 5px 10px rgba(230,138,0,0.2); }
</style>

<div class="order-container">
    <h1>🛒 Order Summary</h1>
    
    <table class="order-table">
        <thead>
            <tr>
                <th>Product</th>
                <th style="text-align: right;">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $id) {
                    $sql = "SELECT * FROM menu WHERE product_id = $id";
                    $res = mysqli_query($conn, $sql);
                    $item = mysqli_fetch_assoc($res);
                    
                    if ($item) {
                        // Eğer image_url doluysa doğrudan 'images/' klasöründen çağırıyoruz. Boşsa default görsel basıyoruz.
                        $img_src = !empty($item['image_url']) ? 'images/' . $item['image_url'] : 'images/default-food.png';
                        
                        echo "<tr>";
                        echo "<td>";
                        echo "  <div class='product-cell'>";
                        echo "      <img src='" . htmlspecialchars($img_src) . "' class='product-img' alt='food'>";
                        echo "      <span>" . htmlspecialchars($item['product_name']) . "</span>";
                        echo "  </div>";
                        echo "</td>";
                        echo "<td style='text-align: right; font-weight: 500;'>" . $item['Price'] . " TL</td>";
                        echo "</tr>";
                        $total += $item['Price'];
                    }
                }
            } else {
                echo "<tr><td colspan='2' style='text-align: center; color: #999; padding: 20px;'>Your cart is currently empty.</td></tr>";
            }
            ?>
            <tr class="total-row">
                <td>TOTAL AMOUNT</td>
                <td style="text-align: right;" class="total-price-text"><?php echo $total; ?> TL</td>
            </tr>
        </tbody>
    </table>

    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <form action="order_summary.php" method="POST">
            <input type="hidden" name="total_price" value="<?php echo $total; ?>">
            <button type="submit" name="complete_order" class="complete-btn">
                Complete & Confirm Order
            </button>
        </form>
    <?php endif; ?>
</div>