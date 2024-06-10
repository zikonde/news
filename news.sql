set default_storage_engine=InnoDB;
set character_set_client = gbk ; 
set character_set_connection = gbk ; 
set character_set_database = gbk ; 
set character_set_results = gbk ; 
set character_set_server = gbk ;  
create database news; 
use news; 
create table category( 
     category_id int auto_increment primary key, 
     name char(20) not null, 
     description char(255) not null
); 
create table users( 
     user_id int auto_increment primary key, 
     role CHAR( 6 ) NOT NULL DEFAULT 'user',
     name char(20) not null, 
     email VARCHAR( 255 ) NOT NULL,
     password char(32), 
     sex CHAR( 3 ) NULL, 
     DOB DATE NULL
); 
create table news( 
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
); 
create table review( 
     review_id int auto_increment primary key, 
     news_id int, 
     user_id int, 
     content text, 
     publish_time datetime, 
     state char(10), 
     ip char(15), 
     constraint FK_review_news foreign key (news_id) references news(news_id), 
     constraint FK_review_news foreign key (user_id) references news(user_id) 
); 