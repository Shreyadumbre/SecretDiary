<?php

    session_start();

    
        if (array_key_exists('content', $_POST)) {
              
        $link = mysqli_connect("shareddb-j.hosting.stackcp.net", "secretdiary-3935efb0", "0jhd1n62ha", "secretdiary-3935efb0");

        if(mysqli_connect_error()){
        
            die("Database connection error");
       }
            
            //$_SESSION['id']  = mysqli_insert_id();
            
            //$query = "UPDATE `users` SET `diary` = '".mysqli_real_escape_string($link, $_POST['content'])."' WHERE id = 32";
            
     $query = "UPDATE `users` SET `diary` = '".mysqli_real_escape_string($link, $_POST['content'])."' WHERE id = '".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT 1";
       
        mysqli_query($link, $query);
        
        }

?>

