<?php  
if($_SERVER["PHP_SELF"] === "/functions/database.php"){
    header("location:../index.php");
    return;
}else{
    $database_connection = null; 
    $connection_tries = 0;
    
    function get_connection(){ 
        global $database_connection; 
        $hostname = "sv78.ifastnet.com"; 		//数据库服务器主机名，可以用IP代替 
        $host_username = "zikondec_admin"; 			//数据库服务器用户名 
        $host_password = "admin"; 				//数据库服务器密码 
        $database = "zikondec_news"; 			//数据库名 
        $port = 3306;
        @$database_connection = NEW mysqli($hostname, $host_username, $host_password,$database,$port); 					//连接数据库服务器
        // @$database_connection = NEW mysqli("sql300.infinityfree.com","if0_36616324","8BynwuNX88y5LDO","if0_36616324_news",3306); 					//连接数据库服务器
        if(mysqli_connect_error()){
            if(strtolower(@$database_connection->connect_error)==strtolower("Unknown database '$database'")){
                //数据库不存在
                global $connection_tries;
                @$database_connection = new mysqli($hostname, $host_username, $host_password, '', $port);

                create_database(@$database_connection, $database);
                create_tables(@$database_connection, $database);

                if($connection_tries<10){
                    get_connection();
                    $connection_tries++;
                }

            }else{
                die("连接失败: " . @$database_connection->connect_error);
            }
        }else{
            $database_connection->query("set names 'gbk'");//设置字符集 
        } 
        return $database_connection;
    }

    function close_connection(){ 
        global $database_connection; 
        if($database_connection){ 
                $database_connection->close() or die(); 
                //mysql_close($database_connection) or die(mysql_error()); 
        } 
    }

    
    function create_database($database_connection, $database){

        $database_connection->query("set default_storage_engine='InnoDB';");
        $database_connection->query("set character_set_client = 'gbk' ; ");
        $database_connection->query("set character_set_connection = 'gbk' ;");
        $database_connection->query("set character_set_database = 'gbk' ; ");
        $database_connection->query("set character_set_results = 'gbk' ; ");
        $database_connection->query("set character_set_server = 'gbk' ;");

        $create_database = "CREATE DATABASE IF NOT EXISTS $database
                            DEFAULT CHARACTER SET gbk
                            DEFAULT COLLATE gbk_chinese_ci; ";

        if ($database_connection->query($create_database) === TRUE) {
            // echo "成功建起数据库$database"."<br>";
        } else {
            die( "数据库 $database 建起失败： " . $database_connection->error. "<br>");
        }
    }

    function create_tables($database_connection, $database){
        $database_connection->select_db("$database");

        $create_category_table = "CREATE table category( 
            category_id int auto_increment primary key, 
            name char(20) not null,
            description char(255) not null 
        );";
        if ($database_connection->query($create_category_table)) {
            // echo "成功建起表category"."<br>";
            $database_connection->query("insert into category values(null,'娱乐')"); 
            $database_connection->query("insert into category values(null,'财经')"); 
            // echo "成功添加category表初始化数据"."<br>"; 
        }else {
            die( "表category建起失败： " . $database_connection->error."<br>");
        }

        $create_users_table = "CREATE table users( 
            user_id int auto_increment primary key, 
            role CHAR( 6 ) NOT NULL DEFAULT 'user',
            name char(20) not null, 
            email VARCHAR( 255 ) NOT NULL,
            password char(32), 
            sex CHAR( 3 ) NULL, 
            DOB DATE NULL
        );"; 
        if ($database_connection->query($create_users_table)) {
            // echo "成功建起表users"."<br>";
            $admin_pwd = md5(md5("admin"));
            $Zikonde_pwd = md5(md5("123"));
            $dwq_pwd = md5(md5("123"));

            $InsertSQL =    "INSERT into users ( user_id, name, password) 
                            values
                                (null, 'admin', 'admin', '$admin_pwd', '男', '2000-01-01'),
                                (null, 'admin', 'Zikonde', '$Zikonde_pwd', null, null),
                                (null, 'admin', 'dwq', '$dwq_pwd', null, null)";
            // echo "成功添加users表初始化数据"."<br>"; 

            $database_connection->query($InsertSQL);
        } else {
            die( "表users建起失败： " . $database_connection->error."<br>");
        }

        $create_news_table = "CREATE table news( 
            news_id int auto_increment primary key, 
            user_id int, 
            category_id int, 
            title char(100) not null, 
            content text, 
            publish_time datetime, 
            clicked int, 
            attachment char(100), 
            thumbnail CHAR( 255 ) NOT NULL DEFAULT 'images/thumbnail.jpg',
            constraint FK_news_user foreign key (user_id) references users(user_id), 
            constraint FK_news_category foreign key (category_id) references category(category_id) 
        ); ";
        if ($database_connection->query($create_news_table)) {
            // echo "成功建起表news"."<br>";
        } else {
            die( "表news建起失败： " . $database_connection->error."<br>");
        }

    $create_review_table = "CREATE table review( 
            review_id int auto_increment primary key, 
            news_id int, 
            user_id int, 
            content text, 
            publish_time datetime, 
            state char(10), 
            ip char(15), 
            constraint FK_review_news foreign key (news_id) references news(news_id), 
            constraint FK_review_news foreign key (user_id) references news(user_id)  
        );"; 
        if ($database_connection->query($create_review_table)) {
            // echo "成功建起表review"."<br>";
        } else {
            die( "表review建起失败： " . $database_connection->error."<br>");
        }

    }

}
?> 