<?php 
include_once("functions/is_login.php"); 
include_once("functions/session_config.php"); 

if($_SERVER["PHP_SELF"] === "/login.php"){
     header("location:../index.php");
 }else{
     if(isset($_GET["login_message"])){ 
          if($_GET["login_message"]=="checknum_error"){ 
                    echo "��֤�����,���µ�¼��<br/>"; 
          }else if($_GET["login_message"]=="password_error"){ 
                    echo "�������,���µ�¼��<br/>"; 
          }else if($_GET["login_message"]=="password_right"){ 
                    echo "��¼�ɹ���<br/>"; 
          } 
     } 
     if(is_login()){ ?>
          ��ӭ <?=$_SESSION['name'] ?> ����ϵͳ��<br/> 
            <a href='index?url=logout.php' onclick="return confirm('ȷ��Ҫע����')">ע��</a> 
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
               �û�����<input type="text" name="name" size="11" value="<?php echo $name?>" autocomplete=1 />
               &emsp;
               �� �� ��<input type="password" name="password" size="11" value="<?php echo $password?>" />
               &emsp; 
               ��֤�룺<input type="text" name="checknum" size="6"/>
               <?php $checknum  =  "";
                    $checknum .= mt_rand(0,9);
                    $checknum .= mt_rand(0,9);
                    $checknum .= mt_rand(0,9);
                    $checknum .= mt_rand(0,9);
                    $_SESSION['checknum'] = $checknum;
               echo $checknum;?>
               <br/>
               <br/>
               <input type="checkbox" name="expire" value="3600" checked/> Cookie����1Сʱ
               &emsp; 
               <input type="submit" value="��¼" /> 
               &emsp; 
               <a href="#"> ע��</a> 
          </form>  
 <?php 
     }  
} ?>