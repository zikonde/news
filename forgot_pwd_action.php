<?php
require_once 'functions/session_config.php';
include_once("functions/url_navigator.php");

function change_pwd(){
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data
        $email = addslashes(@$_POST["femail"]);
        $password = addslashes(@$_POST["fpassword"]);
        $confirm_password = addslashes(@$_POST["fconfirm_password"]);

        
        // validation and database logic
        // Validate form data
        if (empty($email)|| empty($password)|| empty($confirm_password)) {
            return "����д�����";
        }

        // Validate form password
        if ($confirm_password != $password) {
            return "��ȷ�����룡";
        }else{
            $password = md5(md5($password));
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "�ʼ���Ч��";
        }

        // Connect to the database
        include_once("functions/database.php"); 
        $database_connection = get_connection();
        
        
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $database_connection->query($sql);

        if($result instanceof mysqli_result){
            if ($result->num_rows == 0) {
                return "���û������ڣ�ȥע��";
            }
            $result->free();
        }


        // Insert user data into the database
        var_dump($email);
        $sql = "UPDATE users SET password = '$password' WHERE email = '$email';";
        if ($database_connection->query($sql)) {
            return "�����޸ĳɹ�";
        } else {
            return "�����޸Ĵ���";
        }

        // Close the database connection
        close_connection();
        
        
    }else{
        include ("error_pages/404.html"); 
        exit();
    }
}

$message = change_pwd();

// Redirect to success page
header("Location:".add_to_url(["message" => $message]));
?>

<script>
    // Redirect to previous page on completion
    window.history.go(-1);
</script>