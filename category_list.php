<?php 
include_once("functions/database.php"); 
include_once("functions/page.php"); 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

//��ʾ�ļ��ϴ���״̬��Ϣ 
if(isset($_GET["message"])){ 
    echo $_GET["message"]."<br/>"; ?>
<?php } 

//��������
$page_size = (isset($_GET["page_size"])? (intval($_GET["page_size"])>0?intval($_GET["page_size"]):3):3); 
$page_current = (isset($_GET["page_current"])?(intval($_GET["page_current"])>0?intval($_GET["page_current"]):1):1); 
$start = ($page_current-1)*$page_size; 

//�����ѯ�������ŵ�SQL���
$search_all_sql1 = "select COUNT(news_id) as 'total records1' from news where category_id=1"; 
$search_all_sql2 = "select COUNT(news_id) as 'total records2' from news where category_id=2";

//����ģ����ѯ���ŵ�SQL��� 
$search_sql1 = "select * from news where category_id=1 order by news_id desc limit $start,$page_size"; 
$search_sql2 = "select * from news where category_id=2 order by news_id desc limit $start,$page_size"; 
get_connection(); 

$result_set1 = $database_connection->query($search_sql1); 
$result_set2 = $database_connection->query($search_sql2);
$total_records1 = $database_connection->query("$search_all_sql1");
$total_records1 = ($total_records1 instanceof mysqli_result?$total_records1->fetch_array()["total records1"]:0); 
$total_records2 = $database_connection->query("$search_all_sql2");
$total_records2 = ($total_records2 instanceof mysqli_result?$total_records2->fetch_array()["total records2"]:0); 

close_connection(); 
    
//�ṩ����ģ����ѯ��form�� 
?> 
<form action="index.php?url=news_list.php" method="get" name = 'f1'>
    <table> 
        <?php 
        //��ҳ��ʵ�� 
        echo "<tr>
                <td colspan='3'>������Ŀ</td>
            </tr>";
        if($total_records1 == 0){
            echo("��������Ŀ�������ţ�"); 
            
            echo "<br/>";
            //exit("���޼�¼��"); 
        }else{
            while($row = mysqli_fetch_array($result_set1)){ 
                ?>           
                <tr> 
                    <td> 
                        <a href="index.php?url=news_detail.php&news_id= <?php echo $row['news_id']?>">
                            <?php echo mb_strcut($row['title'],0,40,"gbk")?>
                        </a> 
                    </td>
                </tr> 
                <?php 
            }
        }

        echo "<tr>
            <td colspan='3'>�ƾ���Ŀ</td>
        </tr>";     
        if($total_records2== 0){
            echo("�ƾ�����Ŀ�������ţ�"); 
            echo "<br/>";
            //exit("���޼�¼��"); 
        }else{
            while($row = mysqli_fetch_array($result_set2)){ 
                ?>           
                <tr> 
                    <td> 
                    <a href="index.php?url=news_detail.php&news_id= <?php echo $row['news_id']?>">
                        <?php echo mb_strcut($row['title'],0,40,"gbk")?>
                    </a>
                    </td>
                </tr> 
                <?php 
            }
        }
        ?>  
    </table> 
</form> 