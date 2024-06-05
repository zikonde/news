<!DOCTYPE html>
<html lang="en">
    <head>
        <title>News - µËçþÇí¡¢Zikonda Nyirenda</title>
        <link href="img/favicon.ico" rel="icon">
    </head>

    <body onload="showMessage()">
        
        <?php include_once "top_and_nav_bar.php" ?>

        <div id="mainbody"> 
            <?php 
                if(isset($_GET["url"])){ 
                    $url = $_GET["url"]; 
                }else{ 
                    $url = "news.php"; 
                } 
                
                if (file_exists($url)) include_once($url); 
            ?> 
        </div> 


        <?php include_once "footer.php" ?>

    </body>
</html>
