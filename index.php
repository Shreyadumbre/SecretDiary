<?php

   session_start();

    $error = "";

    if(array_key_exists("logout",$_GET)){
        
       unset($_SESSION);
        setcookie("id","",time() - 60*60);
       $_COOKIE["id"]="";
        
    } else if((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id']))
    {
        header("Location: login.php");
        
   }

    
    
    if(array_key_exists("submit",$_POST)){
        
        $link = mysqli_connect("shareddb-j.hosting.stackcp.net", "secretdiary-3935efb0", "0jhd1n62ha", "secretdiary-3935efb0");

        if(mysqli_connect_error()){
        
            die("Database connection error");
        }
        
        if(!$_POST['email']){
            
            $error .= "Please Enter an Email.<br>";
        }
        
        if(!$_POST['password']){
            
             $error .= "Please Enter a Password.<br>";
        }
        if($error != ""){
            
            $error = "<p>There were error(s) in the form: <p>".$error ;
        } 
        
        else {
            if($_POST['signup'] == '1'){
            
            $query = "select id from `users` where email = '".mysqli_real_escape_string($link, $_POST["email"])."'limit 1 ";
            
            $result =  mysqli_query($link, $query);
            
            if(mysqli_num_rows($result)>0){
                
                $error = "This Email is already taken.<br>";
            }else{
                
                $query = "insert into `users` (`email`,`password`) values 
               ( '".mysqli_real_escape_string($link, $_POST["email"])."',
                 '".mysqli_real_escape_string($link, $_POST["password"])."')";
                
               if(!mysqli_query($link,$query)){
                   
                   $error = "<p>Could not sign you up! Please try again.<p>";
               }else{
                   
                   $query = "update `users` 
                            set password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."'
                            where id = ".mysqli_insert_id($link)." limit 1";
                            
                            mysqli_query($link,$query);
                   
                            $_SESSION['id'] = mysqli_insert_id($link);

                            if(isset($_POST['stayloggedin']) == '1'){
                                
                                setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);
                            }
                   
                            header("Location: login.php");    
               } 
                
            }
            
        }
            else{
                
                 $query = "select * from `users` where email = '".mysqli_real_escape_string($link, $_POST["email"])."'";
                
                $result =  mysqli_query($link, $query);
                
                $row = mysqli_fetch_array($result);
                
                if(isset($row))
                {
                    $hashedpassword = md5(md5($row['id']).$_POST['password']);
                    
                    if($hashedpassword == $row['password']){
                        
                        isset($_SESSION['id']) == $row['id'];
                        
                        if(isset($_POST['stayloggedin']) == '1'){
                            
                            setcookie("id", $row['id'], time() + 60*60*24*365);
                        }
                        header("Location: login.php");  
                        
                    }
                    else{
                    
                    echo "Email/Password cannot be found. Sign Up first!";
                }
                    
                }
                 else{
                    
                    echo "Email/Password cannot be found. Sign Up first!";
                }
            }
        }
    }

?>




<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css?family=Walter+Turncoat" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Luckiest+Guy" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" rel="stylesheet">
    <title>Secret Diary</title>
      
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
                 color: white;
          }
          
          .container{
              
              text-align: center;
              margin-top: 50px;
              width: 400px;
          }
          #login{
              
              color: white;
          }
          h1{
              text-align: center;
              font-family: 'Love Ya Like A Sister', cursive;
              color: white;
              font-size: 90px;
          }
          #email, #password{
              
             /*background: transparent;*/
              border: 2px solid white;
          }
          
          
         .form-control::-webkit-input-placeholder { 
             
             color: white;
             font-size: 25px;
          } 

          h3{
              text-align: center;
              color: white;
              font-family: 'Love Ya Like A Sister', cursive;
              font-size: 35px;
              margin-top: 30px;
              font-weight: bolder;
              
          }
          .error{
              text-align: center;
              color: white;
          }
          
          #loginform{
              
              display: none;
          }
          a:hover {
               cursor: pointer;
              
            }
          .toggleforms{
              
              font-weight: bold;
              color: white;
          }
         
        </style>
  </head>
  <body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
       <h1>Secret Diary</h1>
      <h3>Store your thoughts permanently and securely</h3>
      <h3>Interested? Sign Up!</h3>
       
      <div class="container">
          <div id="error"><?php if ($error!="") {
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
} ?></div>
      <form method="post" id="signupform">
          <fieldset class="form-group">
            <input type="email" name="email" class="form-control" id="email" placeholder="Your Email">
          </fieldset>
           <fieldset class="form-group"> 
    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
          </fieldset>
            <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1" name="Stayloggedin" value="1">Stay Logged In</label>
          </div>
            <fieldset class="form-group">
    <input type="hidden" name="signup" value="1">
          </fieldset>
            <fieldset class="form-group">
    <input type="submit" name="submit" class="btn btn-primary" value="Sign Up!">
          </fieldset>
          <p><a class="toggleforms" >Log In!</a></p>

</form>

<form method="post" id="loginform">
  <fieldset class="form-group">
    <input type="email" name="email" class="form-control" id="email" placeholder="Your Email">
    </fieldset>
      <fieldset class="form-group">
    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
    </fieldset>
     <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1" name="Stayloggedin" value="1">Stay Logged In</label>
          </div>
      <fieldset class="form-group">
    <input type="hidden" name="signup" value="0">
    </fieldset>
      <fieldset class="form-group">
    <input type="submit" name="submit" class="btn btn-primary" value="Log In!">
    </fieldset>
    <p><a class="toggleforms" >Sign Up!</a></p>
</form> 
      </div>
      
      <script type="text/javascript">
      
            $(".toggleforms").click(function(){
                
              $("#signupform").toggle();
               $("#loginform").toggle();
                
                
            });
      
      
      
      </script>
  </body>
</html>