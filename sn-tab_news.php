<?php 
include_once("includes/sn-model.php");?>

<div id="featured" class="container tab-pane active">
    <?php 
    if($total_records_tab == 0){?>
        <div class="tn-news">
            <div class="tn-title">
                <p>暂无新闻！</p>
            </div>
        </div>
        <?php 
    }else{
        $n = 0 ;
        while($n++ < $page_size){ 
            $row = mysqli_fetch_array($tab1)?>
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

<div id="latest" class="container tab-pane fade">
    <?php 
    if(!$tab1){?>
        <div class="tn-news">
            <div class="tn-title">
                <p>暂无新闻！</p>
            </div>
        </div>
        <?php 
    }else{
        $n = 0 ;
        while($n++ < $page_size){ 
            $row = mysqli_fetch_array($tab1)?>
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


<div id="popular" class="container tab-pane fade">
    <?php 
    if(!$tab1){?>
        <div class="tn-news">
            <div class="tn-title">
                <p>暂无新闻！</p>
            </div>
        </div>
        <?php 
    }else{
        $n = 0 ;
        while($n++ < $page_size){ 
            $row = mysqli_fetch_array($tab1)?>
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