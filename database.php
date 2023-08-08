<?php 

$hostname = "localhost";
$uname = "root";
$password = '';

$db_name = "project";

$conn = mysqli_connect($hostname, $uname, $password, $db_name);

if(!$conn){

    echo "Connection failed!";
    exit();
}

?>