<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
        

    <?php include_once "top_and_nav_bar.php" ?>

            
    <div id="mainfunction"> 
          <?php 
          include_once("functions/database.php"); 
          include_once("functions/get_url_parameters.php"); 

          if($news_id==0){ 
               echo "该新闻不存在或已被删除！"; 
          }else{
               //构造3条SQL语句 
               // $sql_news_update = "update news set clicked=clicked+1 where news_id=$news_id";
               $sql_news_detail = "select * from news where news_id=$news_id"; 
               $sql_review_query = "select * from review where news_id=$news_id and state='已审核'"; 

               //执行3条SQL语句 
               get_connection(); 
               
               // $database_connection->query($sql_news_update); 
               $result_news = $database_connection->query($sql_news_detail); 
               $result_review = $database_connection->query($sql_review_query); 

               //取出结果集中新闻条数 
               $count_news = ($result_news instanceof mysqli_result? $result_news->num_rows:0); 

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
               
               close_connection(); 
               
               if($result_user instanceof mysqli_result)$result_user->free_result(); 
               if($result_category instanceof mysqli_result)$result_category->free_result(); 
               if($result_news instanceof mysqli_result)$result_news->free_result(); 
               if($result_review instanceof mysqli_result)$result_review->free_result(); 
               
               $title = $news['title']; 
               $content = $news['content']; 
               $user = $user['name'];
               if($keyword){ 
                    $replacement = "<span style='color: red'><b><i>".$keyword."</b></i></span>";  
                    $title = str_replace($keyword,$replacement,$title); 
                    $content = str_replace($keyword,$replacement,$content); 
                    $user = str_replace($keyword,$replacement,$user); 
               } 
               
               //显示新闻详细信息 
               ?> 

               
               <div id="mainfunction" style="text-align: justify;"> 
                    <table> 
                    <tr><td width="80">标题：</td><td><?php echo $title;?></td></tr> 
                    <tr><td width="80">内容：</td><td><?php echo $content;?></td></tr> 
                    <tr><td width="80">附件：</td><td><a href="download.php?attachment=<?php echo urlencode($news['attachment']);?>"><?php echo $news['attachment'];?></a></td></tr> 
                    <tr><td width="80">发布者：</td><td><?php echo ($user) ;?></td></tr> 
                    <tr><td width="80">类别：</td><td><?php echo $category['name'];?></td></tr> 
                    <tr><td width="80">发布时间：</td><td><?php echo $news['publish_time'];?></td></tr> 
                    <tr><td width="80">点击次数：</td><td><?php echo $news['clicked'];?></td></tr> 
                    </table> 
                    <br/> 
                    <form action="review_save.php" method="post"> 
                    添加评论：<textarea name="content" cols="50" rows="5"></textarea><br/> 
                    <input type="hidden" name="news_id" value="<?php echo $news['news_id'];?>"> 
                    <input type="submit" value="评论"> 
                    </form> 

                    <br/> 
                    
                    <?php 
                    //显示查看评论超链接 
                    if($count_review>0){ 
                         echo "<a href='index.php?url=review_news_list.php&news_id=".$news['news_id']."'>共有".$count_review."条评论</a><br/>"; 
                         include_once("review_news_list.php");
                    }else{ 
                         echo "该新闻暂无评论！<br/>"; 
                    } 
                    ?> 
               </div> 
                    
          <?php } ?>
    </div> 
            
        
    <?php include_once "footer.php" ?>
        
            
</body>
</html>
