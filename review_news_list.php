
<div>
     <?php 
     include_once("functions/database.php"); 
     $sql = "select * from review where news_id=$news_id and state='ÒÑÉóºË' order by publish_time desc limit 50"; 
     get_connection(); 
     $result_set = $database_connection->query($sql); 
     close_connection(); 

     while($row = $result_set->fetch_array()){ ?>
          <div class="media">
               <img src="img/user.png" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
               <div class="media-body">
                    <?php 
                    get_connection();
                    $user_id = $row["user_id"];
                    $sql_user = "select name from users where user_id=$user_id"; 
                    $result_user = $database_connection->query($sql_user); 
                    $user = ($result_user instanceof mysqli_result? $result_user->fetch_array():["name"=>"Î´Öª"]);
                    // $ipdat = "http://ip-api.com/json/" . $row["ip"];
                    // $response = file_get_contents($ipdat);

                    // Decode the JSON response
                    // $data = json_decode($response);

                    // Extract the city name (if available)
                    // $city = @$data->city;
                    // $city = $ipdat->geoplugin_city;  
                    close_connection();
                    ?>
                    <h6> <a class="text-secondary font-weight-bold" href=""><?=$user["name"]?> </a> <small><i> <?php echo $row["publish_time"]; ?></i></small></h6>
                    <p><?php echo $row["content"]; ?></p>
                    <p>IP: <?php echo  $row["ip"] ?></p>
                    <!-- <p>IP: <?#php echo (isset($city)?$city:"Î´Öª") ?></p> -->
               </div>
          </div>
               <hr>
     <?php } ?> 
</div>