<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

if(!is_login()){ 
     echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
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
          ���⣺<input type="text"  size="60" name="title" value="<?php echo $news['title']?>">
          <br/> 
          ���ݣ�<?php 
          include("fckeditor/fckeditor.php");		//����FCKeditor���ļ� 
          $oFCKeditor = new FCKeditor('content');  // ����content���߱༭����ʵ����Ϊ$oFCKeditor 
          $oFCKeditor->BasePath = 'fckeditor/';  		// ����FCKeditorʵ���ĸ�Ŀ¼ 
          $oFCKeditor->Width = 550;  				// ����FCKeditorʵ���Ŀ�� 
          $oFCKeditor->Height = 350;  				// ����FCKeditorʵ���ĸ߶� 
          $oFCKeditor->Value = $news['content'];  	// ����FCKeditorʵ�������� 
          $oFCKeditor->ToolbarSet = "Default"; 		//����FCKeditorʵ���Ĺ��������� 
          $oFCKeditor->Config['EnterMode'] = 'br';	//����FCKeditorʵ���Ķ������� 
          $oFCKeditor->Create() ; 					//��ʾ���߱༭����HTML���� 
          ?> 
          <br/> 
          ���<select name="category_id" size="1"> 
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
          <input type="submit" value="�޸�"> 
          <input type="button" value="ȡ��" onclick="window.history.back();"> 
     </form> 

<?php } ?>