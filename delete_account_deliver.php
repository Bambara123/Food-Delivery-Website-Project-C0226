<?php

    session_start();
    $username_d = $_SESSION['username_d'];

    include("database.php");

    function processLogin($username, $password, $conn) {
        // Prepare and bind the SELECT statement
        $stmt = $conn->prepare("SELECT * FROM deliverymen_details WHERE username_d = ?");
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
        if(processLogin($username_d, $password, $conn)){

            $sql_delete = "DELETE FROM deliverymen_details WHERE username_d = '$username_d'";
            mysqli_query($conn, $sql_delete);

            header("Location: index2.html");
            
        }
    }

    // Close the database connection
    $conn->close();

?>