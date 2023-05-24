<?php
/* 
	Appointment: Баланс
	File: balance.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	$metatags['title'] = $lang['settings'];
	$balanc = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
	
	switch($act){
		 case "checkPaymentUser":
   NoAjaxQuery();
   $id = intval($_POST['id']);
   $row = $db->super_query("SELECT user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
   if($row) echo $row['user_search_pref']."|".$row['user_photo'];
   die();
  break;
  
  case "metodbox":
  
   $rowus = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_id");
   $rowusd = $db->super_query("SELECT user_id FROM `".PREFIX."_users` ORDER by `user_id` LIMIT 1");
    $row = $db->super_query("SELECT user_photo, user_id FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
  $tpl->load_template('balance/buy.tpl');
   if($row['user_photo']){
    $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
   } else {
    $tpl->set('{ava}', '/templates/Default/images/no_ava.gif');
   }
   $tpl->set('{ubm}', '<b>'.$balanc['user_balance'].' '.gram_record($balanc['user_balance'], 'votes').'</b>');
   $tpl->set('{cnt}', $rowusd['user_id']);
   $tpl->set('{userid}', $row['user_id']);
  $tpl->compile('content');

  
  AjaxTpl();
  die();
  break;
  
  //################### SMS покупка ###################//
  case "sms_buy":

   $row = $db->super_query("SELECT user_photo, user_id, user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
   $tpl->load_template('balance/sms_buy.tpl');
   if($row['user_photo']){
    $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
   } else {
    $tpl->set('{ava}', '/templates/Default/images/no_ava.gif');
   }
   $tpl->set('{ubm}', '<b>'.$balanc['user_balance'].' '.gram_record($balanc['user_balance'], 'votes').'</b>');
   $tpl->set('{cnt}', $rowus['cnt']);
   $tpl->set('{userid}', $row['user_id']);
   $tpl->compile('content');

  AjaxTpl();
  die();
  $tpl->clear();
  $db->free();
  break;
  
  case "offers":

   $row = $db->super_query("SELECT user_photo, user_id, user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
   $tpl->load_template('balance/offers.tpl');
   if($row['user_photo']){
    $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
   } else {
    $tpl->set('{ava}', '/templates/Default/images/no_ava.gif');
   }
   $tpl->set('{ubm}', '<b>'.$balanc['user_balance'].' '.gram_record($balanc['user_balance'], 'votes').'</b>');
   $tpl->set('{cnt}', $rowus['cnt']);
   $tpl->set('{userid}', $row['user_id']);
   $tpl->compile('content');

  AjaxTpl();
  die();
  $tpl->clear();
  $db->free();
  break;
  
  //################### AJAX вывод приглашения друга ###################//
  case "invates":

   $row = $db->super_query("SELECT user_photo, user_id FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
   $tpl->load_template('balance/invates.tpl');
   if($row['user_photo']){
    $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
   } else {
    $tpl->set('{ava}', '/templates/Default/images/no_ava.gif');
   }
   $tpl->set('{ubm}', '<b>'.$balanc['user_balance'].' '.gram_record($balanc['user_balance'], 'votes').'</b>');
   $tpl->set('{cnt}', $rowus['cnt']);
   $tpl->set('{userid}', $row['user_id']);
   $tpl->set('{uid}', $user_id);
   $tpl->compile('content');

  AjaxTpl();
  die();
  $tpl->clear();
  $db->free();
  break;
  
  //################### Окно Покупки голосов через ВМ ###################//
  case "metodbox_emoney":

    $row = $db->super_query("SELECT user_photo, user_id FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
   $tpl->load_template('balance/metodbox_emoney.tpl');
   if($row['user_photo']){
    $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
   } else {
    $tpl->set('{ava}', '/templates/Default/images/no_ava.gif');
   }
   $tpl->set('{ubm}', '<b>'.$balanc['user_balance'].' '.gram_record($balanc['user_balance'], 'votes').'</b>');
   $tpl->set('{cnt}', $rowus['cnt']);
   $tpl->set('{userid}', $row['user_id']);
   $tpl->compile('content');

  AjaxTpl();
  die();
  $tpl->clear();
  $db->free();
  break;  
		
		//################### Страница приглашения дург ###################//
		case "invite":
			$tpl->load_template('balance/invite.tpl');
			$tpl->set('{uid}', $user_id);
			$tpl->compile('content');
		break;
		
		//################### Страница приглашённых друзей ###################//
		case "invited":
			$tpl->load_template('balance/invited.tpl');
			$tpl->compile('info');
			$sql_ = $db->super_query("SELECT tb1.ruid, tb2.user_name, user_search_pref, user_birthday, user_last_visit, user_photo FROM `".PREFIX."_invites` tb1, `".PREFIX."_users` tb2 WHERE tb1.uid = '{$user_id}' AND tb1.ruid = tb2.user_id", 1);
			if($sql_){
				$tpl->load_template('balance/invitedUser.tpl');
				foreach($sql_ as $row){
					$user_country_city_name = explode('|', $row['user_country_city_name']);
					$tpl->set('{country}', $user_country_city_name[0]);

					if($user_country_city_name[1])
						$tpl->set('{city}', ', '.$user_country_city_name[1]);
					else
						$tpl->set('{city}', '');

					$tpl->set('{user-id}', $row['ruid']);
					$tpl->set('{name}', $row['user_search_pref']);
					
					if($row['user_photo'])
						$tpl->set('{ava}', '/uploads/users/'.$row['ruid'].'/100_'.$row['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
					
					//Возраст юзера
					$user_birthday = explode('-', $row['user_birthday']);
					$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
					
					OnlineTpl($row['user_last_visit']);
					$tpl->compile('content');
				}
			} else
				msgbox('', '<br /><br />Вы еще никого не приглашали.<br /><br /><br />', 'info_2');
		break;
		
		default:
		
			//################### Вывод текущего счета ###################//
			$owner = $db->super_query("SELECT user_balance, desing FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$tpl->load_template('balance/main.tpl');
			if($owner['desing'] == 1){
				$tpl->set('[stikers]', '');
				$tpl->set('[/stikers]', '');
			} else
				$tpl->set_block("'\\[stikers\\](.*?)\\[/stikers\\]'si","");
			$row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$tpl->set('{ubm}', '<b>'.$row['user_balance'].' '.gram_record($row['user_balance'], 'votes').'</b>');
			$tpl->compile('content');
	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>