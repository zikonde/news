<?php
require_once 'functions/session_config.php';
include_once("functions/url_navigator.php");

function signup(){
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data
        $username = addslashes(@$_POST["username"]);
        $email = addslashes(@$_POST["email"]);
        $password = addslashes(@$_POST["password"]);
        $confirm_password = addslashes(@$_POST["confirm_password"]);
        $sex = @(isset($_POST["sex"])?addslashes($_POST['sex']):'');
        $DOB = @(isset($_POST["DOB"])?htmlentities($_POST['DOB']):null);

        
        // validation and database logic
        // Validate form data
        if (empty($username)  || empty($email)|| empty($password)|| empty($confirm_password)) {
            return "请填写所有项！";
        }

        // Validate form password
        if ($confirm_password != $password) {
            return "请确认密码！";
        }else{
            $password = md5(md5($password));
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "邮件无效！";
        }

        // Connect to the database
        include_once("functions/database.php"); 
        $database_connection = get_connection();
        
        
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $database_connection->query($sql);

        if($result instanceof mysqli_result){
            if ($result->num_rows > 0) {
                return "该用户已存在，去登录";
            }
            $result->free();
        }


        // Insert user data into the database
        $InsertSQL = "INSERT into users values(null, 'user', '$username', '$email', '$password', '$sex', '$DOB');";
        if ($database_connection->query($InsertSQL)) {
            return "注册成功";
        } else {
            return "注册错误";
        }

        // Close the database connection
        close_connection();
        
        
    }else{
        include ("error_pages/404.html"); 
        exit();
    }
}

$message = signup();

// Redirect to success page
header("Location:".add_to_url(["message" => $message]));
?>

<script>
    // Redirect to previous page on completion
    window.history.go(-1);
</script>