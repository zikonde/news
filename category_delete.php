<?php 
include_once("functions/is_login.php"); 
include_once("functions/url_navigator.php");

if(!is_admin()){ 
     echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
     return; 
}else{
    include_once("functions/delete.php"); 
    include_once("functions/get_url_parameters.php");

    $message = delete_category($category_id); 

    // $message = "���ż����������Ϣɾ���ɹ���"; 
    header("Location:".add_to_url(["message"     => $message])); 
} 
?> 
<?php 
?> 