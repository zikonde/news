<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 
if(!is_login()){ 
     echo "请您登录系统后，再访问该页面！"; 
     return; 
} 

include_once("functions/file_system.php"); 
if(empty($_POST)){ 
     $message = "上传的文件超过了php.ini中post_max_size选项限制的值"; 
}else{ 
     $user_id = $_SESSION["user_id"]; 
     $category_id = (isset($_POST["category_id"])? (intval($_POST["category_id"])>0?intval($_POST["category_id"]):1):1);
     if(isset($_POST["title"])&&isset($_POST["content"])){

        $title = htmlspecialchars(addslashes()); 
        $content = htmlspecialchars(addslashes($_POST["content"])); 
        $currentDate =  date("Y-m-d H:i:s"); 
        $clicked = 0; 
        $file_name = $_FILES["news_file"]["name"]; 
        $message = upload($_FILES["news_file"],"uploads"); 
        $sql = "insert into news 
               values(null,$user_id,$category_id,'$title','$content', '$currentDate',$clicked,'$file_name')"; 
        if($message=="文件上传成功！"||$message=="没有选择上传附件！"){ 
               include_once("functions/database.php"); 
               get_connection(); 
               $database_connection->query($sql); 
               close_connection();		 
        }
     }	 
} 
$message = urlencode($message);
header("Location:index.php?url=news_list.php&message=$message");  
?>