<?php
// 1. Veritabanı bağlantısı ve oturum kontrolü
include '../config/db.php';
/** @var mysqli $conn */ 
include '../check_login.php'; 

// Sadece adminlerin girmesine izin veriyoruz
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gelen Rezervasyonlar - Admin Paneli</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .admin-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
        }
        .res-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .res-table thead {
            background-color: #2c3e50;
            color: white;
            text-align: left;
        }
        .res-table th, .res-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
        }
        .pending { background-color: #ffa502; }
        .approved { background-color: #2ed573; }
        
        .action-btn {
            text-decoration: none;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .approve { color: #2ed573; }
        .edit { color: #3498db; } /* YENİ: Düzenle butonu rengi */
        .delete { color: #ff4757; }
        .approve:hover, .edit:hover, .delete:hover { background: #f0f0f0; }

        /* Navbar düzenlemesi */
        .admin-nav {
            background: #2c3e50;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .admin-nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 400;
        }
    </style>
</head>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Sayfanın hemen silme linkine gitmesini engelle
            const targetUrl = this.getAttribute('href');

            Swal.fire({
                title: 'Emin misiniz?',
                text: "Bu rezervasyon kaydı kalıcı olarak silinecektir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff4757',
                cancelButtonColor: '#2c3e50',
                confirmButtonText: 'Evet, Sil!',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Eğer onaylandıysa silme linkine yönlendir
                    window.location.href = targetUrl;
                }
            });
        });
    });
});
</script>
<body>

<nav class="admin-nav">
    <div style="font-weight: 600; font-size: 1.2rem;">🍴 Restaurant Admin</div>
    <div>
        <a href="dashboard.php">Panel</a>
        <a href="../index.php" target="_blank">Siteyi Gör</a>
        <a href="../logout.php" style="color: #ff6b6b;">Çikiş Yap</a>
    </div>
</nav>

<div class="admin-container">
    <h2 style="color: #2c3e50; margin-bottom: 30px; display: flex; align-items: center;">
        <span style="margin-right: 15px;">📅</span> Gelen Rezervasyonlar
    </h2>

    <table class="res-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Müşteri Bilgileri</th>
                <th>Telefon</th>
                <th>Tarih / Saat</th>
                <th>Kişi</th>
                <th>Not</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Rezervasyonları veritabanından çek (en yeni en üstte)
            $sql = "SELECT * FROM reservation ORDER BY reservation_id DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $status_class = ($row['status'] == 'pending') ? 'pending' : 'approved';
                    
                    echo "<tr>";
                    echo "<td>#".$row['reservation_id']."</td>";
                    echo "<td><strong>".$row['user_name']." ".$row['user_surname']."</strong></td>";
                    echo "<td>".$row['user_phone']."</td>";
                    echo "<td>".$row['reservation_date']." <br> <small style='color:#888'>".$row['reservation_time']."</small></td>";
                    echo "<td>".$row['number_of_people']." Kişi</td>";
                    echo "<td style='max-width: 200px; font-size: 0.85rem; color: #666;'>".htmlspecialchars($row['user_description'])."</td>";
                    echo "<td><span class='status-badge $status_class'>".$row['status']."</span></td>";
                    echo "<td>
                            <a href='approve_res.php?id=".$row['reservation_id']."' class='action-btn approve'>Onayla</a>
                            <span style='color: #ddd'>|</span>
                            <a href='update_reservation.php?id=".$row['reservation_id']."' class='action-btn edit'>Düzenle</a>
                            <span style='color: #ddd'>|</span>
                            <a href='delete_res.php?id=".$row['reservation_id']."' class='action-btn delete delete-btn'>Sil</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' style='text-align:center; padding: 30px;'>Henüz bir rezervasyon kaydı bulunamadı.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>