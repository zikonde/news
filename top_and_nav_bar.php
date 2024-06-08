
<?php 
include_once("functions/database.php"); 
include_once("functions/page.php"); 
include_once("functions/is_login.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="GBK">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Bootstrap News Template - Free HTML Templates" name="keywords">
    <meta content="Bootstrap News Template - Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Fonts -->
    <link href="lib/css/googleapis.css" rel="stylesheet"> 

    <!-- CSS Libraries -->
    <link href="lib/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/css/all.min.css" rel="stylesheet">
    <link href="lib/slick/slick.css" rel="stylesheet">
    <link href="lib/slick/slick-theme.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Template Stylesheet -->
    <link href="lib/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Top Bar Start -->
    <!-- 
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="tb-contact">
                        <p><i class="fas fa-envelope"></i>info@mail.com</p>
                        <p><i class="fas fa-phone-alt"></i>+012 345 6789</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tb-menu">
                        <a href="">About</a>
                        <a href="">Privacy</a>
                        <a href="">Terms</a>
                        <a href="">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    -->
    <!-- Top Bar End -->
    
    <!-- Brand Start -->
    <div class="brand">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4">
                    <div class="b-logo">
                        <a href="index.html">
                            <img src="img/logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-4" style="text-align: center;">
                    <?php 
                    include_once("login.php"); 
                    ?> 
                </div>
                <!-- 
                <div class="col-lg-3 col-md-4">
                    <div class="b-search">
                        <input type="text" placeholder="Search">
                        <button><i class="fa fa-search"></i></button>
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
    <!-- Brand End -->

    <!-- Nav Bar Start -->
    <div class="nav-bar">
        <div class="container">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <?php 
                            $url = (isset($_GET["url"])?$_GET["url"]:basename($_SERVER["SCRIPT_FILENAME"]));
                        ?>
                        <a href="index.php" class="nav-item nav-link <?php if ($url == "index.php" or $url == "news.php")echo "active"?>">首页</a>

                        <a href="index.php?url=review_list.php" class="nav-item nav-link <?php if ($url == "review_list.php")echo "active"?>">评论浏览</a>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">分类浏览</a>
                            <div class="dropdown-menu">
                                <a href="index.php?url=category_list.php" class="dropdown-item">所有分类 (All)</a>
                                <?php 
                                $sql = "SELECT category_id, category.name FROM category ORDER BY name;";
                                get_connection();
                                $result_set = $database_connection->query($sql);
                                close_connection();
                                while($row = mysqli_fetch_array($result_set)){ ?>
                                    <a href="#" class="dropdown-item"><?php echo $row['name']?></a>
                                <?php  }
                                ?>
                            </div>
                        </div>

                        <a href="index.php?url=news_add.php" class="nav-item nav-link <?php if ($url == "news_add.php")echo "active"?>">新闻发布</a>

                        <a href="index.php?url=category_add.php" class="nav-item nav-link <?php if ($url == "category_add.php")echo "active"?>">添加分类</a>

                        <a href="index.php?url=contact.php" class="nav-item nav-link <?php if ($url == "contact.php")echo "active"?>">联系方法</a>
                    </div>
                    <div class="social ml-auto">
                        <?php include_once("social-brands.php") ?>
                    </div>
                    <div class="brand" style="background-color: #FF6F61;">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12 col-md-4">
                                    <div class="b-search">
                                        <?php
                                        $keyword = (isset($_GET["keyword"])?(trim($_GET["keyword"])):""); 
                                        ?>
                                        <form action="news_list.php" method="get" name = 'f1' onsubmit="check()">
                                            <input type="text" name="keyword" placeholder="请输入搜索关键字" value="<?php echo $keyword?>">
                                            <button><i class="fa fa-search"></i></button>
                                        </form> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav Bar End -->

    <script>
        var page_size = document.getElementsByName("page_size")[0];
        if(page_size){
            page_size.value= <?= (isset($_GET["page_size"])?$_GET["page_size"]:3);?>;
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
            
        function updateThumbnail() {
            var file = document.getElementById("thumbnail").files[0];
            // var thumbnail = document.getElementById("thumbnail");
            var reader = new FileReader();
            reader.onloadend = function() {
                document.getElementById("news_image").src = reader.result;
                // thumbnail.style.backgroundImage = "url("+ reader.result+")";
            }
            if(file) {
                reader.readAsDataURL(file);
            } else {
                document.getElementById("news_image").src = "images/thumbnail.jpg";
                // thumbnail.style.backgroundImage = "url(images/thumbnail.jpg)";
            }
        }

        function check(){
            var keyword = document.f1.keyword.value;
            if(keyword == ""){
                alert("请输入关键字！");
                return false;
            }
            return true;
        }
        
        function updateClicked(hreflink){
            var news_id = new URLSearchParams(hreflink).get('news_id');
            
            document.location.href = '<?php echo "updateClicked.php?news_id="; ?>'+news_id;
        }
        </script>
</body>
</html>
        