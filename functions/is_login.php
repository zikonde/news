<?php 
if($_SERVER["PHP_SELF"] === "/functions/is_login.php"){
    header("location:../index.php");
}else{
     include_once("session_config.php");
     
     function is_login(){ 
          if(isset($_SESSION["user_id"])){ 
                    return TRUE; 
          }else{ 
                    return FALSE; 
          } 
     } 
     function is_admin(){ 
          if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){ 
                    return TRUE; 
          }else{ 
                    return FALSE; 
          } 
     }
}
?> 