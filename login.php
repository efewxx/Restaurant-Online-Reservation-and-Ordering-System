<?php
session_start(); // Oturumu başlatıyoruz
include 'config/db.php'; 

if (isset($_POST['login'])) {
    // Formdan gelen veriler
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Efe'nin tablosuna göre: users tablosunda email üzerinden ara
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // password_verify: Girilen şifreyi veritabanındaki hashli şifre ile karşılaştırır
        if (password_verify($pass, $user['password'])) {
            // Giriş başarılı! Bilgileri session'a kaydediyoruz
            $_SESSION['user_id'] = $user['user_id']; // Efe 'user_id' yapmış
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            // Role göre yönlendirme
            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
        } else {
            echo "<script>alert('Incorrect Password!');</script>";
        }
    } else {
        echo "<script>alert('No user was found registered with this email address!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Restaurant System</title>
</head>
<body>
    <form action="login.php" method="post" onsubmit="return validateLogin()">
        <h2>Login</h2>
        <input type="email" name="email" id="email" placeholder="E-posta" required>
        <br><br>
        <input type="password" name="password" id="password" placeholder="Şifre" required>
        <br><br>
        <input type="submit" name="login" value="Login">
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </form>
    
    <script src="js/validation.js"></script>
</body>
</html>