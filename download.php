<?php 
include_once("functions/is_login.php");
include_once("functions/file_system.php"); 
include_once("functions/url_navigator.php");
include_once("functions/get_url_parameters.php");

if(is_login()){ 
    if($file_name){ 
        download("uploads/","$file_name"); 
    }
}else{ 
    echo "请您登录系统后，再访问该页面！";
    header("location:".add_to_url(['message'=>"请先登录系统！"])); 
} 
?> 