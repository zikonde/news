<?php 
if($_SERVER["PHP_SELF"] === "/category_add.php"){
    header("location:../index.php");
}else{
    include_once("functions/is_login.php"); 
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
        <form action="index.php?url=category_add_process.php" method="post">
            ����������������ƣ�
            <input type="text" name="new_category" style="width:200px ; height:50px;">
            <br />
            �������������������
            <input type="text" name="new_description" style="width:200px ; height:50px;">
            <br />
            <input type="submit" value="���" /> 
        </form>
    </body>
<?php } ?>