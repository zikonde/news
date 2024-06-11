<?php include_once("functions/get_news.php"); ?>

<div class="top-news">
    <div class="container">
        <div class="row">

            <div class="col-md-6 tn-left">
                <div class="row tn-slider">

                    <?php 
                    $popular = get_xi(1, 1);

                    if (mysqli_num_rows($popular) > 0) { 
                        $row = mysqli_fetch_assoc($popular);
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
                    <?php } ?>

                    <?php 
                    $popular = get_popular(0, 1, 1);

                    if (mysqli_num_rows($popular) > 0) { 
                        $row = mysqli_fetch_assoc($popular);
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
                    <?php } ?>

                    <?php 
                    $latest_news = get_latest(0, 1, 1);

                    if (mysqli_num_rows($latest_news) > 0) { 
                        $row = mysqli_fetch_assoc($latest_news);
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
                    <?php } ?>
                    
                </div>
            </div>

            <div class="col-md-6 tn-right">
                <div class="row">

                    <?php $latest_news = get_latest(0, 4, 3);

                    if (mysqli_num_rows($latest_news) > 0) { 
                        while($row = mysqli_fetch_assoc($latest_news)) {
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