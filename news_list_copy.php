<?php 
include_once("functions/database.php"); 
include_once("functions/page.php"); 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

//��ʾ�ļ��ϴ���״̬��Ϣ 
if(isset($_GET["message"])){ 
     echo $_GET["message"]."<br/>"; 
} 

//������ģ����ѯ��ȡ��ģ����ѯ�Ĺؼ���keyword 
$keyword = ""; 

if(isset($_GET["keyword"])){ 
     $keyword = trim($_GET["keyword"]); 
} 
    //�����ѯ�������ŵ�SQL���
    //����ģ����ѯ���ŵ�SQL��� 
    $search_sql = "select * from news where title like '%$keyword%' or content like '%$keyword%' order by news_id desc"; 


//�ṩ����ģ����ѯ��form�� 
?> 
<form action="index.php?url=news_list.php" method="get" name = 'f1'>
������ؼ��֣�<input type="text" name="keyword" value="<?php echo $keyword?>"> 
<input type="submit" value="����"> 
<br/> 
<table> 
<?php 
get_connection(); 
//��ҳ��ʵ�� 
$result_news = $database_connection->query($search_sql); 
var_dump($result_news->fetch_array());
$total_records = $result_news->num_rows; 
$page_size = (isset($_GET["page_size"])? (intval($_GET["page_size"])>0?intval($_GET["page_size"]):3):3); 
if(isset($_GET["page_current"])){ 
     $page_current = $_GET["page_current"]; 
}else{ 
     $page_current=1; 
} 
$start = ($page_current-1)*$page_size; 
$search_sql = "select * from news order by news_id desc limit $start,$page_size"; 
if(isset($_GET["keyword"])){ 
     $keyword = trim($_GET["keyword"]);  
     //����ģ����ѯ���ŵ�SQL��� 
     $search_sql = "select * from news where title like '%$keyword%' or content like '%$keyword%' order by news_id desc limit $start,$page_size"; 
} 
$result_set = $database_connection->query($search_sql); 
close_connection(); 
if(mysqli_num_rows($result_set)==0){ 
    echo("���޼�¼��"); 
    //exit("���޼�¼��"); 
} 
while($row = mysqli_fetch_array($result_set)){ 
?> 
<tr> 
<td> 
     <a href="index.php?url=news_detail.php&keyword=<?php echo $keyword?>&news_id= <?php echo $row['news_id']?>"><?php echo mb_strcut($row['title'],0,40,"gbk")?></a> 
</td>
<?php 
if(is_login()){ 
?> 
<td> 
     <a href="index.php?url=news_edit.php&news_id=<?php echo $row['news_id']?>">�༭</a> 
</td> 
<td> 
     <a href="index.php?url=news_delete.php&news_id=<?php echo $row['news_id']?>" onclick="return confirm('ȷ��ɾ����');">ɾ��</a> 
</td> 
<?php 
} 
?> 
</tr> 
<?php 
} 
?> 
    </table> 
<?php 
//��ӡ��ҳ������
$url = $_SERVER["REQUEST_URI"]; 
page($total_records,$page_size,$page_current,$url,$keyword); 
?> 

</form> 