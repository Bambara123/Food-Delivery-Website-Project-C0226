<?php

    session_start();
    $username_s = $_SESSION['username_s'];

    include("database.php");

    function processLogin($username, $password, $conn) {
        // Prepare and bind the SELECT statement
        $stmt = $conn->prepare("SELECT * FROM shop_details WHERE username_s = ?");
        $stmt->bind_param("s", $username);
    
        // Execute the statement
        $stmt->execute();
    
        // Get the result
        $result = $stmt->get_result();
    
        // Check if a row is returned
        if ($result->num_rows > 0) {
            // Fetch the row data
            $row = $result->fetch_assoc();
    
    
            // Verify the password
            if (password_verify($password, $row['Password'])) {
                echo "Login successful!";
                return true;
    
                
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "Username not found!";
        }
    
        // Close the statement
        $stmt->close();
        return false;
    }

    // Check if the login form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $password = $_POST["password"];

        // Process the login
        if(processLogin($username_s, $password, $conn)){

            $sql_delete = "DELETE FROM shop_details WHERE username_s = '$username_s'";
            mysqli_query($conn, $sql_delete);

            header("Location: index2.html");
            
        }
    }

    // Close the database connection
    $conn->close();

?>