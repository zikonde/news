<div>
     <?php 
     include_once("includes/sn-model.php");  

     while($row = $result_set_reviews->fetch_array()){ ?>
          <div class="media">
               <img src="/img/user.png" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
               <div class="media-body">
                    <h6> <a class="text-secondary font-weight-bold" href=""><?=$row["name"]?> </a> <small><i> <?php echo $row["publish_time"]; ?></i></small></h6>
                    <p><?php echo $row["content"]; ?></p>
                    <p>IP: <?php echo  $row["ip"] ?></p>
               </div>
          </div>
               <hr>
     <?php } ?> 
</div>