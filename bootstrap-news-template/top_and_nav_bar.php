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
                <div class="col-lg-6 col-md-4">
                    <div class="b-logo">
                        <a href="index.html">
                            <img src="img/logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4" style="text-align: right;">
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
                            <a href="index.php?url=category_list.php" class="nav-link dropdown-toggle" data-toggle="dropdown">分类浏览</a>
                            <div class="dropdown-menu">
                                <a href="#" class="dropdown-item">Sub Item 1</a>
                                <a href="#" class="dropdown-item">Sub Item 2</a>
                            </div>
                        </div>

                        <a href="index.php?url=news_add.php" class="nav-item nav-link">新闻发布</a>

                        <a href="index.php?url=category_add.php" class="nav-item nav-link">添加分类</a>
                        
                        <a href="single-page.html" class="nav-item nav-link">Single Page</a>
                        <a href="index.php?url=contact.php" class="nav-item nav-link <?php if ($url == "contact.php")echo "active"?>">Contact Us</a>
                    </div>
                    <div class="social ml-auto">
                        <a href=""><i class="fab fa-twitter"></i></a>
                        <a href=""><i class="fab fa-facebook-f"></i></a>
                        <a href=""><i class="fab fa-linkedin-in"></i></a>
                        <a href=""><i class="fab fa-instagram"></i></a>
                        <a href=""><i class="fab fa-youtube"></i></a>
                    </div>
                    <div class="brand" style="background-color: #FF6F61;">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12 col-md-4">
                                    <div class="b-search">
                                        <input type="text" placeholder="Search">
                                        <button><i class="fa fa-search"></i></button>
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
        </script>
</body>
</html>
        