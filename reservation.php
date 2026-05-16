<?php 
include 'check_login.php';
include 'config/db.php'; 


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
        echo "<script>alert('Your reservation has been successfully received!'); window.location.href='index.php';</script>";
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}


include 'includes/header.php'; 
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    
    const resForm = document.querySelector("form");
    
    if (resForm) {
        
        const today = new Date().toISOString().split('T')[0];
        
        
        const dateInput = resForm.querySelector("input[type='date']");
        if (dateInput) {
            dateInput.setAttribute("min", today);
        }

        
        resForm.addEventListener("submit", function (e) {
            const phoneInput = resForm.querySelector("input[type='tel']") || resForm.querySelector("input[name*='phone']");
            
            if (phoneInput) {
                const phoneValue = phoneInput.value.trim();
                
                if (phoneValue.length < 10) {
                    e.preventDefault(); 
                    alert("Please enter a valid phone number that is at least 10 digits long! 📱");
                    phoneInput.focus();
                }
            }
        });
    }
});
</script>

<div style="background-color: #f8f9fa; padding: 60px 0; min-height: 90vh; font-family: 'Poppins', sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        
        <div style="text-align: center; font-size: 3rem; margin-bottom: 10px;">📅</div>
        <h2 style="text-align: center; color: #2c3e50; margin-bottom: 30px;">Table Reservation</h2>

        <form action="reservation.php" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Name</label>
                    <input type="text" name="usr_name" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" placeholder="Your name" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Surname</label>
                    <input type="text" name="usr_surname" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" placeholder="Your surname" required>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Telephone</label>
                <input type="tel" name="usr_phone" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" placeholder="05XX XXX XX XX" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Date</label>
                    <input type="date" name="res_date" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Time</label>
                    <input type="time" name="res_time" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" required>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Number of People</label>
                <input type="number" name="num_people" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" placeholder="How many people are coming?" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:5px; font-weight:600; ">Note</label>
                <textarea name="mydescription" rows="6" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; resize: none;" placeholder="Do you have any special requests?"></textarea>
            </div>

            <button type="submit" style="width:100%; padding:15px; background:#ff9800; color:white; border:none; border-radius:8px; font-size:1.1rem; font-weight:600; cursor:pointer; transition:0.3s;">
                Complete Your Reservation
            </button>
        </form>
    </div>
</div>