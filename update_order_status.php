<?php

    session_start();
    $username_d = $_SESSION['username_d'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['picked_up'])) {
    include('database.php');

    $order_id =  $_GET['orderID']; 
    $picked_up = $_POST['picked_up'];

    // Update 'picked_up' column in your_table_name
    $update_query = "UPDATE order_details SET picked_up = $picked_up WHERE order_id = $order_id";
    mysqli_query($conn, $update_query);

    $conn->close();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paid'])) {
    include('database.php');

    $order_id =  $_GET['orderID']; 
    $paid = $_POST['paid'];

    // Update 'paid' column in your_table_name
    $update_query = "UPDATE order_details SET paid = $paid WHERE order_id = $order_id";
    mysqli_query($conn, $update_query);

    $conn->close();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delivered'])) {
    include('database.php');

    $order_id =  $_GET['orderID']; 
    $delivered = $_POST['delivered'];
    $shop_id = $_GET['shop_id'];

    // Update 'delivered' column in your_table_name
    $update_query = "UPDATE order_details SET delivered = $delivered WHERE order_id = $order_id";
    mysqli_query($conn, $update_query);

    //update shop details
    $sql1 = "UPDATE shop_details SET completed_orders = completed_orders + 1 WHERE username_s ='$shop_id'";
    mysqli_query($conn, $sql1);

    $sql2 = "UPDATE shop_details SET ongoing_orders = ongoing_orders - 1 WHERE username_s ='$shop_id'";
    mysqli_query($conn, $sql2);

    
    $sql3 = "UPDATE deliverymen_details SET ongoing_orders = ongoing_orders - 1 WHERE username_d ='$username_d'";
    mysqli_query($conn, $sql3);

    $sql4 = "UPDATE deliverymen_details SET completed_orders = completed_orders + 1 WHERE username_d ='$username_d'";
    mysqli_query($conn, $sql4);

    $conn->close();
    exit();
}
?>
