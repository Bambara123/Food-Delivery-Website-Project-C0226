<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'project';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {
    exit('Error connecting to the database ' . mysqli_connect_error());
}

if (!isset($_POST['f_name'], $_POST['l_name'], $_POST['shop_name'], $_POST['address_line1'], $_POST['city'], $_POST['p_number'], $_POST['username_s'], $_POST['password'], $_POST['email'])) {
    exit('Empty field(s)');
}

if (empty($_POST['f_name']) || empty($_POST['l_name']) || empty($_POST['shop_name']) || empty($_POST['address_line1']) || empty($_POST['city']) || empty($_POST['p_number']) || empty($_POST['username_s']) || empty($_POST['password']) || empty($_POST['email'])) {
    exit('Empty values');
}

// Check if the username exists or not.
if ($stmt = $con->prepare('SELECT id FROM shop_details WHERE username_s = ?')) {

    $username_s = strtolower($_POST['username_s']);

    $stmt->bind_param('s', $username_s);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username is not available, send a JSON response
        $response = array();
        $response['usernameNotAvailable'] = true;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Username is available, proceed with registration
        if ($stmt = $con->prepare('INSERT INTO shop_details (first_name, last_name, shopname, address_line1, address_line2, city, phone_number, username_s, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $f_name = strtolower($_POST['f_name']);
            $l_name = strtolower($_POST['l_name']);
            $shop_name = strtolower($_POST['shop_name']);
            $address_line1 = strtolower($_POST['address_line1']);
            $address_line2 = strtolower($_POST['address_line2']);
            $city = strtolower($_POST['city']);
            $p_number = $_POST['p_number'];  // No need to convert this to lowercase            
            $email = strtolower($_POST['email']);

            $stmt->bind_param('ssssssssss', $f_name, $l_name, $shop_name, $address_line1, $address_line2, $city, $p_number, $username_s, $email, $password);
            if ($stmt->execute()) {
                session_start();
                $_SESSION["username_s"] = $username_s;
               
                $response = array();
                $response['usernameNotAvailable'] = false;
                header('Content-Type: application/json');
                echo json_encode($response);
                
            } else {
                echo 'Error occurred while inserting into the database.';
            }
        } else {
            echo 'Error occurred while preparing the SQL statement.';
        }
    }
    $stmt->close();
} else {
    echo 'Error occurred while preparing the SQL statement.';
}

$con->close();
exit();
?>
