
<?php
function display($category_id){
    include_once("functions/is_login.php"); 
    include_once("functions/url_navigator.php");
    include_once("functions/get_url_parameters.php");

    if(!is_admin()){ 
        include_once("error_pages/404.html"); 
        return; 
    }else{
        include_once("functions/delete.php"); 

        $message = delete_category($category_id); 
        
        // $message = "新闻及相关评论信息删除成功！"; 
        header("Location:".add_to_url(["message"=> $message])); 
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <?php include_once "top_and_nav_bar.php" ?>
            
    <div id="mainfunction"> 
        <?php 
        display($category_id);
        ?> 
    </div> 
            
    <?php include_once "footer.php" ?>
        
</body>
</html>
