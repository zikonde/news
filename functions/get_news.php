<?php
include_once("database.php"); 

function get_category_news($page_size = 5, $page_current = 1){
    //构造查询所有新闻的SQL语句
    $count_all_sql = 
        "SELECT name, COUNT( news.news_id ) AS 'total records'
        FROM category
        INNER JOIN news ON category.category_id = news.category_id
        GROUP BY category.name"; 
    $sql = "SELECT category_id, name, description from category";

    $database_connection = get_connection(); 
    $result_categories = $database_connection->query($sql);
    $result = $database_connection->query("$count_all_sql");
    
    $start = ($page_current-1)*$page_size; 
    $result_search_by_category_set = [];
    while($categories = mysqli_fetch_assoc($s = $result_categories)){
        $category_id = $categories['category_id'];
        $search_sql = 
            "SELECT news_id, title, thumbnail 
            FROM news WHERE category_id LIKE '$category_id' ORDER BY news_id DESC LIMIT $start, $page_size";
        $result_search_by_category_set[] = $database_connection->query($search_sql);
    }
    $result_categories = $database_connection->query($sql);

    close_connection(); 

    $total_records = [];
    while($row = $result->fetch_array()){
        $total_records[] = $row[1];
    }
    return [$result_categories, $total_records, $result_search_by_category_set]; 
}

function get_latest($news_id = 0, $page_size = 5, $page_current = 1){
    //变量声明
    $start = ($page_current-1)*$page_size; 

    //构造查询所有新闻的SQL语句
    $search_sql = "select news_id, title, thumbnail from news where not news_id = $news_id order by publish_time desc limit $start,$page_size"; 

    $database_connection = get_connection();
    $result_set = $database_connection->query($search_sql);
    close_connection(); 

    return $result_set; 
}

function get_main_news($news_id = 0, $page_size = 5, $page_current = 1){
    //变量声明
    $start = ($page_current-1)*$page_size; 

    //构造查询所有新闻的SQL语句
    $main_sql = "select news_id, title, thumbnail from news order by publish_time desc limit $start,$page_size"; 

    $start = ($page_current)*$page_size + 1; 
    $more_news_sql = "select news_id, title, thumbnail from news order by publish_time desc limit $start,10"; 

    $database_connection = get_connection();
    $result_set = $database_connection->query($main_sql);
    $more_news_set = $database_connection->query($more_news_sql);
    close_connection(); 

    return [$result_set, $more_news_set]; 
}

function get_matching($keyword = "", $page_size = 5, $page_current = 1, $category_id = ""){
    $keyword_search = addslashes($keyword);
    $start = ($page_current-1)*$page_size; 

    //构造模糊查询新闻的SQL语句 
    $search_sql = "SELECT news_id, title, thumbnail 
    FROM news WHERE (title LIKE '%$keyword_search%' OR content LIKE '%$keyword_search%' OR user_id IN (SELECT user_id FROM users WHERE name LIKE '%$keyword_search%')) AND category_id LIKE '$category_id' ORDER BY news_id DESC LIMIT $start, $page_size";

    $database_connection = get_connection(); 
    $result_set = $database_connection->query($search_sql); 
    close_connection(); 

    return $result_set; 
}

function get_most_viewed($news_id = 0, $page_size = 5, $page_current = 1){
    //变量声明
    $start = ($page_current-1)*$page_size; 

    //构造查询所有新闻的SQL语句
    $search_sql = "select news_id, title, thumbnail from news where not news_id = $news_id order by clicked desc limit $start,$page_size"; 

    $database_connection = get_connection();
    $result_set = $database_connection->query($search_sql);
    close_connection(); 

    return $result_set; 
}

function get_news_count($keyword = "", $category_id = ""){
    $keyword_search = addslashes($keyword);

    //构造查询所有新闻的SQL语句
    $count_all_sql = "SELECT COUNT(news_id) as 'total records' 
    from news where (title like '%$keyword_search%' or content like '%$keyword_search%' OR user_id IN (SELECT user_id FROM users WHERE name LIKE '%$keyword_search%')) AND category_id LIKE '%$category_id%' order by news_id"; 

    $database_connection = get_connection(); 
    $total_records = $database_connection->query("$count_all_sql");
    $total_records = ($total_records instanceof mysqli_result?$total_records->fetch_array()["total records"]:0); 
    close_connection(); 

    return $total_records; 
}

