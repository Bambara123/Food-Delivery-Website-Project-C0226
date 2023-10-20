<?php

session_start();

$username_d = $_SESSION['username_d'];

$email = $_POST['email'];
$address_line1 =  $_POST['address_line1'];
$address_line2 =  $_POST['address_line2'];
$home_city =  $_POST['home_city'];
$city = $_POST['city'];
$p_number = $_POST['p_number'];
$vehicle_reg = $_POST['vehicle_reg'];


include("database.php");

$query = "UPDATE deliverymen_details SET email = '$email', address_line1 = '$address_line1', address_line2 = '$address_line2', home_city = '$home_city' , city = '$city', phone_number= '$p_number', vehicle_reg = '$vehicle_reg' WHERE username_d = '$username_d' ";
$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(['message' => 'Data inserted successfully']);
    header("Location: http://localhost/project/deliver_home.php");
} else {
    echo json_encode(['message' => 'Error inserting data']);
    header("Location: http://localhost/project/deliver_home.php");
}
?>