<?php 
include_once("functions/url_navigator.php");
include_once("functions/session_config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("functions/database.php"); 
    
    if(isset($_POST["news_id"])){
        
        $news_id = addslashes($_POST["news_id"]); 
        $content = addslashes($_POST["content"]); 

        if (empty($content)) {
            $url =  add_to_url(["message" => "�������ݲ���Ϊ�գ�"]);
            header("Location: $url");
            return;
        } else {
            $currentDate = date("Y-m-d H:i:s"); 
            $ip = $_SERVER["REMOTE_ADDR"]; 
            $state = "δ���"; 
            $user_id = isset($_SESSION["user_id"])?$_SESSION["user_id"]:null;
    
            $sql = "insert into review values(null,$news_id,'$user_id','$content','$currentDate','$state','$ip')"; 
    
            get_connection(); 
            if($database_connection->query($sql)){
                $message = "�����ŵ�������Ϣ�ɹ���ӵ����ݿ���У�"; 
            }else{
                $message = "ʧ�ܣ�";
            } 
            
            close_connection(); 
    
            $url =  add_to_url(["message" => $message]);
            
            header("Location:$url");
        }
 
    }else{
        header("location:".add_to_url(["message" => "���ű�Ų���Ϊ�գ�"]));
    } 
}else{
    header("location:index.php");
}
?> 