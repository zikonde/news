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
get_connection();
$result_categories = $database_connection->query("select category_id, name from category");

$search_all_sql = [];
while($categories = mysqli_fetch_assoc($result_categories)){
    $search_all_sql[] = "select COUNT(news_id) as 'total records1' from news where category_id=".$categories['category_id']; 
}

//构造模糊查询新闻的SQL语句 
$result_categories = $database_connection->query("select category_id, name from category");
$search_by_category_sql = [];
while($categories = mysqli_fetch_assoc($result_categories)){
    $search_by_category_sql[] = "select * from news where category_id=".$categories['category_id']." order by news_id desc limit $start,$page_size"; 
}

$result_search_by_category_set = [];
for($i=0;$i<=count($search_by_category_sql)-1;$i++){
    $result_search_by_category_set[] = $database_connection->query($search_by_category_sql[$i]);
}
// var_dump(mysqli_fetch_all($result_search_by_category_set[1]));


$total_records_by_category = [];
for($i=0;$i<=count($search_all_sql)-1;$i++){
    $total_records_n = $database_connection->query($search_all_sql[$i]);
    $total_records_n = ($total_records_n instanceof mysqli_result?$total_records_n->fetch_array()["total records1"]:0); 
    $total_records_by_category[] = $total_records_n;
}




// $total_records2 = $database_connection->query("$search_all_sql2");
// $total_records2 = ($total_records2 instanceof mysqli_result?$total_records2->fetch_array()["total records2"]:0); 
$result_categories = $database_connection->query("select category_id, name from category");
close_connection(); 
    
//提供进行模糊查询的form表单 
?> 

<?php 
//分页的实现 
for($i = 0; $i < count($result_search_by_category_set)-1; $i=$i+2){?>
    <!-- Category News Start-->
    <div class="cat-news">
        <div class="container">
            <div class="row">

                <?php
                for($j = 0; $j < 2; $j++){
                    $cat_name = mysqli_fetch_assoc($result_categories)["name"];?>
                    <div class="col-md-6">
                        <h2><?=$cat_name?></h2>
                        <div class="row cn-slider">

                            <?php 
                            if($total_records_by_category[$i+$j] == 0){?>
                                <div>
                                    <div>
                                        <div>
                                            <a href="">类栏目暂无新闻！</a>
                                        </div>
                                    </div>
                                </div>
                                <?php //return;
                            }else{
                                while($row = mysqli_fetch_array($result_search_by_category_set[$i+$j])){ ?> 
                                    <div class="col-md-6">
                                        <div class="cn-img">
                                            <img src="<?=$row['thumbnail']?>" />
                                            <div class="cn-title">
                                                <a href="index.php?url=news_detail.php&news_id= <?php echo $row['news_id']?>" onclick="updateClicked(this.href)"><?php echo mb_strcut($row['title'],0,40,"gbk")?></a>
                                            </div>
                                        </div>
                                    </div>    
                                <?php }
                            }?>

                        </div>
                    </div>
                <?php }
                ?>

            </div>
        </div>
    </div>
    <!-- Category News End-->

<?php 
}
?>  


