<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

if(!is_login()){ 
     echo "请您登录系统后，再访问该页面！"; 
     return; 
}else{
     include_once("functions/database.php"); 
     $news_id = $_GET["news_id"]; 

     get_connection(); 
     mysqli_query($database_connection, "delete from review where news_id=$news_id"); 
     mysqli_query($database_connection, "delete from news where news_id=$news_id"); 
     close_connection(); 

     $message = "新闻及相关评论信息删除成功！"; 
     header("Location:index.php?url=news_list.php&message=$message");
} 
?> 
<?php 
?> 