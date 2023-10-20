<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Document</title>

    <link rel = "stylesheet"  href = "deliver_home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
<body>

    <input type = "checkbox" id = "nav-toggle">

    <div class = "sidebar">
        <div class =  "brand-logo">
            <img src="images/logo-white1.png" alt=""><h2><span>FOODIPY</span></h2>
        </div>

<!-- navigation bar -->

        <div class = "sidebar-menu">

        <nav class = "navigation">
            <ul>
                <li>
                    <a href="" data-content="dashboard" class = "list-item">
                        <span class="las la-tachometer-alt" id = "dashboard_icon"></span>
                        <span>Shop Dashboard</span>    
                    </a>                    
                </li>

                <li>
                    <a href="" data-content="add-new" class = "list-item">
                        <span class="far fa-plus-square"></span>
                        <span>Add New</span>                
                    </a>                    
                </li>

                <li>
                    <a href="" data-content="update_stocks" class = "list-item">
                        <span class="fas fa-edit"></span>
                        <span>Update Stocks</span>                
                    </a>                    
                </li>

                <li>
                    <a href="" data-content="settings" class = "list-item">
                        <span class="fas fa-user-cog"></span>
                        <span>Settings</span>                
                    </a>                    
                </li>

                <li>
                    <a href="" data-content="help" class = "list-item">
                        <span class="fas fa-question"></span>
                        <span>Help</span>                
                    </a>                    
                </li>

                <li>
                    <a  href="http://localhost/project/logout.php" data-content="" class = "list-item logout-link">
                        <span class="fa fa-sign-out"></span>
                        <span>Logout</span>                
                    </a>                    
                </li>
   
            </ul>

        </nav>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>
                <label for = "nav-toggle">
                    <span class = "las la-bars">
                    </span>
                </label>
                Dashboard
            </h2>


            <div class = "user-wrapper">
                <img src = "http://localhost/project/images/1.jpg" width="30px" height = "30px" alt = "">
                <div>

                <?php
                
                    session_start();

                    if(isset($_SESSION['username_s'])){
                        $username_s = $_SESSION['username_s'];


                    }else{
                        header("Location: http://localhost/project/shop_log.html");

                    }
                    include('database.php');

                    $sql_get_shop_name = "SELECT first_name, last_name FROM shop_details WHERE username_s = '$username_s'";

                    $result_name = mysqli_query($conn, $sql_get_shop_name);

                    if($result_name -> num_rows > 0){
                    while($row = $result_name -> fetch_assoc()){
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                    }
                    }

                    echo '<h4>'.$first_name.' '.$last_name.'</h4>';

                    mysqli_close($conn);

                    ?>
                    
                </div>

            </div>

        </header>

