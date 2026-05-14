<?php 
include 'check_login.php';
// 1. Önce bağlantıyı kur
include 'config/db.php'; 

// --- EKLEDİĞİMİZ MOTOR KISMI BURASI ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri yakalıyoruz
    $date = $_POST['res_date'];
    $time = $_POST['res_time'];
    $people = $_POST['num_people'];
    $name = $_POST['usr_name'];
    $surname = $_POST['usr_surname'];
    $phone = $_POST['usr_phone'];
    $description = $_POST['mydescription'];
    
    // Şimdilik giriş yapan biri olmadığı için el ile user_id veriyoruz
    // Veritabanında users tablosunda 1 ID'li birisi olduğundan emin ol!
    $user_id = 1; 
    // Veritabanına kaydetme komutu (INSERT)
    $sql = "INSERT INTO reservation (user_id, reservation_date, reservation_time, number_of_people, user_name, user_surname, user_phone, user_description, status) 
            VALUES ('$user_id', '$date', '$time', '$people','$name', '$surname', '$phone', '$description', 'pending')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Your reservation has been successfully recorded!');</script>";
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}
// ---------------------------------------

// 2. Sayfanın en üst parçasını çağır
include 'reservation_includes/header.php'; 
?>

<!-- 3. SENİN REZERVASYON FORMU KODLARIN (Değişmedi) -->
<section class="reservation-section">
    <h1>Table Reservation</h1>
    <form action="reservation.php" method="POST">
        <input type="text" name = "usr_name" placeholder = "Name" required> <br><br>
        <input type="text" name = "usr_surname" placeholder = "Surname" required> <br><br>
        <input type="tel" name = "usr_phone" placeholder = "Phone Number" required> <br><br>
        <input type="date" name="res_date" required> <br><br>
        <input type="time" name="res_time" required> <br><br>
        <input type="number" name="num_people" placeholder="How Many People?" required> <br><br>
        <textarea name="mydescription" rows = "5" placeholder = "Please write your explanation here..."></textarea> <br><br>
        <button type="submit">Submit</button>
    </form>
</section>

<?php 
// 4. Sayfanın en alt parçasını çağır
include 'reservation_includes/footer.php'; 
?>