<!DOCTYPE html>
<html>
<head>
    <title>ע��</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php 
    require_once 'functions/session_config.php';
    include_once "functions/get_url_parameters.php";  
    ?>
    
    <div id="formhide" onclick="toggleForgotPwd()"></div>
    <div class="registration-form">
        <div class="close" onclick="toggleForgotPwd()"><a href="#"><i class="fa-regular fa-circle-xmark"></i></a></div>
        <br />
        <form action="forgot_pwd_action.php" method="POST">
            <table>
                <tr>
                    <td><label for="email">����</label></td>
                    <td>��</td>
                    <td><input type="email" id="femail" name="femail" size="30" maxlength="50" required placeholder="����"></td>
                </tr>
                <tr>
                    <td><label for="password">����</label></td>
                    <td>��</td>
                    <td><input type="password" id="fpassword" name="fpassword" size="30" maxlength="25" required placeholder="����"></td>
                </tr>
                <tr>
                    <td><label for="confirm_password">ȷ������</label></td>
                    <td>��</td>
                    <td><input type="password" id="fconfirm_password" name="fconfirm_password" size="30" maxlength="25" required placeholder="ȷ������"></td>
                </tr>
            </table>

            <?php
            if ($login_message) {
                echo "<p class='error_msg'> *".$login_message." </p>";
            }else echo "<br />";
            ?>

            
            <input type="submit" value="�ύ">  
            &emsp;
            <input type="reset" value="����">

            <br>

        </form>
    </div>
    
    <script>
    </script>
</body>
</html>