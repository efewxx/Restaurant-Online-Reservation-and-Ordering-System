<?php
session_start(); // Oturumu başlatıyoruz
include 'config/db.php'; 


if (isset($_POST['login'])) {
   
    $email = $_POST['email'];
    $pass = $_POST['password'];

    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        
        if (password_verify($pass, $user['password'])) {
           
            $_SESSION['user_id'] = $user['user_id']; 
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            
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
    <link rel="stylesheet" href="./css/login_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
      
   <div class="main-container">
    <div class="left-side">
        <div class="overlay">
            <h1>Welcome Back</h1>
            <p>Continue enjoying delicious moments from where you left off.</p>
        </div>
        <img src="./images/restaurantview.gif" alt="Restaurant GIF">
    </div>

    <div class="right-side">
        <div class="form-box">
            <h2>User Login</h2>
            <form action="login.php" method="post">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <input type="submit" name="login" value="LOGIN" class="btn">
                <p class="switch-text">Don't have an account? <a href="register.php">Register Now</a></p>
            </form>
        </div>
    </div>
</div>
    
    <script src="js/validation.js"></script>
    
</body>
<?php include '/includes/footer.php'; ?>
</html>
