<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 
include_once("functions/url_navigator.php");


if(!is_admin()){ 
     include_once("error_pages/404.html"); 
     return; 
} else{
     include_once("functions/file_system.php"); 


     if(empty($_POST)){ 
          $message = "�ϴ����ļ�������php.ini��post_max_sizeѡ�����Ƶ�ֵ"; 
     }else{ 
          $user_id = $_SESSION["user_id"]; 
          $category_id = (isset($_POST["category_id"])? (intval($_POST["category_id"])>0?intval($_POST["category_id"]):1):1); 
          $title = addslashes(trim(isset($_POST["title"])?$_POST["title"]:"")); 
          $content = addslashes(trim(isset($_POST["content"])?$_POST["content"]:"")); 
          
          if(empty($title)||empty($content)){ 
               $message = "���ű�������ݲ���Ϊ�գ�";
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
               
               $message = upload($_FILES["attachment"],"uploads"); 

               $upload_err = $_FILES["thumbnail"]["error"];
               var_dump((!$upload_err)? upload($_FILES["thumbnail"],"images"): null); 

               
               $sql = "insert into news values(null, $user_id, $category_id, '$title', '$content', '$currentDate', $clicked, '$attachment_name','/images/$thumbnail_name');"; 

               if($message == "�ļ��ϴ��ɹ���" || $message == "û��ѡ���ϴ�������"){ 
                    include_once("functions/database.php"); 
                    get_connection(); 
                    $message = (($database_connection->query($sql))? "���ŷ����ɹ���":"���ŷ���ʧ�ܣ�"); 
                    
                    $result = $database_connection->query("select max(news_id) as news_id from news");
                    $news_id = mysqli_fetch_assoc($result)["news_id"];
                    if(!$upload_err){
                         $new_thumbnail_name = $news_id.$thumbnail_name;
                         $message = (($database_connection->query("UPDATE news set thumbnail = 'images/$new_thumbnail_name' where news_id = $news_id"))? "���ŷ����ɹ���":"���ŷ���ʧ�ܣ�");
                         rename("images/".$thumbnail_name, "images/".$new_thumbnail_name);
                    } 


                    close_connection();		 
               }
          }
     } 

     $message = urlencode($message);
     header("Location:".add_to_url(["message" => $message], "index.php"));  
}

?>