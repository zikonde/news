<html> 
<head> 
<title> 
��ӭ�������ŷ���ϵͳ�� 
</title> 
<link rel="stylesheet" href="css/news.css" type="text/css"> 
</head> 
<body> 
<div id="container"> 
     <div id="header"> 
     		<div id="menu"> 
     			<ul> 
     			<li><a href="index.php?url=news_list.php">��ҳ</a></li> 
     			<li class="menudiv"></li> 
     			<li><a href="index.php?url=review_list.php">�������</a></li> 
     			<li class="menudiv"></li> 
     			<li><a href="index.php?url=category_list.php">�������</a></li> 
     			<li class="menudiv"></li> 
     			<li><a href="index.php?url=news_add.php">���ŷ���</a></li> 
     			<li class="menudiv"></li> 
     			<li><a href="index.php?url=category_add.php">��ӷ���</a></li> 
     			<li class="menudiv"></li> 
     			<li><a href="" onclick="this.style.behavior='url(#default#homepage)';this. setHomePage('http://<?php echo $_SERVER['HTTP_HOST']?>/news');">��Ϊ��ҳ</a></li>
     			</ul> 
     		</div> 
     		<div id="banner"> 
     		</div> 
     </div> 
     <div id="pagebody"> 
     		<div id="sidebar"> 
     			<div id="login"> 
     				<br> 
     				<?php 
     				include_once("login.php"); 
     				?> 
     			</div> 
     		</div> 
     		<div id="mainbody"> 
     			<div id="mainfunction"> 
     				<br> 
     				<?php 
     					if(isset($_GET["url"])){ 
     						$url = $_GET["url"]; 
     					}else{ 
     						$url = "news_list.php"; 
     					} 
     					include_once($url); 
     				?> 
     			</div> 
     		</div> 
     		<div style="clear:both;"> 
     		</div> 
     </div> 
     <div id="footer"> 
     		<a href="">ϵͳ���</a> 
     		<a href="">��ϵ����</a> 
     		<a href="">��ط���</a> 
     		<a href="">�ٱ�Υ����Ϣ</a> 
     		<br><br>��˾��Ȩ���� 
     </div> 
</div> 
</body> 
</html> 
<script> 
var sidebarHeight = document.getElementById("sidebar").clientHeight; 
var mainbodyHeight = document.getElementById("mainbody").clientHeight; 
if(sidebarHeight<500&&mainbodyHeight<500){ 
     document.getElementById("sidebar").style.height="500px"; 
     document.getElementById("mainbody").style.height="500px"; 
}else{ 
     if(sidebarHeight<mainbodyHeight){ 
     		document.getElementById("sidebar").style.height=mainbodyHeight+"px"; 
     }else{ 


     		document.getElementById("mainbody").style.height=sidebarHeight+"px"; 
     } 
} 
</script> 