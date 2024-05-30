<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

if(!is_login()){ 
    echo "请您登录系统后，再访问该页面！"; 
    return; 
}else{?>  
    <form action="news_save.php" method="post" enctype="multipart/form-data"> 
        标题：	<input type="text"  size="60" name="title" placeholder="请在此输入新闻的标题">
        
        <br/> 
        
        内容：	<?php 
        include("fckeditor/fckeditor.php");//载入FCKeditor类文件 
        $oFCKeditor = new FCKeditor('content');  // 创建名称为content在线编辑器，实例名为$oFCKeditor 
        $oFCKeditor->BasePath = 'fckeditor/';  // 设置FCKeditor实例的根目录 
        $oFCKeditor->Width = 550;  				// 设置FCKeditor实例的宽度 
        $oFCKeditor->Height = 350;  				// 设置FCKeditor实例的高度 
        $oFCKeditor->Value = "请在此输入新闻的内容！";	// 设置FCKeditor实例的内容 
        $oFCKeditor->ToolbarSet = "Default";		// 设置FCKeditor实例的工具栏集合 
        $oFCKeditor->Config['EnterMode'] = 'br';	// 设置FCKeditor实例的额外配置 
        $oFCKeditor->Create() ; 					// 显示在线编辑器的HTML代码 
        ?> 
        
        <br/>
        
        类别：<select name="category_id" size="1"> 
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
        
        附件：	<input type="file" name="news_file" size="50"> 
        <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
        
        <br/> 
        
        <input type="submit" value="提交"><input type="reset" value="重置"> 
    </form>    
<?php } 
?>