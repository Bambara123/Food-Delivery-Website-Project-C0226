<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop Page</title>
  <link rel="stylesheet" href="customer_home.css">

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

    <div id="food_container">
      

      <div id="food-items">

        <div id="shop-by-food">

          <?php

            include("database.php");

            if(isset($_GET['search_term_food'])){
                $sql = "SELECT * FROM menu WHERE food LIKE '%{$_GET['search_term_food']}%' AND available = 1";

            }else{
                $sql = "SELECT * FROM menu ORDER BY RAND()";
            }

           
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $username_s = $row['username_s'];
                $imageName = $row['image'];
                $name = $row['food'];
                $price = $row['price'];
                $imagePath = $imageName;
                $food_id = $row['food_id'];

                $sql_to_get_shop_name = "SELECT shopname FROM shop_details WHERE username_s = '$username_s'";
                $result_shop_name_sql = mysqli_query($conn, $sql_to_get_shop_name);

                $shop_name = get_single_value_from_a_table($result_shop_name_sql, 'shopname');

                echo '<div id="item-card" onclick="redirectToProductPage('.$food_id.')">
                    <div id="card-top">
                      <i class="fa fa-heart-o add-to-cart"></i>
                    </div>
                    <img src="' . $imagePath . '" alt="">
                    <p id="item-name">' . $name . '</p>
                    <p id="shop-name">by ' . $shop_name . '</p>
                    <p id="item-price">LKR ' . $price . '</p>
                  </div>';
              }
            } else {
              echo 'No products found.';
            }

            $conn->close();
            

            // function 
            
            function get_single_value_from_a_table($result, $column_to_get) {
              $row = mysqli_fetch_assoc($result);
  
              if ($row) {
                  return $row[$column_to_get];
              } else {
                  return null;
              }
            }
            ?>

        </div>
      </div>
    </div>

  </div>
</body>
</html>

<!-- go to product page -->
<script>
    function redirectToProductPage(food_id) {
        // Redirect to the next page with the specific order_id parameter
        window.location.href = "http://localhost/project/one_product_show.php?food_id=" + food_id;
    }
</script>


