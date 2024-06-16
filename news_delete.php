<?php 
include_once("functions/is_login.php"); 
include_once("functions/url_navigator.php");
include_once("functions/get_url_parameters.php");

if(!is_admin()){ 
     include_once("error_pages/404.html"); 
     return; 
}else{
     include_once("functions/delete.php"); 

     var_dump($news_id);
     delete_news($news_id); 

     $message = "新闻及相关评论信息删除成功！"; 
     header("Location:".add_to_url(["message" => $message])); 
} 
?> 
<?php 
?> 