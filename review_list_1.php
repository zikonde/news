<?php 
include_once("functions/database.php"); 
$sql = "select * from review order by review_id desc"; 
; 
$result_set = mysqli_query(get_connection(),$sql); 
close_connection(); 
echo "ϵͳ����������Ϣ���£�<br/>"; 
while($row = mysqli_fetch_array($result_set)){ 
     echo "�������ݣ�".$row["content"]."<br/>"; 
     echo "���ڣ�".$row["publish_time"]."&nbsp;&nbsp;"; 
     echo "IP��ַ��".$row["ip"]."&nbsp;&nbsp;"; 
     echo "״̬��".$row["state"]."<br/>"; 
     echo "<a href='review_delete.php?review_id=".$row["review_id"]."'>ɾ��</a>"; 
     echo "&nbsp;&nbsp;&nbsp;"; 
     if($row["state"]=="δ���"){ 
     		echo "<a href='review_verify.php?review_id=".$row["review_id"]."'>���</a>"; 
     } 
     echo "<hr/>"; 
} 
?> 