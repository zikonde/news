<?php 
include_once("functions/database.php"); 
if(isset($_POST["news_id"])){
    $news_id = $_POST["news_id"]; 
    $content = htmlspecialchars(addslashes($_POST["content"]));
    //$content = addslashes($_POST["content"]); 
    echo $content;
    $currentDate = date("Y-m-d H:i:s"); 
    $ip = $_SERVER["REMOTE_ADDR"]; 
    $state = "未审核"; 
    $sql = "insert into review values(null,$news_id,'$content','$currentDate','$state','$ip')"; 
    get_connection(); 
    $database_connection->query($sql); 
    $b = $database_connection->query("select* from review");
    while($a = $b->fetch_array())print_r($b->fetch_assoc());
    close_connection(); 
    $message = "该新闻的评论信息成功添加到数据库表中！"; 
    //header("Location:index.php?url=news_list.php&message=$message"); 
}else{
    header("location:index.php");
} 
?> 