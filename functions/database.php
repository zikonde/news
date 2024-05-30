<?php  
if($_SERVER["REQUEST_URI"] === "/functions/database.php"){
    header("location:../index.php");
}else{
    $database_connection = null; 
    $connection_tries = 0;
    function get_connection(){ 
        global $database_connection; 
        $hostname = "localhost"; 		//���ݿ��������������������IP���� 
        $host_username = "root"; 			//���ݿ�������û��� 
        $host_password = ""; 				//���ݿ���������� 
        $database = "news"; 			//���ݿ��� 
        $port = 3306;
        @$database_connection = NEW mysqli($hostname, $host_username, $host_password,$database,$port); 					//�������ݿ������
        if(mysqli_connect_error()){
            if(strtolower(@$database_connection->connect_error)==strtolower("Unknown database '$database'")){
                //���ݿⲻ����
                global $connection_tries;
                @$database_connection = new mysqli($hostname, $host_username, $host_password, '', $port);

                #var_dump($database_connection);
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
                        // echo "�ɹ��������ݿ�$database"."<br>";
                    } else {
                        die( "���ݿ� $database ����ʧ�ܣ� " . $database_connection->error. "<br>");
                    }
                }

                function create_tables($database_connection, $database){
                    $database_connection->select_db("$database");

                    $create_category_table = "create table category( 
                        category_id int auto_increment primary key, 
                        name char(20) not null 
                    );";
                    if ($database_connection->query($create_category_table)) {
                        // echo "�ɹ������category"."<br>";
                        $database_connection->query("insert into category values(null,'����')"); 
                        $database_connection->query("insert into category values(null,'�ƾ�')"); 
                        // echo "�ɹ����category���ʼ������"."<br>"; 
                    }else {
                        die( "��category����ʧ�ܣ� " . $database_connection->error."<br>");
                    }

                    $create_users_table = "create table users( 
                        user_id int auto_increment primary key, 
                        name char(20) not null, 
                        password char(32) 
                    );"; 
                    if ($database_connection->query($create_users_table)) {
                        // echo "�ɹ������users"."<br>";
                        $admin_pwd = md5(md5("admin"));
                        $Zikonde_pwd = md5(md5("123"));

                        $InsertSQL =    "Insert into users ( user_id, name, password) 
                                        values
                                            (null, 'admin', '$admin_pwd'),
                                            (null, 'Zikonde', '$Zikonde_pwd')";
                        // echo "�ɹ����users���ʼ������"."<br>"; 

                        $database_connection->query($InsertSQL);
                    } else {
                        die( "��users����ʧ�ܣ� " . $database_connection->error."<br>");
                    }

                    $create_news_table = "create table news( 
                        news_id int auto_increment primary key, 
                        user_id int, 
                        category_id int, 
                        title char(100) not null, 
                        content text, 
                        publish_time datetime, 
                        clicked int, 
                        attachment char(100), 
                        constraint FK_news_user foreign key (user_id) references users(user_id), 
                        constraint FK_news_category foreign key (category_id) references category(category_id) 
                    ); ";
                    if ($database_connection->query($create_news_table)) {
                        // echo "�ɹ������news"."<br>";
                    } else {
                        die( "��news����ʧ�ܣ� " . $database_connection->error."<br>");
                    }

                $create_review_table = "create table review( 
                        review_id int auto_increment primary key, 
                        news_id int, 
                        content text, 
                        publish_time datetime, 
                        state char(10), 
                        ip char(15), 
                        constraint FK_review_news foreign key (news_id) references news(news_id) 
                    );"; 
                    if ($database_connection->query($create_review_table)) {
                        // echo "�ɹ������review"."<br>";
                    } else {
                        die( "��review����ʧ�ܣ� " . $database_connection->error."<br>");
                    }

                }


                create_database(@$database_connection, $database);
                create_tables(@$database_connection, $database);

                if($connection_tries<10){
                    get_connection();
                    $connection_tries++;
                }

            }else{
                die("����ʧ��: " . @$database_connection->connect_error);
            }
        }else{
            $database_connection->query("set names 'gbk'");//�����ַ��� 
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
    get_connection();
}
?> 