<?php 
include_once("functions/database.php"); 
include_once("functions/page.php"); 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

//��ʾ�ļ��ϴ���״̬��Ϣ 
if(isset($_GET["message"])){ 
    echo $_GET["message"]."<br/>"; 
} 

//��������
$page_size = (isset($_GET["page_size"])? (intval($_GET["page_size"])>0?intval($_GET["page_size"]):3):3); 

//������ģ����ѯ��ȡ��ģ����ѯ�Ĺؼ���keyword 
$keyword = (isset($_GET["keyword"])?(trim($_GET["keyword"])):""); 
$keyword_search = addslashes($keyword);

$page_current = (isset($_GET["page_current"])?(intval($_GET["page_current"])>0?intval($_GET["page_current"]):1):1); 

$start = ($page_current-1)*$page_size; 

//�����ѯ�������ŵ�SQL���
$search_all_sql = "select COUNT(news_id) as 'total records' from news where title like '%$keyword_search%' or content like '%$keyword_search%' order by news_id"; 

//����ģ����ѯ���ŵ�SQL��� 
$search_sql = "select * from news where title like '%$keyword_search%' or content like '%$keyword_search%' order by news_id desc limit $start,$page_size"; 
get_connection(); 

$result_set = $database_connection->query($search_sql); 
$total_records = $database_connection->query("$search_all_sql");
$total_records = ($total_records instanceof mysqli_result?$total_records->fetch_array()["total records"]:0); 
close_connection(); 
    
//�ṩ����ģ����ѯ��form�� 
?> 
<form action="index.php?url=news_list.php" method="get" name = 'f1'>
    ������ؼ��֣�<input type="text" name="keyword" value="<?php echo $keyword?>"> 
    <input type="submit" value="����"> 
    
    <br/> 
    
    <table> 
        <?php 
        //��ҳ��ʵ�� 
        if($total_records==0){ 
            echo("���޼�¼��"); 
            //exit("���޼�¼��"); 
        }else{
            while($row = mysqli_fetch_array($result_set)){ 
                ?> 
                <tr> 
                    <td> 
                       <a href="index.php?url=news_detail.php&keyword=<?php echo $keyword?>&news_id= <?php echo $row['news_id']?>"><?php echo mb_strcut($row['title'],0,40,"gbk")?></a> 
                    </td>
                    <?php 
                    if(is_admin()){ 
                    ?> 
                        <td> 
                           <a href="index.php?url=news_edit.php&news_id=<?php echo $row['news_id']?>">�༭</a> 
                        </td> 
                        <td> 
                           <a href="index.php?url=news_delete.php&news_id=<?php echo $row['news_id']?>" onclick="return confirm('ȷ��ɾ����');">ɾ��</a> 
                        </td> 
                    <?php } ?> 
                </tr> 
                <?php 
            } 
        //��ӡ��ҳ������
        $url = $_SERVER["REQUEST_URI"]; 
        page($total_records,$page_size,$page_current,$url,$keyword); 
        }
        ?>  
    </table> 

</form> 