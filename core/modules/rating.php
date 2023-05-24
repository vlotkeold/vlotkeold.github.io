<?php
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();
	
if($logged){
	$act = $_GET['act'];
	$for_user_id = $_POST['for_user_id'];
	$user_id = $user_info['user_id'];
	$nums = str_replace("-", '', $_POST['num']);
	$balanc = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
	$num = $balanc['user_balance']-1;
	$balance = $balanc['user_balance'];
	$rate_date = time();
	switch($act){

	
	  //################### Новое ###################//
  case "test":

   $row = $db->super_query("SELECT user_photo, user_id FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
   $tpl->load_template('rating/test.tpl');
   if($row['user_photo']){
    $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
   } else {
    $tpl->set('{ava}', '/templates/Default/images/no_ava.gif');
   }
   $tpl->set('{balance}', $balanc['user_balance']);
   $tpl->set('{cnt}', $rowus['cnt']);
   $tpl->set('{userid}', $row['user_id']);
   $tpl->compile('content');

  AjaxTpl();
  die();
  $tpl->clear();
  $db->free();
  break;
	
// ###################### Показываем рейтинг и голоса ###################### //

case "view":
	$limit_rate = 6;
	$page_cnt = intval($_POST['page_cnt'])*$limit_rate;
	
	//echo $page_cnt;
	$tpl->load_template('rating/view.tpl');
	
	$sql_rate = $db->super_query("SELECT author_user_id, for_user_id, rate_date, num, user_name, user_lastname, user_photo FROM `".PREFIX."_user_rate` ur left join `".PREFIX."_users` u on u.user_id = ur.author_user_id WHERE for_user_id = '{$user_id}' LIMIT {$page_cnt},{$limit_rate}",1);
		//var_dump($sql_rate);
		if($sql_rate){
				$c = 0;
				foreach($sql_rate as $sql_list){
					if($sql_list['user_photo']){
						$ava = '/uploads/users/'.$sql_list['author_user_id'].'/50_'.$sql_list['user_photo'];
					}else{
						$ava = 'templates/Default/images/no_ava_50.png';
					}
					$temp_list.='
						<div class="rate_block">
							<a href="/id'.$sql_list['author_user_id'].'" onClick="Page.Go(this.href); return false"><img src="'.$ava.'" width="50" height="50" /></a>
							<a href="/id'.$sql_list['author_user_id'].'" onClick="Page.Go(this.href); return false"><b>'.$sql_list['user_name'].' '.$sql_list['user_lastname'].'</b></a>
							<div class="profile_ratingview">+'.$sql_list['num'].'</div>
							<div class="rate_date">'.megaDateNoTpl($sql_list['rate_date']).'</div>
						</div>'."\n";
					$c++;
				}
				
				if($c > 5 AND !$_POST['page_cnt']){
					$tpl->set('{users}', $temp_list);
					$tpl->set('[prev]', '');
					$tpl->set('[/prev]', '');
					$tpl->compile('content');
				}
		}
		if($_POST['page_cnt']){
			echo $temp_list;
		}
		
AjaxTpl();
die();
$tpl->clear();
$db->free();		
break;


case "add":
if($for_user_id){
	if($balanc['user_balance'] >= "$nums"){
	
// ################################################### Считываем и перезаписываем .############################################ //
	$db->query("UPDATE `".PREFIX."_users` SET user_rate = user_rate+{$nums} WHERE user_id = '{$for_user_id}'");
	$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance-{$nums} WHERE user_id = '{$user_id}'");

// ################################################### Записываем историю в бд. ############################################### //
	$db->query("INSERT INTO `".PREFIX."_user_rate` (author_user_id, for_user_id, num, rate_date) VALUES ('{$user_id}', '{$for_user_id}', '{$nums}', '{$rate_date}')");
	echo '';
	}
}
die();
break;

default:
$photo = $db->super_query("SELECT user_photo FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
if($photo['user_photo']){
$tpl->set('[ava]', '');
$tpl->set('[/ava]', '');
$tpl->set_block("'\\[no-ava\\](.*?)\\[/no-ava\\]'si","");
} else {
$tpl->set('[no-ava]', '');
$tpl->set('[/no-ava]', '');
$tpl->set_block("'\\[ava\\](.*?)\\[/ava\\]'si","");
}
$tpl->load_template('rating/main.tpl');
$tpl->set('{user-id}', $for_user_id);
$tpl->set('{num}', $num);
$tpl->set('{balance}', $balance);
$tpl->compile('content');
AjaxTpl();
die();
	}
}
?>