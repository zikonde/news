
<?php 
include_once("functions/database.php"); 
include_once("functions/page.php"); 
include_once("functions/is_login.php"); 


//构造查询所有新闻的SQL语句
$sql = "SELECT category.name, Count(news.news_id) AS total_news\n"
    . "FROM category INNER JOIN news ON category.category_id = news.category_id\n"
    . "GROUP BY category.name";

get_connection();
$result_set = $database_connection->query($sql);

$total_records = $database_connection->query($sql);
$total_records = ($total_records instanceof mysqli_result?$total_records->fetch_array():0); 
close_connection(); 

?>

<ul>
    <?php 
    if($total_records == 0){?>
        <p>暂无新闻！</p>
        <?php 
    }else{
        while($row = mysqli_fetch_array($result_set)){ ?>
            <li><a href=""><?php echo $row['name']?></a><span>(<?php echo $row['total_news']?>)</span></li>
        <?php  }
    }
    ?>
</ul>