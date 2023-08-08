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
  <i class="fa fa-cart-plus" id="cart-plus"> 0 Items</i>
</div>
</div>



  <div id="container" class="container">

    <div id="side_menu">
      
      <div class="menu-items">
        <a href="#">My orders</a>
        <a href="#">My address</a>
        <a href="#">Settings</a>
        <a href="#">Help</a>
        <a href="#">Add your shop</a>
        <a href="#">Earn Cash</a>
        <a href="#">Refer a friend</a>
      </div>      
    </div>

    <div id="food_container">
      

      <div id="food-items">

        <div id="shop-by-food">

          <?php

            include("database.php");

            if(isset($_GET['search_term_food'])){
                $sql = "SELECT * FROM menu WHERE food LIKE '%{$_GET['search_term_food']}%'";

            }else{
                $sql = "SELECT * FROM menu";
            }

           
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $shop_name = $row['shop_name'];
                $imageName = $row['image'];
                $name = $row['food'];
                $price = $row['price'];
                $imagePath = 'upload/' . $imageName;
                $food_id = $row['food_id'];

                echo '<a href="http://localhost/project/one_product_show.php">
                  <div id="item-card">
                    <div id="card-top">
                      <i class="fa fa-heart-o add-to-cart"></i>
                    </div>
                    <img src="' . $imagePath . '" alt="">
                    <p id="item-name">' . $name . '</p>
                    <p id="shop-name">by ' . $shop_name . '</p>
                    <p id="item-price">$' . $price . '</p>
                  </div>
                </a>';
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
</body>
</html>


