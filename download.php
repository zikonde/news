<?php 
include_once("functions/is_login.php");
include_once("functions/file_system.php"); 
include_once("url_navigator.php");

if(is_login()){ 
    if(isset($_GET["attachment"])){ 
        $file_name = $_GET["attachment"]; 
        download("uploads/","$file_name"); 
    }
}else{ 
    echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡";
    header("location:".add_to_url(['message'=>"���ȵ�¼ϵͳ��"])); 
} 
?> 