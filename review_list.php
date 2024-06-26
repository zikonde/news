<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
        
     <?php include_once "top_and_nav_bar.php" ?>

     
     <div id="mainfunction" style="text-align: justify;"> 
          <?php 
          include_once("functions/is_login.php"); 
          if (!session_id()){//这里使用session_id()判断是否已经开启了Session 
               session_start(); 
          } 
          if(!is_admin()){ 
               include_once("error_pages/404.html"); 
               return; 
          }else{
          include_once("functions/database.php"); 
          include_once("functions/page.php");
          include_once("functions/get_url_parameters.php"); 
          
          $sql = "select * from review"; 
          get_connection(); 
          //分页的实现 
          $result_news = $database_connection->query($sql); 
          $total_records = $result_news->num_rows; 
          
          $result_sql = "select * from review order by review_id desc limit $start,$page_size"; 
          $result_set = $database_connection->query($result_sql); 
          close_connection(); ?>

          
          <div class="breadcrumb-wrap">
               <div class="container">
               <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">首页</a></li>
                    <li class="breadcrumb-item active">评论浏览</li>
               </ul>
               </div>
          </div>
          <!-- Breadcrumb End -->
          
          <br />

          <h1 class="sn-title" style="text-align: center;">系统所有评论信息如下：</h1>
          <br />

          <hr/>
          <?php
          while($row = $result_set->fetch_array()){ ?>
               <div class="media">
                    <img src="img/user.png" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                    <div class="media-body">
                         <?php 
                         get_connection();
                         $user_id = $row["user_id"];
                         $sql_user = "select name from users where user_id=$user_id"; 
                         $result_user = $database_connection->query($sql_user); 
                         $user = ($result_user instanceof mysqli_result? $result_user->fetch_array():["name"=>"未知"]);
                         close_connection();
                         ?>
                         <h6> <a class="text-secondary font-weight-bold" href=""><?=$user["name"]?> </a> <small><i> <?php echo $row["publish_time"]; ?></i></small></h6>
                         <p><?php echo $row["content"]; ?></p>
                         <p>IP: <?php echo  $row["ip"] ?></p>
                         <a href='review_delete.php?review_id=<?=$row["review_id"]?>' onclick='return confirm("确定删除该评论？")'>删除</a>
                         &emsp;
                         <?php if($row["state"]=="未审核"){ ?>
                              <a href='review_verify.php?review_id=<?=$row["review_id"]?>'>审核</a>
                         <?php } ?>
                    </div>
               </div>
               <hr/>
               <br>
               <?php
          } 
          //打印分页导航条
          $url = $_SERVER["REQUEST_URI"]; 
          //$url = "index.php?url=review_list.php"; 
          page($total_records,$page_size,$page_current,$url,""); 
          ?> 
          <?php } 
          ?> 
     </div> 

        
     <?php include_once "footer.php" ?>

    
</body>
</html>