<!-- Main sections -->

        <section class ="content" id="dashboard">
            <main>

            <!-- getting driver data for display -->
            <?php

                    include('database.php');

                    $sql_get_shop_data = "SELECT ongoing_orders, completed_orders, all_orders FROM shop_details WHERE username_s = '$username_s'";

                    $result_name = mysqli_query($conn, $sql_get_shop_data);

                    if($result_name -> num_rows > 0){
                    while($row = $result_name -> fetch_assoc()){
                        $ongoing_orders = $row['ongoing_orders'];
                        $completed_orders = $row['completed_orders'];
                        $all_ordrs = $row['all_orders'];
                        $success_rate = 100 * ($completed_orders/ $row['all_orders']);
                        $success_rate = round( $success_rate, 2);
                    }
                    }

                    echo '<div class = "driver-data-cards">
                    <div class="single-card">
                        
                        <div>
                            <h1>'.$ongoing_orders.'</h1>
                            <span>Ongoing orders</span>
                        </div>
                    
                        <div>
                            <span class = "las la-users"></span>
                        </div>
    
                    </div>
    
                    <div class="single-card">
                        <div>
                            <h1>'.$completed_orders.'</h1>
                            <span>Orders completed</span>
                        </div>
    
                        <div>
                            <span class = "las la-clipboard"></span>
                        </div>
    
                    </div>
    
                    <div class="single-card">
                        <div>
                            <h1>'.$success_rate.' %</h1>
                            <span>Success rate</span>
                        </div>
    
                        <div>
                            <span class = "las la-shopping-bag"></span>
                        </div>
    
                    </div>
    
                    <div class="single-card">
                        <div>
                            <h1>'.$all_ordrs.'</h1>
                            <span>All orders</span>
                        </div>
    
                        <div>
                            <span class = "lab la-google-wallet"></span>
                        </div>
    
                    </div>
    
                </div>';

                    mysqli_close($conn);

                    ?>

            

            <div class = "recent-grid">
                <div class = "projects">
                    <div class = "card">
                        <div class ="card-header">
                            <h3>To be Prepared</h3>

                        </div>

                        <div class = "card-body">
                            <table width = "100%">
                                <thead>
                                    <tr>
                                        <td>Order ID</td>
                                        <td>Parcel Includes</td>
                                        <td>Delivery Men Name</td>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                        include('database.php');

                                        $get_orders_sql = "SELECT order_id, food_id, username_d FROM order_details WHERE username_s = '$username_s' AND delivered = 0";

                                        $result_get_orders = mysqli_query($conn, $get_orders_sql);

                                        if($result_get_orders -> num_rows > 0){
                                            while($row = $result_get_orders -> fetch_assoc()){

                                                $order_id = $row['order_id'];
                                                $food_id = $row['food_id'];
                                                $username_d = $row['username_d'];

                                                //get the food name

                                                $get_food_sql = "SELECT food FROM menu WHERE food_id = $food_id";

                                                $result_food = mysqli_query($conn, $get_food_sql);
                                                $row_from_menu = $result_food -> fetch_assoc();
                                                
                                                $food_name = $row_from_menu['food'];

                                                // get the driver name

                                                $get_driver_sql = "SELECT first_name, last_name FROM deliverymen_details WHERE username_d = '$username_d'";
                                                $result_driver = mysqli_query($conn, $get_driver_sql);

                                                $row_from_driver = $result_driver  -> fetch_assoc();

                                                $first_name = $row_from_driver['first_name'];
                                                $last_name = $row_from_driver['last_name'];                                        

                                                echo '<tr class="clickable-row" onclick="redirectToProductPage('.$order_id.')">';
                                                echo '<td>'.$order_id.'</td>';
                                                echo '<td>'.$food_name.'</td>';
                                                echo '<td>'.$first_name.' '.$last_name.'</td>';
                                                echo '</tr>';


                                            }

                                        }else{

                                        }

                                    mysqli_close($conn);


                                    
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class = "completed-grid">
                <div class = "projects">
                    <div class = "card">
                        <div class ="card-header">
                            <h3>Completed orders</h3>

                        </div>

                        <div class = "card-body">
                            <table width = "100%">
                                <thead>
                                    <tr>
                                        <td>Order ID</td>
                                        <td>Parcel Includes</td>
                                        <td>Delivery Men Name</td>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                        include('database.php');

                                        $get_orders_sql = "SELECT order_id, food_id, username_d FROM order_details WHERE username_s = '$username_s' AND delivered = 1";

                                        $result_get_orders = mysqli_query($conn, $get_orders_sql);

                                        if($result_get_orders -> num_rows > 0){
                                            while($row = $result_get_orders -> fetch_assoc()){

                                                $order_id = $row['order_id'];
                                                $food_id = $row['food_id'];
                                                $username_d = $row['username_d'];

                                                //get the food name

                                                $get_food_sql = "SELECT food FROM menu WHERE food_id = $food_id";

                                                $result_food = mysqli_query($conn, $get_food_sql);
                                                $row_from_menu = $result_food -> fetch_assoc();
                                                
                                                $food_name = $row_from_menu['food'];

                                                // get the driver name

                                                $get_driver_sql = "SELECT first_name, last_name FROM deliverymen_details WHERE username_d = '$username_d'";
                                                $result_driver = mysqli_query($conn, $get_driver_sql);

                                                $row_from_driver = $result_driver  -> fetch_assoc();

                                                $first_name = $row_from_driver['first_name'];
                                                $last_name = $row_from_driver['last_name'];                                        

                                                echo '<tr class="clickable-row" onclick="redirectToProductPage('.$order_id.')">';
                                                echo '<td>'.$order_id.'</td>';
                                                echo '<td>'.$food_name.'</td>';
                                                echo '<td>'.$first_name.' '.$last_name.'</td>';
                                                echo '</tr>';


                                            }

                                        }else{
                                            

                                        }

                                    mysqli_close($conn);


                                    
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            </main>

        </section>    

    
        <section class = "content" id = "add-new">
            <main>
                <div class = "add-food">
                <h1>Add your next savory food</h1>

                <form id="registration-form" action = "http://localhost/project/add_food2.php" class = "form1" method = "POST" enctype="multipart/form-data">


                    <div class = "input-box">
                        <label>Food name</label>
                        <input type = "text" placeholder="Enter the food name" name = "food_name"/>
                    </div>


                    <div class = "input-box">
                        <label>Price</label>
                        <input type = "text" placeholder="Enter the price" name = "price"/>
                    </div>

                    <div class = "input-box">
                        <label>Description</label>
                        <input type = "text" placeholder="Enter your menu description"/>
                    </div>


                    <div class="form-input">

                        <div class="preview">
                            <img src = "" alt = "" id = "file-ip-1-preview">
                        </div>

                        <label for = "file-ip-1">Select image</label>
                        <input type = "file" id = "file-ip-1" name = "image" accept="image/*"  onchange="showPreview(event);" e>

                    </div>                

                    <button type = "submit" name = "submit">Add food item</button>    
                    
                    
