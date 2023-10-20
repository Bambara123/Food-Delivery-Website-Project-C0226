<?php

session_start();

$username_s = $_SESSION['username_s'];

$email = $_POST['email'];
$address_line1 =  $_POST['address_line1'];
$address_line2 =  $_POST['address_line2'];
$city = $_POST['city'];
$p_number = $_POST['p_number'];
$shop_name = $_POST['shop_name'];


include("database.php");

$query = "UPDATE shop_details SET email = '$email', address_line1 = '$address_line1', address_line2 = '$address_line2', city = '$city', phone_number= '$p_number', shopname = '$shop_name' WHERE username_s = '$username_s' ";
$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(['message' => 'Data inserted successfully']);
    header("Location: http://localhost/project/shop_home.php");
} else {
    echo json_encode(['message' => 'Error inserting data']);
    header("Location: http://localhost/project/shop_home.php");
}
?>
