<?php
/* 
	Appointment: �������� �������������
	File: profile_ban.php
 
*/
if(!defined('MOZG'))
	die("Hacking attempt!");

if($user_info['user_group'] != '1'){
	$tpl->load_template('profile_baned.tpl');
	if($user_info['user_ban_date'])
		$tpl->set('{date}', langdate('j F Y � H:i', $user_info['user_ban_date']));
	else
		$tpl->set('{date}', '�������������');
	$tpl->compile('main');
	echo str_replace('{theme}', '/templates/'.$config['temp'], $tpl->result['main']);
	die();
}
?>