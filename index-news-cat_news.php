<?php 
include_once("functions/database.php"); 
include_once("functions/page.php"); 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 
include_once("functions/get_url_parameters.php");

$sql = "SELECT category_id, name, description from category WHERE category_id LIKE '%$category_id%'";

//构造查询所有新闻的SQL语句
get_connection();
$result_categories = $database_connection->query($sql);
close_connection();
$total_records_by_category = [];
while($categories = mysqli_fetch_assoc($result_categories)){
    $total_records_by_category[] = get_news_count("", $categories['category_id']);
}

//构造模糊查询新闻的SQL语句 
get_connection();
$result_categories = $database_connection->query($sql);
close_connection();
$result_search_by_category_set = [];
while($categories = mysqli_fetch_assoc($result_categories)){
    $result_search_by_category_set[] = get_matching("", $page_size, $page_current, $categories['category_id']);
}


get_connection();
// $total_records2 = $database_connection->query("$search_all_sql2");
// $total_records2 = ($total_records2 instanceof mysqli_result?$total_records2->fetch_array()["total records2"]:0); 
$result_categories = $database_connection->query($sql);
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
                    $cat = mysqli_fetch_assoc($result_categories);
                    $cat_name = $cat["name"];
                    $cat_id = $cat["category_id"];
                    $cat_title = mb_strcut($cat["description"],0,80,"gbk")."...";
                    ?>
                    <div class="col-md-6">
                        <h2><a href="index.php?url=category_list.php&category_id=<?=$cat_id?>&page_size=10" title="<?=$cat_title ?>"><?=$cat_name?></a></h2>
                        <div class="row cn-slider">

                            <?php 
                            if($total_records_by_category[$i+$j] == 0){?>
                                <div>
                                    <div>
                                        <div>
                                            类栏目暂无新闻！
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


