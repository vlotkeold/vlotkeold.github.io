<?php
/* 
	Appointment: Сообщества -> О странице
	File: about.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged or !$logged){
	$user_id = $user_info['user_id'];
	$aboutid = intval($_GET['aboutid']);
	
	if(preg_match("/^[a-zA-Z0-9_-]+$/", $_GET['get_adres'])) $get_adres = $db->safesql($_GET['get_adres']);
	
	$sql_where = "id = '".$aboutid."'";
	
	if($aboutid){
		$get_adres = '';
		$sql_where = "id = '".$aboutid."'";
	}
	if($get_adres){
		$aboutid = '';
		$sql_where = "adres = '".$get_adres."'";
	} else
	
	echo $get_adres;

	//Если страница вывзана через "к предыдущим записям"
	$limit_select = 10;
	if($_POST['page_cnt'] > 0)
		$page_cnt = intval($_POST['page_cnt'])*$limit_select;
	else
		$page_cnt = 0;

	if($page_cnt){
		$row = $db->super_query("SELECT admin FROM `".PREFIX."_about` WHERE id = '{$aboutid}'");
		$row['id'] = $aboutid;
	} else
		$row = $db->super_query("SELECT id, com_real, ptype, title, descr, traf, ulist, photo, date, admin, feedback, comments, status_text, real_admin, rec_num, del, ban, adres, audio_num, gtype, videos_num, web, privacy FROM `".PREFIX."_about` WHERE ".$sql_where."");
	
	if($row['del'] == 1){
		$user_speedbar = 'Страница удалена';
		msgbox('', '<br /><br />Сообщество удалено администрацией.<br /><br /><br />', 'info_2');
	} elseif($row['ban'] == 1){
		$user_speedbar = 'Страница заблокирована';
		msgbox('', '<br /><br />Сообщество заблокировано администрацией.<br /><br /><br />', 'info_2');
	} elseif($row){
		$metatags['title'] = stripslashes($row['title']);
		if($row['com_real']==1){
		$ver = '<a href="/verify"><div class="page_verified" onMouseOver="news.showWallText(250)" onMouseOut="news.hideWallText(250)" id="2href_text_250" style="cursor:pointer"></div></a>';
		}else{
		$ver ='';
		}
		$user_speedbar = $row['ptype'].$ver;
		
		if(stripos($row['admin'], "u{$user_id}|") !== false)
			$about_admin = true;
		else
			$about_admin = false;

		//Стена
		//Если страница вывзана через "к предыдущим записям"
		if($page_cnt)
			NoAjaxQuery();
		
		include ENGINE_DIR.'/classes/wall.about.php';
		$wall = new wall();
		$wall->query("SELECT SQL_CALC_FOUND_ROWS tb1.id, text, public_id, add_date, fasts_num, attach, likes_num, likes_users, tell_uid, public, tell_date, tell_comm, tb2.title, photo, comments, adres FROM `".PREFIX."_about_wall` tb1, `".PREFIX."_about` tb2 WHERE tb1.public_id = '{$row['id']}' AND tb1.public_id = tb2.id AND fast_comm_id = 0 ORDER by `add_date` DESC LIMIT {$page_cnt}, {$limit_select}");
		$wall->template('about/record.tpl');
		//Если страница вывзана через "к предыдущим записям"
		if($page_cnt)
			$wall->compile('content');
		else
			$wall->compile('wall');
		$wall->select($about_admin, $server_time);
		
		//Если страница вывзана через "к предыдущим записям"
		if($page_cnt){
			AjaxTpl();
			exit;
		}
		
		$tpl->load_template('about/main.tpl');
		
		$tpl->set('{title}', stripslashes($row['title']));
		if($row['photo']){
			$tpl->set('{photo}', "/uploads/about/{$row['id']}/{$row['photo']}");
			$tpl->set('{ava}', $row['photo']);
			$tpl->set('{display-ava}', '');
		} else {
			$tpl->set('{ava}', '');
			$tpl->set('{photo}', "{theme}/images/no_ava.gif");
			$tpl->set('{display-ava}', 'no_display');
		}
		
		if($row['descr'])
			$tpl->set('{descr-css}', '');
		else 
			$tpl->set('{descr-css}', 'no_display');
		
		$privacy = xfieldsdataload($row['privacy']);
		
		if($privacy['p_contact']) {
			$tpl->set('[pr_contact]', '');
			$tpl->set('[/pr_contact]', '');
		} else $tpl->set_block("'\\[pr_contact\\](.*?)\\[/pr_contact\\]'si","");
		
		if($privacy['p_audio']) {
			$tpl->set('[pr_audio]', '');
			$tpl->set('[/pr_audio]', '');
		} else $tpl->set_block("'\\[pr_audio\\](.*?)\\[/pr_audio\\]'si","");
		
		if($privacy['p_videos']) {
			$tpl->set('[pr_videos]', '');
			$tpl->set('[/pr_videos]', '');
		} else $tpl->set_block("'\\[pr_videos\\](.*?)\\[/pr_videos\\]'si","");
		
		//КНопка Показать полностью..
		$expBR = explode('<br />', $row['descr']);
		$textLength = count($expBR);
		if($textLength > 9)
			$row['descr'] = '<div class="wall_strlen" id="hide_wall_rec'.$row['id'].'">'.$row['descr'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row['id'].', this.id)" id="hide_wall_rec_lnk'.$row['id'].'">Показать полностью..</div>';
				
		$tpl->set('{descr}', stripslashes($row['descr']));
		$tpl->set('{edit-descr}', myBrRn(stripslashes($row['descr'])));		
		
		//Права админа
		if($about_admin){
			$tpl->set('[admin]', '');
			$tpl->set('[/admin]', '');
		} else
			$tpl->set_block("'\\[admin\\](.*?)\\[/admin\\]'si","");
		
		//Проверка подписан юзер или нет
		if(stripos($row['ulist'], "|{$user_id}|") !== false)
			$tpl->set('{yes}', 'no_display');
		else
			$tpl->set('{no}', 'no_display');
			
		//Тематика by sloopy 
		$tpl->set('{gtype2}', installationSelected($row['gtype'], '<option value="СМИ">СМИ</option><option value="Электроника и техника">Электроника и техника</option><option value="Фото, оптика">Фото, оптика</option><option value="Услуги и деятельность">Услуги и деятельность</option><option value="Телефоны и связь">Телефоны и связь</option><option value="Строительство и ремонт">Строительство и ремонт</option><option value="Публичная страница">Публичная страница</option><option value="Отказаться от рекламы">Отказаться от рекламы</option><option value="Одежда, обувь, аксессуары">Одежда, обувь, аксессуары</option><option value="Недвижимость">Недвижимость</option><option value="Музыка, искусство">Музыка, искусство</option><option value="Мебель, интерьер">Мебель, интерьер</option><option value="Компьютерная техника">Компьютерная техника</option><option value="Книги, учебники, журналы">Книги, учебники, журналы</option><option value="Игры">Игры</option><option value="Видео">Видео</option><option value="Авто и мото">Авто и мото</option> '));  
			
		//Контакты
		if($row['feedback']){
			$tpl->set('[yes]', '');
			$tpl->set('[/yes]', '');
			$tpl->set_block("'\\[no\\](.*?)\\[/no\\]'si","");
			$tpl->set('{num-feedback}', '<span id="fnumu">'.$row['feedback'].'</span> '.gram_record($row['feedback'], 'feedback'));
			$sql_feedbackusers = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.fuser_id, office, tb2.user_search_pref, user_photo FROM `".PREFIX."_about_feedback` tb1, `".PREFIX."_users` tb2 WHERE tb1.cid = '{$row['id']}' AND tb1.fuser_id = tb2.user_id ORDER by `fdate` ASC LIMIT 0, 5", 1);
			foreach($sql_feedbackusers as $row_feedbackusers){
				if($row_feedbackusers['user_photo']) $ava = "/uploads/users/{$row_feedbackusers['fuser_id']}/50_{$row_feedbackusers['user_photo']}";
				else $ava = "{theme}/images/no_ava_50.png";
				$row_feedbackusers['office'] = stripslashes($row_feedbackusers['office']);
				$feedback_users .= "<div class=\"onesubscription onesubscriptio2n\" style=\"margin-left:8px;\" id=\"fb{$row_feedbackusers['fuser_id']}\"><a href=\"/id{$row_feedbackusers['fuser_id']}\" onClick=\"Page.Go(this.href); return false\"><img src=\"{$ava}\" alt=\"\" /><div class=\"onesubscriptiontitle\">{$row_feedbackusers['user_search_pref']}</div></a><div class=\"nesubscriptstatus\">{$row_feedbackusers['office']}</div></div>";
			}
			$tpl->set('{feedback-users}', $feedback_users);
			$tpl->set('[feedback]', '');
			$tpl->set('[/feedback]', '');
		} else {
			$tpl->set('[no]', '');
			$tpl->set('[/no]', '');
			$tpl->set_block("'\\[yes\\](.*?)\\[/yes\\]'si","");
			$tpl->set('{feedback-users}', '');
			if($about_admin){
				$tpl->set('[feedback]', '');
				$tpl->set('[/feedback]', '');
			} else
				$tpl->set_block("'\\[feedback\\](.*?)\\[/feedback\\]'si","");
		}
		
		$tpl->set('{id}', $row['id']);
		megaDate(strtotime($row['date']), 1, 1);
		
		//Комментарии включены
		if($row['comments'])
			$tpl->set('{settings-comments}', 'comments');
		else
			$tpl->set('{settings-comments}', 'none');
			
		//Выводим админов при ред. страницы
		if($about_admin){
			$admins_arr = str_replace('|', '', explode('u', $row['admin']));
			foreach($admins_arr as $admin_id){
				if($admin_id){
					$row_admin = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$admin_id}'");
					if($row_admin['user_photo']) $ava_admin = "/uploads/users/{$admin_id}/50_{$row_admin['user_photo']}";
					else $ava_admin = "{theme}/images/no_ava_50.png";
					if($admin_id != $row['real_admin']) $admin_del_href = "<a href=\"/\" onClick=\"about.deladmin('{$row['id']}', '{$admin_id}'); return false\"><small>Удалить</small></a>";
					$adminO .= "<div class=\"public_oneadmin\" id=\"admin{$admin_id}\"><a href=\"/id{$admin_id}\" onClick=\"Page.Go(this.href); return false\"><img src=\"{$ava_admin}\" align=\"left\" width=\"32\" /></a><a href=\"/id{$admin_id}\" onClick=\"Page.Go(this.href); return false\">{$row_admin['user_search_pref']}</a><br />{$admin_del_href}</div>";		
				}
			}
			
			$tpl->set('{admins}', $adminO);
		}

		$tpl->set('{records}', $tpl->result['wall']);
		
		//Стена
		if($row['rec_num'] > 10)
			$tpl->set('{wall-page-display}', '');
		else
			$tpl->set('{wall-page-display}', 'no_display');
			
		if($row['rec_num'])
			$tpl->set('{rec-num}', '<b id="rec_num">'.$row['rec_num'].'</b> '.gram_record($row['rec_num'], 'rec'));
		else {
			$tpl->set('{rec-num}', '<b id="rec_num">Нет записей</b>');
			if($about_admin)
				$tpl->set('{records}', '<div class="wall_none" style="border-top:0px">Новостей пока нет.</div>');
			else
				$tpl->set('{records}', '<div class="wall_none">Новостей пока нет.</div>');
		}
		
		//Выводим информцию о том кто смотрит страницу для себя
		$tpl->set('{viewer-id}', $user_id);
			
		if(!$row['adres']) $row['adres'] = 'about'.$row['id'];
		$tpl->set('{adres}', $row['adres']);
		
		$tpl->set('{gtype}', $row['gtype']);
		if($row['gtype']){
		$tpl->set('[gtype]', '');
		$tpl->set('[/gtype]', '');
		} else
		$tpl->set_block("'\\[gtype\\](.*?)\\[/gtype\\]'si","");			

		$tpl->set('{web}', $row['web']);
		if($row['web']){
		$tpl->set('[web]', '');
		$tpl->set('[/web]', '');
		} else
		$tpl->set_block("'\\[web\\](.*?)\\[/web\\]'si","");
		
		//
		$privaces = xfieldsdataload($row['privacy']);	
		if($privaces['p_audio']) $tpl->set('{settings-audio}', 'audio');
		else $tpl->set('{settings-audio}', 'none');
		if($privaces['p_videos']) $tpl->set('{settings-videos}', 'videos');
		else $tpl->set('{settings-videos}', 'none');
		if($privaces['p_contact']) $tpl->set('{settings-contact}', 'contact');
		else $tpl->set('{settings-contact}', 'none');
		
		$tpl->compile('content');
	} else {
		$user_speedbar = $lang['no_infooo'];
		msgbox('', $lang['no_upage'], 'info');
	}
	
	$tpl->clear();
	$db->free();
} else {
	$pid = intval($_GET['pid']);

	if(!$row){
		$row = $db->super_query("SELECT id, com_real, ptype, title, descr, traf, ulist, photo, date, admin, feedback, comments, status_text, real_admin, rec_num, del, ban, adres, audio_num, gtype, videos_num, web, privacy FROM `".PREFIX."_about` WHERE id = '{$aboutid}'");
	} 

	//Если есть такой,  юзер то продолжаем выполнение скрипта
	if($row){			
			$metatags['title'] = stripslashes($row['title']);
			if($row['com_real']==1){
			$ver = '<a href="/verify"><div class="page_verified" onMouseOver="news.showWallText(250)" onMouseOut="news.hideWallText(250)" id="2href_text_250" style="cursor:pointer"></div></a>';
			}else{
			$ver ='';
			}
			$user_speedbar = 'О сайте';
         $tpl->load_template('about/prm.tpl');
			//Аватарка
			$tpl->set('{title}', stripslashes($row['title']));
			if($row['photo']){
			if($config['temp'] == 'mobile'){$tpl->set('{ava}', $config['home_url'].'uploads/about/'.$row['id'].'/50_'.$row['photo']);}else{$tpl->set('{ava}', $config['home_url'].'uploads/about/'.$row['id'].'/'.$row['photo']);}
				$tpl->set('{display-ava}', 'style="display:block;"');
			} else {
				$tpl->set('{ava}', '{theme}/images/no_ava.gif');
				$tpl->set('{display-ava}', 'style="display:none;"');
			}
		$tpl->set('{descr}', stripslashes($row['descr']));
		$tpl->set('{web}', $row['web']);
		if($row['web']){
		$tpl->set('[web]', '');
		$tpl->set('[/web]', '');
		} else
		$tpl->set_block("'\\[web\\](.*?)\\[/web\\]'si","");
		$tpl->set('{gtype}', $row['gtype']);
		if($row['gtype']){
		$tpl->set('[gtype]', '');
		$tpl->set('[/gtype]', '');
		} else
		$tpl->set_block("'\\[gtype\\](.*?)\\[/gtype\\]'si","");
		if($row['rec_num'])
			$tpl->set('{rec-num}', '<b id="rec_num">'.$row['rec_num'].'</b> '.gram_record($row['rec_num'], 'rec'));
		else {
			$tpl->set('{rec-num}', '<b id="rec_num">Нет записей</b>');
			if($about_admin)
				$tpl->set('{records}', '<div class="wall_none" style="border-top:0px">Новостей пока нет.</div>');
			else
				$tpl->set('{records}', '<div class="wall_none">Новостей пока нет.</div>');
		}
		
		$tpl->set('{id}', $row['id']);
		megaDate(strtotime($row['date']), 1, 1);
			$tpl->compile('content');
		
		}
		else {
		$user_speedbar = $lang['no_infooo'];
		msgbox('', $lang['no_upage'], 'infou');
	}
}
?>