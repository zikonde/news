<?php 
include_once("functions/database.php");
include_once("functions/get_news.php");
include_once("functions/get_url_parameters.php");
include_once("functions/is_login.php");  

// 获取数据库连接
$database_connection = get_connection();
    
// 

//sn details 
    $sql_news_detail = "select * from news where news_id=$news_id"; 
    $sql_review_query = "select * from review where news_id=$news_id and state='已审核'"; 

    //执行2条SQL语句 
    $result_news = $database_connection->query($sql_news_detail); 
    $result_review = $database_connection->query($sql_review_query); 

    //取出结果集中新闻条数 
    $count_news = ($result_news instanceof mysqli_result? $result_news->num_rows:0); 

    if ($count_news == 0) { 
        // 关闭数据库连接
        close_connection();
        return; 
    }
    //取出结果集中该新闻"已审核"的评论条数 
    $count_review = ($result_review instanceof mysqli_result? $result_review->num_rows:0);

    //根据新闻信息中的user_id查询对应的用户信息 
    $news =$result_news->fetch_array(); 
    $user_id = $news["user_id"]; 
    $sql_user = "select name from users where user_id=$user_id"; 
    $result_user = $database_connection->query($sql_user); 
    $user = ($result_user instanceof mysqli_result? $result_user->fetch_array():["name"=>"未知"]);
    
    //根据新闻信息中的category_id查询对应的新闻类别信息 
    $category_id = $news["category_id"]; 
    $sql_category = "select name from category where category_id=$category_id"; 
    $result_category =$database_connection->query($sql_category); 
    $category = ($result_category instanceof mysqli_result? $result_category->fetch_array():["name"=>"——"]);
          
// sn reviews
    $sql = 
        "SELECT users.name, review.publish_time, review.content, review.ip, review.state
        FROM users INNER JOIN review ON users.user_id = review.user_id
        WHERE (((review.news_id)=$news_id) AND ((review.state)='已审核'))
        ORDER BY publish_time DESC
        LIMIT 50;"; 
    $result_set_reviews = $database_connection->query($sql); 

// sn related
$related_result = get_related($database_connection, $news_id, $page_size, $page_current);

// sn same category
    $search_by_category_sql = "select * from news where category_id=".$category_id." and not news_id = $news_id order by publish_time desc limit $start,$page_size"; 

    $result_search_by_category_set = $database_connection->query($search_by_category_sql);

    $total_records_by_category = $database_connection->query($search_by_category_sql);
    $total_records_by_category = ($total_records_by_category instanceof mysqli_result?$total_records_by_category->fetch_array():0); 


    $result_categories = $database_connection->query("select category_id, name from category");

// sn tab content

$result_set_tabs = get_tab_content_news($database_connection, $news_id, $page_size, $page_current); 
$tab1 = $result_set_tabs[2];
$total_records_tab = ($tab1 instanceof mysqli_result?$tab1->num_rows:0); 

// sn category list
    //构造查询所有新闻的SQL语句
    $sql = "SELECT category.category_id, category.name, Count(news.news_id) AS total_news\n"
        . "FROM category LEFT JOIN news ON category.category_id = news.category_id\n"
        . "GROUP BY category.name ORDER BY total_news DESC";

    $result_set_categories = $database_connection->query($sql);

    $total_records = $database_connection->query($sql);
    $total_records = ($total_records instanceof mysqli_result?$total_records->fetch_array():0); 



// 关闭数据库连接
close_connection();
?> 
