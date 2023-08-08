<?php

session_start();

include('database.php');

// Function to validate and process the login
function processLogin($username, $password, $conn) {
    // Prepare and bind the SELECT statement
    $stmt = $conn->prepare("SELECT * FROM customer_details WHERE username = ?");
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
        if (password_verify($password, $row['password'])) {
            echo "Login successful!";
            // Continue with further processing or redirect to a dashboard page
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
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // to pass for next page
    $_SESSION["user_name"] = $username;

    // Process the login
    if(processLogin($username, $password, $conn)){
        header("Location: customer_home.php");
        
    }
}

// Close the database connection
$conn->close();
?>

