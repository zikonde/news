<!DOCTYPE html>
<html lang="en">
    <head>
        <title>新闻详细</title>
        <link href="img/favicon.ico" rel="icon">
    </head>

    <body>
        

        <?php include_once "top_and_nav_bar.php" ?>
    
                
        <div id="mainfunction" style="text-align: justify;"> 
            <?php 
            include_once("functions/database.php");
            include_once("functions/get_url_parameters.php"); 

            if($news_id==0){ 
                echo "该新闻不存在或已被删除！"; 
            }else{
                //构造2条SQL语句 
                $sql_news_detail = "select * from news where news_id=$news_id"; 
                $sql_review_query = "select * from review where news_id=$news_id and state='已审核'"; 

                //执行2条SQL语句 
                get_connection(); 
                $result_news = $database_connection->query($sql_news_detail); 
                $result_review = $database_connection->query($sql_review_query); 

                //取出结果集中新闻条数 
                $count_news = ($result_news instanceof mysqli_result? $result_news->num_rows:0); 

                //取出结果集中该新闻"已审核"的评论条数 
                $count_review = ($result_review instanceof mysqli_result? $result_review->num_rows:0);
                if($count_news == 0){
                    include_once("error_pages/404.html"); }
                else{
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
                    $thumbnail = $news['thumbnail'];
                    $attatchment = urlencode($news['attachment']);
                    $category_name = $category['name'];
        
                    if($keyword){ 
                        $replacement = "<span style='color: red'><b><i>".$keyword."</b></i></span>";  
                        $title = str_replace($keyword,$replacement,$title); 
                        $content = str_replace($keyword,$replacement,$content); 
                        $user = str_replace($keyword,$replacement,$user); 
                    } 
                    
                    //显示新闻详细信息 
                    ?> 
                    <!-- Breadcrumb Start -->
                    <div class="breadcrumb-wrap">
                        <div class="container">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">首页</a></li>
                                <li class="breadcrumb-item"><a href="index.php?url=category_list.php">新闻</a></li>
                                <li class="breadcrumb-item"><a href="index.php?url=category_list.php&category_id=<?=$category_id?>&page_size=10"><?php echo $category_name;?></a></li>
                                <li class="breadcrumb-item active"><?=$title?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Breadcrumb End -->
                    
                    <!-- Single News Start-->
                    <div class="single-news">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="sn-container">
                                        <div style="display: flex;" class="text-body">
                                            <div><i class="fa-regular fa-calendar-days"></i>&nbsp; <?php echo $news['publish_time'];?></div>
                                            &emsp;
                                            <div><i class="fa-solid fa-user"></i>&nbsp; 发布者：<?php echo ($user) ;?></div>
                                            &emsp;
                                            &emsp;
                                            <div>
                                                &nbsp; 
                                                <?php if(is_admin()){ 
                                                ?> 
                                                    <td> 
                                                    
                                                    <a href="index.php?url=news_add.php&news_id=<?=$news_id?>"><i class="fa-regular fa-pen-to-square"></i>&nbsp; 编辑</a> 
                                                    </td> 
                                                    &emsp;
                                                    <td> 
                                                    <a href="index.php?url=news_delete.php&news_id=<?=$news_id?>" onclick="return confirm('确定删除吗？');"><i class="fa-regular fa-trash-can"></i>&nbsp; 删除</a> 
                                                    </td> 
                                                <?php } ?> 
                                            </div>
                                        </div>

                                        <hr />
                                        <br />
                                        
                                        <div class="sn-img">
                                            <img src="<?php echo $thumbnail?>" />
                                        </div>

        
                                        <div class="sn-content">
                                            <div style="text-align: center;">
                                                <h1 class="sn-title"><?php echo $title;?></h1>
                                            </div>
        
                                            <p><?php echo $content;?></p>
        
                                            <br />
                                            <?php if($attatchment){ ?> 
                                            <hr />
                                            <a href="download.php?attachment=<?php echo $attatchment;?>">附件：<?php echo $news['attachment'];?></a> <?php }?>
                                        </div>
                                        
                                        <hr />
                                        <br />
                                        <br />
                                        
                                        <div class="sn-comment">
                                            <form action="review_save.php" method="post" class="contact-form"> 
                                                <textarea name="content" cols="50" rows="5" placeholder="添加评论"></textarea>
                                                <input type="hidden" name="news_id" value="<?php echo $news['news_id'];?>"> 
                                                &emsp13;
                                                <input type="submit" value="评论" class="btn"> 
                                            </form>
                                        </div> 

                                        <br />
                                        <br />

                                        <div style="text-align: right;">
                                            <i class="fa-regular fa-eye"></i>&nbsp; <?php echo $news['clicked'];?>
                                            &emsp;
                                            <i class="fa-regular fa-comment"></i>&nbsp; <?php echo $count_review;?>
                                        </div>
                                        
                                        <div class="sn-content">
                                            <h4>评论区</h4>
                                            <br/>
                                            <?php 
                                            //显示查看评论超链接 
                                            if($count_review>0){  
                                                include_once("review_news_list.php");
                                            }else{ 
                                                echo "<p>该新闻暂无评论！</p>"; 
                                            } 
                                            ?>
                                        </div>

                                    </div>


                                    <br />
        

                                    <div class="sn-related">
                                        <h2>相关新闻</h2>
                                        <?php include("sn-related_news.php"); ?>
                                    </div>
                                </div>
        
                                <div class="col-lg-4">
                                    <div class="sidebar">
                                        <div class="sidebar-widget">
                                            <?php include("sn-same_category_list.php"); ?>
                                        </div>
        
                                        <div class="sidebar-widget">
                                            <div class="tab-news">
                                                <ul class="nav nav-pills nav-justified">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="pill" href="#featured">特色新闻</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="#popular"><i class="fa-solid fa-fire"></i> 热门</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="#latest">最新</a>
                                                    </li>
                                                </ul>
        
                                                <div class="tab-content">
                                                    <?php include("sn-tab_news.php"); ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
        
                                        <div class="sidebar-widget">
                                            <h2 class="sw-title"><a href="index.php?url=category_list.php">新闻分类</a></h2>
                                            <div class="category">
                                                <?php include("sn-category_list.php"); ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single News End-->        

                
                <?php }
            } ?>
            
        </div> 
                

        <?php include_once "footer.php" ?>

    </body>
</html>
