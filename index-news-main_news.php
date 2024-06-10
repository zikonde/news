<?php include_once("functions/get_news.php"); 

?>
<div class="main-news">
    <div class="container">
        <div class="row">

            <div class="col-lg-9">
                <div class="row">
                    <?php 
                    $result_set = get_latest(0, 9, 1); 
                    if($result_set){
                        while($row = mysqli_fetch_array($result_set)){ ?>
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="<?php echo $row['thumbnail']?>" />
                                    <div class="mn-title">
                                        <a href="index.php?url=news_detail.php&news_id= <?php echo $row['news_id']?>"><?php echo mb_strcut($row['title'],0,40,"gbk")?></a>
                                    </div>
                                </div>
                            </div>
                        <?php  }
                    } ?>
                </div>
            </div>

            <?php 
            $result_set = get_latest(0, 10, 2); 
            if($result_set){ ?>
                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2><a href="index.php?url=news_list.php&page_size=10">ÔÄ¶Á¸ü¶à</a></h2>
                        <ul>
                            <?php while($row = mysqli_fetch_array($result_set)){ ?>
                                <li><a href="index.php?url=news_detail.php&news_id= <?php echo $row['news_id']?>"><?php echo mb_strcut($row['title'],0,40,"gbk")?></a></li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            <?php  }?>
            
        </div>
    </div>
</div>