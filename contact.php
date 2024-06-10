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
                        <li class="breadcrumb-item"><a href="index.php">��ҳ</a></li>
                        <li class="breadcrumb-item active">��ϵ����</li>
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
                                            <input type="text" class="form-control" placeholder="��������" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="email" class="form-control" placeholder="���ĵ����ʼ�" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="����" />
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" placeholder="����"></textarea>
                                    </div>
                                    <div><button class="btn" type="submit">������Ϣ</button></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-info" style="text-align: justify;">
                                
                                <h3>��ϵ��ʽ</h3>
                                
                                <br>

                                <h4><i class="fa-solid fa-user"></i> ������ 1�� �῵�Zikonde��</h4>
                                <h4><i class="fa fa-map-marker"></i> �ֻ��ţ�17543995348</h4>
                                <h4><i class="fa-brands fa-weixin"></i> ΢�źţ�zirenda</h4>
                                <h4><i class="fa-brands fa-qq"></i> QQ�ţ�2819960965</h4>
                                
                                <br>

                                <h4><i class="fa-solid fa-user"></i> ������ 2�� ������</h4>
                                <h4><i class="fa fa-map-marker"></i> �ֻ��ţ�19381923882</h4>
                                <h4><i class="fa-brands fa-weixin"></i> ΢�źţ�wxid_0684sfy1oohv12</h4>
                                <h4><i class="fa-brands fa-qq"></i> QQ�ţ�2819960965</h4>

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
