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
            echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
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
            $content = $news['content'] ? $news['content'] : "���ڴ��������ŵ����ݣ�";
            $category_id = $news['category_id'];
            $attachment = $news['attachment'];
            
            ?>  

            <div class="breadcrumb-wrap">
                <div class="container">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">��ҳ</a></li>
                        <li class="breadcrumb-item active">����<?=($news?"�༭":"����")?></li>
                    </ul>
                </div>
            </div>
            <!-- Breadcrumb End -->
            
            <br />
                    
            <form action="<?=($news?"news_update.php":"news_save.php")?>" method="post" enctype="multipart/form-data"> 
                <div style="font-size: 20px; font-weight: bold; text-align:center">
                    <h1 class="sn-title">����<?=($news?"�༭":"����")?></h1>
                    <br /> 
                    <img src="<?=$thumbnail?>" width="300" height="200" id="news_image"> 
                    &emsp; 
                    <input type = "file" id="thumbnail" name="thumbnail" accept="image/*" size="50" onchange="updateThumbnail()" >
                    <br />
                    <span style="font-size: small;color:red"> ͼƬ����Ҫ��Ϊ 3:2</span>
                </div>

                <br />

                ���⣺	<input type="text"  size="60" name="title" placeholder="���ڴ��������ŵı���" value="<?php echo $title?>">
                
                <br/> 
                <br />
                
                ���ݣ�	<?php 
                include("fckeditor/fckeditor.php");         //����FCKeditor���ļ� 
                $oFCKeditor = new FCKeditor('content');     // ��������Ϊcontent���߱༭����ʵ����Ϊ$oFCKeditor 
                $oFCKeditor->BasePath = 'fckeditor/';       // ����FCKeditorʵ���ĸ�Ŀ¼ 
                $oFCKeditor->Width = 550;  				    // ����FCKeditorʵ���Ŀ�� 
                $oFCKeditor->Height = 350;  				// ����FCKeditorʵ���ĸ߶� 
                $oFCKeditor->Value = $content;          	// ����FCKeditorʵ�������� 
                $oFCKeditor->ToolbarSet = "Default";		// ����FCKeditorʵ���Ĺ��������� 
                $oFCKeditor->Config['EnterMode'] = 'br';	// ����FCKeditorʵ���Ķ������� 
                $oFCKeditor->Create() ; 					// ��ʾ���߱༭����HTML���� 
                ?> 
                
                <br/>
                <br />
                
                ���<select name="category_id" size="1"> 
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
                    ������	<input type="file" name="attachment" size="50"> &emsp14;
                    <span> <?php if($attachment){ echo"���ڸ�����<a href='download.php?attachment=$attachment'>".$attachment."</a>";}?></span>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                
                <br/> 
                <br />
                
                <input type="hidden" name="news_id" value="<?php echo $news_id?>">
                <input type="hidden" name="available_attchment" value="<?=$attachment?>" value="<?php echo $news_id?>">
                <input type="hidden" name="available_thumbnail" value="<?=$thumbnail?>" 


                <p style="text-align:center">
                    <input type="submit" value="<?=($news?"�޸�":"�ύ")?>"> 
                    &emsp; 
                    <input type="reset" <?=($news?" value=\"ȡ��\" onclick=\"window.history.back();\" ":"value=\"����\" ")?>> 
                </p>

                <br />
            </form>    
        <?php } 
        ?>
        
    </div> 
        
    
    <?php include_once "footer.php" ?>

    
</body>

</html>