<?php
    
    // get the session variables.
    session_start();

    $username = $_SESSION['username'];
    $food_id = $_POST['food_id'];
    $added_quantity = $_POST['quantity']; 

    // database connection
    include('database.php');

    $sql_0 = "SELECT quantity FROM food_items_in_carts WHERE user_name = '$username' AND food_id = '$food_id'";

    $result = mysqli_query($conn, $sql_0);

    if ($result) {
    // Fetch the entire result set as an enumerated array
    $row = mysqli_fetch_array($result, MYSQLI_NUM);

        // Check if the array is not empty
        if ($row) {
            // Access the first element (index 0) which contains the quantity value and type cast it
            $quantity = (int)$row[0]; // or (float)$row[0];
            $quantity = $quantity + $added_quantity;

            $sql_update = "UPDATE food_items_in_carts SET quantity = $quantity WHERE user_name = '$username' AND food_id = '$food_id'";

            mysqli_query($conn, $sql_update);


        } else {

            // No matching row found
            $quantity = $added_quantity;
            $sql_add = "INSERT INTO food_items_in_carts(user_name, food_id, quantity) 
            VALUES ('$username', '$food_id', '$quantity')";
        
            mysqli_query($conn, $sql_add);

        }
    } else {

    // Query failed, handle the error
    echo "Error: " . mysqli_error($connection);

    }

?>