<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    
        
    <?php include_once "top_and_nav_bar.php" ?>

                
    <div id="mainfunction">     
        <?php 
        if($_SERVER["PHP_SELF"] === "/category_add.php"){
            header("location:../index.php");
        }else{
            include_once("functions/is_login.php"); 
            if(!is_admin()){ 
                echo "请登录后再查看该页面！";
                return; 
            } 
            ?> 
            <body>
                <script> 
                var $new_category = document.getElementsByName("new_category").value;
                var $new_description= document.getElementsByName("new_description").value;
                    if($new_category!=0&&$new_description!=0){
                        "提交成功！";
                    }else if($new_category==0){
                        "请输入类别！";
                    }else if($new_description==0){
                        "请输入类别描述！";
                    }

                </script>
                
                <div class="breadcrumb-wrap">
                    <div class="container">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">首页</a></li>
                            <li class="breadcrumb-item active">添加分类</li>
                        </ul>
                    </div>
                </div>
                <!-- Breadcrumb End -->
                
                <br />
                
                <form action="index.php?url=category_add_process.php" method="post">
                    请输入新增类别名称：
                    <input type="text" name="new_category" style="width:200px ; height:50px;">
                    <br />
                    <br />
                    请输入新增类别描述：
                    <input type="text" name="new_description" style="width:200px ; height:50px;">
                    <br />
                    <br />
                    <input type="submit" value="添加" /> 
                </form>
            </body>
        <?php } ?>
        <br />
    </div> 
            
        
    <?php include_once "footer.php" ?>
        
            
</body>
</html>