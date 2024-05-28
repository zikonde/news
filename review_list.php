<?php 
include_once("functions/is_login.php"); 
if (!session_id()){//这里使用session_id()判断是否已经开启了Session 
     session_start(); 
} 
if(!is_login()){ 
     echo "请您登录系统后，再访问该页面！"; 
     return; 
}else{
    include_once("functions/database.php"); 
    include_once("functions/page.php");
    
    $sql = "select * from review"; 
    get_connection(); 
    //分页的实现 
    $result_news = $database_connection->query($sql); 
    $total_records = $result_news->num_rows; 
    $page_size = (isset($_GET["page_size"])? (intval($_GET["page_size"])>0?intval($_GET["page_size"]):3):3);; 
    $page_current = (isset($_GET["page_current"])?(intval($_GET["page_current"])>0?intval($_GET["page_current"]):1):1); 
    $start = ($page_current-1)*$page_size; 
    
    $result_sql = "select * from review order by review_id desc limit $start,$page_size"; 
    $result_set = $database_connection->query($result_sql); 
    close_connection(); 
    echo "系统所有评论信息如下：<br/>"; 
    while($row = $result_set->fetch_array()){ 
         echo "评论内容：".$row["content"]."<br/>"; 
         echo "日期：".$row["publish_time"]."&nbsp;&nbsp;"; 
         echo "IP地址：".$row["ip"]."&nbsp;&nbsp;"; 
         echo "状态：".$row["state"]."<br/>"; 
         echo "<a href='review_delete.php?review_id=".$row["review_id"]."'>删除</a>"; 
         echo "&nbsp;&nbsp;&nbsp;"; 
         if($row["state"]=="未审核"){ 
                echo "<a href='review_verify.php?review_id=".$row["review_id"]."'>审核</a>"; 
         } 
         echo "<hr/>"; 
    } 
    //打印分页导航条
    $url = $_SERVER["REQUEST_URI"]; 
    //$url = "index.php?url=review_list.php"; 
    page($total_records,$page_size,$page_current,$url,""); 
    ?> 
<?php } 
?> 