<?php
/* 
	File: stikers.php 
	Данный код защищен авторскими правами Sloopy
*/
if(!defined('MOZG'))
	die('FY');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];

	switch($act){
		
		//################### Страница списка стикеров ###################//
		case "boxbuy":
			NoAjaxQuery();					
				$row = $db->super_query("SELECT user_cat_stik_1 FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
				$tpl->load_template('stikers/boxbuy.tpl');				
				if($row['user_cat_stik_1'] == 1){
				$tpl->set('[stikers1_yes]', '');
				$tpl->set('[/stikers1_yes]', '');
			} else
				$tpl->set_block("'\\[stikers1_yes\\](.*?)\\[/stikers1_yes\\]'si","");
				
				if($row['user_cat_stik_1'] == 0){
				$tpl->set('[stikers1_no]', '');
				$tpl->set('[/stikers1_no]', '');
			} else
				$tpl->set_block("'\\[stikers1_no\\](.*?)\\[/stikers1_no\\]'si","");
				$tpl->compile('content');			
			AjaxTpl();
			die();
		break;
		
		//Бесплатные категории:
		//Просмотр 1-ой (бесплатной) категории
		case "open_free_cat1":
			NoAjaxQuery();
			$for_user_id = intval($_POST['user_id']);			
			$section = intval($_POST['section']);
			if(!$section) $section = 1;		
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS sid, img FROM `".PREFIX."_stikers_list` WHERE category = '{$section}' ORDER by `sid` DESC", 1);		
				if(!$_POST['section']) $tpl->load_template('stikers/stikers_open_1.tpl');			
				foreach($sql_ as $stikers){
					$stikers_list .= "<a class=\"gift_cell fl_l\" onClick=\"stikers.send('{$stikers['img']}', '{$for_user_id}'); return false\" id=\"skiter_{$stikers['sid']}\"><img class=\"gift_img\" src=\"/uploads/stikers/{$stikers['img']}.png\" width=\"96\" height=\"96\"></a>";
				}				
				if(!$_POST['section']) {
					$tpl->set('{top}', '50');
					$tpl->set('{stikers}', $stikers_list);
					$tpl->set('{from}', $for_user_id);
					$tpl->compile('content');
				} else echo $stikers_list;
			AjaxTpl();
			die();
		break;
		
		//Платные категории:
		//Покупка 1-ой (платной) категории
		case "add_category_1_buy":			
			$row = $db->super_query("SELECT user_cat_stik_1,user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");			
			if($row['user_cat_stik_1']!=1 and $row['user_balance']>=5) {
				$db->query("UPDATE `".PREFIX."_users` SET user_cat_stik_1 = 1, user_balance = user_balance-5 WHERE user_id = '{$user_id}'");
				$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance+5 WHERE user_id = '2'");
			} elseif($row['user_balance']<5) echo "n_money";
			else echo "now_cat_stik_1";		
		break;
		//Просмотр 1-ой (платной) категории
		case "open_cat1":
			NoAjaxQuery();
			$for_user_id = intval($_POST['user_id']);			
			$section = intval($_POST['section']);
			if(!$section) $section = 2;		
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS sid, img FROM `".PREFIX."_stikers_list` WHERE category = '{$section}' ORDER by `sid` DESC", 1);		
				if(!$_POST['section']) $tpl->load_template('stikers/stikers_open_2.tpl');			
				foreach($sql_ as $stikers){
					$stikers_list .= "<a class=\"gift_cell fl_l\" onClick=\"stikers.send('{$stikers['img']}', '{$for_user_id}'); return false\" id=\"skiter_{$stikers['sid']}\"><img class=\"gift_img\" src=\"/uploads/stikers/{$stikers['img']}.png\" width=\"96\" height=\"96\"></a>";
				}				
				if(!$_POST['section']) {
					$tpl->set('{top}', '50');
					$tpl->set('{stikers}', $stikers_list);
					$tpl->set('{from}', $for_user_id);
					$tpl->compile('content');
				} else echo $stikers_list;
			AjaxTpl();
			die();
		break;
		
		//################### Отправка стикера в БД ###################//
		case "send":
			NoAjaxQuery();
			$for_user_id = intval($_POST['for_user_id']);
			$stiker = intval($_POST['stiker']);
			$privacy = intval($_POST['privacy']);
			if($privacy == 0) $privacy = 1;
			else if($privacy == 1) $privacy = 2;
			else $privacy = 1;
			$msg = ajax_utf8(textFilter($_POST['msg']));
			$stikers = $db->super_query("SELECT price FROM `".PREFIX."_stikers_list` WHERE img = '".$stiker."'");
			$str_date = time();
			
			//Выводим текущий баланс свой
			$row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			if($stikers['price'] AND $user_id != $for_user_id){
				if($row['user_balance'] >= $stikers['price']){
					//Отправляем сообщение получателю
					$db->query("INSERT INTO `".PREFIX."_messages` SET theme = 'Стикер', text = '<b>Стикер</b><br><img src=\"/uploads/stikers/{$stiker}.png\">', for_user_id = '{$for_user_id}', from_user_id = '{$user_id}', date = '{$server_time}', pm_read = 'no', folder = 'inbox', history_user_id = '{$user_id}'");
					$dbid = $db->insert_id();

					//Сохраняем сообщение в папку отправленные
					$db->query("INSERT INTO `".PREFIX."_messages` SET theme = 'Стикер', text = '<b>Стикер</b><br><img src=\"/uploads/stikers/{$stiker}.png\">', for_user_id = '{$user_id}', from_user_id = '{$for_user_id}', date = '{$server_time}', pm_read = 'no', folder = 'outbox', history_user_id = '{$user_id}'");

					//Обновляем кол-во новых сообщения у получателя
					$db->query("UPDATE `".PREFIX."_users` SET user_pm_num = user_pm_num+1 WHERE user_id = '{$for_user_id}'");
					
					//Проверка на наличии созданого диалога у себя
					$check_im = $db->super_query("SELECT iuser_id FROM `".PREFIX."_im` WHERE iuser_id = '".$user_id."' AND im_user_id = '".$for_user_id."'");
					if(!$check_im)
						$db->query("INSERT INTO ".PREFIX."_im SET iuser_id = '".$user_id."', im_user_id = '".$for_user_id."', idate = '".$server_time."', all_msg_num = 1");
					else
						$db->query("UPDATE ".PREFIX."_im  SET idate = '".$server_time."', all_msg_num = all_msg_num+1 WHERE iuser_id = '".$user_id."' AND im_user_id = '".$for_user_id."'");
							
					//Проверка на наличии созданого диалога у получателя, а если есть то просто обновляем кол-во новых сообщений в диалоге
					$check_im_2 = $db->super_query("SELECT iuser_id FROM ".PREFIX."_im WHERE iuser_id = '".$for_user_id."' AND im_user_id = '".$user_id."'");
					if(!$check_im_2)
						$db->query("INSERT INTO ".PREFIX."_im SET iuser_id = '".$for_user_id."', im_user_id = '".$user_id."', msg_num = 1, idate = '".$server_time."', all_msg_num = 1");
					else
						$db->query("UPDATE ".PREFIX."_im  SET idate = '".$server_time."', msg_num = msg_num+1, all_msg_num = all_msg_num+1 WHERE iuser_id = '".$for_user_id."' AND im_user_id = '".$user_id."'");
												
					$db->query("INSERT INTO `".PREFIX."_stikers` SET uid = '{$for_user_id}', stiker = '{$stiker}', msg = '{$msg}', privacy = '{$privacy}', gdate = '{$str_date}', from_uid = '{$user_id}', status = 1");
					
					mozg_clear_cache_file('user_'.$for_user_id.'/im');
					mozg_create_cache('user_'.$for_user_id.'/im_update', '1');
						
						//Вставляем событие в моментальные оповещания
						$row_owner = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$for_user_id}'");
						$update_time = $server_time - 70;
						if($row_owner['user_last_visit'] >= $update_time){
						$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$for_user_id}', from_user_id = '{$user_info['user_id']}', type = '8', date = '{$server_time}', text = '{$msg}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '/im'");
						mozg_create_cache("user_{$for_user_id}/updates", 1);
						}
					
					//Отправка уведомления на E-mail
					if($config['news_mail_8'] == 'yes' AND $user_id != $for_user_id){
							$rowUserEmail = $db->super_query("SELECT user_name, user_email FROM `".PREFIX."_users` WHERE user_id = '".$for_user_id."'");
							if($rowUserEmail['user_email']){
								include_once ENGINE_DIR.'/classes/mail.php';
								$mail = new dle_mail($config);
								$rowMyInfo = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$user_id."'");
								$rowEmailTpl = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '8'");
								$rowEmailTpl['text'] = str_replace('{%user%}', $rowUserEmail['user_name'], $rowEmailTpl['text']);
								$rowEmailTpl['text'] = str_replace('{%user-friend%}', $rowMyInfo['user_search_pref'], $rowEmailTpl['text']);
								$rowEmailTpl['text'] = str_replace('{%rec-link%}', $config['home_url'].'messages/show/'.$dbid, $rowEmailTpl['text']);
								$mail->send($rowUserEmail['user_email'], 'Новое персональное сообщение', $rowEmailTpl['text']);
							}
						}		
				} else
					echo '1';
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