<?php

session_start();

$diarycontent = "";

if (array_key_exists("id", $_COOKIE) && $_COOKIE ['id']) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION)) {
              
       $link = mysqli_connect("shareddb-j.hosting.stackcp.net", "secretdiary-3935efb0", "0jhd1n62ha", "secretdiary-3935efb0");

        if(mysqli_connect_error()){
        
            die("Database connection error");
        }
      
           // echo "<p>Logged In! <a href='diary.php?logout=1'>Logout</a></p>";
        
            $query = "select `diary` from `users` where id = '".mysqli_real_escape_string($link,$_SESSION['id'])."' limit 1";
        
           $row = mysqli_fetch_array(mysqli_query($link, $query));
        
        $diarycontent = $row['diary'];
      
    } else {
        
        header("Location: index.php");
        
    }

?>

<html lang="en">
<head>
    <title>Your Diary</title>
     <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <style>
    
        html { 
              background: url("img4.jpg") no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
            }
    
        body{
            background: none;
            
        }
    
        #diary{
            
            width: 100%;
            height: 100%;
            
        }
        h3{
            color: white;
        }
        h4{
            text-align: right;
            font-weight: bolder;
        }
        ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #f3f3f3;
}

li {
  float: left;
}

li a {
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  font-size: 20px;
  text-decoration: none;
}

.active {
  background-color: #4CAF50;
}
        #containerloginpage{
            
            margin-top: 40px;
        }
        
        button{
            font-size: 28px;
        }
    </style>

    
    </head>
<body>
    
    <ul>
  <li><a href="#">Welcome to you Secret Diary!</a></li>
  <li style="float:right"><a href ='index.php?logout=1'>
        <button class="btn btn-success-outline" type="submit">Logout</button></a></li>
</ul>

    
    <div class="container-fluid" id="containerloginpage">
    
        <div class="form-group">
            <textarea class="form-control" placeholder="Start writing here..." id="diary"><?php echo $diarycontent; ?></textarea>
        </div>
    
    
    </div> 
    <script type="text/javascript">
    
        $('#diary').bind('input propertychange', function() {

             $.ajax({
                  method: "POST",
                  url: "updatedatabase.php",
                  data: { content: $("#diary").val() }
                 });  
            });
    
    
    </script>
    
    </body>


</html>