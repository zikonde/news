<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
        
     <?php include_once "top_and_nav_bar.php" ?>

     
     <div id="mainfunction" style="text-align: justify;"> 
          <?php 
          include_once("functions/is_login.php"); 
          if (!session_id()){//����ʹ��session_id()�ж��Ƿ��Ѿ�������Session 
               session_start(); 
          } 
          if(!is_admin()){ 
               echo "������¼ϵͳ���ٷ��ʸ�ҳ�棡"; 
               return; 
          }else{
          include_once("functions/database.php"); 
          include_once("functions/page.php");
          
          $sql = "select * from review"; 
          get_connection(); 
          //��ҳ��ʵ�� 
          $result_news = $database_connection->query($sql); 
          $total_records = $result_news->num_rows; 
          $page_size = (isset($_GET["page_size"])? (intval($_GET["page_size"])>0?intval($_GET["page_size"]):3):3);; 
          $page_current = (isset($_GET["page_current"])?(intval($_GET["page_current"])>0?intval($_GET["page_current"]):1):1); 
          $start = ($page_current-1)*$page_size; 
          
          $result_sql = "select * from review order by review_id desc limit $start,$page_size"; 
          $result_set = $database_connection->query($result_sql); 
          close_connection(); ?>

          
          <div class="breadcrumb-wrap">
               <div class="container">
               <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">��ҳ</a></li>
                    <li class="breadcrumb-item active">�������</li>
               </ul>
               </div>
          </div>
          <!-- Breadcrumb End -->
          
          <br />

          <h1 class="sn-title" style="text-align: center;">ϵͳ����������Ϣ���£�</h1>
          <br />

          <?php
          while($row = $result_set->fetch_array()){ 
               echo "�������ݣ�".$row["content"]."<br/>"; 
               echo "���ڣ�".$row["publish_time"]."&nbsp;&nbsp;"; 
               echo "IP��ַ��".$row["ip"]."&nbsp;&nbsp;"; 
               echo "״̬��".$row["state"]."<br/>"; 
               echo "<a href='review_delete.php?review_id=".$row["review_id"]."' onclick='return confirm(\"ȷ��ɾ�������ۣ�\")'>ɾ��</a>";
               echo "&nbsp;&nbsp;&nbsp;"; 
               if($row["state"]=="δ���"){ 
                         echo "<a href='review_verify.php?review_id=".$row["review_id"]."'>���</a>"; 
               } 
               echo "<hr/>"; 
          } 
          //��ӡ��ҳ������
          $url = $_SERVER["REQUEST_URI"]; 
          //$url = "index.php?url=review_list.php"; 
          page($total_records,$page_size,$page_current,$url,""); 
          ?> 
          <?php } 
          ?> 
     </div> 

        
     <?php include_once "footer.php" ?>

    
</body>
</html>