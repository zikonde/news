<?php 
if($_SERVER["PHP_SELF"] === "/category_add_process.php"){
    header("location:../index.php");
}else{
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          include_once("functions/database.php");
          include_once("functions/is_login.php"); 
          include_once("functions/url_navigator.php");


          if(!is_login()){ 
               echo "请您登录后在访问该页面！"; 
               return; 
          }else{
               include_once("functions/database.php"); 
               
               $new_category = $_POST["new_category"]; 
               if(empty($new_category)){
                    $message = "请输入类别！"; 
                    header("Location:".add_to_url(["message"=> $message]));
               }else{
                    $new_description = $_POST["new_description"];  

                    $sql = "insert into category values(null, '$new_category', '$new_description')"; 

                    get_connection(); 
                    var_dump(mysqli_query($database_connection,$sql)); 
                    close_connection(); 

                    header("Location:index.php"); 
               }
          }  
     }
}
?> 