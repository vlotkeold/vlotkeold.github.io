<?php
/* 
	Appointment: ������ ���������
	File: mysettings.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

$row = $db->super_query("SELECT user_email, user_name, user_lastname, user_password FROM `".PREFIX."_users` WHERE user_id = '".$user_info['user_id']."'");

//���� ���������
if(isset($_POST['save'])){
		
	$old_pass = md5(md5(GetVar($_POST['old_pass'])));
	$new_pass = md5(md5(GetVar($_POST['new_pass'])));
	
	$user_name = textFilter($_POST['name'], false, true);
	$user_lastname = textFilter($_POST['lastname'], false, true);
	$user_email = textFilter($_POST['email'], false, true);
	
	$errors = array();
	
	//�������� �����
	if(isset($user_name)){
		if(strlen($user_name) >= 2){
			if(!preg_match("/^[a-zA-Z�-��-�]+$/", $user_name))
				$errors[] = '������� ���';
			} else
		$errors[] = '������� ���';
	} else
		$errors[] = '������� ���';

	//�������� �������
	if(isset($user_lastname)){
		if(strlen($user_lastname) >= 2){
			if(!preg_match("/^[a-zA-Z�-��-�]+$/", $user_lastname))
				$errors[] = '������� �������';
		} else
			$errors[] = '������� �������';
	} else
		$errors[] = '������� �������';
		
	//�������� E-mail
	if(!preg_match('/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i', $user_email)) 
		$errors[] = '������� ��������� e-mail �����';
	
	//���� ������ ������
	if($_POST['old_pass'])
		if($old_pass == $row['user_password'])
			$newPassOk = true;
		else
			$errors[] = '������ ������ ������ �����������';
		
	foreach($errors as $er)
		if($er)
			$all_er .= '<li>'.$er.'</li>';

	if($all_er)
		msgbox('������', $all_er, '?mod=mysettings');
	else {
		if($newPassOk)
			$db->query("UPDATE `".PREFIX."_users` SET user_name = '".$user_name."', user_lastname = '".$user_lastname."', user_email = '".$user_email."', user_search_pref = '".$user_name." ".$user_lastname."' WHERE user_id = '".$user_info['user_id']."'");
		else
			$db->query("UPDATE `".PREFIX."_users` SET user_name = '".$user_name."', user_lastname = '".$user_lastname."', user_email = '".$user_email."', user_password = '".$new_pass."', user_search_pref = '".$user_name." ".$user_lastname."' WHERE user_id = '".$user_info['user_id']."'");
			
		//clear cache
		mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
		mozg_clear_cache();
			
		msgbox('��������� ���������', '���� ������������ ���������� ���� ������� ���������', '?mod=mysettings');
	}
} else {
	echoheader();
	echohtmlstart('�������������� ������������ �������');

	echo <<<HTML
<style type="text/css" media="all">
.inpu{width:300px;}
textarea{width:300px;height:100px;}
</style>

<form method="POST" action="">

<div class="fllogall">E-mail:</div><input type="text" name="email" class="inpu" value="{$row['user_email']}" /><div class="mgcler"></div>

<div class="fllogall">���:</div><input type="text" name="name" class="inpu" value="{$row['user_name']}" /><div class="mgcler"></div>

<div class="fllogall">�������:</div><input type="text" name="lastname" class="inpu" value="{$row['user_lastname']}" /><div class="mgcler"></div>

<div class="fllogall">������ ������:</div><input type="password" name="old_pass" class="inpu" /><div class="mgcler"></div>

<div class="fllogall">����� ������:</div><input type="text" name="new_pass" class="inpu" /><div class="mgcler"></div>

<div class="fllogall">&nbsp;</div><input type="submit" value="���������" name="save" class="inp" style="margin-top:0px" />

</form>
HTML;

	htmlclear();
	echohtmlend();
}
?>