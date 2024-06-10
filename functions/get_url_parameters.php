<?php

//╠Да©иЫцВ
$category_id = (isset($_GET["category_id"])?(intval($_GET["category_id"])?intval($_GET["category_id"]):""):"");
$keyword = addslashes(isset($_GET["keyword"])? $_GET["keyword"]:"");
$message = (isset($_GET["message"])?$_GET["message"]:"");
$news_id = isset($_GET["news_id"])? addslashes(intval($_GET["news_id"])):0; 
$page_current = (isset($_GET["page_current"])?(intval($_GET["page_current"])>0?intval($_GET["page_current"]):1):1); 
$page_size = (intval((isset($_GET["page_size"])? ($_GET["page_size"]>0?($_GET["page_size"]>50?50:$_GET["page_size"]):5):5)));
$review_id = intval(isset($_GET["review_id"])?$_GET["review_id"]:0); 
$start = ($page_current-1)*$page_size; 
$file_name = isset($_GET["attachment"])?$_GET["attachment"]:""; 

function get_url_parameters($parameter){
    return $_GET[$parameter];
}
?>