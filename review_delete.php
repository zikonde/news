<?php 
include_once("functions/is_login.php"); 
include_once("functions/url_navigator.php");
include_once("functions/get_url_parameters.php"); 

if(!is_admin()){ 
     echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
     return; 
}else{
     include_once("functions/delete.php"); 

     delete_review($review_id);
     
     //header("Location:".add_to_url()); 
} 
?> 