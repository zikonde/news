<?php
include_once("database.php"); 

function get_latest($news_id = 0, $page_size = 5, $page_current = 1){
    //变量声明
    $start = ($page_current-1)*$page_size; 

    //构造查询所有新闻的SQL语句
    $search_sql = "select * from news where not news_id = $news_id order by publish_time desc limit $start,$page_size"; 

    $database_connection = get_connection();
    $result_set = $database_connection->query($search_sql);
    close_connection(); 

    return $result_set; 
}

function get_most_viewed($news_id = 0, $page_size = 5, $page_current = 1){
    //变量声明
    $start = ($page_current-1)*$page_size; 

    //构造查询所有新闻的SQL语句
    $search_sql = "select * from news where not news_id = $news_id order by clicked desc limit $start,$page_size"; 

    $database_connection = get_connection();
    $result_set = $database_connection->query($search_sql);
    close_connection(); 

    return $result_set; 
}

function get_popular($news_id = 0, $page_size = 5, $page_current = 1){
    //变量声明
    $start = ($page_current-1)*$page_size; 

    //构造查询所有新闻的SQL语句
    $search_sql = "SELECT news.news_id, news.category_id, news.title, news.thumbnail, SUM( news.clicked ) AS total_views, SUM( news.clicked ) AS total_clicked, COUNT( review.review_id ) AS total_comments, HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) AS hour_since_published, 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) AS freshness_score, (\n"
        . "SUM( news.clicked ) * 0.4 + COUNT( review.review_id ) * 0.2 + ( 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) ) * 0.4\n"
        . ") AS trendingscore\n"
        . "FROM (\n"
        . "news\n"
        . "LEFT JOIN review ON news.news_id = review.news_id\n"
        . ")\n"
        ."WHERE NOT news.news_id = $news_id\n"
        . "GROUP BY news.news_id, news.category_id, hour_since_published , freshness_score\n"
        . "ORDER BY trendingscore DESC\n"
        . "LIMIT $start,$page_size";

    $database_connection = get_connection();
    $result_set = $database_connection->query($search_sql);
    close_connection(); 

    return $result_set;
}

function get_related($news_id = 0, $page_size = 5, $page_current = 1){
    //变量声明
    $start = ($page_current-1)*$page_size; 
    $database_connection = get_connection();
    
    // 获取当前新闻的分类（如果适用）
    $categorySql = "SELECT category_id FROM news WHERE news_id = $news_id";
    $categoryResult = mysqli_query($database_connection, $categorySql);
    
    
    if (mysqli_num_rows($categoryResult) == 1) {
        $category_id = mysqli_fetch_assoc($categoryResult)["category_id"];
            
        $sql = "SELECT news_id, title, thumbnail 
        FROM news 
        WHERE category_id = $category_id";

        // 排除当前新闻文章
        if ($news_id) {
        $sql .= " AND news_id != $news_id";
        }

        // 限制结果数量（根据需要进行调整）
        $sql .= " LIMIT $start,$page_size";

        $result = mysqli_query($database_connection, $sql);
        
        return $result;
    } else {    
        return null;
    }
    mysqli_close($database_connection);
}

?>