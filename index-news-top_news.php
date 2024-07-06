<?php include_once("functions/get_news.php"); ?>

<div class="top-news">
    <div class="container">
        <div class="row">

            <div class="col-md-6 tn-left">
                <div class="row tn-slider">

                    <?php 
                    $result = get_top_news();
                    $left = $result[0];
                    $right = $result[1];

                    if (mysqli_num_rows($left) > 0) { 
                        while($row = mysqli_fetch_assoc($left)) {
                        $newsId = $row["news_id"];
                        $title = $row["title"];
                        $thumbnail = $row["thumbnail"];?>

                        <div class="col-md-6">
                            <div class="tn-img">
                                <img src="<?= $thumbnail ?>" />
                                <div class="tn-title">
                                    <a href="<?=("?url=news_detail.php&news_id=$newsId") ?>"> <?= $title ?></a>
                                </div>
                            </div>
                        </div>
                        <?php }
                    } ?>

                </div>
            </div>

            <div class="col-md-6 tn-right">
                <div class="row">

                    <?php
                    if (mysqli_num_rows($right) > 0) { 
                        while($row = mysqli_fetch_assoc($right)) {
                            $newsId = $row["news_id"];
                            $title = $row["title"];
                            $thumbnail = $row["thumbnail"];?>
                            
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img src="<?= $thumbnail ?>" />
                                    <div class="tn-title">
                                        <a href="<?=("?url=news_detail.php&news_id=$newsId") ?>"> <?= $title ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }?>
                </div>
            </div>

        </div>
    </div>
</div>