<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop Page</title>
  <link rel="stylesheet" href="mycart.css">

  <!-- font awesome link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

<div id="header">

<div class="brand-logo">
        <img src="http://localhost/project/images/logo.png" alt="">
</div>

<div class="search-bar-container">
    <form action = "http://localhost/project/customer_home_see_more_food.php" class = "search-bar" >
        <input type = "text" placeholder="Foodie thoughts?" name = "search_term_food">
        <button type = "submit"><img src = "images/search.png"></button>
    </form>
</div> 

<div class="util">
  
  <i class="fa fa-tags"> Offers</i>
  <a href = "http://localhost/project/mycart.php"><i class="fa fa-cart-plus" id="cart-plus"> My Cart</i></a>
</div>
</div>



  <div id="container" class="container">

    <div id="side_menu">
      
    <div class="menu-items">
          <a href="http://localhost/project/customer_home.php#">Home</a>
          <a href="http://localhost/project/my_orders.php">My orders</a>
          <a href="#">My address</a>
          <a href="#">Settings</a>
          <a href="#">Help</a>
          <a href="http://localhost/project/shop_reg.html">Add your shop</a>
          <a href="http://localhost/project/deliver_reg.html">Enroll Courier</a>
          <?php
          session_start();
          if (isset($_SESSION['username'])) {
    echo '<a href="http://localhost/project/logout.php">Log out</a>';
} ?>
        </div>      
    </div>

    <!-- cart products area -->

    <div id="food_container">
      
        <div class="cart">


        <?php 
            
            if(isset($_SESSION['username'])){
                $username = $_SESSION['username'];

            }else{
                header("Location: http://localhost/project/customer_log.html");
            }
            $checkout_price = 0;

            include("database.php");

            //array to store cart items  
            $cart_items = array();

            $sql_get_food_items = "SELECT * FROM food_items_in_carts WHERE user_name = '$username'";

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
                        $username_s = $row2['username_s'];
                        $image = $row2['image'];
                        $image_path = $image;
                        $total_price = $price * $quantity;
                        $checkout_price =  $checkout_price + $total_price;


                        $sql_to_get_shop_name = "SELECT shopname FROM shop_details WHERE username_s = '$username_s'";
                        $result_shop_name_sql = mysqli_query($conn, $sql_to_get_shop_name);

                        $shop_name = get_single_value_from_a_table($result_shop_name_sql, 'shopname');

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
                        'city' => $city_of_the_shop,
                        'username_s' => $username_s
                        
                    );

                    $cart_items[] = $item_array;

                    echo '<div class="cart-item-card" data-username="'.$username.'" data-food-id="'.$food_id.'">
                <div class = "cart-image-single">

                    <div class = "img-container">
                        
                        <img src = "'.$image_path.'" alt = "">

                    </div>
                    
                </div>
                <div class = "cart-description-single">
                    
                    <div class="price-and-name">
                        <h2>'.$food_name.' </h2>
                        <h5>Price: '.$price.' LKR</h5>
                    </div>
                    <h4>X '.$quantity.'</h4>
                    
                    <h6>'.$total_price.' LKR</h6>
                    <button class="button delete-button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    
                </div>
            </div>';

                }

                echo '<form action = "mycart.php" method = "post">
                <div class = "total">
                <p>Total: '.$checkout_price.' LKR</p>

                <button class = "checkout" value = "payment_submitted" name = "payment_submitted">Checkout</button>

            </div>
                </form>';
                    
                if(isset($_POST["payment_submitted"])){

                    // query to delete all the cart items. after inserting into order details.
                    $delete_cart_sql = "DELETE FROM food_items_in_carts WHERE user_name = '$username'";

                    mysqli_query($conn, $delete_cart_sql);  

                    foreach($cart_items as $item){
    
                        $food_id = $item['food_id'];
                        $quantity = $item['quantity'];
                        $price = $item['price'];
                        $city = $item['city'];
                        $username_s = $item['username_s'];

                        

                        // query to find the driver most suitable.
                        $check_available_drivers_sql = "SELECT username_d
                        FROM deliverymen_details
                        WHERE city = '$city' 
                        AND ongoing_orders = (SELECT MIN(ongoing_orders) FROM deliverymen_details WHERE city = '$city')
                        ORDER BY completed_orders ASC
                        LIMIT 1";

                        $result = mysqli_query($conn, $check_available_drivers_sql);

                        $driver_u_name = get_single_value_from_a_table($result,'username_d');

                        if(!empty($driver_u_name)){ // to proceed only found a suitable deliverymen.
                            
                            // query to insert values into order details.
                            $orders_table_sql = "INSERT INTO order_details (user_name, food_id, quantity, price, username_d, username_s) VALUES ('$username', $food_id, $quantity, $price, '$driver_u_name', '$username_s')";
                            mysqli_query($conn, $orders_table_sql);    
                            
                            

                            // query to update ingoing orders 

                            $update_ongoing_orders = "UPDATE deliverymen_details SET ongoing_orders = ongoing_orders + 1 WHERE username_d = '$driver_u_name'";
                            mysqli_query($conn, $update_ongoing_orders);

                            $update_ongoing_orders = "UPDATE deliverymen_details SET all_orders = all_orders + 1 WHERE username_d = '$driver_u_name'";
                            mysqli_query($conn, $update_ongoing_orders);

                            // query to update ongoing orders shop
                            $update_ongoing_orders_shop = "UPDATE shop_details SET ongoing_orders = ongoing_orders + 1 WHERE username_s = '$username_s'";
                            mysqli_query($conn, $update_ongoing_orders_shop);

                            $update_ongoing_orders_shop = "UPDATE shop_details SET all_orders = all_orders + 1 WHERE username_s = '$username_s'";
                            mysqli_query($conn, $update_ongoing_orders_shop);


                        }else{
                            
                            header("Location: cannot_deliver.html");

                        }

                       
                
                    }
                    
                    $cart_items = array();
                    header("Location: http://localhost/project/my_orders.php");
                    
                                        
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

        </div>
      
    </div>

  </div>

  <script>
    // Function to delete a cart item

    function deleteCartItem(button) {
        const cartItem = button.closest('.cart-item-card');
        if (cartItem) {
            cartItem.remove();
            updateTotal();
        }
    }

    // Function to update the total amount
    function updateTotal() {
        const cartItems = document.querySelectorAll('.cart-item-card');
        let total = 0;

        cartItems.forEach(cartItem => {
            const priceElement = cartItem.querySelector('.price-and-name h5');
            const quantityElement = cartItem.querySelector('h4');
            const price = parseFloat(priceElement.innerText.match(/\d+/)[0]);
            const quantity = parseInt(quantityElement.innerText.match(/\d+/)[0]);
            total += price * quantity;
        });

        const totalElement = document.querySelector('.total p');
        totalElement.innerText = `Total: ${total} LKR`;
    }

    // Attach event listeners to the delete buttons
    const deleteButtons = document.querySelectorAll('.button');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            deleteCartItem(this);
        });
    });
</script>

<!-- delete item in cart table -->

<script>
document.addEventListener('DOMContentLoaded', () => {
  const deleteButtons = document.querySelectorAll('.delete-button');
  
  deleteButtons.forEach(button => {
    button.addEventListener('click', (event) => {
      const cartItemCard = event.target.closest('.cart-item-card');
      const username = cartItemCard.dataset.username;
      const foodId = cartItemCard.dataset.foodId;
      
      // Send a request to the server to delete the item using AJAX or Fetch
      // You can use the itemId to identify which item to delete

        fetch('delete_cart_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `delete_item=true&food_id=${foodId}&username=${username}`
        })
        .then(response => response.json())
        .then(data => {
        if (data.success) {
            // Item deleted successfully, you can remove the cart item card from the DOM

            cartItemCard.remove();
        } else {
            // Handle error case
        }
        })
        .catch(error => {
        // Handle fetch error
        });

    });
  });
});
</script>


</body>
</html>


