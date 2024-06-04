<?php
include_once("functions/database.php"); 
include_once("url_navigator.php");

$news_id = isset($_GET["news_id"])? intval(addslashes($_GET["news_id"])): 0; 

if($news_id!==0){
     //¹¹Ôì3ÌõSQLÓï¾ä 
     $sql_news_update = "update news set clicked=clicked+1 where news_id=$news_id"; 
     
     get_connection(); 
     $database_connection -> query($sql_news_update); 
     close_connection(); 
}
header("Location:".add_to_url([], "index.php"));

return; 