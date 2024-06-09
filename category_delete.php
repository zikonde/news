<?php 
include_once("functions/is_login.php"); 
include_once("functions/url_navigator.php");

if(!is_admin()){ 
     echo "请您登录系统后，再访问该页面！"; 
     return; 
}else{
    include_once("functions/delete.php"); 
    include_once("functions/get_url_parameters.php");

    $message = delete_category($category_id); 

    // $message = "新闻及相关评论信息删除成功！"; 
    header("Location:".add_to_url(["message"     => $message])); 
} 
?> 
<?php 
?> 