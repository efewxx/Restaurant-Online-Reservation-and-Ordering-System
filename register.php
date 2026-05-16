<?php
// 1. ADIM: Efe'nin hazırladığı veritabanı bağlantısını çağırıyoruz
include 'config/db.php'; 


if (isset($_POST['signup'])) {
    // Formdan gelen verileri alıyoruz
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conf_pass = $_POST['confirmpassword'];
    $role = isset($_POST['role']) ? $_POST['role'] : 'user';

    // Şifreler eşleşiyor mu kontrolü
    if ($password !== $conf_pass) {
        echo "<script>alert('The passwords don't match!');</script>";
    } else {
        // Şifreyi güvenli hale getiriyoruz
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        

        // 2. ADIM: Veritabanına kayıt (Efe'nin tablo isimlerine dikkat!)
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "Hata: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration </title>
    <link rel="stylesheet" href="css/login_style.css">
</head>
<body>
   <div class="main-container">
    <div class="left-side">
        <div class="overlay">
            <h1>Join Us</h1>
            <p>Register with our restaurant system and enjoy the privileges..</p>
        </div>
        <img src="./images/restaurantview.gif" alt="Restaurant GIF">
    </div>

    <div class="right-side">
        <div class="form-box">
            <h2>Create Account</h2>
            <form action="register.php" method="post">
                <div class="input-group">
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <input type="password" name="confirmpassword" placeholder="Confirm Password" required>
                </div>
                
                <div class="form-group">
    <select name="role" class="form-control" style="width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 20px; border: 1px solid #ccc;">
        <option value="user">Customer (User)</option>
        <option value="admin">Manager (Admin)</option>
    </select>
</div>
                <input type="submit" name="signup" value="SIGN UP" class="btn">
                <p class="switch-text">Already have an account? <a href="login.php">Login Here</a></p>
            </form>
        </div>
    </div>
</div>
    
</body>
</html>