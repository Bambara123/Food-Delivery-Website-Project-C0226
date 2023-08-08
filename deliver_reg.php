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

if(!isset($_POST['username_d'], $_POST['password'], $_POST['email'])){
    exit('Empty field(s)');

}

if(empty($_POST['username_d']) || empty($_POST['password']) || empty($_POST['email'])){
    exit('Empty values');

}


if($stmt = $con ->prepare('SELECT id, password FROM deliverymen_details WHERE username_d = ?')){
    $stmt-> bind_param('s', $_POST['username_d']);
    $stmt-> execute();
    $stmt-> store_result();

    if($stmt-> num_rows > 0){
        echo 'username_d already exist';

    }else{
        if($stmt = $con-> prepare('INSERT INTO deliverymen_details (username_d, email, password, city) VALUES (?, ? ,?, ?)')){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT) ;
            $stmt->bind_param('ssss', $_POST['username_d'], $_POST['email'], $password, $_POST['city']);
            $stmt->execute();

            echo 'Successfully registered!';
            // Redirect to the desired webpage
            header("Location: deliver_home.html");

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
