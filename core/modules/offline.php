<?php
/* 
	Appointment: ��������� ���������� �����
	File: offline.php
 
*/
if(!defined('MOZG'))
	die("Hacking attempt!");

if($user_info['user_group'] != '1'){
	$tpl->load_template('offline.tpl');
	$config['offline_msg'] = str_replace('&quot;', '"', stripslashes($config['offline_msg']));
	$tpl->set('{reason}', nl2br($config['offline_msg']));
	$tpl->compile('main');
	echo $tpl->result['main'];
	die();
}
?>