<!DOCTYPE html>
<html lang="en">
<head>
    <title>News - Zikonda Nyirenda、邓琬琼</title>
    <link href="img/favicon.ico" rel="icon">
</head>
<body>
        

    <?php include_once "top_and_nav_bar.php"; ?>


    <div id="mainfunction"> 
        <?php 
        include_once("functions/get_url_parameters.php");
        include_once("functions/get_news.php");
        include_once("functions/database.php");
        
        $database_connection = get_connection();
        ?>
        
        <!-- 热门新闻开始 -->
        <?php include 'index-news-top_news.php'; ?>
        <!-- 热门新闻结束 -->
        
        <!-- 分类新闻开始 -->
        <?php include 'index-news-cat_news.php'; ?>
        <!-- 分类新闻结束 -->

        <!-- 标签新闻开始 -->
        <?php include 'index-news-tab_news.php'; ?>
        <!-- 标签新闻结束 -->

        <!-- 主要新闻开始 -->
        <?php include 'index-news-main_news.php'; ?>
        <!-- 主要新闻结束 -->

    </div> 
            
        
    <?php include_once "footer.php" ?>
        
            
</body>
</html>