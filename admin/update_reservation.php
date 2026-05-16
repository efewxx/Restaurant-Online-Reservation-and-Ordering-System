<?php
session_start();
include __DIR__ . '/../config/db.php';
/** @var mysqli $conn */

// GÜVENLİK: Admin değilse giriş sayfasına postala
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// URL'den rezervasyon ID'si gelmiş mi?
if (!isset($_GET['id'])) {
    header("Location: view_reservations.php");
    exit();
}

$reservation_id = mysqli_real_escape_string($conn, $_GET['id']);

// REZERVASYONUN MEVCUT BİLGİLERİNİ VERİTABANINDAN ÇEK
$sql_get = "SELECT * FROM reservation WHERE reservation_id = '$reservation_id'";
$res_get = mysqli_query($conn, $sql_get);
$reservation = mysqli_fetch_assoc($res_get);

// Eğer böyle bir rezervasyon yoksa listeye geri gönder
if (!$reservation) {
    header("Location: view_reservations.php");
    exit();
}

// FORM POST EDİLDİĞİNDE GÜNCELLEME MOTORU OYUNA GİRER
if (isset($_POST['update_reservation'])) {
    $res_date = mysqli_real_escape_string($conn, $_POST['r_date']);
    $res_time = mysqli_real_escape_string($conn, $_POST['r_time']);
    $guests = mysqli_real_escape_string($conn, $_POST['r_guests']);
    $notes = mysqli_real_escape_string($conn, $_POST['r_notes']);
    $status = mysqli_real_escape_string($conn, $_POST['r_status']);

    // UPDATE SORGUSU
    $sql_update = "UPDATE reservation SET 
                    reservation_date = '$res_date', 
                    reservation_time = '$res_time', 
                    number_of_people = '$guests', 
                    user_description = '$notes',
                    status = '$status'
                   WHERE reservation_id = '$reservation_id'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Rezervasyon başarıyla güncellendi! 📅✨'); window.location.href='view_reservations.php';</script>";
        exit();
    } else {
        echo "Güncelleme Hatası: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervasyon Düzenle | Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif; background-color: #f4f7f6;
            margin: 0; padding: 0;
        }
        .form-container {
            max-width: 600px; margin: 60px auto; background: #fff; 
            padding: 40px; border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        h2 { color: #2c3e50; font-weight: 600; margin-bottom: 25px; margin-top: 0; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #555; }
        .form-control {
            width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;
            box-sizing: border-box; font-family: 'Poppins', sans-serif; font-size: 0.95rem;
        }
        .form-control:focus { border-color: #3498db; outline: none; }
        
        .submit-btn {
            background: #3498db; color: white; padding: 12px 30px; border: none;
            border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer;
            transition: 0.3s; width: 100%;
        }
        .submit-btn:hover { background: #2980b9; }
        
        .admin-nav {
            background: #2c3e50; padding: 15px 5%; display: flex;
            justify-content: space-between; align-items: center; color: white;
        }
        .admin-nav a { color: white; text-decoration: none; font-weight: 400; }
    </style>
</head>
<body>

<nav class="admin-nav">
    <div style="font-weight: 600; font-size: 1.2rem;">🍴 Restaurant Admin</div>
    <div>
        <a href="view_reservations.php">← Geri Dön</a>
    </div>
</nav>

<div class="form-container">
    <h2>✏️ Rezervasyon Düzenle</h2>
    
    <form method="POST">
        
        <div class="form-group">
            <label>Müşteri Adı Soyadı</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($reservation['user_name'] . ' ' . $reservation['user_surname']); ?>" disabled style="background-color: #eee; cursor: not-allowed;">
        </div>

        <div class="form-group">
            <label>Müşteri Telefonu</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($reservation['user_phone']); ?>" disabled style="background-color: #eee; cursor: not-allowed;">
        </div>

        <div class="form-group">
            <label for="r_date">Rezervasyon Tarihi</label>
            <input type="date" id="r_date" name="r_date" class="form-control" value="<?php echo $reservation['reservation_date']; ?>" required>
        </div>

        <div class="form-group">
            <label for="r_time">Rezervasyon Saati</label>
            <input type="time" id="r_time" name="r_time" class="form-control" value="<?php echo $reservation['reservation_time']; ?>" required>
        </div>

        <div class="form-group">
            <label for="r_guests">Kişi Sayısı</label>
            <input type="number" id="r_guests" name="r_guests" class="form-control" value="<?php echo $reservation['number_of_people']; ?>" min="1" required>
        </div>

        <div class="form-group">
            <label for="r_notes">Müşteri Notu</label>
            <textarea id="r_notes" name="r_notes" class="form-control" rows="3"><?php echo htmlspecialchars($reservation['user_description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="r_status">Onay Durumu</label>
            <select id="r_status" name="r_status" class="form-control" required>
                <option value="pending" <?php if($reservation['status'] == 'pending') echo 'selected'; ?>>pending (Beklemede)</option>
                <option value="approved" <?php if($reservation['status'] == 'approved') echo 'selected'; ?>>approved (Onaylandı)</option>
            </select>
        </div>

        <button type="submit" name="update_reservation" class="submit-btn">💾 Değişiklikleri Kaydet</button>
    </form>
</div>

</body>
</html>