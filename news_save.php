<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 
include_once("url_navigator.php");


if(!is_admin()){ 
     echo "请您登录系统后，再访问该页面！"; 
     return; 
} else{
     include_once("functions/file_system.php"); 


     if(empty($_POST)){ 
          $message = "上传的文件超过了php.ini中post_max_size选项限制的值"; 
     }else{ 
          $user_id = $_SESSION["user_id"]; 
          $category_id = (isset($_POST["category_id"])? (intval($_POST["category_id"])>0?intval($_POST["category_id"]):1):1); 
          $title = addslashes(trim(isset($_POST["title"])?$_POST["title"]:"")); 
          $content = addslashes(trim(isset($_POST["content"])?$_POST["content"]:"")); 
          
          if(empty($title)||empty($content)){ 
               $message = "新闻标题或内容不能为空！";
               header("Location:".add_to_url(["message" => $message]));
               return;
          }else{
               $currentDate =  date("Y-m-d H:i:s"); 
               $clicked = 0; 
               $attachment_name = isset($_FILES["attachment"]["name"])&&$_FILES["attachment"]["error"] == 0?$_FILES["attachment"]["name"]:"";
               $thumbnail_name = "thumbnail.jpg";
               if(isset($_FILES["thumbnail"]["name"])&&$_FILES["thumbnail"]["error"] == 0){
                    $_FILES["thumbnail"]["name"] = "_".date("YmdHis").rand(100,999).substr($_FILES["thumbnail"]["name"],strrpos($_FILES["thumbnail"]["name"],"."));
                    $thumbnail_name = $_FILES["thumbnail"]["name"];
               }
               
               // if{
               //      $thumbnail_name = ";
               // }
               
               
               if(is_dir("uploads") == false) mkdir("uploads");
               if(is_dir("images") == false) mkdir("images");
               
               $message = upload($_FILES["attachment"],"uploads"); #revisit this
               upload($_FILES["thumbnail"],"images"); #revisit this

               $sql = "insert into news values(null, $user_id, $category_id, '$title', '$content', '$currentDate', $clicked, '$attachment_name','$thumbnail_name');"; 

               if($message == "文件上传成功！" || $message == "没有选择上传附件！"){ 
                    include_once("functions/database.php"); 
                    get_connection(); 
                    $database_connection->query($sql); 
                    
                    $result = $database_connection->query("select max(news_id) as news_id from news");
                    $news_id = mysqli_fetch_assoc($result)["news_id"];
                    $new_thumbnail_name = $news_id.$_FILES["thumbnail"]["name"];

                    $message = (($database_connection->query("UPDATE news set thumbnail = 'images/$new_thumbnail_name' where news_id = $news_id"))? "新闻发布成功！":"新闻发布失败！");
                    rename("images/".$thumbnail_name, "images/".$new_thumbnail_name);

                    close_connection();		 
               }
          }
     } 

     $message = urlencode($message);
     header("Location:".add_to_url(["message" => $message], "index.php"));  
}

?>