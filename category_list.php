<?php 
include_once("functions/database.php"); 
include_once("functions/is_login.php"); 
include_once("functions/get_news.php"); 
include_once("functions/get_url_parameters.php");
include_once("functions/page.php"); 

//显示文件上传的状态信息 
if($message){ 
    echo "$message<br/>";
} 

$sql = "SELECT category_id, name, description from category WHERE category_id LIKE '%$category_id%'";

//构造查询所有新闻的SQL语句
get_connection();
$result_categories = $database_connection->query($sql);
close_connection();
$total_records_by_category = [];
while($categories = mysqli_fetch_assoc($result_categories)){
    $total_records_by_category[] = get_news_count("", $categories['category_id']);
}

//构造模糊查询新闻的SQL语句 
get_connection();
$result_categories = $database_connection->query($sql);
close_connection();
$result_search_by_category_set = [];
while($categories = mysqli_fetch_assoc($result_categories)){
    $result_search_by_category_set[] = get_matching("", $page_size, $page_current, $categories['category_id']);
}

get_connection();
// var_dump(mysqli_fetch_all($result_search_by_category_set[1]));
$result_categories = $database_connection->query($sql);
close_connection(); 

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <title>分类浏览</title>
    <link href="img/favicon.ico" rel="icon">
</head>
<body>
        

    <?php include_once "top_and_nav_bar.php" ?>

            
    <div id="mainfunction"> 
        <?php 
        if(!$result_categories->num_rows){ 
            echo "暂时没无内容！"; 
            return; 
        }else{?>
            <table class="nl-table"> 
                <?php 
                //分页的实现 
                for($i = 0; $i < count($result_search_by_category_set); $i++){
                    $cat = mysqli_fetch_assoc($result_categories);
                    $cat_id = $cat["category_id"];
                    $cat_name = $cat["name"];
                    $cat_title = $cat["description"];
                    ?>
                    <tr class="sw-title">
                        <td colspan='4'><h2 title="<?=$cat_title ?>"><a href="index.php?url=category_list.php&category_id=<?=$cat_id?>&page_size=10"><?=$cat_name?>栏目</a></h2></td>
                        <?php if(is_admin()){?><td><a href="index.php?url=category_delete.php&category_id =<?=$cat_id?>"  onclick='return confirm("该操作也会删除分类里面的所有新闻，确定删除该分类？")'><i class="fa-regular fa-trash-can"></i></a></td> <?php } ?> 
                    </tr>

                    <?php 
                    if($total_records_by_category[$i] == 0){?>
                        <tr>
                            <td><?=$cat_name ?>类栏目暂无新闻！</td>
                        </tr>
                        
                        <br/>
                    
                        <?php //return;
                    }else{
                        while($row = mysqli_fetch_array($result_search_by_category_set[$i])){ 
                            ?>      
                            
                            <tr> 
                                <td> 
                                    <img src="<?php echo $row['thumbnail'];?>" width="150px"> 
                                </td>
                                <td> 
                                    <a href="index.php?url=news_detail.php&keyword=<?php echo $keyword?>&news_id= <?php echo $row['news_id']?>" onclick="updateClicked(this.href)"> <?php echo mb_strcut($row['title'],0,40,"gbk")?></a> 
                                </td>
                                <?php 
                                if(is_admin()){ 
                                ?> 
                                    <td> 
                                        <a href="index.php?url=news_add.php&news_id=<?php echo $row['news_id']?>">编辑</a> 
                                    </td> 
                                    <td> 
                                        <a href="index.php?url=news_delete.php&news_id=<?php echo $row['news_id']?>" onclick="return confirm('确定删除吗？');">删除</a> 
                                    </td> 
                                <?php } ?> 
                            </tr>  

                        <?php  }
                    }
                }
                ?>  
            </table> 

            <br />
            <br />
            
            <div style="text-align:center">
                <?php
                $url = $_SERVER["REQUEST_URI"];
                $total_records = array_sum($total_records_by_category);
                page($total_records,$page_size,$page_current,$url,$keyword);
                ?>
            </div>

        <?php } ?>
        
    </div> 
            
        
    <?php include_once "footer.php" ?>
        
            
</body>
</html>