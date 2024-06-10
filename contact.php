<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Contact</title>
    </head>

    <body>
        
        <?php include_once "top_and_nav_bar.php" ?>

        
        <div id="mainfunction"> 
            <!-- Breadcrumb Start -->
            <div class="breadcrumb-wrap">
                <div class="container">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">首页</a></li>
                        <li class="breadcrumb-item active">联系方法</li>
                    </ul>
                </div>
            </div>
            <!-- Breadcrumb End -->
            
            <!-- Contact Start -->
            <div class="contact">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="contact-form">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="您的姓名" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="email" class="form-control" placeholder="您的电子邮件" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="主题" />
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" placeholder="留言"></textarea>
                                    </div>
                                    <div><button class="btn" type="submit">发送消息</button></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-info" style="text-align: justify;">
                                
                                <h3>联系方式</h3>
                                
                                <br>

                                <h4><i class="fa-solid fa-user"></i> 制作人 1： 尼康达（Zikonde）</h4>
                                <h4><i class="fa fa-map-marker"></i> 手机号：17543995348</h4>
                                <h4><i class="fa-brands fa-weixin"></i> 微信号：zirenda</h4>
                                <h4><i class="fa-brands fa-qq"></i> QQ号：2819960965</h4>
                                
                                <br>

                                <h4><i class="fa-solid fa-user"></i> 制作人 2： 邓琬琼</h4>
                                <h4><i class="fa fa-map-marker"></i> 手机号：19381923882</h4>
                                <h4><i class="fa-brands fa-weixin"></i> 微信号：wxid_0684sfy1oohv12</h4>
                                <h4><i class="fa-brands fa-qq"></i> QQ号：2819960965</h4>

                                <br>

                                <div class="social">
                                    <?php include("social-brands.php") ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contact End -->
        </div> 
        
        <?php include_once "footer.php" ?>

    </body>
</html>
