<?php

    include("database.php");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE deliverymen_details SET ongoing_orders = all_orders - completed_orders";

mysqli_query($conn, $sql);


// Close connection
$conn->close();

?>
    
    
