<?php 

if($_SERVER["PHP_SELF"] === "/logout.php"){
     header("location:../index.php");
 }else{
     include_once("functions/session_config.php"); 

     session_unset(); 

     if(isset($_COOKIE[session_name()])){ 
          setcookie(session_name(),session_id(), time()-10); 
     } 

     session_destroy(); 

     header("Location:index.php");
}
?> 