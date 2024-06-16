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
    
    <div id="formhide" onclick="toggleSignup()"></div>
    <div class="registration-form">
        <div class="close" onclick="toggleSignup()"><a href="#"><i class="fa-regular fa-circle-xmark"></i></a></div>
        <br />
        <form action="signup_action.php" method="POST">
            <table>
                <p class="section-label">������Ϣ</p>
                <tr>
                    <td><label for="username">�û���</label></td>
                    <td>��</td>
                    <td><input type="text" id="username" name="username" size="30" maxlength="25" required placeholder="�û���"></td>
                </tr>
                <tr>
                    <td><label for="email">����</label></td>
                    <td>��</td>
                    <td><input type="email" id="email" name="email" size="30" maxlength="50" required placeholder="����"></td>
                </tr>
                <tr>
                    <td><label for="password">����</label></td>
                    <td>��</td>
                    <td><input type="password" id="password" name="password" size="30" maxlength="25" required placeholder="����"></td>
                </tr>
                <tr>
                    <td><label for="confirm_password">ȷ������</label></td>
                    <td>��</td>
                    <td><input type="password" id="confirm_password" name="confirm_password" size="30" maxlength="25" required placeholder="ȷ������"></td>
                </tr>
            </table>

            <?php
            if ($login_message) {
                echo "<p class='error_msg'> *".$login_message." </p>";
            }else echo "<br />";
            ?>

            
            <hr width="100%" text-align='left'>
            
            <details>
                <summary class="section-label">��ѡ����Ϣ</summary>
                <table>
                    <tr>
                        <td><label>�Ա�</label></td>
                        <td>��</td>
                        <td>
                            <label for="male">��</label><input type="radio" id="male" name="sex" value="��">
                            &emsp;
                            <label for="female">Ů</label> <input type="radio" id="female" name="sex" value="Ů">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="DOB">��������</label></td>
                        <td>��</td>
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

            
            <input type="submit" value="�ύ">  
            &emsp;
            <input type="reset" value="����">

            <br>
            <br>

            <input type="checkbox" id="agree" name="agree" required>
            <label for="agree" style="font-size:small;">��ͬ��ע����<a href="terms.php">����</a>��<a href="conditions.php">����</a></label>
        </form>
    </div>
    
    <script>
    </script>
</body>
</html>