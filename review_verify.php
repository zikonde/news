<?php 
include_once("functions/is_login.php"); 
include_once("functions/url_navigator.php");


session_start(); 
if(!is_admin()){ 
     echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
     return; 
} 
?> 
<?php 
include_once("functions/database.php"); 
include_once("functions/get_url_parameters.php"); 

$sql = "update review set state='�����' where review_id=$review_id"; 
get_connection(); 
$database_connection->query($sql); 
close_connection(); 
header("Location:".add_to_url()); 
?> 