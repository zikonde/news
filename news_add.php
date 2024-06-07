<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
        
    <?php include_once "top_and_nav_bar.php" ?>

        
    <div id="mainfunction" style="text-align: center;"> 
        <?php 
        include_once("functions/is_login.php"); 
        include_once("functions/session_config.php"); 

        if(!is_admin()){ 
            echo "请您登录系统后，再访问该页面！"; 
            return; 
        }else{ 
            include_once("functions/database.php"); 
            $news_id = (isset($_GET["news_id"])? intval($_GET["news_id"]):0); 
       
            $database_connection = get_connection(); 
            
            $result_news = mysqli_query($database_connection, "select * from news where news_id=$news_id"); 
            $result_category = mysqli_query($database_connection, "select * from category"); 
       
            close_connection(); 
       
            $news = mysqli_fetch_array($result_news); 
            $thumbnail = $news['thumbnail'] ? $news['thumbnail'] :"images/thumbnail.jpg";
            $title = $news['title'];
            $content = $news['content'] ? $news['content'] : "请在此输入新闻的内容！";
            $category_id = $news['category_id'];
            $attachment = $news['attachment'];
            
            ?>  

            <div class="breadcrumb-wrap">
                <div class="container">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">首页</a></li>
                        <li class="breadcrumb-item active">新闻<?=($news?"编辑":"发布")?></li>
                    </ul>
                </div>
            </div>
            <!-- Breadcrumb End -->
            
            <br />
                    
            <form action="<?=($news?"news_update.php":"news_save.php")?>" method="post" enctype="multipart/form-data"> 
                <div style="font-size: 20px; font-weight: bold; text-align:center">
                    <h1 class="sn-title">新闻<?=($news?"编辑":"发布")?></h1>
                    <br /> 
                    <img src="<?=$thumbnail?>" width="300" height="200" id="news_image"> 
                    &emsp; 
                    <input type = "file" id="thumbnail" name="thumbnail" accept="image/*" size="50" onchange="updateThumbnail()" >
                    <br />
                    <span style="font-size: small;color:red"> 图片比例要求为 3:2</span>
                </div>

                <br />

                标题：	<input type="text"  size="60" name="title" placeholder="请在此输入新闻的标题" value="<?php echo $title?>">
                
                <br/> 
                <br />
                
                内容：	<?php 
                include("fckeditor/fckeditor.php");         //载入FCKeditor类文件 
                $oFCKeditor = new FCKeditor('content');     // 创建名称为content在线编辑器，实例名为$oFCKeditor 
                $oFCKeditor->BasePath = 'fckeditor/';       // 设置FCKeditor实例的根目录 
                $oFCKeditor->Width = 550;  				    // 设置FCKeditor实例的宽度 
                $oFCKeditor->Height = 350;  				// 设置FCKeditor实例的高度 
                $oFCKeditor->Value = $content;          	// 设置FCKeditor实例的内容 
                $oFCKeditor->ToolbarSet = "Default";		// 设置FCKeditor实例的工具栏集合 
                $oFCKeditor->Config['EnterMode'] = 'br';	// 设置FCKeditor实例的额外配置 
                $oFCKeditor->Create() ; 					// 显示在线编辑器的HTML代码 
                ?> 
                
                <br/>
                <br />
                
                类别：<select name="category_id" size="1"> 
                    <?php 
                    include_once("functions/database.php"); 
                    get_connection(); 
                    $result_set = $database_connection->query("select * from category;"); 
                    close_connection(); 

                    while($row = $result_set->fetch_array()){ 
                    ?> 
                        <option value="<?php echo $row['category_id'];?>" <?php echo ($category_id==$row['category_id'])?"selected":""?> >
                            <?php echo $row['name'];?>
                        </option> 
                    <?php 
                    } 
                    ?> 
                </select>
                
                <br/> 
                <br />
                
                <div>
                    附件：	<input type="file" name="attachment" size="50"> &emsp14;
                    <span> <?php if($attachment){ echo"现在附件：<a href='download.php?attachment=$attachment'>".$attachment."</a>";}?></span>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                
                <br/> 
                <br />
                
                <input type="hidden" name="news_id" value="<?php echo $news_id?>">
                <input type="hidden" name="available_attchment" value="<?=$attachment?>" value="<?php echo $news_id?>">
                <input type="hidden" name="available_thumbnail" value="<?=$thumbnail?>" 


                <p style="text-align:center">
                    <input type="submit" value="<?=($news?"修改":"提交")?>"> 
                    &emsp; 
                    <input type="reset" <?=($news?" value=\"取消\" onclick=\"window.history.back();\" ":"value=\"重置\" ")?>> 
                </p>

                <br />
            </form>    
        <?php } 
        ?>
        
    </div> 
        
    
    <?php include_once "footer.php" ?>

    
</body>

</html>