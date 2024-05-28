<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

// �����Ự��ʹ�� Cookie �洢 (���ð�ȫ�Ը��ߵĻỰ�洢��ʽ)
ini_set('session.use_only_cookies', 1);

// �����ϸ�ģʽ (���ϸ�ط�ֹ�Ự�ٳ�)
ini_set('session.use_strict_mode', 1);

// ���ûỰ Cookie ����
//session_set_cookie_params([
//  'lifetime' => 1800,                                              // Cookie ������ (��λ: ��)
//  'path' => '/',                                                    // Cookie ��Ч·��
//  'domain' => $_SERVER['HTTP_HOST'],                                          // Cookie ������
//  'secure' => false,                                                // �Ƿ��ͨ�� HTTPS ���� Cookie (���ð�ȫ�Ը��ߵĴ��䷽ʽ)
//  'httponly' => true,                                               // ��ֹ�ͻ��˽ű� (JavaScript) ���� Cookie
//  'samesite' => 'Strict'                                            // ���� Cookie �� SameSite ���� (��߰�ȫ��)
//]);

if (!session_id()){                                                 //����ʹ��session_id()�ж��Ƿ��Ѿ�������Session 
	session_start();                                              // �����Ự
} 

if(isset($_SESSION['user_email'])) {
  
  // �жϲ�ˢ�»Ự ID
  if (!isset($_SESSION['last_generation'])) {
    regenerate_session_id_loggedin();                                      // ˢ�»Ự ID ������ԭ�лỰ����
    $_SESSION['last_generation'] = time();                            // ��¼��ǰʱ����Ϊ���ɻỰ ID �Ĳο�ֵ
  } else {
    $interval = 60 * 60;                                               // ����ˢ�»Ự ID �ļ�� (��λ: ����)
    if (time() - $_SESSION['last_generation'] > $interval) {
      regenerate_session_id_loggedin();                                    // ���������ˢ�»Ự ID
      $_SESSION['last_generation'] = time();                          // ���²ο�ֵ
    }
  }
}else{
  // �жϲ�ˢ�»Ự ID
  if (!isset($_SESSION['last_generation'])) {
    session_regenerate_id(true);                                      // ˢ�»Ự ID ������ԭ�лỰ����
    $_SESSION['last_generation'] = time();                            // ��¼��ǰʱ����Ϊ���ɻỰ ID �Ĳο�ֵ
  } else {
    $interval = 60 * 60;                                               // ����ˢ�»Ự ID �ļ�� (��λ: ����)
    if (time() - $_SESSION['last_generation'] > $interval) {
      session_regenerate_id(true);                                    // ���������ˢ�»Ự ID        
      $_SESSION['last_generation'] = time();                          // ���²ο�ֵ
    }
  }
}

function regenerate_session_id_loggedin(){
  session_regenerate_id(true);                                    // ���������ˢ�»Ự ID 
  $_SESSION['last_generation'] = time();                          // ���²ο�ֵ
      
  $email = $_SESSION['user_email'];
  $newSessionID = session_create_id();
  $newSessionID = $newSessionID.md5($email);
  session_id($newSessionID);
    
    
  $_SESSION['last_generation'] = time();   
}