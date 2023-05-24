<?php
/*
Author: Sloopy
*/
if(!defined('MOZG'))
	die('Hacking attempt!');
if($ajax == 'yes')
	NoAjaxQuery();
if($logged){
    $act = $_GET['act'];
    $user_id = $user_info['user_id'];
    switch($act){		
		case "web":    
			$tpl->load_template('jobs/web.tpl');
			$tpl->compile('content');
        break;
		case "sysadmin":    
			$tpl->load_template('jobs/sysadmin.tpl');
			$tpl->compile('content');
        break;		
		case "ios":    
			$tpl->load_template('jobs/ios.tpl');
			$tpl->compile('content');
        break;	
		case "android":    
			$tpl->load_template('jobs/android.tpl');
			$tpl->compile('content');
        break;
		case "addweb":    
			$row = $db->super_query("SELECT user_id, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$tpl->load_template('jobs/addweb.tpl');
			$tpl->set('{web}', 'Веб-разработчик');
			$tpl->set('{name_user}', $row['user_search_pref']);
			$tpl->compile('content');
        break;
		case "addsysadmin":    
			$row = $db->super_query("SELECT user_id, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$tpl->load_template('jobs/addsysadmin.tpl');
			$tpl->set('{sys}', 'Системный администратор');
			$tpl->set('{name_user}', $row['user_search_pref']);
			$tpl->compile('content');
        break;
		case "addios":    
			$row = $db->super_query("SELECT user_id, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$tpl->load_template('jobs/addios.tpl');
			$tpl->set('{ios}', 'iOS-разработчик');
			$tpl->set('{name_user}', $row['user_search_pref']);
			$tpl->compile('content');
        break;
		case "addandroid":    
			$row = $db->super_query("SELECT user_id, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$tpl->load_template('jobs/addandroid.tpl');
			$tpl->set('{android}', 'Android-разработчик');
			$tpl->set('{name_user}', $row['user_search_pref']);
			$tpl->compile('content');
        break;
		
		//Подача заявки
		case "addjob":
            $namejob = ajax_utf8(textFilter($_POST['namejob']));           
            $name = ajax_utf8(textFilter($_POST['name']));
            $phone = ajax_utf8(textFilter($_POST['phone']));		
			$email = ajax_utf8(textFilter($_POST['email']));
            $description = ajax_utf8(textFilter($_POST['description']));
			if($namejob AND $name AND $phone AND $email AND $description){
					$db->query("INSERT INTO `".PREFIX."_jobs` SET namejob = '{$namejob}', description = '{$description}', email = '{$email}', phone = '{$phone}', name = '{$name}', user_id = '{$user_id}'");
					$db->query("INSERT INTO `".PREFIX."_job` SET num = '1'");
					echo '1';     
			}else{
					echo '2';  					
            }		
        die();
        break;	
    }
    $tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>