function get_popular($news_id = 0, $page_size = 5, $page_current = 1){
    //变量声明
    $start = ($page_current-1)*$page_size; 

    //构造查询所有新闻的SQL语句
    $search_sql = "SELECT news_id, title, thumbnail FROM (
        SELECT news.news_id, news.category_id, news.title, news.thumbnail, SUM( news.clicked ) AS total_views, SUM( news.clicked ) AS total_clicked, COUNT( review.review_id ) AS total_comments, HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) AS hour_since_published, 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) AS freshness_score, ( SUM( news.clicked ) * 0.4 + COUNT( review.review_id ) * 0.2 + ( 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) ) * 0.4 ) AS trendingscore 
        FROM ( news LEFT JOIN review ON news.news_id = review.news_id )
        WHERE NOT news.news_id = $news_id
        GROUP BY news.news_id, news.category_id, hour_since_published , freshness_score
        ORDER BY trendingscore DESC
        LIMIT $start,$page_size
    ) as t1";

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

function get_tab_content_news($news_id = 0, $page_size = 5, $page_current = 1){
    //变量声明
    $start = ($page_current-1)*$page_size; 

    //构造查询所有新闻的SQL语句
    $tab1_latest_sql =  "SELECT news_id, title, thumbnail from news where not news_id = $news_id order by publish_time desc limit 0,$page_size";
    $tab1_popular_sql =  "SELECT news.news_id, news.category_id, news.title, news.thumbnail, SUM( news.clicked ) AS total_views, SUM( news.clicked ) AS total_clicked, COUNT( review.review_id ) AS total_comments, HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) AS hour_since_published, 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) AS freshness_score, ( SUM( news.clicked ) * 0.4 + COUNT( review.review_id ) * 0.2 + ( 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) ) * 0.4 ) AS trendingscore 
    FROM ( news LEFT JOIN review ON news.news_id = review.news_id )
    WHERE NOT news.news_id = $news_id
    GROUP BY news.news_id, news.category_id, hour_since_published , freshness_score
    ORDER BY trendingscore DESC
    LIMIT $start,$page_size";
    $tab1_latest_sql2 =  "SELECT news_id, title, thumbnail from news where not news_id = $news_id order by clicked desc limit $page_size,$page_size";
    
    
    $tab1_sql =  "(".
            "SELECT news_id, title, thumbnail FROM ( $tab1_latest_sql) as t1 
        )
        UNION ALL
        (  
            SELECT news_id, title, thumbnail FROM ($tab1_popular_sql ) as t2 
        )
        UNION ALL
        (
            SELECT news_id, title, thumbnail FROM ( $tab1_latest_sql2 ) as t3
        )
    ";

    //变量声明
    $start = (2)*$page_size; 

    //构造查询所有新闻的SQL语句
    $tab2_most_viewed_sql =  "SELECT news_id, title, thumbnail from news where not news_id = $news_id order by clicked desc limit 0,$page_size";
    $tab2_most_viewed_sql2 =  "SELECT news_id, title, thumbnail from news where not news_id = $news_id order by clicked desc limit $page_size,$page_size";
    $tab2_latest_sql =  "SELECT news_id, title, thumbnail from news where not news_id = $news_id order by publish_time desc limit $start,$page_size";
    
    
    $tab2_sql =  "(".
            "SELECT news_id, title, thumbnail FROM ( $tab2_most_viewed_sql) as t1 
        )
        UNION ALL
        (  
            SELECT news_id, title, thumbnail FROM ($tab2_most_viewed_sql2 ) as t2 
        )
        UNION ALL
        (
            SELECT news_id, title, thumbnail FROM ( $tab2_latest_sql ) as t3
        )
    ";

    //变量声明
    $start = ($page_current)*$page_size; 

    //构造查询所有新闻的SQL语句
    $tab3_popular_sql =  "SELECT news.news_id, news.category_id, news.title, news.thumbnail, SUM( news.clicked ) AS total_views, SUM( news.clicked ) AS total_clicked, COUNT( review.review_id ) AS total_comments, HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) AS hour_since_published, 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) AS freshness_score, ( SUM( news.clicked ) * 0.4 + COUNT( review.review_id ) * 0.2 + ( 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) ) * 0.4 ) AS trendingscore 
    FROM ( news LEFT JOIN review ON news.news_id = review.news_id )
    WHERE NOT news.news_id = $news_id
    GROUP BY news.news_id, news.category_id, hour_since_published , freshness_score
    ORDER BY trendingscore DESC
    LIMIT $start,$page_size";
    $tab3_latest_sql =  "SELECT news_id, title, thumbnail from news where not news_id = $news_id order by publish_time desc limit $start,$page_size";
    $start = ($page_current-1)*$page_size; 
    $tab3_popular_sql2 =  "SELECT news_id, title, thumbnail from news where not news_id = $news_id order by publish_time desc limit $start,$page_size";
    
    
    $tab3_sql =  "(".
            "SELECT news_id, title, thumbnail FROM ( $tab3_popular_sql) as t1 
        )
        UNION ALL
        (  
            SELECT news_id, title, thumbnail FROM ($tab3_latest_sql ) as t2 
        )
        UNION ALL
        (
            SELECT news_id, title, thumbnail FROM ( $tab3_popular_sql2 ) as t3
        )
    ";


    $database_connection = get_connection();
    $tab1_result = $database_connection->query($tab1_sql);
    $tab2_result = $database_connection->query($tab2_sql);
    $tab3_result = $database_connection->query($tab3_sql);
    close_connection(); 

    return [$tab1_result, $tab2_result, $tab3_result]; 
}

