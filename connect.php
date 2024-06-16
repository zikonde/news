<?php
    @$conn = null;
    
    function open_conn(){
        global $conn;
        $servername = "localhost";
        $server_username = "root";
        $server_password = "";
        $dbname = "Homework5";
        $port = 3306;

        @$conn = new mysqli($servername, $server_username, $server_password, $dbname, $port);

        if(mysqli_connect_error()){
            if(strtolower($conn->connect_error)==strtolower("Unknown database '$dbname'")){
                //���ݿⲻ����
                include_once 'create_database.php';
                @$conn = new mysqli($servername, $server_username, $server_password, '', $port);
                $dbname = "Homework5";

                create_database($conn, $dbname);
                create_users_table($conn, $dbname);
                insert_users_data($conn, $dbname);
                open_conn();

            }else{
                die("����ʧ��: " . $conn->connect_error);
            }
            
        }else{
            $conn->query("set default_storage_engine='InnoDB';");
            $conn->query("set character_set_client = 'gbk' ; ");
            $conn->query("set character_set_connection = 'gbk' ;");
            $conn->query("set character_set_database = 'gbk' ; ");
            $conn->query("set character_set_results = 'gbk' ; ");
            $conn->query("set character_set_server = 'gbk' ;");
            echo ("���ӳɹ�"."<br>");
            return $conn;
        }
    }

    function close_conn(){
        global $conn;
        if($conn instanceof mysqli){
            //var_dump($conn);
            $conn->close();
            echo "���ӹر�"."<br>";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        include_once '../not-found.html';
    }