<?php 
include_once("url_navigator.php");
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
    
            $sql = "insert into review values(null,$news_id,'$content','$currentDate','$state','$ip')"; 
    
            get_connection(); 
            $database_connection->query($sql); 
            close_connection(); 
    
            $message = "�����ŵ�������Ϣ�ɹ���ӵ����ݿ���У�"; 
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