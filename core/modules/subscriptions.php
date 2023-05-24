<?php
/* 
	Appointment: ��������
	File: subscriptions.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	
	switch($act){
		
		//################### ��������� ����� � �������� ###################//
		case "add":
			$for_user_id = intval($_POST['for_user_id']);
			
			//�������� �� ������������� ����� � ���������
			$check = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$for_user_id}' AND subscriptions = 1");
			
			//��
			$CheckBlackList = CheckBlackList($check['user_id']);
				
			if(!$CheckBlackList AND !$check){
				$db->query("INSERT INTO `".PREFIX."_friends` SET user_id = '{$user_id}', friend_id = '{$for_user_id}', friends_date = NOW(), subscriptions = 1");
				$db->query("UPDATE `".PREFIX."_users` SET user_subscriptions_num = user_subscriptions_num+1 WHERE user_id = '{$user_id}'");
				$db->query("UPDATE `".PREFIX."_users` SET user_sub_num = user_sub_num+1 WHERE user_id = '{$for_user_id}'");
					
				//������ ���
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache_file('subscr_user_'.$user_id);	
								
				mozg_clear_cache_file('user_'.$for_user_id.'/profile_'.$for_user_id);
				mozg_clear_cache_file('sub_user_'.$for_user_id);
			}
		break;
		
		//################### �������� ����� �� �������� ###################//
		case "del":
			$del_user_id = intval($_POST['del_user_id']);
			
			//�������� �� ������������� ����� � ���������
			$check = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$del_user_id}' AND subscriptions = 1");
			if($check){
				$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$del_user_id}' AND subscriptions = 1");
				$db->query("UPDATE `".PREFIX."_users` SET user_subscriptions_num = user_subscriptions_num-1 WHERE user_id = '{$user_id}'");
				$db->query("UPDATE `".PREFIX."_users` SET user_sub_num = user_sub_num-1 WHERE user_id = '{$del_user_id}'");
				
				//������ ���
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache_file('subscr_user_'.$user_id);				
				mozg_clear_cache_file('user_'.$del_user_id.'/profile_'.$del_user_id);
				mozg_clear_cache_file('sub_user_'.$del_user_id);
			}
			
		break;
		
		
		
			//################### ��������� ����� � �������� ###################//
		case "fall":
			$f_user_id = intval($_POST['uid']);
			
			
			$sqlg_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.friend_id, tb2.user_id, user_search_pref, user_photo, user_country_city_name, user_status FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.friend_id = '{$f_user_id}' AND tb1.user_id = tb2.user_id AND tb1.subscriptions = 1 ORDER by `friends_date` DESC LIMIT 0, 9999", 1);
			
			if($sqlg_){
						
				$tpl->load_template('profile_friends_sub.tpl');
				foreach($sqlg_ as $rowg){
					$tpl->set('{user-id}', $row['user_id']);
					$friend_info_online = explode(' ', $rowg['user_search_pref']);
					$tpl->set('{name}', $row['user_search_pref']);
					if($rowg['user_photo'])
						$ava = $config['home_url'].'uploads/users/'.$rowg['user_id'].'/100_'.$rowg['user_photo'];
					else
						$ava = $config['home_url'].'templates/Default/images/no_ava_50.png';
					echo "<script>$('.box_footer').hide();</script>
					<div class=\"fans_fan_row inl_bl\" id=\"fans_fan_row\">
<div class=\"fans_fanph_wrap\">
<div class=\"gedit_user_bigph_wrap fl_l\">
<a class=\"gedit_user_thumb\" href=\"/id{$rowg['user_id']}\"><img class=\"gedit_user_img\" src=\"{$ava}\"></a>
</div>
</div>
<div class=\"fans_fan_name\"><a class=\"fans_fan_lnk\" href=\"/id{$rowg['user_id']}\">{$rowg['user_search_pref']}</a></div>
</div>
					";
					$tpl->compile('content');
				}
				
			}
			
			
		break;
		
		
		
		
		default:
		
			//################### ����� ���� ��������� ����� ###################//
			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 24;
			$limit_page = ($page-1)*$gcount;
			$for_user_id = intval($_POST['for_user_id']);
			$subscr_num = intval($_POST['subscr_num']);
			
			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.friend_id, tb2.user_search_pref, user_photo, user_country_city_name, user_status FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$for_user_id}' AND tb1.friend_id = tb2.user_id AND tb1.subscriptions = 1 ORDER by `friends_date` DESC LIMIT {$limit_page}, {$gcount}", 1);
			
			if($sql_){
				$tpl->load_template('profile_subscription_box_top.tpl');
				$tpl->set('[top]', '');
				$tpl->set('[/top]', '');
				$tpl->set('{subcr-num}', $subscr_num.' '.gram_record($subscr_num, 'subscr'));
				$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
				$tpl->compile('content');
						
				$tpl->load_template('profile_friends.tpl');
				foreach($sql_ as $row){
					if($row['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['friend_id'].'/50_'.$row['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
					$friend_info_online = explode(' ', $row['user_search_pref']);
					$tpl->set('{user-id}', $row['friend_id']);
					$tpl->set('{name}', $friend_info_online[0]);
					$tpl->set('{last-name}', $friend_info_online[1]);
					$tpl->compile('content');
				}
				box_navigation($gcount, $subscr_num, $for_user_id, 'subscriptions.all', $subscr_num);
			}
			AjaxTpl();
	}
	$tpl->clear();
	$db->free();
} else 
	echo 'no_log';

die();
?>