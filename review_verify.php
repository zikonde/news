<?php 
include_once("functions/is_login.php"); 
include_once("functions/url_navigator.php");


session_start(); 
if(!is_admin()){ 
     echo "请您登录系统后，再访问该页面！"; 
     return; 
} 
?> 
<?php 
include_once("functions/database.php"); 
include_once("functions/get_url_parameters.php"); 

$sql = "update review set state='已审核' where review_id=$review_id"; 
get_connection(); 
$database_connection->query($sql); 
close_connection(); 
header("Location:".add_to_url()); 
?> 