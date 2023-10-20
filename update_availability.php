<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("database.php"); // Include your database connection code
    
    $food_id = $_POST['food_id'];
    $isAvailable = $_POST['isAvailable'];
    
    // Update the database based on the food_id and isAvailable status
    $update_query = "UPDATE menu SET available = $isAvailable WHERE food_id = $food_id";
    
    if (mysqli_query($conn, $update_query)) {
        echo "Food availability updated successfully.";
    } else {
        echo "Error updating food availability: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}
?>
