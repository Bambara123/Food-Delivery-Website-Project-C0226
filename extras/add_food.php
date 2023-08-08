<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'project';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $foodName = $_POST["food_name"];
    $price = $_POST["price"];

    // Upload image
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    // Insert data into table
    $sql = "INSERT INTO food_items (food_name, price, image) VALUES ('$foodName', $price, '$targetFile')";

    if (mysqli_query($conn, $sql)) {
        echo "Food item added successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
        
    }
        
}

mysqli_close($conn);
?>
