
<?php 
include_once("includes/sn-model.php");
?>

<h2 class="sw-title">更多<span style="color: #FF6F61;"><?php echo $category_name;?></span>新闻</h2>
<div class="news-list">
    <?php 
    if($total_records_by_category == 0){?>
        <div class="nl-item">
            <div class="nl-title">
            <?=$category_name ?>类栏目暂无更多新闻！
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