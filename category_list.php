<?php 
include_once("functions/database.php"); 
include_once("functions/page.php"); 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

//显示文件上传的状态信息 
if(isset($_GET["message"])){ 
    echo $_GET["message"]."<br/>"; ?>
<?php } 

//变量声明
$page_size = (isset($_GET["page_size"])? (intval($_GET["page_size"])>0?intval($_GET["page_size"]):3):3); 
$page_current = (isset($_GET["page_current"])?(intval($_GET["page_current"])>0?intval($_GET["page_current"]):1):1); 
$start = ($page_current-1)*$page_size; 

//构造查询所有新闻的SQL语句
$search_all_sql1 = "select COUNT(news_id) as 'total records1' from news where category_id=1"; 
$search_all_sql2 = "select COUNT(news_id) as 'total records2' from news where category_id=2";

//构造模糊查询新闻的SQL语句 
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
    
//提供进行模糊查询的form表单 
?> 
<form action="index.php?url=news_list.php" method="get" name = 'f1'>
    <table> 
        <?php 
        //分页的实现 
        echo "<tr>
                <td colspan='3'>娱乐栏目</td>
            </tr>";
        if($total_records1 == 0){
            echo("娱乐类栏目暂无新闻！"); 
            
            echo "<br/>";
            //exit("暂无记录！"); 
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
            <td colspan='3'>财经栏目</td>
        </tr>";     
        if($total_records2== 0){
            echo("财经类栏目暂无新闻！"); 
            echo "<br/>";
            //exit("暂无记录！"); 
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