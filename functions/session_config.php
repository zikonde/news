<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

// 开启会话仅使用 Cookie 存储 (启用安全性更高的会话存储方式)
ini_set('session.use_only_cookies', 1);

// 开启严格模式 (更严格地防止会话劫持)
ini_set('session.use_strict_mode', 1);

// 设置会话 Cookie 参数
//session_set_cookie_params([
//  'lifetime' => 1800,                                              // Cookie 生存期 (单位: 秒)
//  'path' => '/',                                                    // Cookie 有效路径
//  'domain' => $_SERVER['HTTP_HOST'],                                          // Cookie 作用域
//  'secure' => false,                                                // 是否仅通过 HTTPS 传输 Cookie (启用安全性更高的传输方式)
//  'httponly' => true,                                               // 防止客户端脚本 (JavaScript) 访问 Cookie
//  'samesite' => 'Strict'                                            // 限制 Cookie 的 SameSite 属性 (提高安全性)
//]);

if (!session_id()){                                                 //这里使用session_id()判断是否已经开启了Session 
	session_start();                                              // 启动会话
} 

if(isset($_SESSION['user_email'])) {
  
  // 判断并刷新会话 ID
  if (!isset($_SESSION['last_generation'])) {
    regenerate_session_id_loggedin();                                      // 刷新会话 ID 并保持原有会话数据
    $_SESSION['last_generation'] = time();                            // 记录当前时间作为生成会话 ID 的参考值
  } else {
    $interval = 60 * 60;                                               // 设置刷新会话 ID 的间隔 (单位: 分钟)
    if (time() - $_SESSION['last_generation'] > $interval) {
      regenerate_session_id_loggedin();                                    // 超过间隔则刷新会话 ID
      $_SESSION['last_generation'] = time();                          // 更新参考值
    }
  }
}else{
  // 判断并刷新会话 ID
  if (!isset($_SESSION['last_generation'])) {
    session_regenerate_id(true);                                      // 刷新会话 ID 并保持原有会话数据
    $_SESSION['last_generation'] = time();                            // 记录当前时间作为生成会话 ID 的参考值
  } else {
    $interval = 60 * 60;                                               // 设置刷新会话 ID 的间隔 (单位: 分钟)
    if (time() - $_SESSION['last_generation'] > $interval) {
      session_regenerate_id(true);                                    // 超过间隔则刷新会话 ID        
      $_SESSION['last_generation'] = time();                          // 更新参考值
    }
  }
}

function regenerate_session_id_loggedin(){
  session_regenerate_id(true);                                    // 超过间隔则刷新会话 ID 
  $_SESSION['last_generation'] = time();                          // 更新参考值
      
  $email = $_SESSION['user_email'];
  $newSessionID = session_create_id();
  $newSessionID = $newSessionID.md5($email);
  session_id($newSessionID);
    
    
  $_SESSION['last_generation'] = time();   
}