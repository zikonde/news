<?php
function delete_review($review_id = 0, $news_id = 0){
    include_once("functions/is_login.php");
    include_once("functions/database.php"); 
    
    $sql = "DELETE FROM review WHERE review_id=$review_id OR news_id=$news_id"; 

    get_connection()->query($sql); 
    close_connection(); 
}

function delete_news($news_id = 0, $category_id = 0){
    include_once("functions/is_login.php");
    include_once("functions/database.php"); 
    
    if($category_id){
        $result_set = get_connection()->query("SELECT news_id from news where category_id=$category_id");
        close_connection();

        while($row = $result_set->fetch_array()){
            delete_review(0, $row["news_id"]);
        }
    }else{
        delete_review(0, $news_id);
    }
    
    get_connection()->query("DELETE FROM news WHERE news_id=$news_id OR category_id=$category_id"); 
    close_connection(); 
}

function delete_category($category_id = 0){
    include_once("functions/is_login.php");
    include_once("functions/database.php"); 
    
    delete_news(0, $category_id);
    get_connection()->query("DELETE FROM category WHERE category_id=$category_id"); 
    close_connection(); 
}


?>