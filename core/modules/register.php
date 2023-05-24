<?php
/* 
	Appointment: ���������� �����������
	File: register.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');
	
$_IP = $db->safesql($_SERVER['REMOTE_ADDR']);
$_BROWSER = $db->safesql($_SERVER['HTTP_USER_AGENT']);

//��������� ���� �� ������ ������, ���� ���, �� ������ �������� �� �������
if(!$logged){
	NoAjaxQuery();
	
	//��� ������������
	$session_sec_code = $_SESSION['sec_code'];
	$sec_code = $_POST['sec_code'];

	//���� ��� ������� ������ ���������, �� ����������, ����� ������� ������
	if($sec_code == $session_sec_code){
		//������� POST ������
		$user_name = ajax_utf8(textFilter(ucfirst($_POST['name']), false, true)); 
        $user_lastname = ajax_utf8(textFilter(ucfirst($_POST['lastname']), false, true));
		$user_email = ajax_utf8(textFilter($_POST['email'], false, true));
		
		$user_name = ucfirst($user_name);
		$user_lastname = ucfirst($user_lastname);
		
		$user_sex = intval($_POST['sex']);
		if($user_sex < 0 OR $user_sex > 2) $user_sex = 0;
		
		$user_day = intval($_POST['day']);
		if($user_day < 0 OR $user_day > 31) $user_day = 0;
		
		$user_month = intval($_POST['month']);
		if($user_month < 0 OR $user_month > 12) $user_month = 0;
		
		$user_year = intval($_POST['year']);
		if($user_year < 1930 OR $user_year > 2007) $user_year = 0;
		
		$user_country = intval($_POST['country']);
		if($user_country < 0 OR $user_country > 10) $user_country = 0;
		
		$user_city = intval($_POST['city']);
		if($user_city < 0 OR $user_city > 1587) $user_city = 0;
		
		$_POST['password_first'] = ajax_utf8($_POST['password_first']);
		$_POST['password_second'] = ajax_utf8($_POST['password_second']);
		
		$password_first = GetVar($_POST['password_first']);
		$password_second = GetVar($_POST['password_second']);
		$user_birthday = $user_year.'-'.$user_month.'-'.$user_day;

		$errors = array();
		
		//�������� �����
		if(preg_match("/^[a-zA-Z�-��-�]+$/", $user_name) AND strlen($user_name) >= 2) $errors[] = 0;
		
		//�������� �������
		if(preg_match("/^[a-zA-Z�-��-�]+$/", $user_lastname) AND strlen($user_lastname) >= 2) $errors[] = 0;

		//�������� E-mail
		if(preg_match('/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i', $user_email)) $errors[] = 0;

		//�������� �������
		if(strlen($password_first) >= 6 AND $password_first == $password_second) $errors[] = 0;

		$allEr = count($errors);

		//���� ��� ������ �� ���������� � ��������� � ����
		if($allEr == 4){
			$check_email = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_email = '{$user_email}'");
			if(!$check_email['cnt']){
				$md5_pass = md5(md5($password_first));
				$user_group = '5';
				
				if($user_country > 0 or $user_city > 0){
					$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_country."'");
					$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_city."'");
					
					$user_country_city_name = $country_info['name'].'|'.$city_info['name'];
				}
				
				$user_search_pref = $user_name.' '.$user_lastname;
				
				//Hash ID
				$hid = $md5_pass.md5(md5($_IP));

				$db->query("INSERT INTO `".PREFIX."_users` (user_email, user_password, user_name, user_lastname, user_sex, user_day, user_month, user_year, user_country, user_city, user_reg_date, user_lastdate, user_group, user_hid, user_country_city_name, user_search_pref, user_birthday, user_msg_type, user_privacy) VALUES ('{$user_email}', '{$md5_pass}', '{$user_name}', '{$user_lastname}', '{$user_sex}', '{$user_day}', '{$user_month}', '{$user_year}', '{$user_country}', '{$user_city}', '{$server_time}', '{$server_time}', '{$user_group}', '{$hid}', '{$user_country_city_name}', '{$user_search_pref}', '{$user_birthday}', '1', 'val_msg|1||val_wall1|1||val_wall2|1||val_wall3|1||val_info|1||val_gift|1||val_audio|1||val_video|1||val_public|1||')");
				$id = $db->insert_id();

				//������������� � ������ �� �����
				$_SESSION['user_id'] = intval($id);

				//���������� COOKIE
				set_cookie("user_id", intval($id), 365);
				set_cookie("password", md5(md5($password_first)), 365);
				set_cookie("hid", $hid, 365);
				
				
				
				//������ ����� ����� � ����
				mozg_create_folder_cache("user_{$id}");
				
				//���������� ������
				$uploaddir = ROOT_DIR.'/uploads/users/';
	
				@mkdir($uploaddir.$id, 0777);
				@chmod($uploaddir.$id, 0777);
				@mkdir($uploaddir.$id.'/albums', 0777);
				@chmod($uploaddir.$id.'/albums', 0777);

				//���� ���� ������� �� ��� ������, �� ��������� �������� 10 ���
				if($_SESSION['ref_id']){
					//�������� �� �������� ���, ��� ���� �� ��� ������������ ������
					$check_ref = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_log` WHERE ip = '{$_IP}'");
					if(!$check_ref['cnt']){
						$ref_id = intval($_SESSION['ref_id']);
						
						//��� �������� +10 ���
						$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance+1 WHERE user_id = '{$ref_id}'");
						
						//��������� �������� �� ������������
						$db->query("INSERT INTO `".PREFIX."_invites` SET uid = '{$ref_id}', ruid = '{$id}'");
					}
				}

				//��������� ��� � ��
				$db->query("INSERT INTO `".PREFIX."_log` SET uid = '{$id}', browser = '{$_BROWSER}', ip = '{$_IP}'");

				echo 'ok|'.$id;
			} else
				echo 'err_mail|';
		} else
			echo 'no_val';
	}
	die();
}
?>