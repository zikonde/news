<?php 
include_once("functions/is_login.php");
include_once("functions/session_config.php"); 

if(!is_login()){ 
     echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
     return; 
}else{
     include_once("functions/database.php"); 
     $news_id = $_POST["news_id"]; 
     $category_id = $_POST["category_id"]; 
     $title = $_POST["title"]; 
     $content = $_POST["content"]; 

     $sql = "update news set category_id = $category_id, title = '$title', content = '$content' where news_id = $news_id"; 

     get_connection(); 
     $res = mysqli_query($database_connection, $sql); 
     var_dump($res);
     close_connection(); 
     
     $message = "������Ϣ�޸ĳɹ���"; 
     
     header("Location:index.php?url=news_list.php&message=$message"); 
}?> 