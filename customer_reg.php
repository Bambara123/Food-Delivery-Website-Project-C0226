<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'project';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if(mysqli_connect_error()){
    exit('Error connecting the database ' . mysqli_connect_error());

}

if(!isset($_POST['f_name'], $_POST['l_name'] , $_POST['address_line1'],  $_POST['city'] , $_POST['p_number'],$_POST['username'], $_POST['password'], $_POST['email'])){
    exit('Empty field(s)');

}

if(empty($_POST['f_name']|| $_POST['l_name'] || $_POST['address_line1'] ||  $_POST['city']|| $_POST['p_number']||$_POST['username']|| $_POST['password']||$_POST['email'])){
    exit('Empty values');

}


if($stmtCheckUsername = $con ->prepare('SELECT id FROM customer_details WHERE username = ?')){ // Here, It should be ok to duplicate the usermame since we use IDs, Just remove it later.if you need.
   
    $username = $_POST['username'];

    $stmtCheckUsername-> bind_param('s', $username);
    // Set parameters for above statement.
    $stmtCheckUsername-> execute();
    $stmtCheckUsername-> store_result();
    // Store results in statement to use later.

    if($stmtCheckUsername-> num_rows > 0){// Result of executing the statement is used here.
        // Username is not available, send a JSON response
        $response = array();
        $response['usernameNotAvailable'] = true;
        header('Content-Type: application/json');
        echo json_encode($response);

    }else{
        if($stmtInsertUser = $con-> prepare('INSERT INTO customer_details (f_name, l_name, address_line1, address_line2, city, phone_number, username, email, password) VALUES (?, ? ,?, ?, ?, ?, ?, ?, ?)')){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $f_name = strtolower($_POST['f_name']);
            $l_name = strtolower($_POST['l_name']);
            $address_line1 = strtolower($_POST['address_line1']);
            $address_line2 = strtolower($_POST['address_line2']);
            $city = strtolower($_POST['city']);
            $p_number = $_POST['p_number'];  
            $email = strtolower($_POST['email']);


            $stmtInsertUser->bind_param('sssssssss', $_POST['f_name'], $l_name, $address_line1, $address_line2, $city, $p_number, $username, $email, $password);
            $stmtInsertUser->execute();

            session_start();
            $_SESSION['username'] = $username;

            $response = array();
            $response['usernameNotAvailable'] = false;
            header('Content-Type: application/json');
            echo json_encode($response);

        }else{
            echo 'Error occurred';

        }
    }

    $stmtInsertUser->close();

}else{
    echo 'Error occurred';
}

$con->close();
exit();

?>
