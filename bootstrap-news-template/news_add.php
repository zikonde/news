<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
        
    <?php include_once "top_and_nav_bar.php" ?>

        
    <div id="mainfunction"> 
        <?php 
        include_once("functions/is_login.php"); 
        include_once("functions/session_config.php"); 

        if(!is_login()){ 
            echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
            return; 
        }else{?>  
            <form action="news_save.php" method="post" enctype="multipart/form-data"> 
                <div style="font-size: 20px; font-weight: bold; text-align:center">
                    <p>���ŷ���</p>
                    <img src="images/thumbnail.jpg" width="150" height="150" id="news_image"> <input type = "file" id="thumbnail" name="thumbnail" accept="image/*" size="50" onchange="updateThumbnail()" >
                </div>

                <br />

                ���⣺	<input type="text"  size="60" name="title" placeholder="���ڴ��������ŵı���">
                
                <br/> 
                <br />
                
                ���ݣ�	<?php 
                include("fckeditor/fckeditor.php");//����FCKeditor���ļ� 
                $oFCKeditor = new FCKeditor('content');  // ��������Ϊcontent���߱༭����ʵ����Ϊ$oFCKeditor 
                $oFCKeditor->BasePath = 'fckeditor/';  // ����FCKeditorʵ���ĸ�Ŀ¼ 
                $oFCKeditor->Width = 550;  				// ����FCKeditorʵ���Ŀ�� 
                $oFCKeditor->Height = 350;  				// ����FCKeditorʵ���ĸ߶� 
                $oFCKeditor->Value = "���ڴ��������ŵ����ݣ�";	// ����FCKeditorʵ�������� 
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
                        <option value="<?php echo $row['category_id'];?>">
                            <?php echo $row['name'];?>
                        </option> 
                    <?php 
                    } 
                    ?> 
                </select>
                
                <br/> 
                <br />
                
                ������	<input type="file" name="news_file" size="50"> 
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                
                <br/> 
                <br />
                
                <p style="text-align:center"><input type="submit" value="�ύ"> &emsp;<input type="reset" value="����"> </p>

                <br />
            </form>    
        <?php } 
        ?>
        
    </div> 
        
    
    <?php include_once "footer.php" ?>

    
</body>

</html>