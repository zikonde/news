<?php include_once("functions/get_news.php"); 

?>
<div class="main-news">
    <div class="container">
        <div class="row">

            <div class="col-lg-9">
                <div class="row">
                    <?php 
                    $result_set = get_main_news(0, 9, 1); 
                    $main = $result_set[0];
                    $more = $result_set[1];

                    if($main){
                        $n = 0;
                        while($n++ < 9){ 
                            $row = mysqli_fetch_array($main)?>
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
            if($more){ ?>
                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2><a href="index.php?url=news_list.php&page_size=10">ÔÄ¶Á¸ü¶à</a></h2>
                        <ul>
                            <?php while($row = mysqli_fetch_array($more)){ ?>
                                <li><a href="index.php?url=news_detail.php&news_id= <?php echo $row['news_id']?>"><?php echo mb_strcut($row['title'],0,40,"gbk")?></a></li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            <?php  }?>
            
        </div>
    </div>
</div>