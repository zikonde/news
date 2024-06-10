<?php
include_once("functions/database.php"); 
include_once("functions/url_navigator.php");
include_once("functions/get_url_parameters.php"); 
var_dump($_GET);    
if($news_id!==0){
     //¹¹Ôì3ÌõSQLÓï¾ä 
     $sql_news_update = "update news set clicked=clicked+1 where news_id=$news_id"; 
     
     get_connection(); 
     $database_connection -> query($sql_news_update); 
     close_connection(); 
}
// header("Location:".add_to_url([], "index.php"));

return; 