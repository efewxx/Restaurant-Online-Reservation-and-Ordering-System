<?php
$conn = mysqli_connect("localhost", "root", "", "restaurant_db");
if(!$conn){
    die("Error: " . mysqli_connect_error());
}     
?>