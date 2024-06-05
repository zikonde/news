<?php 
if($_SERVER["PHP_SELF"] === "/functions/is_login.php"){
    header("location:../index.php");
}else{
     include_once("session_config.php");
     
     function is_login(){ 
          if(is_admin()){
               return TRUE; 
          }else{ 
               if(isset($_SESSION["user_id"])){ 
                    return TRUE; 
               }else{ 
                    return FALSE; 
               } 
          } 
     } 

     function is_admin(){ 
          if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){ 
                    return TRUE; 
          }else{ 
                    return FALSE; 
          } 
     }
     
     function creator_access($user_id){ 
          if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){ 
                    return TRUE; 
          }else{ 
               if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $user_id){ 
                         return TRUE;
               }else{ 
                         return FALSE; 
               }
          } 
     }
}
?> 