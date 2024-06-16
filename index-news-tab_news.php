
<div class="tab-news">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#featured">特色新闻</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#popular">热门新闻</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#latest">最新新闻</a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div id="featured" class="container tab-pane active">
                        <?php 
                        include_once("functions/get_news.php"); 
                        include_once("functions/get_url_parameters.php");

                        $result_set = get_latest(0, 3, 2);
                        ?>
                            <?php 
                            if(!$result_set){?>
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
                    <div id="popular" class="container tab-pane fade">
                        <?php 
                        include_once("functions/get_news.php"); 

                        $result_set = get_popular(0, 3, 2);
                        ?>
                            <?php 
                            if(!$result_set){?>
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
                    <div id="latest" class="container tab-pane fade">
                        <?php 
                        include_once("functions/get_news.php"); 
                        
                        $result_set = get_latest(0, 3, 1);
                        ?>
                            <?php 
                            if(!$result_set){?>
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
                </div>
            </div>
            
            <div class="col-md-6">
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#m-viewed">最多浏览</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#m-read">最多阅读</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#m-recent">最新新闻</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="m-viewed" class="container tab-pane active">
                        <?php 
                        include_once("functions/get_news.php"); 

                        $result_set = get_most_viewed(0, 3, 1);
                        ?>
                            <?php 
                            if(!$result_set){?>
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
                    <div id="m-read" class="container tab-pane fade">
                        <?php 
                        include_once("functions/get_news.php"); 

                        $result_set = get_most_viewed(0, 3, 2);
                        ?>
                            <?php 
                            if(!$result_set){?>
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
                    <div id="m-recent" class="container tab-pane fade">
                        <?php 
                        include_once("functions/get_news.php"); 

                        $result_set = get_latest(0, 3, 2);
                        ?>
                            <?php 
                            if(!$result_set){?>
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
                </div>
            </div>
        </div>
    </div>
</div>