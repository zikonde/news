<?php 
if (!$_SERVER["REQUEST_METHOD"] == "POST") {
     header("Location:index.php");
}else{
     // if($_SERVER["PHP_SELF"] === "/login_process.php"){
     //      header("location:../index.php");
     // }
          
     include_once("functions/session_config.php"); 
     include_once("functions/database.php"); 
     include_once("functions/url_navigator.php");

     $name = addslashes($_POST["name"]);
     $input_password = addslashes($_POST["password"]); 

     if($_POST["checknum"] != $_SESSION["checknum"]){
          header("Location:index.php?login_message=checknum_error"); 
          return;
     }else{
          if(isset($_COOKIE["name"]) && $_COOKIE["name"] == $name) {
               if(isset($_COOKIE["password"])){ 
                    $first_password = $_COOKIE["password"]; 
               }else{ 
                    $first_password = md5($input_password); 
               } 
          }else{  
               setcookie("password",$first_password,time()-1); 
               $first_password = md5($input_password);
          }

          if(empty($_POST["expire"])){ 
               setcookie("name",$name,time()-1); 
               setcookie("password",$first_password,time()-1); 
          }else{ 
               $expire = time()+intval($_POST["expire"]); 
               setcookie("name",$name,$expire); 
          }  

          get_connection(); 
          $password = md5($first_password);
          $sql = "select * from users where (name = '$name' or email = '$name') and password ='$password'";
          $result_set = $database_connection->query($sql); 

          if($result_set->num_rows>0){ 
               setcookie("password",$first_password,$expire); 
               
               $admin = $result_set->fetch_assoc(); 
               $_SESSION['user_id'] = $admin['user_id']; 
               $_SESSION['role'] = $admin['role']; 
               $_SESSION['name'] = $admin['name'];
               
               header("Location:".add_to_url(["login_message"=>"password_right"]));
          }else{ 
               header("Location:".add_to_url(["login_message"=>"password_error"]));
          } 
          close_connection(); 
     }
}

?> 