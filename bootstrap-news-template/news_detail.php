<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap News Template - Free HTML Templates</title>
    </head>

    <body>
        

        <?php include_once "top_and_nav_bar.php" ?>
    
                
        <div id="mainfunction" style="text-align: justify;"> 
            <?php 
            include_once("functions/database.php"); 

            $news_id = isset($_GET["news_id"])? addslashes(intval($_GET["news_id"])):0; 

            if($news_id==0){ 
                echo "�����Ų����ڻ��ѱ�ɾ����"; 
            }else{
                //����3��SQL��� 
                // $sql_news_update = "update news set clicked=clicked+1 where news_id=$news_id";
                $sql_news_detail = "select * from news where news_id=$news_id"; 
                $sql_review_query = "select * from review where news_id=$news_id and state='�����'"; 

                //ִ��3��SQL��� 
                get_connection(); 
                
                // $database_connection->query($sql_news_update); 
                $result_news = $database_connection->query($sql_news_detail); 
                $result_review = $database_connection->query($sql_review_query); 

                //ȡ����������������� 
                $count_news = ($result_news instanceof mysqli_result? $result_news->num_rows:0); 

                //ȡ��������и�����"�����"���������� 
                $count_review = ($result_review instanceof mysqli_result? $result_review->num_rows:0);
                if($count_news == 0){
                echo "�����Ų����ڻ��ѱ�ɾ����"; }
                else{
                    //����������Ϣ�е�user_id��ѯ��Ӧ���û���Ϣ 
                    $news =$result_news->fetch_array(); 
                    $user_id = $news["user_id"]; 
                    $sql_user = "select name from users where user_id=$user_id"; 
                    $result_user = $database_connection->query($sql_user); 
                    $user = ($result_user instanceof mysqli_result? $result_user->fetch_array():["name"=>"δ֪"]);
                    
                    //����������Ϣ�е�category_id��ѯ��Ӧ�����������Ϣ 
                    $category_id = $news["category_id"]; 
                    $sql_category = "select name from category where category_id=$category_id"; 
                    $result_category =$database_connection->query($sql_category); 
                    $category = ($result_category instanceof mysqli_result? $result_category->fetch_array():["name"=>"����"]);
                    
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
        
                    if(isset($_GET["keyword"])){ 
                        $keyword = addslashes($_GET["keyword"]); 
                        $replacement = "<span style='color: red'><b><i>".$keyword."</b></i></span>";  
                        $title = str_replace($keyword,$replacement,$title); 
                        $content = str_replace($keyword,$replacement,$content); 
                        $user = str_replace($keyword,$replacement,$user); 
                    } 
                    
                    //��ʾ������ϸ��Ϣ 
                    ?> 
                    <!-- Breadcrumb Start -->
                    <div class="breadcrumb-wrap">
                        <div class="container">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">��ҳ</a></li>
                                <li class="breadcrumb-item"><a href="#">����</a></li>
                                <li class="breadcrumb-item"><a href="#"><?php echo $category_name;?></a></li>
                                <li class="breadcrumb-item active">��������</li>
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
                                            <div><i class="fa-solid fa-user"></i>&nbsp; �����ߣ�<?php echo ($user) ;?></div>
                                        </div>

                                        <hr />
                                        <br />
                                        
                                        <div class="sn-img">
                                            <img src="<?php echo $thumbnail?>" />
                                        </div>

        
                                        <div class="sn-content">
                                            <h1 class="sn-title"><?php echo $title;?></h1>
        
                                            <?php echo $content;?>
        
                                            <br />
                                            <?php if($attatchment){ ?> 
                                            <hr />
                                            <a href="download.php?attachment=<?php echo $attatchment;?>">������<?php echo $news['attachment'];?></a> <?php }?>
                                        </div>
                                        
                                        <hr />
                                        <br />
                                        <br />
                                        
                                        <div class="sn-comment">
                                            <form action="review_save.php" method="post" class="contact-form"> 
                                                <textarea name="content" cols="50" rows="5" placeholder="�������"></textarea>
                                                <input type="hidden" name="news_id" value="<?php echo $news['news_id'];?>"> 
                                                &emsp13;
                                                <input type="submit" value="����" class="btn"> 
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
                                            <h4>������</h4>
                                            <br/>
                                            <?php 
                                            //��ʾ�鿴���۳����� 
                                            if($count_review>0){  
                                                include_once("review_news_list.php");
                                            }else{ 
                                                echo "<p>�������������ۣ�</p>"; 
                                            } 
                                            ?>
                                        </div>

                                    </div>


                                    <br />
        

                                    <div class="sn-related">
                                        <h2>Related News</h2>
                                        <div class="row sn-slider">
                                            <div class="col-md-4">
                                                <div class="sn-img">
                                                    <img src="img/news-350x223-1.jpg" />
                                                    <div class="sn-title">
                                                        <a href="">Interdum et fames ac ante</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="sn-img">
                                                    <img src="img/news-350x223-2.jpg" />
                                                    <div class="sn-title">
                                                        <a href="">Interdum et fames ac ante</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="sn-img">
                                                    <img src="img/news-350x223-3.jpg" />
                                                    <div class="sn-title">
                                                        <a href="">Interdum et fames ac ante</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="sn-img">
                                                    <img src="img/news-350x223-4.jpg" />
                                                    <div class="sn-title">
                                                        <a href="">Interdum et fames ac ante</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                        <a class="nav-link active" data-toggle="pill" href="#featured">Featured</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="#popular">����</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="#latest">����</a>
                                                    </li>
                                                </ul>
        
                                                <div class="tab-content">
                                                    <?php include("sn-tab_news-featured.php"); ?>

                                                    <?php include("sn-tab_news-popular.php"); ?>

                                                    <?php include("sn-tab_news-latest.php"); ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
        
                                        <div class="sidebar-widget">
                                            <h2 class="sw-title">���ŷ���</h2>
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
