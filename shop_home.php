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
                    <a href="" data-content="profile" class = "list-item">
                        <span class="far fa-plus-square"></span>
                        <span>Add New</span>                
                    </a>                    
                </li>

                <li>
                    <a href="" data-content="profile" class = "list-item">
                        <span class="fas fa-edit"></span>
                        <span>Update Stocks</span>                
                    </a>                    
                </li>

                <li>
                    <a href="" data-content="profile" class = "list-item">
                        <span class="fas fa-user-cog"></span>
                        <span>Settings</span>                
                    </a>                    
                </li>

                <li>
                    <a href="" data-content="profile" class = "list-item">
                        <span class="fas fa-question"></span>
                        <span>Help</span>                
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

            <div class="search-wrapper">
                <span class = "las la-search"></span>
                <input type = "text" placeholder="Search here"/>

            </div>

            <div class = "user-wrapper">
                <img src = "http://localhost/project/images/1.jpg" width="30px" height = "30px" alt = "">
                <div>

                <?php

                    $username_s = 'shopper';
                    $first_name = "";
                    $last_name = "";


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

                    $username_d = 'shopper';
                    $ongoing_orders = 0;
                    $completed_orders = 0;


                    include('database.php');

                    $sql_get_shop_data = "SELECT ongoing_orders, completed_orders FROM shop_details WHERE username_s = '$username_s'";

                    $result_name = mysqli_query($conn, $sql_get_shop_data);

                    if($result_name -> num_rows > 0){
                    while($row = $result_name -> fetch_assoc()){
                        $ongoing_orders = $row['ongoing_orders'];
                        $completed_orders = $row['completed_orders'];
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
                            <h1>45</h1>
                            <span>Success rate</span>
                        </div>
    
                        <div>
                            <span class = "las la-shopping-bag"></span>
                        </div>
    
                    </div>
    
                    <div class="single-card">
                        <div>
                            <h1>6km</h1>
                            <span>Distance traveled</span>
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

                            <button>See all <span class = "las la-arrow-right"></span></button>

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

                                        $username_s = 'shopper';

                                        include('database.php');

                                        $get_orders_sql = "SELECT order_id, food_id, username_d FROM order_details WHERE username_s = '$username_s'";

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
                                            echo "No orders Yet";

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
    link.addEventListener('click', (event) => {
        event.preventDefault();

        const targetContent = link.getAttribute('data-content');
        contentSections.forEach(section => {
            section.style.display = 'none';
        });

        const selectedSection = document.getElementById(targetContent);
        selectedSection.style.display = 'block';
    });
});

</script>

