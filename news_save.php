<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 
include_once("url_navigator.php");


if(!is_login()){ 
     echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
     return; 
} else{
     include_once("functions/file_system.php"); 


     if(empty($_POST)){ 
          $message = "�ϴ����ļ�������php.ini��post_max_sizeѡ�����Ƶ�ֵ"; 
     }else{ 
          $user_id = $_SESSION["user_id"]; 
          $category_id = (isset($_POST["category_id"])? (intval($_POST["category_id"])>0?intval($_POST["category_id"]):1):1);
          $title = isset($_POST["title"])?addslashes(trim($_POST["title"])):""; 
          $content = isset($_POST["content"])?addslashes(trim($_POST["content"])):""; 
          
          if(empty($title)||empty($content)){ 
               $message = "���ű�������ݲ���Ϊ�գ�";
               header("Location:".add_to_url(["message" => $message]));
               return;
          }else{
               $currentDate =  date("Y-m-d H:i:s"); 
               $clicked = 0; 
               $file_name = $_FILES["news_file"]["name"]; 
               $message = upload($_FILES["news_file"],"uploads"); #revisit this

               $sql = "insert into news values(null, $user_id, $category_id, '$title', '$content', '$currentDate', $clicked, '$file_name');"; 

               if($message == "�ļ��ϴ��ɹ���" || $message == "û��ѡ���ϴ�������"){ 
                         include_once("functions/database.php"); 
                         get_connection(); 
                         $database_connection->query($sql); 
                         close_connection();		 
               }
          }
     } 

     $message = urlencode($message);
     header("Location:".add_to_url(["message" => $message], $url = "index.php"));  
}

?>