</form>                 

                </div>
            </main>
    </section>


    <section class = "content" id = "update_stocks">

    <main>
    <div class = "recent-grid2">
                <div class = "projects">
                    <div class = "card">
                        <div class ="card-header">
                            <h3>Update your stocks</h3>

                        </div>

                        <div class = "card-body">
                            <table width = "100%">
                                <thead>
                                    <tr>
                                        <td>Food Listing ID</td>
                                        <td>Food </td>
                                        <td>In stock</td>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                        include('database.php');

                                        $get_listed_food_sql = "SELECT food_id, food, available FROM menu WHERE username_s = '$username_s'";

                                        $result_get_listed_food = mysqli_query($conn, $get_listed_food_sql);

                                        if($result_get_listed_food -> num_rows > 0){
                                            while($row = $result_get_listed_food -> fetch_assoc()){

                                                $food_id = $row['food_id'];
                                                $food = $row['food'];
                                                $available = $row['available'];
                                  

                                                echo '<tr class="clickable-row">';
                                                echo '<td>' . $food_id . '</td>';
                                                echo '<td>' . $food . '</td>';
                                                echo '<td><div class="toggle">
                                                <input type="checkbox" id="check' . $food_id . '" class="check" data-foodid="' . $food_id . '" ' . ($available == 1 ? 'checked' : '') . '>
                                                <label for="check' . $food_id . '" class="toggle-label"></label></div></td>';
                                                echo '</tr>';



                                            }

                                        }else{
                                            

                                        }

                                    mysqli_close($conn);


                                    
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </main>                                    

    </section>


    <section class = "content" id = "settings">

        <section class = "container">
            <h3>Keep your details upto date</h3> 
            
            <?php

                include("database.php");

                $sql_to_get_user_data = "SELECT * FROM shop_details WHERE username_s = '$username_s'";
                $result_get_user_data = mysqli_query($conn, $sql_to_get_user_data);
                
                $row_s = mysqli_fetch_assoc($result_get_user_data);;
                
                $shop_name = $row_s['shopname'];
                $email = $row_s['Email'];
                $address_line1 = $row_s['address_line1'];
                $address_line2 = $row_s['address_line2'];
                $city = $row_s['city'];
                $p_number =  $row_s['phone_number'];


                echo '<form id="registration-form" action = "http://localhost/project/change_data_shop.php" class = "myForm" method = "POST">
            

                    <div class = "input-box">
                        <label>Shop name</label>
                        <input type = "text" value = "'.$shop_name.'" placeholder="Enter the shop name"  name = "shop_name" required/>
                    </div>
        
        
                    <div class = "input-box">
                        <label>Email</label>
                        <input type = "text" value = "'.$email.'" placeholder="Enter the email" name = "email" required/>
                    </div>
        
                    <div class = "input-box">
                        <label>Shop Address</label>
                        <input type = "text"  value = "'.$address_line1.'" placeholder="Street name" name = "address_line1" required/>
                    </div>
                    <div class = "input-box">
                        <input type = "text"  value = "'.$address_line2.'" placeholder="Enter the address line 2" name = "address_line2" />
                    </div>
        
                    <div class = "input-box">
                        <input type = "text" value = "'.$city.'" placeholder="Nearest city" name = "city" required/>
                    </div>
        
                    <div class = "input-box">
                        <label>Phone number</label>
                        <input type = "text" value = "'.$p_number.'" placeholder="Enter the phone number" name = "p_number" required/>
                    </div>
        
                    <button type="submit">Update</button>   
                    
                    </form>'

                     


            ?>

            <form id="registration-form2" action = "http://localhost/project/add_pp.php" class = "myForm2" method = "POST" enctype="multipart/form-data">
                
                <h3>Upload shop default image</h3> 

                <div class="form-input">

                <div class="preview">
                    <img src = "" alt = "" id = "file-ip-2-preview">
                </div>

                <label for = "file-ip-2">Select image</label>
                <input type = "file" id = "file-ip-2" name = "image" accept="image/*"  onchange="showPreview2(event);" e>

                </div>    
                
                <button type = "submit" name = "submit">Update</button> 

            </form>   
            
            <form id="delete-form" action = "http://localhost/project/delete-account.php" class = "myForm" method = "POST">
                <h3>Delete your account</h3> 
                
                <div class = "input-box">
                        <label>Enter password and delete the account</label>
                        <input type = "password"  placeholder="Enter the password before deleting the account" name = "password" required/>
                </div>

                <button class = "delete-account">Delete my account</button> 


            </form>
            
            





        </section>
    </section>
    </div>

