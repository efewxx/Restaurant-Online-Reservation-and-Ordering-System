<?php
// 1. ADIM: Efe'nin hazırladığı veritabanı bağlantısını çağırıyoruz
include 'config/db.php'; 

if (isset($_POST['signup'])) {
    // Formdan gelen verileri alıyoruz
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conf_pass = $_POST['confirmpassword'];

    // Şifreler eşleşiyor mu kontrolü
    if ($password !== $conf_pass) {
        echo "<script>alert('The passwords don't match!');</script>";
    } else {
        // Şifreyi güvenli hale getiriyoruz
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user'; // Varsayılan rol

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
</head>
<body>
    <div>
        <form action="register.php" method="post">
            <div class="container"></div>

            <label for="name"><b>Name</b></label>
            <input type="text" name="name" required>
            <br><br>
            <label for="email"><b>Email</b></label>
            <input type="email" name="email" required>
            <br><br>
            <label for="password"><b>Password</b></label>
            <input type="password" name="password" required>
            <br><br>
            <label for="password"><b>Confirm Password</b></label>
            <input type="password" name="confirmpassword" required>
            <br><br>
            <input type="submit" name="signup" value="Sign Up">

        </form>
    </div>   
    
</body>
</html>