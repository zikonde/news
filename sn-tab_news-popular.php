<?php 
include_once("functions/get_news.php"); 


//变量声明
$page_size = (isset($_GET["page_size"])? (intval($_GET["page_size"])>0?intval($_GET["page_size"]):5):5); 
$page_current = (isset($_GET["page_current"])?(intval($_GET["page_current"])>0?intval($_GET["page_current"]):1):1); 


$result_set = get_popular($news_id, $page_size, $page_current); 
$total_records = get_popular($news_id, $page_size, $page_current);
$total_records = ($total_records instanceof mysqli_result?$total_records->fetch_array():0); 
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