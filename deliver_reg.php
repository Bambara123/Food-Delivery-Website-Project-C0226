<?php

// Process the form data 

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'project';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);



if(mysqli_connect_error()){
    exit('Error connecting the database ' . mysqli_connect_error());

}

if(!isset($_POST['f_name'], $_POST['l_name'],$_POST['email'], $_POST['address_line1'], $_POST['home_city'], $_POST['city'], $_POST['p_number'], $_POST['vehicle_reg'], $_POST['username_d'], $_POST['password'])){
    exit('Empty field(s)');

}

if(empty($_POST['f_name'] || $_POST['l_name'] || $_POST['email'] || $_POST['address_line1'] || $_POST['home_city']|| $_POST['city'] || $_POST['p_number']|| $_POST['vehicle_reg'] || $_POST['username_d'] || $_POST['password'])){
    exit('Empty values');

}


if($stmt = $con ->prepare('SELECT id, password FROM deliverymen_details WHERE username_d = ?')){

    $username_d = strtolower($_POST['username_d']);

    $stmt-> bind_param('s', $username_d);
    $stmt-> execute();
    $stmt-> store_result();

    if($stmt-> num_rows > 0){

        $response = array();
        $response['usernameNotAvailable'] = true;
        header('Content-Type: application/json');
        echo json_encode($response);

    }else{
        if($stmt = $con-> prepare('INSERT INTO deliverymen_details (first_name, last_name, email, address_line1, address_line2,home_city, city, phone_number, vehicle_reg, username_d, password) VALUES (?, ? ,?, ?, ?, ?, ? ,?, ?, ?, ?)')){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT) ;

            $f_name = strtolower($_POST['f_name']);
            $l_name = strtolower($_POST['l_name']);
            $email = strtolower($_POST['email']);
            $address_line1 = strtolower($_POST['address_line1']);
            $address_line2 = strtolower($_POST['address_line2']);
            $home_city = strtolower($_POST['home_city']);
            $city = strtolower($_POST['city']);
            $p_number = $_POST['p_number'];  // No need to convert this to lowercase
            $vehicle_reg = strtolower($_POST['vehicle_reg']);

            $stmt->bind_param('sssssssssss', $f_name, $l_name, $email, $address_line1, $address_line2, $home_city, $city, $p_number, $vehicle_reg, $username_d, $password);
            $stmt->execute();

            session_start();
            $_SESSION["username_d"] = $username_d;

            $response = array();
            $response['usernameNotAvailable'] = false;
            header('Content-Type: application/json');
            echo json_encode($response);


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
