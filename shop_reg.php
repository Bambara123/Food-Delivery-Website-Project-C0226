<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'project';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if(mysqli_connect_error()){
    exit('Error connecting the database ' . mysqli_connect_error());

}

if(!isset($_POST['shopname'], $_POST['password'], $_POST['email'])){
    exit('Empty field(s)');

}

if(empty($_POST['shopname'] || $_POST['password'] || $_POST['email'] )){
    exit('Empty values');

}


if($stmt = $con ->prepare('SELECT id, password FROM shop_details WHERE shopname = ?')){
    $stmt-> bind_param('s', $_POST['shopname']);
    $stmt-> execute();
    $stmt-> store_result();

    if($stmt-> num_rows > 0){
        echo 'Shopname already exist';

        $value = "Shop name already exist, Please fill it specifying your city."; // The value you want to print
        $url = "shop_reg_1.php?value=" . urlencode($value); // Construct the URL with the value as a query parameter

        // Redirect to the target HTML page
        header("Location: " . $url);
        exit();



    }else{
        if($stmt = $con-> prepare('INSERT INTO shop_details (shopname, email, password) VALUES (?, ? ,?)')){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['shopname'], $_POST['email'], $password);
            $stmt->execute();

            session_start();

            $_SESSION["shopname"] = $_POST['shopname'];

            header("Location: add_food2.html");

            echo 'Successfully registered!';

        }else{
            echo 'Error occurred';

        }
    }

    $stmt->close();
}else{
    echo 'Error occurred';
}

$con->close();

exit();
?>
