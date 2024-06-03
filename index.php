<?php
?>
<!DOCTYPE html>
<html> 
<head> 
<title> 
欢迎访问新闻发布系统！ 
</title> 
<link rel="stylesheet" href="css/news.css" type="text/css"> 
</head> 
<body onload="showMessage()">
	<div id="container"> 
		<div id="header"> 
			<?php include_once("functions/is_login.php");
			include_once("url_navigator.php"); ?>
				<div id="menu"> 
					<ul> 
					<li><a href="index.php?url=news_list.php">首页</a></li> 
					<li class="menudiv"></li> 
					<li><a href="index.php?url=review_list.php">评论浏览</a></li> 
					<li class="menudiv"></li> 
					<li><a href="index.php?url=category_list.php">分类浏览</a></li> 
					<li class="menudiv"></li> 
					<?php if(is_admin()){ ?> <li><a href="index.php?url=news_add.php">新闻发布</a></li>
						<li class="menudiv"></li> 
					<?php }?>
					<li><a href="index.php?url=category_add.php">添加分类</a></li> 
					<li class="menudiv"></li> 
					<li><a href="" onclick="this.style.behavior='url(#default#homepage)';this. setHomePage('http://<?php echo $_SERVER['HTTP_HOST']?>/news');">设为首页</a></li>
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
						
						<?php 
							if(isset($_GET["url"])){ 
								$url = $_GET["url"]; 
							}else{ 
								$url = "news_list.php"; 
							} 
							
							if (file_exists($url)) include_once($url); 
						?> 
					</div> 
				</div> 
				<div style="clear:both;"> 
				</div> 
		</div> 
		<div id="footer"> 
				<a href="">系统简介</a> 
				<a href="">联系方法</a> 
				<a href="">相关法律</a> 
				<a href="">举报违法信息</a> 
				<br><br>
				<p>公司版权所有</p> 
				<br>
		</div> 
	</div> 
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
		
		var page_size = document.getElementsByName("page_size")[0];
		if(page_size){
			page_size.value=<?= (isset($_GET["page_size"])?$_GET["page_size"]:3);?>;
		}
		
		function showMessage() {
			var message = '<?=isset($_GET["message"])? $_GET["message"]: null; ?>';
			if(message != '') {
				alert(message);
				const url = window.location;
				const params = new URLSearchParams(url.search);
				params.delete('message')
				document.location.href = url.origin + url.pathname + '?' + params.toString();
			}
		}
		
		function pager(){
			var page_size = document.getElementsByName("page_size")[0].value;
			if(page_size){
				const url = window.location;
				const params = new URLSearchParams(url.search);
				params.delete('page_size')
				document.location.href = url.origin + url.pathname + '?' + params.toString() + "&page_size=" + page_size;
			}
		}
	</script> 
	<script> 
	</script> 
</body>
</html> 