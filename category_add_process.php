<?php 
include_once("functions/is_login.php"); 
if(!is_login()){ 
     echo "������¼���ڷ��ʸ�ҳ�棡"; 
     return; 
} 
?> 
<?php 
include_once("functions/database.php"); 
$new_category = $_POST["new_category"]; 
$new_description = $_POST["new_description"];  
$sql = "update category set new_category=$new_category,description=$new_description"; 
get_connection(); 
mysql_query($sql); 
close_connection(); 
header("Location:index.php?url=category_list.php"); 
?> 