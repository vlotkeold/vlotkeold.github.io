<?php
/* 
	Appointment: ����������� �������������
	File: login.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');
	
$_IP = $db->safesql($_SERVER['REMOTE_ADDR']);
$_BROWSER = $db->safesql($_SERVER['HTTP_USER_AGENT']);

//���� ������ �����
if(isset($_GET['act']) AND $_GET['act'] == 'logout'){
	set_cookie("user_id", "", 0);
	set_cookie("password", "", 0);
	set_cookie("hid", "", 0);
	unset($_SESSION['user_id']);
	@session_destroy();
	@session_unset();
	$logged = false;
	$user_info = array();
	header('Location: /');
	die();
}

//���� ���� ������ �����
if(isset($_SESSION['user_id']) > 0){
	$logged = true;
	$logged_user_id = intval($_SESSION['user_id']);
	$user_info = $db->super_query("SELECT user_id, user_email, user_delete_type, user_group, user_friends_demands, user_pm_num, user_support, user_lastupdate, user_photo, user_msg_type, user_delet, user_ban_date, user_new_mark_photos, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$logged_user_id."'");

	//���� ���� ������ � �����, �� ��� ���� � �����, �� ���������� ���
	if(!$user_info['user_id'])
		header('Location: /index.php?act=logout');

	//���� ���� �������� "�������" �� ��������� �� ��� ���.
	$host_site = $_SERVER['QUERY_STRING'];
	if($logged AND !$host_site)
		header('Location: /feed');

//���� ���� ������ � COOKIE �� ���������
} elseif(isset($_COOKIE['user_id']) > 0 AND $_COOKIE['password'] AND $_COOKIE['hid']){
	$cookie_user_id = intval($_COOKIE['user_id']);
	$user_info = $db->super_query("SELECT user_id, user_email, user_group, user_password, user_hid, user_friends_demands, user_pm_num, user_support, user_lastupdate, user_photo, user_msg_type, user_delet, user_ban_date, user_new_mark_photos, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$cookie_user_id."'");
	
	//���� ������ � HID ��������� �� ����������
	if($user_info['user_password'] == $_COOKIE['password'] AND $user_info['user_hid'] == $_COOKIE['password'].md5(md5($_IP))){
		$_SESSION['user_id'] = $user_info['user_id'];
		
		//��������� ��� � ��
		$db->query("UPDATE `".PREFIX."_log` SET browser = '".$_BROWSER."', ip = '".$_IP."' WHERE uid = '".$user_info['user_id']."'");
		
		//������� ��� ����� �������
		$db->query("DELETE FROM `".PREFIX."_updates` WHERE for_user_id = '{$user_info['user_id']}'");
				
		$logged = true;
	} else {
		$user_info = array();
		$logged = false;
	}
	
	//���� ���� �������� "�������" �� ��������� �� ��� ���.
	$host_site = $_SERVER['QUERY_STRING'];
	if($logged AND !$host_site)
		header('Location: /feed');
	
} else {
	$user_info = array();
	$logged = false;
}

//���� ������ ��������� ����� ���� � ������������ �� �����������
if(isset($_POST['log_in']) AND !$logged){

	//�������������� ������
	$email = textFilter(strip_tags($_POST['email']));

	$password = md5(md5(GetVar($_POST['password'])));
	
	//��������� ������������ e-mail
	if(!preg_match('/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i', $email)){
		msgbox('', $lang['not_loggin'].'<br /><a href="/restore" onClick="Page.Go(this.href); return false">������ ������?</a>', 'info_red');
	} else {
		//������� ���-�� �������� � ������ � email
		if(isset($email) AND !empty($email)){
			$check_user = $db->super_query("SELECT user_id FROM `".PREFIX."_users` WHERE user_email = '".$email."' AND user_password = '".$password."'");
				
			//���� ���� ���� �� ����������
			if($check_user){
				//Hash ID
				$hid = $password.md5(md5($_IP));
					
				//��������� ��� �����
				$db->query("UPDATE `".PREFIX."_users` SET user_hid = '".$hid."' WHERE user_id = '".$check_user['user_id']."'");
					
				//������� ��� ����� �������
				$db->query("DELETE FROM `".PREFIX."_updates` WHERE for_user_id = '{$check_user['user_id']}'");
	
				//������������� � ������ �� �����
				$_SESSION['user_id'] = intval($check_user['user_id']);
					
				//���������� COOKIE
				set_cookie("user_id", intval($check_user['user_id']), 365);
				set_cookie("password", $password, 365);
				set_cookie("hid", $hid, 365);

				//��������� ��� � ��
				$db->query("UPDATE `".PREFIX."_log` SET browser = '".$_BROWSER."', ip = '".$_IP."' WHERE uid = '".$check_user['user_id']."'");
				$db->query("INSERT INTO `".PREFIX."_user_log` (user_id, browser, ip, date) VALUES('".$check_user['user_id']."','".$_BROWSER."','".$_IP."','".$server_time."')");
				
				header('Location: /feed');
			} else
				msgbox('', $lang['not_loggin'].'<br /><br /><a href="/restore" onClick="Page.Go(this.href); return false">������ ������?</a>', 'info_red');
		} else
			msgbox('', $lang['not_loggin'].'<br /><br /><a href="/restore" onClick="Page.Go(this.href); return false">������ ������?</a>', 'info_red');
	}
}
?>