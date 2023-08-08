<!DOCTYPE html>
<html>
<head>
  <title>My cart</title>
  <link rel="stylesheet" type="text/css" href="customer_home.css">
</head>
<body>

    <header class="header">
      <h1>My cart</h1>

    </header>

    <div class = "product-container">

    <?php 

        $user_name = 'janu';

        include("database.php");

        //array to store cart items  
        $cart_items = array();

        $sql_get_food_items = "SELECT * FROM food_items_in_carts WHERE user_name = '$user_name'";

        $result = mysqli_query($conn, $sql_get_food_items);

        if($result->num_rows > 0){
            
            while($row = $result -> fetch_assoc()){
                $food_id = $row['food_id'];
                $quantity = $row['quantity'];

                $sql_get_price = "SELECT * FROM menu WHERE food_id = '$food_id'";

                $result2 = mysqli_query($conn, $sql_get_price);
                
                // check the result(if we have the result)  and continue processing.
                if($result2){
                    
                    $row2 = $result2 -> fetch_assoc();
                    $price = $row2['price'];
                    $food_name = $row2['food'];
                    $shop_name = $row2['shop_name'];
                    $total_price = $price * $quantity;

                }

                // send the query to location of the shop.

                $location_sql = "SELECT city FROM shop_details WHERE shopname = '$shop_name'";
                $result_location = mysqli_query($conn, $location_sql);
                $city_of_the_shop = get_single_value_from_a_table($result_location, 'city');

                $item_array = array(
                    'food_id' =>  $food_id,
                    'food_name' => $food_name,
                    'quantity' => $quantity,
                    'price' => $total_price,
                    'city' => $city_of_the_shop
                    
                );

                $cart_items[] = $item_array;

                echo '<div class = product>
                <div class="product-name">'.$food_name.'</div>
                <div class="product-name"> quantity: '.$quantity.'</div>
                <div class="product-price">$'.$total_price.' </div>
                <div class="product-name">'.$city_of_the_shop.' </div>
                </div>';

            }

            echo '<div><form method="POST">
            <button type="submit" class="add-to-cart" name="payment_submitted">Checkout</button>
            </form>
            </div>';
                
            if(isset($_POST["payment_submitted"])){

                foreach($cart_items as $item){
                    $user_name = 'janu'; 
                    $food_id = $item['food_id'];
                    $quantity = $item['quantity'];
                    $price = $item['price'];
                    $city = $item['city'];

                    

                    // query to find the driver most suitable.
                    $check_available_drivers_sql = "SELECT username_d
                    FROM deliverymen_details
                    WHERE city = '$city' 
                    AND ongoing_orders = (SELECT MIN(ongoing_orders) FROM deliverymen_details WHERE city = '$city')
                    ORDER BY completed_orders ASC
                    LIMIT 1";

                    $result = mysqli_query($conn, $check_available_drivers_sql);

                    $driver_u_name = get_single_value_from_a_table($result,'username_d');

                    echo $driver_u_name;


                    // query to insert values into order details.
                    $orders_table_sql = "INSERT INTO order_details (user_name, food_id, quantity, price, driver) VALUES ('$user_name', $food_id, $quantity, $price, '$driver_u_name')";
                    mysqli_query($conn, $orders_table_sql);

            

                }
                
                // query to delete all the cart items.
                $delete_cart_sql = "DELETE FROM food_items_in_carts WHERE user_name = '$user_name'";

                mysqli_query($conn, $delete_cart_sql);  

                $cart_items = array();
                $conn->close();

                header("Location: thank.html");

                
            }
        }

    function get_single_value_from_a_table($result, $value_to_get) {
        $row = mysqli_fetch_assoc($result);
    
        if ($row) {
            return $row[$value_to_get];
        } else {
            return null;
        }
    }

    ?>
    
    </div>

</body>

</html>
