<?php
include_once("functions/database.php"); 
include_once("functions/url_navigator.php");
include_once("functions/get_url_parameters.php"); 

if($_SERVER["REQUEST_METHOD"] == "POST"){
     if($news_id!==0){
          //����3��SQL��� 
          $sql_news_update = "update news set clicked=clicked+1 where news_id=$news_id"; 
          
          $database_connectio = get_connection(); 
          $database_connection -> query($sql_news_update); 
          close_connection(); 
     }
     // header("Location:".add_to_url([], "index.php"));

     return; 
}else{
     header("Location:".add_to_url([], "index.php"));
}