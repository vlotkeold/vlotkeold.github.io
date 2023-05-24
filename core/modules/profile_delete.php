<?php
/* 
	Appointment: Страница заблокирована
	File: profile_ban.php
 
*/
if(!defined('MOZG'))
	die("Hacking attempt!");
	
if($user_info['user_group'] != '1'){	
	$tpl->load_template('profile_delete.tpl');
	$tpl->compile('main');
	echo str_replace('{theme}', '/templates/'.$config['temp'], $tpl->result['main']);
	die();
}
?>