<!-- add product -  java script -->

    <script type = "text/javascript">

    function showPreview2(event){
        if(event.target.files.length > 0 ){
            var src  = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-ip-2-preview");

            preview.src = src;
            preview.style.display = "block";
        }

    }
// shop image js
    function showPreview(event){
        if(event.target.files.length > 0 ){
            var src  = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-ip-1-preview");

            preview.src = src;
            preview.style.display = "block";
        }

    }

    </script>



</body>



</html>

<!-- go to order js -->

<script>
    function redirectToProductPage(orderId) {
        // Redirect to the next page with the specific order_id parameter
        window.location.href = "http://localhost/project/one_product_to_show_shop.php?order_id=" + orderId;
    }
</script>

<!-- toggle js -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function() {
    $('.check').change(function() {
        const food_id = $(this).data('foodid');
        const isAvailable = $(this).prop('checked') ? 1 : 0;
        
        // Send AJAX request to update_food_status.php
        $.ajax({
            url: 'update_availability.php', // Change this URL to the correct update script
            type: 'POST',
            data: { food_id: food_id, isAvailable: isAvailable },
            success: function(response) {
                // Handle success, you can update the table here if needed
                console.log(response);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});

</script>


<script>

const navigationLinks = document.querySelectorAll('.navigation a');
const contentSections = document.querySelectorAll('.content');

navigationLinks.forEach(link => {
    if (!link.classList.contains('logout-link')) { // Exclude logout link
        link.addEventListener('click', (event) => {
            event.preventDefault();

            const targetContent = link.getAttribute('data-content');
            contentSections.forEach(section => {
                section.style.display = 'none';
            });

            const selectedSection = document.getElementById(targetContent);
            selectedSection.style.display = 'block';
        });
    }
});

</script>

<!-- change details -->

<script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(event.target);

        fetch('change_data_shop.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response from the server (if needed)
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>


<script>
    document.getElementById('myForm2').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(event.target);

        fetch('add_pp.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response from the server (if needed)
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>


