<?php 
include_once("functions/database.php"); 
$news_id = $_GET["news_id"]; 
$sql = "select * from review where news_id=$news_id and state='�����' order by review_id desc"; 
get_connection(); 
$result_set = $database_connection->query($sql); 
close_connection(); 
echo "�����ŵ��������£�<br/>"; 
while($row = $result_set->fetch_array()){ 
     echo "�������ݣ�".$row["content"]."<br/>"; 
     echo "�������ڣ�".$row["publish_time"]."<br/>"; 
     echo "����IP��ַ��".$row["ip"]."<hr/>"; 
} 
?> 