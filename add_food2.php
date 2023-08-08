<?php

    session_start();

    if(isset($_POST["submit"]) && isset($_POST["food_name"]) && isset($_POST["price"]) && isset($_FILES["image"])){
        
        // printing the image details.    
        echo "<pre>";
        print_r($_FILES["image"]);
        echo "</pre>";

        // Process the image.
        $img_name = $_FILES["image"]["name"];
        $img_size = $_FILES["image"]["size"];
        $tmp_name = $_FILES["image"]["tmp_name"];
        $error = $_FILES["image"]["error"];
       
        if($error === 0){

            if($img_size > 125000000){
                $em = "Sorry the file is to large.";
                header("Location: add_food.html ? error = $em");

            }else{
                
                // getting know the type of the file.
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);

                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "png", "jpeg");
                echo($img_ex);                

                if(in_array($img_ex_lc, $allowed_exs)){

                    include("database.php");

                    // make unique name and upload into uploads folder.
                    $new_image_name = uniqid("IMG-", true).".".$img_ex_lc;
                    $img_upload_path = 'upload/'.$new_image_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $food_name = $_POST['food_name'];
                    $price = $_POST["price"];
                    $shop_name = $_SESSION["shopname"];
                    
                    //Insert into database.
                    $sql = "INSERT INTO menu(shop_name, food, price, image) 
                            VALUES ( '$shop_name','$food_name' , '$price' ,'$new_image_name')";

                    
                    mysqli_query($conn, $sql);
                    header("Location: add_food2.html");                    

                }else{
                    $em = "You cannot upload files of this type.";
                    
                    header("Location: add_food2.php?error=$em");

                }

            }

        }else{
            echo "Unknown error occured!";
            header("Location: add_food2.html");   

        }

    }else{
        header("Location: add_food2.html");

    }

?>