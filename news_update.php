<?php 
include_once("functions/is_login.php");
include_once("functions/session_config.php"); 
include_once("functions/url_navigator.php");

if(!is_admin()){ 
     echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
}else{
     include_once("functions/file_system.php"); 

     $news_id = intval(isset($_POST["news_id"])?$_POST["news_id"]:0); 
     $category_id = intval(isset($_POST["category_id"])?$_POST["category_id"]:0); 
     $title = addslashes(trim(isset($_POST["title"])?$_POST["title"]:"")); 
     $content = addslashes(trim(isset($_POST["content"])?$_POST["content"]:"")); 
     $message = false;


     if(empty($title)||empty($content)){ 
          $message = "���ű�������ݲ���Ϊ�գ�";
          header("Location:".add_to_url(["message" => $message]));
          return;
     }else{
          $attachment_name = isset($_FILES["attachment"]["name"])&&$_FILES["attachment"]["error"] == 0?$_FILES["attachment"]["name"]:"";
          $available_attchment = addslashes(trim(isset($_POST["available_attchment"])?$_POST["available_attchment"]:""));
          $thumbnail_name = "";
          if(isset($_FILES["thumbnail"]["name"])&&$_FILES["thumbnail"]["error"] == 0){
               $_FILES["thumbnail"]["name"] = $news_id."_".date("YmdHis").rand(100,999).substr($_FILES["thumbnail"]["name"],strrpos($_FILES["thumbnail"]["name"],"."));
               $thumbnail_name = "/images/".$_FILES["thumbnail"]["name"];
          }

          $available_thumbnail = addslashes(trim(isset($_POST["available_thumbnail"])?$_POST["available_thumbnail"]:""));

          if(!is_dir("uploads")) mkdir("uploads");
          if(!is_dir("images")) mkdir("images");

          if($attachment_name != $available_attchment && $attachment_name != ""){
               if(!is_dir("uploads/deleted")) mkdir("uploads/deleted");
               $message = upload($_FILES["attachment"],"uploads"); 
               // is_file("uploads/$available_attchment")? rename("uploads/$available_attchment","uploads/deleted/$available_attchment"):null;
          }
          if($thumbnail_name != $available_thumbnail && $thumbnail_name != ""){
               upload($_FILES["thumbnail"],"images"); 
          }


          $sql = "UPDATE news set category_id = $category_id, title = '$title', content = '$content', attachment = '".($attachment_name?$attachment_name:$available_attchment)."', thumbnail = '".($thumbnail_name?$thumbnail_name:$available_thumbnail)."' where news_id = $news_id"; 
          
          // $sql = "insert into news values(null, $user_id, $category_id, '$title', '$content', '$currentDate', $clicked, '$attachment_name','/images/$thumbnail_name');"; 

          if(!$message || $message == "�ļ��ϴ��ɹ���" || $message == "û��ѡ���ϴ�������" ){ 
               include_once("functions/database.php"); 
               get_connection(); 
               $message = ($database_connection->query($sql))? "�����޸ĳɹ���":"�����޸�ʧ�ܣ�";
               close_connection();		 
          }
     }
     
     header("Location:".add_to_url(["message" => $message]));
}?> 