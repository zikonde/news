<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

if($_SERVER["PHP_SELF"] === "/login.php"){
     header("location:../index.php");
 }else{
     if(isset($_GET["login_message"])){ 
          if($_GET["login_message"]=="checknum_error"){ 
                    echo "验证码错误,重新登录！<br/>"; 
          }else if($_GET["login_message"]=="password_error"){ 
                    echo "密码错误,重新登录！<br/>"; 
          }else if($_GET["login_message"]=="password_right"){ 
                    echo "登录成功！<br/>"; 
          } 
     } 
     if(is_login()){ ?>
          欢迎 <?=$_SESSION['name'] ?> 访问系统！<br/> 
            <a href='index?url=logout.php' onclick="return confirm('确认要注销？')">注销</a> 
     <?php }else{
          $name = ""; 
          if(isset($_COOKIE["name"])){ 
               $name = $_COOKIE["name"]; 
          } 
          $password = ""; 
          if(isset($_COOKIE["password"])){ 
               $password = $_COOKIE["password"]; 
          } 
          ?> 

          <form action="login_process.php" method="post"> 
               用户名：<input type="text" name="name" size="15   " value="<?php echo $name?>" autocomplete=1 placeholder="请输入用户名或邮箱"/>
               &emsp;
               密 码 ：<input type="password" name="password" size="15" value="<?php echo $password?>"  placeholder="请输入密码"/>
               &emsp; 
               验证码：<input type="text" name="checknum" size="6"  placeholder="验证码"/>
               <?php $checknum  =  "";
                    $checknum .= mt_rand(0,9);
                    $checknum .= mt_rand(0,9);
                    $checknum .= mt_rand(0,9);
                    $checknum .= mt_rand(0,9);
                    $_SESSION['checknum'] = $checknum;
               echo $checknum;?>
               <br/>
               <br/>
               <input type="checkbox" name="expire" value="3600" checked/> Cookie保存1小时
               &emsp; 
               <input type="submit" value="登录" /> 
               &emsp; 
               <a href="#" onclick="toggleSignup()" class="signup-btn">注册</a>
               <br/>
               
               <?php echo "<a href='#' onclick='toggleForgotPwd()'>忘记密码</a>"; ?>
          </form>  
 <?php 
     }  
     if(!is_login()){ ?>
          <!-- Hidden Signup Div -->
          <div id="signup" style="display: none;">
               <?php include_once("signup.php"); ?>
          </div>
          <div id="forgot-pwd" style="display: none;">
               <?php include_once("forgot_pwd.php"); ?>
          </div>
     <?php }
} ?>

