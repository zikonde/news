
<?php 
include_once("functions/database.php"); 
include_once("functions/page.php"); 
include_once("functions/is_login.php"); 


//变量声明
$page_size = (isset($_GET["page_size"])? (intval($_GET["page_size"])>0?intval($_GET["page_size"]):5):5); 
$page_current = (isset($_GET["page_current"])?(intval($_GET["page_current"])>0?intval($_GET["page_current"]):1):1); 
$start = ($page_current-1)*$page_size; 

//构造查询所有新闻的SQL语句
$search_by_category_sql = "select * from news where category_id=".$category_id." and not news_id = $news_id order by publish_time desc limit $start,$page_size"; 

get_connection();
$result_search_by_category_set = $database_connection->query($search_by_category_sql);

// var_dump(mysqli_fetch_all($result_search_by_category_set[1]));


$total_records_by_category = $database_connection->query($search_by_category_sql);
$total_records_by_category = ($total_records_by_category instanceof mysqli_result?$total_records_by_category->fetch_array():0); 


$result_categories = $database_connection->query("select category_id, name from category");
close_connection(); 
?>

<h2 class="sw-title">更多<span style="color: #FF6F61;"><?php echo $category_name;?></span>新闻</h2>
<div class="news-list">
    <?php 
    if($total_records_by_category == 0){?>
        <div class="nl-item">
            <div class="nl-title">
            <?=$category_name ?>类栏目暂无新闻！
            </div>
        </div>
        

        <?php //return;
    }else{
        while($row = mysqli_fetch_array($result_search_by_category_set)){ ?>
        <div class="nl-item">
            <div class="nl-img">
                <img src="<?php echo $row['thumbnail']?>" />
            </div>
            <div class="nl-title">
                <a href="index.php?url=news_detail.php&news_id= <?php echo $row['news_id']?>"><?php echo mb_strcut($row['title'],0,40,"gbk")?></a>
            </div>
        </div>
        <?php  }
    }
    ?>
</div>