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
          <p id="category-name">Shop by Food</p>
          
          <?php

            if (isset($_SESSION['username'])) {
              $username = $_SESSION['username'];

            }

            include("database.php");

            $sql = "SELECT * FROM menu WHERE available = 1 ORDER BY RAND()";
            $result = $conn->query($sql);

            $count = 0;

            if ($result->num_rows > 0) {
              while (($row = $result->fetch_assoc()) && $count < 30) {
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
                  $count++;

              }
            } else {
              echo 'No products found.';
            }

            $conn->close();

            function get_single_value_from_a_table($result, $column_to_get) {
              $row = mysqli_fetch_assoc($result);
  
              if ($row) {
                  return $row[$column_to_get];
              } else {
                  return null;
              }
            }

            ?>

     
          <a href = "http://localhost/project/customer_home_see_more_food.php">
            <div class = "see-more-foods" id = "see-more-foods">
              
                <input type = "button" id = "see-more" value = "Still hungry?"/>
            
            </div> 
          </a>

        </div>


        <!-- shop by shop -->

        <div id="shop-by-shop">

          <p id="category-name">Shop By Restaurant</p> 

          <?php

          include("database.php");

          // Fetch products from the database
          $sql = "SELECT * FROM shop_details ORDER BY RAND()";
          $result = $conn->query($sql);

          // Display products
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $username_s = $row['username_s'];
              $shop_name = $row['shopname'];
              $city = $row['city'];  
              $imageName = $row['default_image_for_shop'];
              
              if(empty($imageName)){
                $imagePath = "shop_pp/default.png";

              }else{
                $imagePath = 'shop_pp/' . $imageName;
              }
              

              echo '<div id="shop-item-card" onclick="redirectToShopPage(\''.htmlspecialchars($username_s, ENT_QUOTES, 'UTF-8').'\')">
                      <img src="'.$imagePath.'" alt="">
                      <p id="shop-name-2">'.$shop_name.'</p>
                      <p id="shop-name">'.$city.'</p>
                  </div>';
            }
          } else {
            echo 'No products found.';
          }

          $conn->close();
          ?>
          
        </div>

      </div>
    </div>

  </div>
 
  <script>
    function redirectToProductPage(food_id) {
        // Redirect to the next page with the specific order_id parameter
        window.location.href = "http://localhost/project/one_product_show.php?food_id=" + food_id;
    }
</script>

<script>
    function redirectToShopPage(username_s) {
        // Redirect to the next page with the specific username_s parameter
        window.location.href = "http://localhost/project/shop_by_shop.php?username_s=" + username_s;
    }
</script>


</body>
</html>


