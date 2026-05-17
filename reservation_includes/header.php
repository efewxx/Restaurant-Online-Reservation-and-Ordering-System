<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Reservation | MILOS</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .reservation-section {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .reservation-section h1 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        .reservation-section input, 
        .reservation-section textarea, 
        .reservation-section button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }
        .reservation-section button {
            background-color: #ff9800;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .reservation-section button:hover { background-color: #e67e22; }
    </style>
</head>
<body>

<nav class="main-nav">
    <a href="index.php" class="nav-brand"><span>🍴 MILOS</span></a>
    <div class="nav-links-container">
        <a href="index.php">Home Page</a>
        <a href="make_reservation.php">Make a Reservation</a>
        <a href="login.php" class="nav-auth-btn">Login / Register</a>
    </div>
</nav>