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

                    $username_d = 'k_janaka';
                    $first_name = "";
                    $last_name = "";


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

                    $username_d = 'k_janaka';
                    $ongoing_orders = 0;
                    $completed_orders = 0;


                    include('database.php');

                    $sql_get_driver_name = "SELECT ongoing_orders, completed_orders FROM deliverymen_details WHERE username_d = '$username_d'";

                    $result_name = mysqli_query($conn, $sql_get_driver_name);

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
                            <h3>To be delivered</h3>

                            <button>See all <span class = "las la-arrow-right"></span></button>

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

                                        $username_d = 'kavindud';

                                        include('database.php');

                                        $get_orders_sql = "SELECT order_id, food_id FROM order_details WHERE driver = '$username_d'";

                                        $result_get_orders = mysqli_query($conn, $get_orders_sql);

                                        if($result_get_orders -> num_rows > 0){
                                            while($row = $result_get_orders -> fetch_assoc()){

                                                $order_id = $row['order_id'];
                                                $food_id = $row['food_id'];

                                                $get_food_sql = "SELECT shop_name, food FROM menu WHERE food_id = $food_id";

                                                $result_food = mysqli_query($conn, $get_food_sql);
                                                $row_from_menu = $result_food -> fetch_assoc();
                                                
                                                $shop_name = $row_from_menu['shop_name'];
                                                $food_name = $row_from_menu['food'];

                                                // go to next page

                                                echo '<tr class="clickable-row" onclick="redirectToProductPage('.$order_id.')">';
                                                echo '<td>'.$order_id.'</td>';
                                                echo '<td>'.$food_name.'</td>';
                                                echo '<td>'.$shop_name.'</td>';
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

