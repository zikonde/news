<?php 
include_once("functions/is_login.php"); 
if (!session_id()){
    session_start(); 
} 
if(!is_login()){ 
    echo "���¼���ٲ鿴��ҳ�棡";
    return; 
} 
?> 
<body>
     <script> 
       var $new_category = document.getElementsByName("new_category").value;
       var $new_description= document.getElementsByName("new_description").value;
        if($new_category!=0&&$new_description!=0){
            "�ύ�ɹ���";
        }else if($new_category==0){
            "���������";
        }else if($new_description==0){
            "���������������";
        }

     </script>
    <form>
        ����������������ƣ�
        <input type="text" name="new_category" style="width:200px ; height:50px;">
        �������������������
        <input type="text" name="new_description" style="width:200px ; height:50px;">
        <input type="submit" value="���" /> 
    </form>
</body>