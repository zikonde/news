<?php 
include_once("functions/database.php"); 
//��ʾ�ļ��ϴ���״̬��Ϣ 
if(isset($_GET["message"])){ 
     echo $_GET["message"]."<br/>"; 
} 
//�����ѯ�������ŵ�SQL��� 
$search_sql = "select * from news order by news_id desc"; 
//������ģ����ѯ��ȡ��ģ����ѯ�Ĺؼ���keyword 
$keyword = ""; 
if(isset($_GET["keyword"])){ 
     $keyword = $_GET["keyword"]; 
     //����ģ����ѯ���ŵ�SQL��� 
     $search_sql = "select * from news where title like '%$keyword%' or content like '%$keyword%' order by news_id desc"; 
} 
//�ṩ����ģ����ѯ��form�� 
?> 
<form action="news_list.php" method="get"> 
������ؼ��֣�<input type="text" name="keyword" value="<?php echo $keyword?>"> 
<input type="submit" value="����"> 
</form> 
<br/> 
<table> 
<?php 
get_connection(); 
//��ҳ��ʵ�� 
$page_size = 3; 
if(isset($_GET["page_current"])){ 
     $page_current = $_GET["page_current"]; 
}else{ 
     $page_current=1; 
} 
$start = ($page_current-1)*$page_size; 
$search_sql = "select * from news order by news_id desc limit $start,$page_size"; 
if(isset($_GET["keyword"])){ 
     $keyword = $_GET["keyword"]; 
     //����ģ����ѯ���ŵ�SQL��� 
     $search_sql = "select * from news where title like '%$keyword%' or content like '%$keyword%' order by news_id desc limit $start,$page_size"; 
} 
$result_set = mysql_query($search_sql); 
close_connection(); 
if(mysql_num_rows($result_set)==0){ 
     exit("���޼�¼��"); 
} 
while($row = mysql_fetch_array($result_set)){ 
?> 
<tr> 
<td> 
     	<a href="news_detail.php?news_id=<?php echo $row['news_id']?>"><?php echo $row ['title']?></a> 
</td> 
<td> 
     <a href="news_edit.php?news_id=<?php echo $row['news_id']?>">�༭</a> 
</td> 
<td> 
     <a href="news_delete.php?news_id=<?php echo $row['news_id']?>">ɾ��</a> 
</td> 
</tr> 
<?php 
} 
?> 
</table> 