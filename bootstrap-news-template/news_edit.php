<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

if(!is_login()){ 
     echo "请您登录系统后，再访问该页面！"; 
     return; 
} else{
     include_once("functions/database.php"); 
     $news_id = $_GET["news_id"]; 

     $database_connection = get_connection(); 
     
     $result_news = mysqli_query($database_connection, "select * from news where news_id=$news_id"); 
     $result_category = mysqli_query($database_connection, "select * from category"); 

     close_connection(); 

     $news = mysqli_fetch_array($result_news); 
     ?> 

     <form action="news_update.php" method="post"> 
          标题：<input type="text"  size="60" name="title" value="<?php echo $news['title']?>">
          <br/> 
          内容：<?php 
          include("fckeditor/fckeditor.php");		//载入FCKeditor类文件 
          $oFCKeditor = new FCKeditor('content');  // 创建content在线编辑器，实例名为$oFCKeditor 
          $oFCKeditor->BasePath = 'fckeditor/';  		// 设置FCKeditor实例的根目录 
          $oFCKeditor->Width = 550;  				// 设置FCKeditor实例的宽度 
          $oFCKeditor->Height = 350;  				// 设置FCKeditor实例的高度 
          $oFCKeditor->Value = $news['content'];  	// 设置FCKeditor实例的内容 
          $oFCKeditor->ToolbarSet = "Default"; 		//设置FCKeditor实例的工具栏集合 
          $oFCKeditor->Config['EnterMode'] = 'br';	//设置FCKeditor实例的额外配置 
          $oFCKeditor->Create() ; 					//显示在线编辑器的HTML代码 
          ?> 
          <br/> 
          类别：<select name="category_id" size="1"> 
               <?php 
               while($category = mysqli_fetch_array($result_category)){ 
               ?> 
                    <option value="<?php echo $category['category_id'];?>" <?php echo ($news ['category_id']==$category['category_id'])?"selected":""?> >
                         <?php echo $category ['name'];?> 
                    </option> 
               <?php 
               } 
               ?> 
          </select>

          <br/> 
          <br/> 

          <input type="hidden" name="news_id" value="<?php echo $news_id?>"> 
          <input type="submit" value="修改"> 
          <input type="button" value="取消" onclick="window.history.back();"> 
     </form> 

<?php } ?>