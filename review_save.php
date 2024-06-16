<?php 
include_once("functions/url_navigator.php");
include_once("functions/session_config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("functions/database.php"); 
    
    if(isset($_POST["news_id"])){
        
        $news_id = addslashes($_POST["news_id"]); 
        $content = addslashes($_POST["content"]); 

        if (empty($content)) {
            $url =  add_to_url(["message" => "评论内容不能为空！"]);
            header("Location: $url");
            return;
        } else {
            $currentDate = date("Y-m-d H:i:s"); 
            $ip = $_SERVER["REMOTE_ADDR"]; 
            $state = "未审核"; 
            $user_id = isset($_SESSION["user_id"])?$_SESSION["user_id"]:null;
    
            $sql = "insert into review values(null,$news_id,'$user_id','$content','$currentDate','$state','$ip')"; 
    
            get_connection(); 
            if($database_connection->query($sql)){
                $message = "该新闻的评论信息成功添加到数据库表中！"; 
            }else{
                $message = "失败！";
            } 
            
            close_connection(); 
    
            $url =  add_to_url(["message" => $message]);
            
            header("Location:$url");
        }
 
    }else{
        header("location:".add_to_url(["message" => "新闻编号不能为空！"]));
    } 
}else{
    header("location:index.php");
}
?> 