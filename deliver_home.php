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
                        <span class = "las la-igloo"></span>
                        <span>Dashboard</span>    
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

            <a href = "" data-content = "image" class = "list-item">
                <div class = "user-wrapper">
                <img src = "http://localhost/project/images/1.jpg" width="30px" height = "30px" alt = "">
                <div>

            </a>
            

                <?php

                    session_start();

                    if(isset($_SESSION['username_d'])){
                        $username_d = $_SESSION['username_d'];


                    }else{
                        header("Location: http://localhost/project/deliver_log.html");

                    }

                    include('database.php');

                    $sql_get_driver_name = "SELECT first_name, last_name FROM deliverymen_details WHERE username_d = '$username_d'";

                    $result_name = mysqli_query($conn, $sql_get_driver_name);

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

                    $sql_get_driver_name = "SELECT ongoing_orders, completed_orders, all_orders FROM deliverymen_details WHERE username_d = '$username_d'";

                    $result_name = mysqli_query($conn, $sql_get_driver_name);

                    if($result_name -> num_rows > 0){
                    while($row = $result_name -> fetch_assoc()){
                        $ongoing_orders = $row['ongoing_orders'];
                        $completed_orders = $row['completed_orders'];
                        $all_orders = $row['all_orders'];
                        $success_rate = 100 * ($completed_orders/$all_orders); 
                        $success_rate = round($success_rate, 2);
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
                            <h1>'.$all_orders.'</h1>
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
                            <h3>To be delivered</h3>

                        </div>

                        <div class = "card-body">
                            <table width = "100%">
                                <thead>
                                    <tr>
                                        <td>Order ID</td>
                                        <td>Parcel Includes</td>
                                        <td>Shop Name</td>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                        include('database.php');

                                        $get_orders_sql = "SELECT order_id, food_id FROM order_details WHERE username_d = '$username_d' AND delivered = 0";

                                        $result_get_orders = mysqli_query($conn, $get_orders_sql);

                                        if($result_get_orders -> num_rows > 0){
                                            while($row = $result_get_orders -> fetch_assoc()){

                                                $order_id = $row['order_id'];
                                                $food_id = $row['food_id'];

                                                $get_food_sql = "SELECT * FROM menu WHERE food_id = $food_id";

                                                $result_food = mysqli_query($conn, $get_food_sql);
                                                $row_from_menu = $result_food -> fetch_assoc();
                                                
                                                $username_s = $row_from_menu['username_s'];
                                                $food_name = $row_from_menu['food'];

                                                //get shop name
                                                $shop_id = 1;   

                                                $sql_to_get_shop_name = "SELECT * FROM shop_details WHERE username_s = '$username_s'";
                                                $result_shop_name_sql = mysqli_query($conn, $sql_to_get_shop_name);
                                        
                                                $shop_name = get_single_value_from_a_table($result_shop_name_sql, 'shopname');

                                                // go to next page

                                                echo '<tr class="clickable-row" onclick="redirectToProductPage('.$order_id.')">';
                                                echo '<td>'.$order_id.'</td>';
                                                echo '<td>'.$food_name.'</td>';
                                                echo '<td>'.$shop_name.'</td>';
                                                echo '</tr>';


                                            }

                                        }else{
                                    

                                        }

                                    mysqli_close($conn);

                                    
                                    function get_single_value_from_a_table($result, $column_to_get) {
                                        $row = mysqli_fetch_assoc($result);
                            
                                        if ($row) {
                                            return $row[$column_to_get];
                                        } else {
                                            return null;
                                        }
                                    }


                                    
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
                                        <td>Shop Name</td>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                        include('database.php');

                                        $get_orders_sql = "SELECT order_id, food_id FROM order_details WHERE username_d = '$username_d' AND delivered = 1";

                                        $result_get_orders = mysqli_query($conn, $get_orders_sql);

                                        if($result_get_orders -> num_rows > 0){
                                            while($row = $result_get_orders -> fetch_assoc()){

                                                $order_id = $row['order_id'];
                                                $food_id = $row['food_id'];

                                                $get_food_sql = "SELECT * FROM menu WHERE food_id = $food_id";

                                                $result_food = mysqli_query($conn, $get_food_sql);
                                                $row_from_menu = $result_food -> fetch_assoc();
                                                
                                                $username_s = $row_from_menu['username_s'];
                                                $food_name = $row_from_menu['food'];

                                                //get shop name
                                                $shop_id = 1;   

                                                $sql_to_get_shop_name = "SELECT * FROM shop_details WHERE username_s = '$username_s'";
                                                $result_shop_name_sql = mysqli_query($conn, $sql_to_get_shop_name);
                                        
                                                $shop_name = get_single_value_from_a_table($result_shop_name_sql, 'shopname');

                                                // go to next page

                                                echo '<tr class="clickable-row" onclick="redirectToProductPage('.$order_id.')">';
                                                echo '<td>'.$order_id.'</td>';
                                                echo '<td>'.$food_name.'</td>';
                                                echo '<td>'.$shop_name.'</td>';
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

                    $sql_to_get_user_data = "SELECT * FROM deliverymen_details WHERE username_d = '$username_d'";
                    $result_get_user_data = mysqli_query($conn, $sql_to_get_user_data);
                    
                    $row_s = mysqli_fetch_assoc($result_get_user_data);;
                
                    $email = $row_s['Email'];
                    $address_line1 = $row_s['address_line1'];
                    $address_line2 = $row_s['address_line2'];
                    $home_city = $row_s['address_line2'];
                    $city = $row_s['city'];
                    $vehicle_reg = $row_s['vehicle_reg'];
                    $p_number =  $row_s['phone_number'];


                    echo '<form id="registration-form" action = "http://localhost/project/change_data_driver.php" class = "myForm" method = "POST">
                
            
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
                        <input type = "text"  value = "'.$home_city.'" placeholder="Enter the home city" name = "home_city" />
                        </div>
            
                        <div class = "input-box">
                            <input type = "text" value = "'.$city.'" placeholder="Nearest city" name = "city" required/>
                        </div>
            
                        <div class = "input-box">
                            <label>Phone number</label>
                            <input type = "text" value = "'.$p_number.'" placeholder="Enter the phone number" name = "p_number" required/>
                        </div>

                        <div class = "input-box">
                            <label>Phone number</label>
                            <input type = "text" value = "'.$vehicle_reg.'" placeholder="Enter the vehicle registration number" name = "vehicle_reg" required/>
                        </div>
            
                        <button type="submit">Update</button>   
                    
            
                        </form>'


                ?>
            
                <form id="delete-form" action = "http://localhost/project/delete_account_deliver.php" class = "myForm" method = "POST">
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

</body>



</html>


<script>
    function redirectToProductPage(orderId) {
        // Redirect to the next page with the specific order_id parameter
        window.location.href = "http://localhost/project/one_product_to_deliver.php?order_id=" + orderId;
    }
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

<!-- update data js -->


<script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(event.target);

        fetch('change_data_driver.php', {
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
