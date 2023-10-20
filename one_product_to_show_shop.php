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

        if(isset($_GET['order_id'])){

            $order_id = $_GET['order_id'];

            include('database.php');

            $get_order_details_to_deliver_sql = "SELECT * FROM order_details WHERE order_id = '$order_id'";

            $result = mysqli_query($conn, $get_order_details_to_deliver_sql);

            $row = $result->fetch_assoc();

            $order_id = $row['order_id'];
            $customer_uname = $row['user_name'];
            $food_id = $row['food_id'];
            $quantity = $row['quantity'];
            $driver = $row['username_d'];
            $price = $row['price'];
            $payment_method = $row['payment_method'];
            $checked_pickup = $row['picked_up'] ;
            $checked_delivered = $row['delivered'];
            $checked_paid = $row['paid'];


            $get_customer_data_sql = "SELECT * FROM customer_details WHERE username = '$customer_uname'";
            $get_customer_data_sql_result = mysqli_query($conn, $get_customer_data_sql);

            if($get_customer_data_sql_result){
                $row_c = $get_customer_data_sql_result->fetch_assoc();

                $address_line1 = $row_c['address_line1'];
                $address_line2 = $row_c['address_line2'];
                $city = $row_c['city'];
                $f_name = $row_c['f_name'];
                $l_name = $row_c['l_name'];
                $phone_number = $row_c['phone_number'];

            }

            function get_single_value_from_a_table($result, $column_to_get) {
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    return $row[$column_to_get];
                } else {
                    return null;
                }
            }

            // get the food details

            $sql_to_get_food = "SELECT * FROM menu WHERE food_id = '$food_id'";
            $result_get_food = mysqli_query($conn, $sql_to_get_food);

            $row_food = $result_get_food ->fetch_assoc();

            $food_name = $row_food['food'];


            $disableCheckboxes = false;
        
            echo ' <header>
            <p id="order-id">Order ID: '.$order_id.'</p>
            <div class="status-div">
                <span class="las la-truck-pickup" id  = "status-icon"></span>
                <p id="status">Delivering</p>
            </div>
            </header>

            <div class="order-details">
            <table class="order-details-table">
                <tr>
                    <td>Customer name:</td>
                    <td>'.$f_name.' '.$l_name.'</td>
                </tr>
                <tr>
                    <td>Address Line 1: </td>
                    <td>'.$address_line1.'</td>
                </tr>
                <tr>
                    <td>Address Line 2: </td>
                    <td>'.$address_line2.'</td>
                </tr>
                <tr>
                    <td>City: </td>
                    <td>'.$city.'</td>
                </tr>
                <tr>
                    <td>Phone number: </td>
                    <td>'.$phone_number.'</td>
                </tr>
                <tr>
                    <td>Food: </td>
                    <td>'.$food_name.'</td>
                </tr>
                <tr>
                    <td>Delivery men  name: </td>
                    <td>'.$driver.'</td>
                </tr>
                <tr>
                    <td>Payment method: </td>
                    <td>'.$payment_method.'</td>
                </tr>
            </table>

            <div class="cards-confirmations">

                    <div class="tile">
                    <input type="checkbox" name="picked_up" id="sport1" ' . ($checked_pickup? 'checked' : '') . ($disableCheckboxes ? 'disabled' : '').' >
                    <label for="sport1" class="label1">
                        <i class="fas fa-box"></i>
                        <h6>Picked Up</h6>
                    </label>
                    </div>
                

                <div class="tile">
                    <input type="checkbox" name="paid" id="sport2" ' . ($checked_paid ? 'checked' : '') . '>
                    <label for="sport2" class="label1">
                        <i class="fas fa-money-bill-wave"></i>
                        <h6>Paid</h6>
                    </label>
                </div>
                
                <div class="tile">
                    <input type="checkbox" name="delivered" id="sport3" ' . ($checked_delivered? 'checked' : '') . '>
                    <label for="sport3" class="label1">
                        <i class="fas fa-shipping-fast"></i>
                        <h6>Delivered</h6>
                    </label>
                </div>
            </div>
            </div>';

        }

        
        ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const isChecked = this.checked ? 1 : 0;
            const status = this.getAttribute('name');

            // Send AJAX request to update_order_status.php
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_order_status.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(`${status} checkbox update successful`);
                }
            };
            xhr.send(status + '=' + isChecked);
        });
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusText = document.getElementById('status');
    const statusIcon = document.getElementById('status-icon');

    // Assume your condition here (e.g., statusChanged is a boolean variable)
    const picked_up = <?php echo $checked_pickup; ?>;
    const delivered = <?php echo $checked_delivered; ?>;
    const paid = <?php echo $checked_paid; ?>;

    if (!picked_up && !delivered) {
        statusText.textContent = 'Preparing';
        statusIcon.classList.remove('la-truck-pickup'); 
        statusIcon.classList.add('la-cloud-meatball');

        
    } 
    if(picked_up && !delivered) {
        statusText.textContent = 'Delivering'; 
        statusIcon.classList.remove('la-cloud-meatball'); 
        statusIcon.classList.add('la-truck-pickup'); 
    }

    if(picked_up && delivered){
        statusText.textContent = 'Delivered'; 
        statusIcon.classList.remove('la-truck-pickup'); 
        statusIcon.classList.add('fa-utensils'); 

    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    // Assume your condition here (e.g., disableCheckboxes is a boolean variable)
    const disableCheckboxes = true; // Change this to your condition

    checkboxes.forEach(checkbox => {
        if (disableCheckboxes) {
            checkbox.disabled = true;
        } else {
            checkbox.disabled = false;
        }
    });
});
</script>





</body>
</html>
