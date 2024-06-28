<!DOCTYPE html>
<html lang="en">
    <head>
        <title>News - Zikonda Nyirenda¡¢µËçþÇí</title>
        <link href="img/favicon.ico" rel="icon">
    </head>

    <body onload="showMessage()">
        
            <?php include_once "top_and_nav_bar.php";?>

        <div id="mainbody"> 
            <?php 
                if(isset($_GET["url"])){ 
                    $url = $_GET["url"]; 
                }else{ 
                    $url = "index-news.php"; 
                } 
                
                if (file_exists($url)) include_once($url); 
                else include_once("error_pages/404.html");
            ?> 
        </div> 


        <?php include_once "footer.php" ?>

    </body>
</html>
