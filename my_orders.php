<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop Page</title>
  <link rel="stylesheet" href="my_orders.css">

  <!-- font awesome link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

<div id="header">

<div class="brand-logo">
        <img src="http://localhost/project/images/logo.png" alt="">
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
        <a href="#">My orders</a>
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

        <!-- <h1 class = "my_orders_heading">My orders</h1> -->


        <?php 
        
            if(isset($_SESSION['username'])){
                $user_name = $_SESSION['username'];

            }else{
                header("Location: http://localhost/project/customer_log.html");
            }

            include("database.php");

            $sql_get_food_items = "SELECT * FROM order_details WHERE user_name = '$user_name'";

            $result4 = mysqli_query($conn, $sql_get_food_items);

            if($result4->num_rows > 0){
                
                while($row4 = $result4 -> fetch_assoc()){
                    $order_id = $row4['order_id'];
                    $food_id = $row4['food_id'];
                    $quantity = $row4['quantity'];
                    $total_price = $row4['price'];
                    
                    // get food name
                    $sql_to_get_food_name = "SELECT food FROM menu WHERE food_id = '$food_id'";
                    $result_food_name = mysqli_query($conn, $sql_to_get_food_name);

                    $food_name = get_single_value_from_a_table($result_food_name, 'food');


                    // get the price 

                    $sql_to_get_food_name = "SELECT price FROM menu WHERE food_id = '$food_id'";
                    $result_food_name = mysqli_query($conn, $sql_to_get_food_name);
                    
                    $price = get_single_value_from_a_table($result_food_name, 'price');
                    


                    echo '<div class="cart-item-card" data-order-id=" '.$order_id.'" >
                        <div class = "cart-description-single">
                            
                            <div class="price-and-name">
                                <h2>'.$food_name.' </h2>
                                <h5>Price: '.$price.' LKR</h5>
                            </div>
                            <h4>X '.$quantity.'</h4>
                            
                            <h6>'.$total_price.' LKR</h6>
                            
                        </div>
                    </div>';                   

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
const menuItems = document.querySelectorAll('.menu-items a');
const firstMenuItem = menuItems[1];

menuItems.forEach(item => {
    item.addEventListener('mouseover', () => {
        if (item !== firstMenuItem) {
            firstMenuItem.classList.add('hovered');
        }
    });

    item.addEventListener('mouseout', () => {
        if (item !== firstMenuItem) {
            firstMenuItem.classList.remove('hovered');
        }
    });
});
</script> 

<script>
    // Get all elements with class "cart-item-card"
    const cartItems = document.querySelectorAll('.cart-item-card');

    // Add a click event listener to each cart item
    cartItems.forEach(cartItem => {
        cartItem.addEventListener('click', function() {
            // Get the order ID from the data attribute
            const orderId = cartItem.getAttribute('data-order-id');
            
            // Redirect to one.php with the order ID as a query parameter
            window.location.href = `customer_view_order_details.php?order_id=${orderId}`;
        });
    });
</script>

</body>
</html>


