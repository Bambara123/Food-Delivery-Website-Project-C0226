<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="one_product_to_deliver.css"> <!-- Include your custom CSS here -->

    <title>Document</title>
</head>
<body>

<?php

$order_id = 108;
$shop_name = 'john';
$food_name = 'rice';

include('database.php');

$get_order_details_to_deliver_sql = "SELECT * FROM order_details WHERE order_id = '$order_id'";

$result = mysqli_query($conn, $get_order_details_to_deliver_sql);

$row = $result->fetch_assoc();

$order_id = $row['order_id'];
$customer_uname = $row['user_name'];
$food_id = $row['food_id'];
$quantity = $row['quantity'];
$price = $row['price'];

$get_address_sql = "SELECT address FROM customer_details WHERE username = '$customer_uname'";
$get_address_sql_result = mysqli_query($conn, $get_address_sql);

$address = get_single_value_from_a_table($get_address_sql_result, 'address');


function get_single_value_from_a_table($result, $column_to_get) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        return $row[$column_to_get];
    } else {
        return null;
    }
}

if(isset($_GET['order_id'])) {
    $clicked_order_id = $_GET['order_id'];
    // Use $clicked_order_id as needed
}

echo ' <header>
<p id="order-id">Order ID: '.$order_id.'</p>
<div class="status-div">
    <span class="las la-truck-pickup"></span>
    <p id="status">Delivering</p>
</div>
</header>

<div class="order-details">
<table class="order-details-table">
    <tr>
        <td>Customer name:</td>
        <td>Kavindu Bambaragama</td>
    </tr>
    <tr>
        <td>Address: </td>
        <td>'.$address.'</td>
    </tr>
    <tr>
        <td>Phone number: </td>
        <td>07034628292</td>
    </tr>
    <tr>
        <td>Payment method: </td>
        <td>Cash on delivery</td>
    </tr>
</table>

<div class="cards-confirmations">
    <div class="tile">
        <input type="checkbox" name="sports" id="sport1">
        <label for="sport1" class="label1">
            <i class="fas fa-box"></i>
            <h6>Picked Up</h6>
        </label>
    </div>

    <div class="tile">
        <input type="checkbox" name="sports" id="sport2">
        <label for="sport2" class="label1">
            <i class="fas fa-money-bill-wave"></i>
            <h6>Paid</h6>
        </label>
    </div>
    
    <div class="tile">
        <input type="checkbox" name="sports" id="sport3">
        <label for="sport3" class="label1">
            <i class="fas fa-shipping-fast"></i>
            <h6>Delivered</h6>
        </label>
    </div>
</div>
</div>
'

?>

</body>
</html>
