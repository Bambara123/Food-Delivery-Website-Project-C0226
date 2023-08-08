<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "project";

// Create a new mysqli instance
$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to validate and process the login
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
    $username = $_POST["username_d"];
    $password = $_POST["password"];

    // Process the login
    if(processLogin($username, $password, $conn)){
        header("Location: deliver_home.html");
        
    }
}

// Close the database connection
$conn->close();
?>

