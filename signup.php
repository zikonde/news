<!DOCTYPE html>
<html>
<head>
    <title>注册</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php 
    require_once 'functions/session_config.php';
    include_once "functions/get_url_parameters.php";  
    ?>
    
    <div id="formhide" onclick="toggleSignup()"></div>
    <div class="registration-form">
        <div class="close" onclick="toggleSignup()"><a href="#"><i class="fa-regular fa-circle-xmark"></i></a></div>
        <br />
        <form action="signup_action.php" method="POST">
            <table>
                <p class="section-label">必填信息</p>
                <tr>
                    <td><label for="username">用户名</label></td>
                    <td>：</td>
                    <td><input type="text" id="username" name="username" size="30" maxlength="25" required placeholder="用户名"></td>
                </tr>
                <tr>
                    <td><label for="email">邮箱</label></td>
                    <td>：</td>
                    <td><input type="email" id="email" name="email" size="30" maxlength="50" required placeholder="邮箱"></td>
                </tr>
                <tr>
                    <td><label for="password">密码</label></td>
                    <td>：</td>
                    <td><input type="password" id="password" name="password" size="30" maxlength="25" required placeholder="密码"></td>
                </tr>
                <tr>
                    <td><label for="confirm_password">确认密码</label></td>
                    <td>：</td>
                    <td><input type="password" id="confirm_password" name="confirm_password" size="30" maxlength="25" required placeholder="确认密码"></td>
                </tr>
            </table>

            <?php
            if ($login_message) {
                echo "<p class='error_msg'> *".$login_message." </p>";
            }else echo "<br />";
            ?>

            
            <hr width="100%" text-align='left'>
            
            <details>
                <summary class="section-label">可选填信息</summary>
                <table>
                    <tr>
                        <td><label>性别</label></td>
                        <td>：</td>
                        <td>
                            <label for="male">男</label><input type="radio" id="male" name="sex" value="男">
                            &emsp;
                            <label for="female">女</label> <input type="radio" id="female" name="sex" value="女">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="DOB">出生日期</label></td>
                        <td>：</td>
                        <td>
                            <?php
                            @$max_dob = date('Y-m-d',strtotime("12 years ago"));
                            echo @"<input type='date' id='DOB' name='DOB' max='$max_dob'>";
                            ?>
                            </td>
                    </tr>
                </table>
            </details>

            <br>

            
            <input type="submit" value="提交">  
            &emsp;
            <input type="reset" value="重置">

            <br>
            <br>

            <input type="checkbox" id="agree" name="agree" required>
            <label for="agree" style="font-size:small;">我同意注册表的<a href="terms.php">条款</a>和<a href="conditions.php">条件</a></label>
        </form>
    </div>
    
    <script>
    </script>
</body>
</html>