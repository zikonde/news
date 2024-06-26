
<?php 
include_once("functions/database.php"); 
include_once("functions/page.php"); 
include_once("functions/is_login.php"); 
// include_once("functions/session_config.php"); 
// include_once("functions/url_navigator.php");
// include_once("functions/get_url_parameters.php");
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
<body onload="showMessage()">
    
    <!-- Brand Start -->
    <div class="brand">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4">
                    <div class="b-logo">
                        <a href="/">
                            <img src="img/logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-4" style="text-align: center;">
                    <?php 
                    include_once("login.php"); 
                    include_once("functions/get_url_parameters.php"); 
                    ?> 
                </div>
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
                        <a href="index.php" class="nav-item nav-link <?php if ($url == "index.php" or $url == "news.php")echo "active"?>">首页</a>

                        <?php if(is_admin()){ ?><a href="index.php?url=review_list.php" class="nav-item nav-link <?php if ($url == "review_list.php")echo "active"?>">评论浏览</a> <?php } ?>

                        <a href="index.php?url=news_list.php&page_size=10" class="nav-item nav-link <?php if ($url == "news_list.php")echo "active"?>">新闻浏览</a>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle <?php if ($url == "category_list.php")echo "active"?>"" data-toggle="dropdown">分类浏览</a>
                            <div class="dropdown-menu">
                                <a href="index.php?url=category_list.php" class="dropdown-item">所有分类 (All)</a>
                                <?php 
                                $sql = "SELECT category_id, category.name FROM category ORDER BY name;";
                                get_connection();
                                $result_set = $database_connection->query($sql);
                                close_connection();
                                while($row = mysqli_fetch_array($result_set)){ ?>
                                    <a href="index.php?url=category_list.php&category_id=<?=$row['category_id']?>&page_size=10" class="dropdown-item"><?php echo $row['name']?></a>
                                <?php  }
                                ?>
                            </div>
                        </div>

                        <?php if(is_admin()){ ?>
                            <a href="index.php?url=news_add.php" class="nav-item nav-link <?php if ($url == "news_add.php")echo "active"?>">新闻发布</a>

                            <a href="index.php?url=category_add.php" class="nav-item nav-link <?php if ($url == "category_add.php")echo "active"?>">添加分类</a>
                        <?php } ?>

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
                                        <!-- //提供进行模糊查询的form表单  -->
                                        <form action="news_list.php" method="get" name = 'f1'>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        <?php if(!is_login()){?>
            var password = document.getElementById("password")
            , confirm_password = document.getElementById("confirm_password");

            function validatePassword(){
                if(password.value !== confirm_password.value) {
                    confirm_password.setCustomValidity("密码不匹配");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }
            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;

        <?php } ?>
        
        var page_size = document.getElementsByName("page_size")[0];
        if(page_size){
            page_size.value= <?= (isset($_GET["page_size"])?$_GET["page_size"]:3);?>;
        }

        function showMessage() {
            var message = '<?=$message; ?>';
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
            
        <?php if(is_admin()){ ?>
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

            function selectAll(category = '') {
                var checkall = document.getElementById('news_item_selectall'+category);
                var checkboxes = document.getElementsByName('news_item'+category);
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = true;
                }
                check(category);
            }
            
            function deselectAll(category = '') {
                var checkall = document.getElementById('news_item_selectall'+category);
                var checkboxes = document.getElementsByName('news_item'+category);
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = false;
                }
                check(category);
            }
            
            function invertSelection(category = '') {
                var checkboxes = document.getElementsByName('news_item'+category);
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = !checkboxes[i].checked;
                }
                check(category);
            }

            function checkall(category = ''){
                var checkall = document.getElementById('news_item_selectall'+category);
                checkall.checked? selectAll(category):deselectAll(category);
            }

            function check(category = ''){
                var checkboxes = document.getElementsByName('news_item'+category);
                var checkall = document.getElementById('news_item_selectall'+category);
                allchecked = 1;
                for (var i = 0; i < checkboxes.length; i++) {
                    allchecked = allchecked*checkboxes[i].checked;
                }
                this.checked = !this.checked;
                allchecked? checkall.checked = true: checkall.checked = false;
            }
        <?php } ?>
        
        $(document).ready(function() {
            $("a").click(function(event) {

                const url = new URL(this.href); // Use `this` to reference the clicked link
                const newsId = url.searchParams.get("news_id");

                $.ajax({
                    url: "updateClicked.php",
                    type: "POST",
                    data: { news_id: newsId }, // Send data as an object
                    success: function(response) {
                        if (typeof response === "object") {
                            // Handle successful JSON response from updateclicked.php (optional)
                            console.log("Data sent successfully! Response:", response);
                        } else {
                            console.log("Data sent successfully! (non-JSON response)");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error sending data:", textStatus, errorThrown);
                    }
                });
            });
            <?php if(is_admin()){ ?>
                $("a[id^='delete_selected']").click(function(event) {
                    var news_ids = [];
                    category_id = this.name;
                    var checkboxes = document.getElementsByName('news_item'+category_id);
                    for (var i = 0; i < checkboxes.length; i++) {
                        if(checkboxes[i].checked){
                            news_ids.push(checkboxes[i].value);
                        }
                    }
                    $.ajax({
                        url: "news_delete_selected.php",
                        type: "POST",
                        data: { news_ids: news_ids }, // Send data as an object
                        success: function(response) {
                            alert("删除成功！");
                            location.reload();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("Error sending data:", textStatus, errorThrown);
                        }
                    });
                });
            <?php } ?>
        });

        function toggleSignup() {
            var signupDiv = document.getElementById("signup");
            if (signupDiv.style.display === "none") {
                signupDiv.style.display = "block";
            } else {
                signupDiv.style.display = "none";
            }
        }

        function toggleForgotPwd() {
            var signupDiv = document.getElementById("forgot-pwd");
            if (signupDiv.style.display === "none") {
                signupDiv.style.display = "block";
            } else {
                signupDiv.style.display = "none";
            }
        }
    </script>
</body>
</html>
        