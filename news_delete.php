<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

if(!is_login()){ 
     echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
     return; 
}else{
     include_once("functions/database.php"); 
     $news_id = $_GET["news_id"]; 

     get_connection(); 
     mysqli_query($database_connection, "delete from review where news_id=$news_id"); 
     mysqli_query($database_connection, "delete from news where news_id=$news_id"); 
     close_connection(); 

     $message = "���ż����������Ϣɾ���ɹ���"; 
     header("Location:index.php?url=news_list.php&message=$message");
} 
?> 
<?php 
?> 