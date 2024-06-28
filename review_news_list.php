<div>
     <?php 
     include_once("functions/database.php"); 

     $sql = 
          "SELECT users.name, review.publish_time, review.content, review.ip, review.state
          FROM users INNER JOIN review ON users.user_id = review.user_id
          WHERE (((review.news_id)=$news_id) AND ((review.state)='ÒÑÉóºË'))
          ORDER BY publish_time DESC
          LIMIT 50;"; 
     get_connection(); 
     $result_set = $database_connection->query($sql); 
     close_connection(); 

     while($row = $result_set->fetch_array()){ ?>
          <div class="media">
               <img src="img/user.png" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
               <div class="media-body">
                    <h6> <a class="text-secondary font-weight-bold" href=""><?=$row["name"]?> </a> <small><i> <?php echo $row["publish_time"]; ?></i></small></h6>
                    <p><?php echo $row["content"]; ?></p>
                    <p>IP: <?php echo  $row["ip"] ?></p>
               </div>
          </div>
               <hr>
     <?php } ?> 
</div>