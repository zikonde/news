<?php 
include_once("functions/database.php"); 
$news_id = $_GET["news_id"]; 
//����3��SQL��� 
$sql_news_update = "update news set clicked=clicked+1 where news_id=$news_id"; 
$sql_news_detail = "select * from news where news_id=$news_id"; 
$sql_review_query = "select * from review where news_id=$news_id and state='�����'"; 
//ִ��3��SQL��� 
get_connection(); 
$database_connection->query($sql_news_update); 
$result_news = $database_connection->query($sql_news_detail); 
$result_review = $database_connection->query($sql_review_query); 
//ȡ����������������� 
$count_news = ($result_news instanceof mysqli_result? $result_news->num_rows:0); 
//ȡ��������и�����"�����"���������� 
$count_review = ($result_review instanceof mysqli_result? $result_review->num_rows:0);
if($count_news==0){ 
     echo "�����Ų����ڻ��ѱ�ɾ����"; 
     exit; 
} 
//����������Ϣ�е�user_id��ѯ��Ӧ���û���Ϣ 
$news =$result_news->fetch_array(); 
$user_id = $news["user_id"]; 
$sql_user = "select name from users where user_id=$user_id"; 
$result_user = $database_connection->query($sql_user); 
$user = ($result_user instanceof mysqli_result? $result_user->fetch_array():["name"=>"δ֪"]);

//����������Ϣ�е�category_id��ѯ��Ӧ�����������Ϣ 
$category_id = $news["category_id"]; 
$sql_category = "select name from category where category_id=$category_id"; 
$result_category =$database_connection->query($sql_category); 
$category = ($result_category instanceof mysqli_result? $result_category->fetch_array():["name"=>"����"]);

close_connection(); 

if($result_user instanceof mysqli_result)$result_user->free_result(); 
if($result_category instanceof mysqli_result)$result_category->free_result(); 
if($result_news instanceof mysqli_result)$result_news->free_result(); 
if($result_review instanceof mysqli_result)$result_review->free_result(); 

$title = $news['title']; 
$content = $news['content']; 
if(isset($_GET["keyword"])){ 
     $keyword = $_GET["keyword"]; 
     $replacement = "<b><i>".$keyword."</b></i>"; 
     $title = str_replace($keyword,$replacement,$title); 
     $content = str_replace($keyword,$replacement,$content); 
} 

//��ʾ������ϸ��Ϣ 
?> 
<table> 
<tr><td width="80">���⣺</td><td><?php echo $title;?></td></tr> 
<tr><td width="80">���ݣ�</td><td><?php echo $content;?></td></tr> 
<tr><td width="80">������</td><td><a href="download.php?attachment=<?php echo urlencode($news['attachment']);?>"><?php echo $news['attachment'];?></a></td></tr> 
<tr><td width="80">�����ߣ�</td><td><?php echo $user['name'];?></td></tr> 
<tr><td width="80">���</td><td><?php echo $category['name'];?></td></tr> 
<tr><td width="80">����ʱ�䣺</td><td><?php echo $news['publish_time'];?></td></tr> 
<tr><td width="80">���������</td><td><?php echo $news['clicked'];?></td></tr> 
</table> 
<?php 
//��ʾ�鿴���۳����� 
if($count_review>0){ 
     echo "<a href='index.php?url=review_news_list.php&news_id=".$news['news_id']."'>����".$count_review."������</a><br/>"; 
}else{ 
     echo "�������������ۣ�<br/>"; 
} 
?> 
<br/> 
<form action="review_save.php" method="post"> 
������ۣ�<textarea name="content" cols="50" rows="5"></textarea><br/> 
<input type="hidden" name="news_id" value="<?php echo $news['news_id'];?>"> 
<input type="submit" value="����"> 
</form> 