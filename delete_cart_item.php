<?php

include("database.php");

if (isset($_POST['delete_item'])) {
    $username = $_POST['username'];
    $foodId = $_POST['food_id'];
    
    // Use prepared statements to prevent SQL injection
    $sql_to_delete = "DELETE FROM food_items_in_carts WHERE food_id = ? AND user_name = ?";
    
    $stmt = mysqli_prepare($conn, $sql_to_delete);
    
    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "ss", $foodId, $username);
    
    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
    
    mysqli_stmt_close($stmt);
}
?>
