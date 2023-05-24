<?php
/* 
	Appointment: ���� � ������ ����������
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
	header("Location: {$admin_link}");
	die();
}

//���� ���� ������ �����
if(isset($_SESSION['user_id']) > 0){
	$logged = true;
	$logged_user_id = intval($_SESSION['user_id']);
	$user_info = $db->super_query("SELECT user_id, user_email, user_group, user_password FROM `".PREFIX."_users` WHERE user_id = '".$logged_user_id."'");

	//���� ���� ������ � �����, �� ��� ���� � �����, �� ���������� ���
	if(!$user_info['user_id'])
		header("Location: {$admin_link}?act=logout");

//���� ���� ������ � COOKIE �� ���������
} elseif(isset($_COOKIE['user_id']) > 0 AND $_COOKIE['password'] AND $_COOKIE['hid']){
	$cookie_user_id = intval($_COOKIE['user_id']);
	$user_info = $db->super_query("SELECT user_id, user_email, user_group, user_password, user_hid FROM `".PREFIX."_users` WHERE user_id = '".$cookie_user_id."' AND user_group = '1'");
	
	//���� ������ � HID ��������� �� ����������
	if($user_info['user_password'] == $_COOKIE['password'] AND $user_info['user_hid'] == $_COOKIE['password'].md5(md5($_IP))){
		$_SESSION['user_id'] = $user_info['user_id'];
		
		//��������� ��� � ��
		$db->query("UPDATE `".PREFIX."_log` SET browser = '".$_BROWSER."', ip = '".$_IP."' WHERE uid = '".$user_info['user_id']."'");
		
		$logged = true;
	} else {
		$user_info = array();
		$logged = false;
	}
} else {
	$user_info = array();
	$logged = false;
}

//���� ������ ��������� ����� ���� � ������������ �� �����������
if(isset($_POST['log_in']) AND !isset($_SESSION['user_id'])){

	//�������������� ������
	$email = $db->safesql(trim(htmlspecialchars(strip_tags($_POST['email']))));
	$password = GetVar($_POST['pass']);
	
	//��������� ������������ e-mail
	if(!preg_match('/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i', $email)){
		$error_log = '������ ��������!';
	} else {
		
		//������� ���-�� �������� � ������ � email
		if(strlen($password) >= 0 AND strlen($email) > 0){
			$md5_pass = md5(md5($password));
			$check_user = $db->super_query("SELECT user_id FROM `".PREFIX."_users` WHERE user_email = '".$email."' AND user_password = '".$md5_pass."' AND user_group = 1");

			//���� ���� ���� �� ����������
			if($check_user){
				//Hash ID
				$hid = $md5_pass.md5(md5($_IP));
					
				//������������� � ������ �� �����
				$_SESSION['user_id'] = intval($check_user['user_id']);
						
				//��������� ��� �����
				$db->query("UPDATE `".PREFIX."_users` SET user_hid = '".$hid."' WHERE user_id = '".$check_user['user_id']."'");
					
				//���������� COOKIE
				set_cookie("user_id", intval($check_user['user_id']), 365);
				set_cookie("password", $md5_pass, 365);
				set_cookie("hid", $hid, 365);

				header("Location: {$admin_link}");
			} else
				$error_log = '������ ��������!';
		} else
			$error_log = '������ ��������!';
	}
}

if(!$logged){
	echoheader();
	echohtmlstart('���� � ������ ����������');
	echo <<<HTML
<form method="POST" action="">
 <div class="fllogall">E-mail:</div><input type="text" name="email" class="inpu" />&nbsp; <font color="red">{$error_log}</font>
 <div class="mgcler"></div>
 <div class="fllogall">������:</div><input type="password" name="pass" class="inpu" />
 <div class="mgcler"></div>
 <div class="fllogall">&nbsp;</div><input type="submit" class="inp fl_l" name="log_in" value="�����" style="margin-top:5px" />
</form>
<div class="clear"></div>
HTML;
	echohtmlend();
} else {
	if($user_info['user_group'] == 1)
		include ADMIN_DIR.'/mod.php';
	else
		msgbox('����������', '� ��� ������������ ���� ��� ��������� ����� �������. <a href="'.$admin_link.'?act=logout">�����</a>', '');
}
?>