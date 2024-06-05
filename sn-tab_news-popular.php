<?php 
include_once("functions/database.php"); 
include_once("functions/page.php"); 
include_once("functions/is_login.php"); 


//变量声明
$page_size = (isset($_GET["page_size"])? (intval($_GET["page_size"])>0?intval($_GET["page_size"]):5):5); 
$page_current = (isset($_GET["page_current"])?(intval($_GET["page_current"])>0?intval($_GET["page_current"]):1):1); 
$start = ($page_current-1)*$page_size; 

//构造查询所有新闻的SQL语句
$search_sql = "SELECT news.news_id, news.category_id, news.title, news.thumbnail, SUM( news.clicked ) AS total_views, SUM( news.clicked ) AS total_clicked, COUNT( review.review_id ) AS total_comments, HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) AS hour_since_published, 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) AS freshness_score, (\n"
    . "SUM( news.clicked ) * 0.4 + COUNT( review.review_id ) * 0.2 + ( 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) ) * 0.4\n"
    . ") AS trendingscore\n"
    . "FROM (\n"
    . "news\n"
    . "LEFT JOIN review ON news.news_id = review.news_id\n"
    . ")\n"
    ."WHERE NOT news.news_id = $news_id\n"
    . "GROUP BY news.news_id, news.category_id, hour_since_published , freshness_score\n"
    . "ORDER BY trendingscore DESC\n"
    . "LIMIT $start,$page_size";

// $search_sql = "select * from news where not news_id = $news_id order by publish_time desc limit $start,$page_size"; 

get_connection();
$result_set = $database_connection->query($search_sql);

// var_dump(mysqli_fetch_all($result_search_by_category_set[1]));


$total_records = $database_connection->query($search_sql);
$total_records = ($total_records instanceof mysqli_result?$total_records->fetch_array():0); 

close_connection(); 
?>
<div id="popular" class="container tab-pane fade">
    <?php 
    if($total_records == 0){?>
        <div class="tn-news">
            <div class="tn-title">
                <p>暂无新闻！</p>
            </div>
        </div>
        <?php 
    }else{
        while($row = mysqli_fetch_array($result_set)){ ?>
            <div class="tn-news">
                <div class="tn-img">
                    <img src="<?php echo $row['thumbnail']?>" />
                </div>
                <div class="tn-title">
                    <a href="index.php?url=news_detail.php&news_id= <?php echo $row['news_id']?>"><?php echo mb_strcut($row['title'],0,40,"gbk")?></a>
                </div>
            </div>
        <?php  }
    }
    ?>
</div>