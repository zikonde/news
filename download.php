<?php 
include_once("functions/is_login.php");
include_once("functions/file_system.php"); 
include_once("functions/url_navigator.php");
include_once("functions/get_url_parameters.php");

if(is_login()){ 
    if($file_name){ 
        download("uploads/","$file_name"); 
    }
}else{ 
    echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡";
    header("location:".add_to_url(['message'=>"���ȵ�¼ϵͳ��"])); 
} 
?> 