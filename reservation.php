<?php 
include 'check_login.php';
include 'config/db.php'; 

// --- ARISH'İN MOTOR KISMI ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date        = mysqli_real_escape_string($conn, $_POST['res_date']);
    $time        = mysqli_real_escape_string($conn, $_POST['res_time']);
    $people      = mysqli_real_escape_string($conn, $_POST['num_people']);
    $name        = mysqli_real_escape_string($conn, $_POST['usr_name']);
    $surname     = mysqli_real_escape_string($conn, $_POST['usr_surname']);
    $phone       = mysqli_real_escape_string($conn, $_POST['usr_phone']);
    $description = mysqli_real_escape_string($conn, $_POST['mydescription']);
    
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 

    $sql = "INSERT INTO reservation (user_id, reservation_date, reservation_time, number_of_people, user_name, user_surname, user_phone, user_description, status) 
            VALUES ('$user_id', '$date', '$time', '$people','$name', '$surname', '$phone', '$description', 'pending')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Rezervasyonunuz başarıyla alındı!'); window.location.href='index.php';</script>";
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}

// Tasarımı düzeltmek için ana header'ı çağırıyoruz
include 'includes/header.php'; 
?>

<div style="background-color: #f8f9fa; padding: 60px 0; min-height: 90vh; font-family: 'Poppins', sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        
        <div style="text-align: center; font-size: 3rem; margin-bottom: 10px;">📅</div>
        <h2 style="text-align: center; color: #2c3e50; margin-bottom: 30px;">Masa Rezervasyonu</h2>

        <form action="reservation.php" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Ad</label>
                    <input type="text" name="usr_name" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" placeholder="Adınız" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Soyad</label>
                    <input type="text" name="usr_surname" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" placeholder="Soyadınız" required>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Telefon</label>
                <input type="tel" name="usr_phone" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" placeholder="05XX XXX XX XX" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Tarih</label>
                    <input type="date" name="res_date" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Saat</label>
                    <input type="time" name="res_time" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" required>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Kişi Sayısı</label>
                <input type="number" name="num_people" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" placeholder="Kaç kişi geleceksiniz?" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Not</label>
                <textarea name="mydescription" rows="3" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" placeholder="Özel bir isteğiniz var mı?"></textarea>
            </div>

            <button type="submit" style="width:100%; padding:15px; background:#ff9800; color:white; border:none; border-radius:8px; font-size:1.1rem; font-weight:600; cursor:pointer; transition:0.3s;">
                Rezervasyonu Tamamla
            </button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>