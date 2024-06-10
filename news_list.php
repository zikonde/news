<!DOCTYPE html>
<html lang="en">
<head>
    <title>新闻浏览</title>
    <link href="img/favicon.ico" rel="icon">
</head>
<body>
        

    <?php include_once "top_and_nav_bar.php" ?>

            
    <div id="mainfunction"> 
        <?php 
        include_once("functions/get_news.php"); 
        include_once("functions/get_url_parameters.php"); 

        //若进行模糊查询，取得模糊查询的关键字keyword 
        $keyword_search = addslashes($keyword);
        
        $total_records =get_news_count($keyword_search);
        $result_set = get_matching($keyword_search, $page_size, $page_current);  
            
        //提供进行模糊查询的form表单 
        ?> 
        <!-- <form action="index.php?url=news_list.php" method="get" name = 'f1' onsubmit="check()">
            请输入关键字：<input type="text" name="keyword" value="<?//php echo $keyword?>"> 
            <input type="submit" value="搜索"> 
             -->
            <br/> 
            
            <table class="nl-table"> 
                <?php 
                //分页的实现 
                if($total_records==0){ 
                    echo("暂无记录！"); 
                    //exit("暂无记录！"); 
                }else{ ?>
                    <tr><h1 class="sn-title" style="text-align: center;">系统所有新闻如下：</h1></tr>
                    <?php
                    while($row = mysqli_fetch_array($result_set)){ 
                        ?> 
                        <tr> 
                            <td> 
                            <img src="<?php echo $row['thumbnail'];?>" width="150px"> 
                            </td>
                            <td> 
                            <a href="index.php?url=news_detail.php&keyword=<?php echo $keyword?>&news_id= <?php echo $row['news_id']?>"> <?php echo mb_strcut($row['title'],0,40,"gbk")?></a> 
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
                        <?php 
                    } 
                //打印分页导航条
                $url = $_SERVER["REQUEST_URI"]; 
                page($total_records,$page_size,$page_current,$url,$keyword); 
                }
                ?>  
            </table> 

        </form> 
    </div> 
            
        
    <?php include_once "footer.php" ?>
        
            
</body>
</html>