<?php 
if($_SERVER["PHP_SELF"] === "/functions/is_login.php"){
    header("location:../index.php");
}else{
     function is_login(){ 
          if(isset($_SESSION["user_id"])){ 
                    return TRUE; 
          }else{ 
                    return FALSE; 
          } 
     } 
}
?> 