<?php 
include_once("functions/session_config.php"); 
include_once("functions/database.php"); 
$name = $_POST["name"]; 

//echo $_POST["name"];
//echo "<br>";
//echo $_POST["checknum"].",".$_SESSION["checknum"];
//echo "<br>";
//echo @$_COOKIE["password"].",".$_POST["password"];
//echo "<br>";

if($_POST["checknum"] != $_SESSION["checknum"]){
	header("Location:index.php?login_message=checknum_error"); 
	return;
}
if(isset($_COOKIE["password"])){ 
     $first_password = $_COOKIE["password"]; 
}else{ 
     $first_password = md5($_POST["password"]); 
} 
if(empty($_POST["expire"])){ 
     		setcookie("name",$name,time()-1); 
     		setcookie("password",$first_password,time()-1); 
} 

get_connection(); 
$password = md5($first_password); 
$sql = "select * from users where name='$name' and password ='$password'";
$result_set = $database_connection->query($sql); 

if($result_set->num_rows>0){ 
     if(isset($_POST["expire"])){ 
     		$expire = time()+intval($_POST["expire"]); 
     		setcookie("name",$name,$expire); 
     		setcookie("password",$first_password,$expire); 
     }  
     var_dump($result_set);
     $admin = $result_set->fetch_assoc(); 
     $_SESSION['user_id'] = $admin['user_id']; 
     echo $admin['name'];
     $_SESSION['name'] = $admin['name']; 
     die();
     header("Location:index.php?login_message=password_right");
}else{ 
     header("Location:index.php?login_message=password_error"); 
} 
close_connection(); 
?> 