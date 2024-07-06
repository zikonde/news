
<div class="row sn-slider">
    <?php
    include_once("includes/sn-model.php"); 

    if (mysqli_num_rows($related_result) > 0) { 
        while($row = mysqli_fetch_assoc($related_result)) {
            $newsId = $row["news_id"];
            $title = $row["title"];
            $thumbnail = $row["thumbnail"];?>
            <div class="col-md-4">
                <div class="sn-img">
                    <img src="<?= $thumbnail ?>" />
                    <div class="sn-title">
                        <a href="<?=("?url=news_detail.php&news_id=$newsId") ?>" title="<?=$row['title']; ?>"> <?= mb_strcut($row['title'],0,18,"gbk").(strlen($row['title'])>18?"...":"") ?></a>
                    </div>
                </div>
            </div>
        <?php }
    } else {?>
        <div>
            <div>
                <div>
                    <a>未发现相关新闻。</a>
                </div>
            </div>
        </div>
    <?php  } ?>
</div>
