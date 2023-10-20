<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop Page</title>
  <link rel="stylesheet" href="one_product_show.css">

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
  <a href = "http://localhost/project/mycart.php">
    <i class="fa fa-cart-plus" id="cart-plus"> My Cart</i>
  </a>
</div>
</div>



  <div id="container" class="container">

    <div id="side_menu">
      
      <div class="menu-items">
        <a href="http://localhost/project/customer_home.php">Home</a>
        <a href="http://localhost/project/my_orders.php">My orders</a>
        <a href="#">My address</a>
        <a href="#">Settings</a>
        <a href="#">Help</a>
        <a href="http://localhost/project/shop_reg.html">Add your shop</a>
        <a href="http://localhost/project/deliver_reg.html">Refer a friend</a>
        <?php
          session_start();
          if (isset($_SESSION['username'])) {
    echo '<a href="http://localhost/project/logout.php">Log out</a>';
} ?>
      </div>      
    </div>

    <div id="food_container">


      <?php

          include("database.php");
          
          if(isset($_SESSION['username'])){

            $username = $_SESSION['username'];

          }         

          $food_id_main = $_GET['food_id'];
          
          $sql_to_get_food_details = "SELECT * FROM menu WHERE food_id = $food_id_main";
          $result_food_details = mysqli_query($conn, $sql_to_get_food_details);

          $row = $result_food_details -> fetch_assoc();

          $food_name = $row['food'];
          $price = $row['price'];
          $username_s = $row['username_s'];
          $description = $row['description'];
          $imagePath = $row['image'];


          $sql_to_get_shop_name = "SELECT shopname FROM shop_details WHERE username_s = '$username_s'";
          $result_shop_name_sql = mysqli_query($conn, $sql_to_get_shop_name);

          $shop_name = get_single_value_from_a_table($result_shop_name_sql, 'shopname');


          echo '        <div class="single-food">

          <div class = "image-container">
  
              <img src = "'.$imagePath.'">
  
          </div>
  
          <div class="product-details-single">
  
              <h1>'.$food_name.'</h1>
              <p class = "description-content">By '.$shop_name.' </p>
  
              
  
              <p class = "description">Description</p>
              <p class = "description-content">'.$description.'</p>    
  
              <p id = "price">'.$price.' LKR</p>
  
              <div class = "add-to-cart-container">
                  <div class="quantity-input">
                      <div class="input-container">
                          
                          <button class="decrement">-</button>
                          <input type="text" id="quantity" name="quantity" value="1">
                          <button class="increment">+</button>
                      </div>
                  </div>
                  <div class = "see-more-foods"><input type = "button" id = "see-more" value = "Add to cart"/></div>
  
              </div>
  
              
  
  
          </div>
  
          
          </div>';

      ?>

        


      <div id="food-items">        

        <div id="shop-by-food">
            <p id="category-name">For Those Who Deserve the Finest Flavors</p>

          <?php

            include("database.php");

            if(isset($_GET['search_term_food'])){
                $sql = "SELECT * FROM menu WHERE food LIKE '%{$_GET['search_term_food']}%' ORDER BY RAND()";

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
                  </div>
                </a>';
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

<!-- increase the  quantity when button clicked -->

<script>

    const quantityInput = document.getElementById('quantity');
    const decrementButton = document.querySelector('.decrement');
    const incrementButton = document.querySelector('.increment');

    decrementButton.addEventListener('click', () => {
      if (quantityInput.value > 1) {
        quantityInput.value--;
      }
    });

    incrementButton.addEventListener('click', () => {
      quantityInput.value++;
    });

</script>

<!-- go to product page -->
<script>
    function redirectToProductPage(food_id) {
        // Redirect to the next page with the specific order_id parameter
        window.location.href = "http://localhost/project/one_product_show.php?food_id=" + food_id;
    }
</script>


<!-- add to cart  -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#see-more").click(function() {
            var food_id = <?php echo $food_id_main ?>;
            var quantity = quantityInput.value;

            // Check if the session is not set (assuming 'username' is your session variable)
            <?php if (!isset($_SESSION['username'])) { ?>
                // Redirect to another page
                window.location.href = "customer_log.html"; // Replace with the URL of your login page
            <?php } else { ?>
                // Perform AJAX request to your PHP script
                $.ajax({
                    type: "POST",
                    url: "add_to_cart.php", // Replace with the actual PHP file that handles the SQL queries
                    data: { 
                        food_id: food_id, 
                        quantity: quantity
                    },
                    success: function(response) {
                        // Handle the response from the server if needed
                        console.log(response);
                    }
                });
            <?php } ?>
        });
    });
</script>