function get_top_news(){
    //变量声明
    $page_size = 4;
    $page_current = 3;
    $start = ($page_current-1)*$page_size; 

    //构造查询所有新闻的SQL语句
    $left_sql =  "("."SELECT news_id, title, thumbnail FROM (
    SELECT * FROM news WHERE title LIKE '%习近平%' ORDER BY news_id DESC LIMIT 1
    ) as t1
    )
    UNION ALL
    (SELECT news_id, title, thumbnail FROM (
        SELECT news.news_id, news.category_id, news.title, news.thumbnail, SUM( news.clicked ) AS total_views, SUM( news.clicked ) AS total_clicked, COUNT( review.review_id ) AS total_comments, HOUR( TIMEDIFF( NOW( ) , news.publish_time 		   ) ) AS hour_since_published, 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) AS freshness_score,  SUM( news.clicked ) * 0.4 + COUNT( review.review_id ) * 0.2 + ( 1 - ( HOUR( TIMEDIFF( NOW( ) , news.publish_time ) ) / ( 24 *7 ) ) ) * 0.4
    AS trendingscore FROM ( news LEFT JOIN review ON news.news_id = review.news_id ) GROUP BY news.news_id, news.category_id, hour_since_published , freshness_score ORDER BY trendingscore DESC LIMIT 1
    ) as t2
    )
    UNION ALL
    (SELECT news_id, title, thumbnail FROM (
        SELECT * FROM news ORDER BY publish_time DESC LIMIT 1,1
    ) as t3
    )
    ";
    $right_sql = "SELECT news_id, title, thumbnail from news order by publish_time desc limit $start,$page_size"; 

    $database_connection = get_connection();
    $left = $database_connection->query($left_sql);
    $right = $database_connection->query($right_sql);
    close_connection(); 

    return [$left, $right]; 
}

function get_xi($page_size = 5, $page_current = 1, $category_id = ""){
    $start = ($page_current-1)*$page_size; 

    //构造模糊查询新闻的SQL语句 
    $search_sql = "SELECT news_id, title, thumbnail 
    FROM news WHERE title LIKE '%习近平%' AND category_id LIKE '%$category_id%' ORDER BY news_id DESC LIMIT $start, $page_size";

    $database_connection = get_connection(); 
    $result_set = $database_connection->query($search_sql); 
    close_connection(); 

    return $result_set; 
}
?>