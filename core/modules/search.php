<?php
/* 
	Appointment: Поиск
	File: search.php 
 
*/
if(!defined('MOZG')){
	die('Hacking attempt!');
}
if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$metatags['title'] = $lang['search'];
	
	$_SERVER['QUERY_STRING'] = strip_tags($_SERVER['QUERY_STRING']);
	$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);
	$user_id = $user_info['user_id'];

	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 100;
	$limit_page =($page-1)*$gcount;

	$query = $db->safesql(ajax_utf8(strip_data(urldecode($_GET['query']))));
	if($_GET['n']) $query = $db->safesql(strip_data(urldecode($_GET['query'])));
	$query = strtr($query, array(' ' => '%')); //Замеянем пробелы на проценты чтоб тоиск был точнее
	
	$miro = $db->safesql(strip_data(urldecode($_GET['miro'])));
	$mesto = $db->safesql(strip_data(urldecode($_GET['mesto'])));
	$dolj = $db->safesql(strip_data(urldecode($_GET['dolj'])));
	$chast = $db->safesql(strip_data(urldecode($_GET['chast'])));
	
	$type = intval($_GET['type']) ? intval($_GET['type']) : 1;
	$countrysl = intval($_GET['countrysl']);
	$nacalosl = intval($_GET['nacalosl']);
	$sex = intval($_GET['sex']);
	$rai = intval($_GET['rai']);
	$metro = intval($_GET['metro']);
	$ulica = intval($_GET['ulica']);
	$nazvanie = intval($_GET['nazvanie']);
	$activity = intval($_GET['activity']);
	$interes = intval($_GET['interes']);
	$music = intval($_GET['music']);
	$kino = intval($_GET['kino']);
	$shou = intval($_GET['shou']);
	$serial = intval($_GET['serial']);
	$books = intval($_GET['books']);
	$games = intval($_GET['games']);
	$shkola = intval($_GET['shkola']);
	$klass = intval($_GET['klass']);
	$rai = intval($_GET['rai']);
	$metro = intval($_GET['metro']);
	$ulica = intval($_GET['ulica']);
	$nazvanie = intval($_GET['nazvanie']);
	$activity = intval($_GET['activity']);
	$interes = intval($_GET['interes']);
	$music = intval($_GET['music']);
	$kino = intval($_GET['kino']);
	$shou = intval($_GET['shou']);
	$serial = intval($_GET['serial']);
	$books = intval($_GET['books']);
	$games = intval($_GET['games']);
	$shkola = intval($_GET['shkola']);
	$klass = intval($_GET['klass']);
	$spec = intval($_GET['spec']);
	$hometown = intval($_GET['hometown']);
	$vuz = intval($_GET['vuz']);
	$fac = intval($_GET['fac']);
	$form = intval($_GET['form']);
	$statusvi = intval($_GET['statusvi']);
	$zvanie = intval($_GET['zvanie']);
	$pred = intval($_GET['pred']);
	$jizn = intval($_GET['jizn']);
	$ludi = intval($_GET['ludi']);
	$kurenie = intval($_GET['kurenie']);
	$alkogol = intval($_GET['alkogol']);
	$narkotiki = intval($_GET['narkotiki']);
	$vdox = intval($_GET['vdox']);
	$day = intval($_GET['day']);
	$month = intval($_GET['month']);
	$year = intval($_GET['year']);
	$country = intval($_GET['country']);
	$city = intval($_GET['city']);
	$online = intval($_GET['online']);
	$user_photo = intval($_GET['user_photo']);
	$sp = intval($_GET['sp']);
	
	//Задаём параметры сортировки
	if($filecontents) $sql_sort .= $for_new_sql_updates;
	if($type_profile) $sql_sort .= "AND type_profile = '{$type_profile}'";
	if($sex) $sql_sort .= "AND user_sex = '{$sex}'";
	if($rai) $sql_sort .= "AND user_rai = '{$rai}'";
	if($metro) $sql_sort .= "AND user_metro = '{$metro}'";
	if($ulica) $sql_sort .= "AND user_ulica = '{$ulica}'";
	if($nazvanie) $sql_sort .= "AND user_nazvanie = '{$nazvanie}'";
	if($activity) $sql_sort .= "AND user_activity = '{$activity}'";
	if($interes) $sql_sort .= "AND user_interes = '{$interes}'";
	if($myinfo) $sql_sort .= "AND user_myinfo = '{$myinfo}'";
	if($music) $sql_sort .= "AND user_music = '{$music}'";
	if($kino) $sql_sort .= "AND user_kino = '{$kino}'";
	if($shou) $sql_sort .= "AND user_shou = '{$shou}'";
	if($serial) $sql_sort .= "AND user_serial = '{$serial}'";
	if($books) $sql_sort .= "AND user_books = '{$books}'";
	if($games) $sql_sort .= "AND user_games = '{$games}'";
	if($shkola) $sql_sort .= "AND user_shkola = '{$shkola}'";
    if($klass) $sql_sort .= "AND user_klass = '{$klass}'";
	if($spec) $sql_sort .= "AND user_spec = '{$spec}'";
	if($hometown) $sql_sort .= "AND user_hometown = '{$hometown}'";
	if($vuz) $sql_sort .= "AND user_vuz = '{$vuz}'";
	if($fac) $sql_sort .= "AND user_fac = '{$fac}'";
	if($form) $sql_sort .= "AND user_form = '{$form}'";
	if($statusvi) $sql_sort .= "AND user_statusvi = '{$statusvi}'";
	if($mesto) $sql_sort .= "AND user_mesto = '{$mesto}'";
	if($dolj) $sql_sort .= "AND user_dolj = '{$dolj}'";
	if($chast) $sql_sort .= "AND user_chast = '{$chast}'";
	if($countrysl) $sql_sort .= "AND user_countrysl = '{$countrysl}'";
	if($nacalosl) $sql_sort .= "AND user_nacalosl = '{$nacalosl}'";
	if($zvanie) $sql_sort .= "AND user_zvanie = '{$zvanie}'";
	if($pred) $sql_sort .= "AND user_pred = '{$pred}'";
	if($miro) $sql_sort .= "AND user_miro = '{$miro}'";
	if($jizn) $sql_sort .= "AND user_jizn = '{$jizn}'";
	if($ludi) $sql_sort .= "AND user_ludi = '{$ludi}'";
	if($kurenie) $sql_sort .= "AND user_kurenie = '{$kurenie}'";
	if($alkogol) $sql_sort .= "AND user_alkogol = '{$alkogol}'";
	if($narkotiki) $sql_sort .= "AND user_narkotiki = '{$narkotiki}'";
	if($vdox) $sql_sort .= "user_vdox = '{$vdox}'";
	if($day) $sql_sort .= "AND user_day = '{$day}'";
	if($month) $sql_sort .= "AND user_month = '{$month}'";
	if($year) $sql_sort .= "AND user_year = '{$year}'";
	if($country) $sql_sort .= "AND user_country = '{$country}'";
	if($city) $sql_sort .= "AND user_city = '{$city}'";
	if($online) $sql_sort .= "AND user_last_visit >= '{$online_time}'";
	if($user_photo) $sql_sort .= "AND user_photo != ''";
	if($sp) $sql_sort .= "AND SUBSTRING(user_sp, 1, 1) regexp '[[:<:]]({$sp})[[:>:]]'";

	//Делаем SQL Запрос в БД на вывод данных
	if($type == 1){ //Если критерий поиск "по людям"
		$sql_query = "SELECT SQL_CALC_FOUND_ROWS user_id, user_search_pref, user_real, user_photo, user_birthday, user_country_city_name, user_last_visit, user_miro, user_jizn, user_ludi, user_kurenie, user_alkogol, user_vuz FROM `".PREFIX."_users` WHERE user_search_pref LIKE '%{$query}%' AND user_ban = '0' AND user_delet = '0' AND user_delete_type = '0' {$sql_sort} ORDER by `user_real` desc, rand() desc LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_search_pref LIKE '%{$query}%' AND user_ban = '0' AND user_delet = '0' AND user_delete_type = '0' {$sql_sort}";
	} elseif($type == 2 AND $config['video_mod'] == 'yes' AND $config['video_mod_search'] == 'yes'){ //Если критерий поиск "по видеозаписям"
		$sql_query = "SELECT SQL_CALC_FOUND_ROWS id, photo, title, add_date, comm_num, owner_user_id FROM `".PREFIX."_videos` WHERE title LIKE '%{$query}%' AND privacy = '1' AND system = '0' AND profile = '1' ORDER by `add_date` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_videos` WHERE title LIKE '%{$query}%' AND privacy = '1' AND system = '0' AND profile = '1'";
	} elseif($type == 3){ //Если критерий поиск "по заметкам"
		$sql_query = "SELECT SQL_CALC_FOUND_ROWS ".PREFIX."_notes.id, title, full_text, owner_user_id, date, comm_num, ".PREFIX."_users.user_photo, user_search_pref FROM ".PREFIX."_notes LEFT JOIN ".PREFIX."_users ON ".PREFIX."_notes.owner_user_id = ".PREFIX."_users.user_id WHERE title LIKE '%{$query}%' OR full_text LIKE '%{$query}%' ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_notes` WHERE title LIKE '%{$query}%' OR full_text LIKE '%{$query}%'";
	} elseif($type == 4){ //Если критерий поиск "по сообщества"
		$sql_query = "SELECT SQL_CALC_FOUND_ROWS id, com_real, title, photo, traf, adres, gtype FROM `".PREFIX."_communities` WHERE title LIKE '%{$query}%' AND ban != '1' ORDER by `com_real` DESC, `traf` DESC, `photo` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities` WHERE title LIKE '%{$query}%' AND ban != '1'";
	} elseif($type == 5 AND $config['audio_mod'] == 'yes' AND $config['audio_mod_search'] == 'yes'){ //Если критерий поиск "по аудиозаписи"
		$sql_query = "SELECT SQL_CALC_FOUND_ROWS `".PREFIX."_audio`.aid, url, name, artist, full_name, auser_id, ".PREFIX."_users.user_search_pref FROM ".PREFIX."_audio LEFT JOIN ".PREFIX."_users ON ".PREFIX."_audio.auser_id = ".PREFIX."_users.user_id WHERE full_name LIKE '%{$query}%' AND stype = 0 ORDER by `adate` DESC LIMIT {$limit_page}, {$gcount}"; 
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_audio` WHERE full_name LIKE '%{$query}%' AND stype = 0"; 
	} elseif($type == 6){ //Если критерий поиск "по группам"
		$sql_query = "SELECT SQL_CALC_FOUND_ROWS id, title, photo, traf, adres, privacy FROM `".PREFIX."_clubs` WHERE title LIKE '%{$query}%' and ban = '0' and del = '0' ORDER by `traf` DESC, `photo` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_clubs` WHERE title LIKE '%{$query}%' and ban = '0' and del = '0'";
	} elseif($type == 7){ //Если критерий поиск "по новостям"
		$sql_query = "SELECT SQL_CALC_FOUND_ROWS ac_id, ac_user_id, action_text, action_time, action_type, obj_id FROM `".PREFIX."_news` WHERE action_text LIKE '%{$query}%' and obj_id != 0 and action_type IN (1, 11) ORDER by `action_time` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_news` WHERE action_text LIKE '%{$query}%' and obj_id != 0 and action_type IN (1, 11)";
	} else {
		$sql_query = false;
		$sql_count = false;
	}
	
	if($sql_query)
		$sql_ = $db->super_query($sql_query, 1);
	
	//Считаем кол-во ответов из БД
	if($sql_count AND $sql_)
		$count = $db->super_query($sql_count);

	//Head поиска
	$tpl->load_template('search/head.tpl');
	if($query)
		$tpl->set('{query}', stripslashes(stripslashes(strtr($query, array('%' => ' ')))));
	else
		$tpl->set('{query}', 'Начните вводить любое слово или имя');
		
	if($miro)
		$tpl->set('{miro}', stripslashes(stripslashes(strtr($miro, array('%' => ' ')))));
	else
		$tpl->set('{miro}', 'Мировоззрение');

	if($mesto)
		$tpl->set('{mesto}', stripslashes(stripslashes(strtr($mesto, array('%' => ' ')))));
	else
		$tpl->set('{mesto}', 'Работа');
		
	if($dolj)
		$tpl->set('{dolj}', stripslashes(stripslashes(strtr($dolj, array('%' => ' ')))));
	else
		$tpl->set('{dolj}', 'Должность');
		
	if($chast)
		$tpl->set('{chast}', stripslashes(stripslashes(strtr($chast, array('%' => ' ')))));
	else
	$tpl->set('{chast}', 'Воинская часть');
	
	$_GET['query'] = $db->safesql(ajax_utf8(strip_data(urldecode($_GET['query']))));
	if($_GET['n']) $_GET['query'] = $db->safesql(strip_data(urldecode($_GET['query'])));
	$tpl->set('{query-people}', str_replace(array('&type=2', '&type=3', '&type=4', '&type=5', '&type=6', '&type=7'), '&type=1', $_SERVER['QUERY_STRING']));
	$tpl->set('{query-videos}', '&type=2&query='.$_GET['query']);
	$tpl->set('{query-notes}', '&type=3&query='.$_GET['query']);
	$tpl->set('{query-groups}', '&type=4&query='.$_GET['query']);
	$tpl->set('{query-clubs}', '&type=6&query='.$_GET['query']);
	$tpl->set('{query-audios}', '&type=5&query='.$_GET['query']);
	$tpl->set('{query-news}', '&type=7&query='.$_GET['query']);
	
	if($online) $tpl->set('{checked-online}', 'online');
	else $tpl->set('{checked-online}', '0');
		
	if($user_photo) $tpl->set('{checked-user-photo}', 'user_photo');
	else $tpl->set('{checked-user-photo}', '0');
	
	$tpl->set("{activetab-{$type}}", 'buttonsprofileSec');
	$tpl->set("{type}", $type);
	
	$explode_sp = explode('|', $sql_['user_sp']);
	if(intval($_GET['sp']) == 0){
	$tpl->set('{sp_name}', 'Выбор статуса');
	}
	
	if(intval($_GET['sex']) != 1 or intval($_GET['sex']) != 2){
	$tpl->set('{sp_id}', intval($_GET['sp']));
		if(intval($_GET['sp']) == 7){
		$tpl->set('{sp_name}', 'В активном поиске');
		}
		if(intval($_GET['sp']) == 1){
		$tpl->set('{sp_name}', 'Не женат');
		}
		if(intval($_GET['sp']) == 2){
		$tpl->set('{sp_name}', 'Есть подруга');
		}
		if(intval($_GET['sp']) == 3){
		$tpl->set('{sp_name}', 'Помовлен');
		}
		if(intval($_GET['sp']) == 4){
		$tpl->set('{sp_name}', 'Женат');
		}
		if(intval($_GET['sp']) == 5){
		$tpl->set('{sp_name}', 'Влюблён');
		}
		if(intval($_GET['sp']) == 6){
		$tpl->set('{sp_name}', 'Всё сложно');
		}
	$tpl->set('{sp_list}', InstallationSelectedNew(intval($_GET['sp']),'<li onmousemove="Select.itemMouseMove(7, 0)"  val="0" class="">- Не выбрано -</li><li onmousemove="Select.itemMouseMove(7, 1)"  val="1" class="">Не женат</li><li onmousemove="Select.itemMouseMove(7, 2)"  val="2" class="">Есть подруга</li><li onmousemove="Select.itemMouseMove(7, 3)"  val="3" class="">Помовлен</li><li onmousemove="Select.itemMouseMove(7, 4)"  val="4" class="">Женат</li><li onmousemove="Select.itemMouseMove(7, 5)"  val="5" class="">Влюблён</li><li onmousemove="Select.itemMouseMove(7, 6)"  val="6" class="">Всё сложно</li><li onmousemove="Select.itemMouseMove(7, 7)"  val="7" class="">В активном поиске</li>'));
	}
	
	if(intval($_GET['sex']) == 1){
	$tpl->set('{sp_id}', intval($_GET['sp']));	
		if(intval($_GET['sp']) == 7){
		$tpl->set('{sp_name}', 'В активном поиске');
		}
		if(intval($_GET['sp']) == 1){
		$tpl->set('{sp_name}', 'Не женат');
		}
		if(intval($_GET['sp']) == 2){
		$tpl->set('{sp_name}', 'Есть подруга');
		}
		if(intval($_GET['sp']) == 3){
		$tpl->set('{sp_name}', 'Помовлен');
		}
		if(intval($_GET['sp']) == 4){
		$tpl->set('{sp_name}', 'Женат');
		}
		if(intval($_GET['sp']) == 5){
		$tpl->set('{sp_name}', 'Влюблён');
		}
		if(intval($_GET['sp']) == 6){
		$tpl->set('{sp_name}', 'Всё сложно');
		}
	$tpl->set('{sp_list}', InstallationSelectedNew(intval($_GET['sp']),'<li onmousemove="Select.itemMouseMove(7, 0)"  val="0" class="">- Не выбрано -</li><li onmousemove="Select.itemMouseMove(7, 1)"  val="1" class="">Не женат</li><li onmousemove="Select.itemMouseMove(7, 2)"  val="2" class="">Есть подруга</li><li onmousemove="Select.itemMouseMove(7, 3)"  val="3" class="">Помовлен</li><li onmousemove="Select.itemMouseMove(7, 4)"  val="4" class="">Женат</li><li onmousemove="Select.itemMouseMove(7, 5)"  val="5" class="">Влюблён</li><li onmousemove="Select.itemMouseMove(7, 6)"  val="6" class="">Всё сложно</li><li onmousemove="Select.itemMouseMove(7, 7)"  val="7" class="">В активном поиске</li>'));
	}
	
	if(intval($_GET['sex']) == 2){
	$tpl->set('{sp_id}', intval($_GET['sp']));
		if(intval($_GET['sp']) == 7){
		$tpl->set('{sp_name}', 'В активном поиске');
		}
		if(intval($_GET['sp']) == 1){
		$tpl->set('{sp_name}', 'Не замужем');
		}
		if(intval($_GET['sp']) == 2){
		$tpl->set('{sp_name}', 'Есть друг');
		}
		if(intval($_GET['sp']) == 3){
		$tpl->set('{sp_name}', 'Помовлена');
		}
		if(intval($_GET['sp']) == 4){
		$tpl->set('{sp_name}', 'Замужем');
		}
		if(intval($_GET['sp']) == 5){
		$tpl->set('{sp_name}', 'Влюблена');
		}
		if(intval($_GET['sp']) == 6){
		$tpl->set('{sp_name}', 'Всё сложно');
		}
	$tpl->set('{sp_list}', InstallationSelectedNew(intval($_GET['sp']),'<li onmousemove="Select.itemMouseMove(7, 0)"  val="0" class="">- Не выбрано -</li><li onmousemove="Select.itemMouseMove(7, 1)"  val="1" class="">Не замужем</li><li onmousemove="Select.itemMouseMove(7, 2)"  val="2" class="">Есть друг</li><li onmousemove="Select.itemMouseMove(7, 3)"  val="3" class="">Помовлена</li><li onmousemove="Select.itemMouseMove(7, 4)"  val="4" class="">Замужем</li><li onmousemove="Select.itemMouseMove(7, 5)"  val="5" class="">Влюблена</li><li onmousemove="Select.itemMouseMove(7, 6)"  val="6" class="">Всё сложно</li><li onmousemove="Select.itemMouseMove(7, 7)"  val="7" class="">В активном поиске</li>'));
	}
	
	$tpl->set('{sex}', InstallationSelectedNew($sql_['user_sex'],'<li onmousemove="Select.itemMouseMove(3, 0)" val="0" class="">Любой</li><li onmousemove="Select.itemMouseMove(3, 1)" val="1" class="">Мужской</li><li onmousemove="Select.itemMouseMove(3, 2)" val="2" class="">Женский</li>'));
	if(intval($_GET['sex']) == 0){
	$tpl->set('{sex_name}',	'Любой');
	$tpl->set('{sex_id}',	'0');
	}
	if(intval($_GET['sex']) == 1){
	$tpl->set('{sex_name}',	'Мужской');
	$tpl->set('{sex_id}',	'1');
	}
	if(intval($_GET['sex']) == 2){
	$tpl->set('{sex_name}',	'Женский');
	$tpl->set('{sex_id}',	'2');
	}

					
if(intval($_GET['day']) >=32){
$day_id == 1;
} else {
$day_id == intval($_GET['day']);
}
	if(intval($_GET['day']) == 0 OR intval($_GET['day']) >=32) {
	$days = 'День рождения';
		} else {
	$days = intval($_GET['day']);
		}
		
	$tpl->set('{day_name}', $days);
	$tpl->set('{day_id}', $day_id);
	$tpl->set('{day}', InstallationSelectedNew(intval($_GET['day']),'<li onmousemove="Select.itemMouseMove(4, 0)"  val="0" class="">День</li><li onmousemove="Select.itemMouseMove(4, 1)" val="1" class="">1</li><li onmousemove="Select.itemMouseMove(4, 2)" val="2" class="">2</li><li onmousemove="Select.itemMouseMove(4, 3)" val="3" class="">3</li><li onmousemove="Select.itemMouseMove(4, 4)" val="4" class="">4</li><li onmousemove="Select.itemMouseMove(4, 5)" val="5" class="">5</li><li onmousemove="Select.itemMouseMove(4, 6)" val="6" class="">6</li><li onmousemove="Select.itemMouseMove(4, 7)" val="7" class="">7</li><li onmousemove="Select.itemMouseMove(4, 8)" val="8" class="">8</li><li onmousemove="Select.itemMouseMove(4, 9)" val="9" class="">9</li><li onmousemove="Select.itemMouseMove(4, 10)" val="10" class="">10</li><li onmousemove="Select.itemMouseMove(4, 11)" val="11" class="">11</li><li onmousemove="Select.itemMouseMove(4, 12)" val="12" class="">12</li><li onmousemove="Select.itemMouseMove(4, 13)" val="13" class="">13</li><li onmousemove="Select.itemMouseMove(4, 14)" val="14" class="">14</li><li onmousemove="Select.itemMouseMove(4, 15)" val="15" class="">15</li><li onmousemove="Select.itemMouseMove(4, 16)" val="16" class="">16</li><li onmousemove="Select.itemMouseMove(4, 17)" val="17" class="">17</li><li onmousemove="Select.itemMouseMove(4, 18)" val="18" class="">18</li><li onmousemove="Select.itemMouseMove(4, 19)" val="19" class="">19</li><li onmousemove="Select.itemMouseMove(4, 20)" val="20" class="">20</li><li onmousemove="Select.itemMouseMove(4, 21)" val="21" class="">21</li><li onmousemove="Select.itemMouseMove(4, 22)" val="22" class="">22</li><li onmousemove="Select.itemMouseMove(4, 23)" val="23" class="">23</li><li onmousemove="Select.itemMouseMove(4, 24)" val="24" class="">24</li><li onmousemove="Select.itemMouseMove(4, 25)" val="25" class="">25</li><li onmousemove="Select.itemMouseMove(4, 26)" val="26" class="">26</li><li onmousemove="Select.itemMouseMove(4, 27)" val="27" class="">27</li><li onmousemove="Select.itemMouseMove(4, 28)" val="28" class="">28</li><li onmousemove="Select.itemMouseMove(4, 29)" val="29" class="">29</li><li onmousemove="Select.itemMouseMove(4, 30)" val="30" class="">30</li><li onmousemove="Select.itemMouseMove(4, 31)" val="31" class="">31</li>'));
					
					
					if(intval($_GET['year']) == 0) 
					$years = 'Год рождения';
					else 
					$years = intval($_GET['year']);
	
					$tpl->set('{years_name}', $years);
					$tpl->set('{years_id}', intval($_GET['year']));
					$tpl->set('{years}', InstallationSelectedNew(intval($_GET['year']),'<li onmousemove="Select.itemMouseMove(6, 0)" val="0" class="">Год</li><li onmousemove="Select.itemMouseMove(6, 2013)" val="2013" class="">2013</li><li onmousemove="Select.itemMouseMove(6, 2012)" val="2012" class="">2012</li><li onmousemove="Select.itemMouseMove(6, 2011)" val="2011" class="">2011</li><li onmousemove="Select.itemMouseMove(6, 2010)" val="2010" class="">2010</li><li onmousemove="Select.itemMouseMove(6, 2009)" val="2009" class="">2009</li><li onmousemove="Select.itemMouseMove(6, 2008)" val="2008" class="">2008</li><li onmousemove="Select.itemMouseMove(6, 2007)" val="2007" class="">2007</li><li onmousemove="Select.itemMouseMove(6, 2006)" val="2006" class="">2006</li><li onmousemove="Select.itemMouseMove(6, 2005)" val="2005" class="">2005</li><li onmousemove="Select.itemMouseMove(6, 2004)" val="2004" class="">2004</li><li onmousemove="Select.itemMouseMove(6, 2003)" val="2003" class="">2003</li><li onmousemove="Select.itemMouseMove(6, 2002)" val="2002" class="">2002</li><li onmousemove="Select.itemMouseMove(6, 2001)" val="2001" class="">2001</li><li onmousemove="Select.itemMouseMove(6, 2000)" val="2000" class="">2000</li><li onmousemove="Select.itemMouseMove(6, 1999)" val="1999" class="">1999</li><li onmousemove="Select.itemMouseMove(6, 1998)" val="1998" class="">1998</li><li onmousemove="Select.itemMouseMove(6, 1997)" val="1997" class="">1997</li><li onmousemove="Select.itemMouseMove(6, 1996)" val="1996" class="">1996</li><li onmousemove="Select.itemMouseMove(6, 1995)" val="1995" class="">1995</li><li onmousemove="Select.itemMouseMove(6, 1994)" val="1994" class="">1994</li><li onmousemove="Select.itemMouseMove(6, 1993)" val="1993" class="">1993</li><li onmousemove="Select.itemMouseMove(6, 1992)" val="1992" class="">1992</li><li onmousemove="Select.itemMouseMove(6, 1991)" val="1991" class="">1991</li><li onmousemove="Select.itemMouseMove(6, 1990)" val="1990" class="">1990</li><li onmousemove="Select.itemMouseMove(6, 1989)" val="1989" class="">1989</li><li onmousemove="Select.itemMouseMove(6, 1988)" val="1988" class="">1988</li><li onmousemove="Select.itemMouseMove(6, 1987)" val="1987" class="">1987</li><li onmousemove="Select.itemMouseMove(6, 1986)" val="1986" class="">1986</li><li onmousemove="Select.itemMouseMove(6, 1985)" val="1985" class="">1985</li><li onmousemove="Select.itemMouseMove(6, 1984)" val="1984" class="">1984</li><li onmousemove="Select.itemMouseMove(6, 1983)" val="1983" class="">1983</li><li onmousemove="Select.itemMouseMove(6, 1982)" val="1982" class="">1982</li><li onmousemove="Select.itemMouseMove(6, 1981)" val="1981" class="">1981</li><li onmousemove="Select.itemMouseMove(6, 1980)" val="1980" class="">1980</li><li onmousemove="Select.itemMouseMove(6, 1979)" val="1979" class="">1979</li><li onmousemove="Select.itemMouseMove(6, 1978)" val="1978" class="">1978</li><li onmousemove="Select.itemMouseMove(6, 1977)" val="1977" class="">1977</li><li onmousemove="Select.itemMouseMove(6, 1976)" val="1976" class="">1976</li><li onmousemove="Select.itemMouseMove(6, 1975)" val="1975" class="">1975</li><li onmousemove="Select.itemMouseMove(6, 1974)" val="1974" class="">1974</li><li onmousemove="Select.itemMouseMove(6, 1973)" val="1973" class="">1973</li><li onmousemove="Select.itemMouseMove(6, 1972)" val="1972" class="">1972</li><li onmousemove="Select.itemMouseMove(6, 1971)" val="1971" class="">1971</li><li onmousemove="Select.itemMouseMove(6, 1970)" val="1970" class="">1970</li><li onmousemove="Select.itemMouseMove(6, 1969)" val="1969" class="">1969</li><li onmousemove="Select.itemMouseMove(6, 1968)" val="1968" class="">1968</li><li onmousemove="Select.itemMouseMove(6, 1967)" val="1967" class="">1967</li><li onmousemove="Select.itemMouseMove(6, 1966)" val="1966" class="">1966</li><li onmousemove="Select.itemMouseMove(6, 1965)" val="1965" class="">1965</li><li onmousemove="Select.itemMouseMove(6, 1964)" val="1964" class="">1964</li><li onmousemove="Select.itemMouseMove(6, 1963)" val="1963" class="">1963</li><li onmousemove="Select.itemMouseMove(6, 1962)" val="1962" class="">1962</li><li onmousemove="Select.itemMouseMove(6, 1961)" val="1961" class="">1961</li><li onmousemove="Select.itemMouseMove(6, 1960)" val="1960" class="">1960</li><li onmousemove="Select.itemMouseMove(6, 1959)" val="1959" class="">1959</li><li onmousemove="Select.itemMouseMove(6, 1958)" val="1958" class="">1958</li><li onmousemove="Select.itemMouseMove(6, 1957)" val="1957" class="">1957</li><li onmousemove="Select.itemMouseMove(6, 1956)" val="1956" class="">1956</li><li onmousemove="Select.itemMouseMove(6, 1955)" val="1955" class="">1955</li><li onmousemove="Select.itemMouseMove(6, 1954)" val="1954" class="">1954</li><li onmousemove="Select.itemMouseMove(6, 1953)" val="1953" class="">1953</li><li onmousemove="Select.itemMouseMove(6, 1952)" val="1952" class="">1952</li><li onmousemove="Select.itemMouseMove(6, 1951)" val="1951" class="">1951</li><li onmousemove="Select.itemMouseMove(6, 1950)" val="1950" class="">1950</li><li onmousemove="Select.itemMouseMove(6, 1949)" val="1949" class="">1949</li><li onmousemove="Select.itemMouseMove(6, 1948)" val="1948" class="">1948</li><li onmousemove="Select.itemMouseMove(6, 1947)" val="1947" class="">1947</li><li onmousemove="Select.itemMouseMove(6, 1946)" val="1946" class="">1946</li><li onmousemove="Select.itemMouseMove(6, 1945)" val="1945" class="">1945</li><li onmousemove="Select.itemMouseMove(6, 1944)" val="1944" class="">1944</li><li onmousemove="Select.itemMouseMove(6, 1943)" val="1943" class="">1943</li><li onmousemove="Select.itemMouseMove(6, 1942)" val="1942" class="">1942</li><li onmousemove="Select.itemMouseMove(6, 1941)" val="1941" class="">1941</li><li onmousemove="Select.itemMouseMove(6, 1940)" val="1940" class="">1940</li><li onmousemove="Select.itemMouseMove(6, 1939)" val="1939" class="">1939</li><li onmousemove="Select.itemMouseMove(6, 1938)" val="1938" class="">1938</li><li onmousemove="Select.itemMouseMove(6, 1937)" val="1937" class="">1937</li><li onmousemove="Select.itemMouseMove(6, 1936)" val="1936" class="">1936</li><li onmousemove="Select.itemMouseMove(6, 1935)" val="1935" class="">1935</li><li onmousemove="Select.itemMouseMove(6, 1934)" val="1934" class="">1934</li><li onmousemove="Select.itemMouseMove(6, 1933)" val="1933" class="">1933</li><li onmousemove="Select.itemMouseMove(6, 1932)" val="1932" class="">1932</li><li onmousemove="Select.itemMouseMove(6, 1931)" val="1931" class="">1931</li><li onmousemove="Select.itemMouseMove(6, 1930)" val="1930" class="">1930</li><li onmousemove="Select.itemMouseMove(6, 1929)" val="1929" class="">1929</li><li onmousemove="Select.itemMouseMove(6, 1928)" val="1928" class="">1928</li><li onmousemove="Select.itemMouseMove(6, 1927)" val="1927" class="">1927</li><li onmousemove="Select.itemMouseMove(6, 1926)" val="1926" class="">1926</li><li onmousemove="Select.itemMouseMove(6, 1925)" val="1925" class="">1925</li><li onmousemove="Select.itemMouseMove(6, 1924)" val="1924" class="">1924</li><li onmousemove="Select.itemMouseMove(6, 1923)" val="1923" class="">1923</li><li onmousemove="Select.itemMouseMove(6, 1922)" val="1922" class="">1922</li><li onmousemove="Select.itemMouseMove(6, 1921)" val="1921" class="">1921</li><li onmousemove="Select.itemMouseMove(6, 1920)" val="1920" class="">1920</li><li onmousemove="Select.itemMouseMove(6, 1919)" val="1919" class="">1919</li><li onmousemove="Select.itemMouseMove(6, 1918)" val="1918" class="">1918</li><li onmousemove="Select.itemMouseMove(6, 1917)" val="1917" class="">1917</li><li onmousemove="Select.itemMouseMove(6, 1916)" val="1916" class="">1916</li><li onmousemove="Select.itemMouseMove(6, 1915)" val="1915" class="">1915</li><li onmousemove="Select.itemMouseMove(6, 1914)" val="1914" class="">1914</li><li onmousemove="Select.itemMouseMove(6, 1913)" val="1913" class="">1913</li><li onmousemove="Select.itemMouseMove(6, 1912)" val="1912" class="">1912</li><li onmousemove="Select.itemMouseMove(6, 1911)" val="1911" class="">1911</li><li onmousemove="Select.itemMouseMove(6, 1910)" val="1910" class="">1910</li><li onmousemove="Select.itemMouseMove(6, 1909)" val="1909" class="">1909</li><li onmousemove="Select.itemMouseMove(6, 1908)" val="1908" class="">1908</li><li onmousemove="Select.itemMouseMove(6, 1907)" val="1907" class="">1907</li><li onmousemove="Select.itemMouseMove(6, 1906)" val="1906" class="">1906</li><li onmousemove="Select.itemMouseMove(6, 1905)" val="1905" class="">1905</li><li onmousemove="Select.itemMouseMove(6, 1904)" val="1904" class="">1904</li><li onmousemove="Select.itemMouseMove(6, 1903)" val="1903" class="">1903</li><li onmousemove="Select.itemMouseMove(6, 1902)" val="1902" class="">1902</li><li onmousemove="Select.itemMouseMove(6, 1901)" val="1901" class="">1901</li><li onmousemove="Select.itemMouseMove(6, 1900)" val="1900" class="">1900</li><li onmousemove="Select.itemMouseMove(6, 1899)" val="1899" class="">1899</li><li onmousemove="Select.itemMouseMove(6, 1898)" val="1898" class="">1898</li><li onmousemove="Select.itemMouseMove(6, 1897)" val="1897" class="">1897</li><li onmousemove="Select.itemMouseMove(6, 1896)" val="1896" class="">1896</li><li onmousemove="Select.itemMouseMove(6, 1895)" val="1895" class="">1895</li><li onmousemove="Select.itemMouseMove(6, 1894)" val="1894" class="">1894</li><li onmousemove="Select.itemMouseMove(6, 1893)" val="1893" class="">1893</li><li onmousemove="Select.itemMouseMove(6, 1892)" val="1892" class="">1892</li><li onmousemove="Select.itemMouseMove(6, 1891)" val="1891" class="">1891</li><li onmousemove="Select.itemMouseMove(6, 1890)" val="1890" class="">1890</li><li onmousemove="Select.itemMouseMove(6, 1889)" val="1889" class="">1889</li><li onmousemove="Select.itemMouseMove(6, 1888)" val="1888" class="">1888</li><li onmousemove="Select.itemMouseMove(6, 1887)" val="1887" class="">1887</li><li onmousemove="Select.itemMouseMove(6, 1886)" val="1886" class="">1886</li><li onmousemove="Select.itemMouseMove(6, 1885)" val="1885" class="">1885</li><li onmousemove="Select.itemMouseMove(6, 1884)" val="1884" class="">1884</li><li onmousemove="Select.itemMouseMove(6, 1883)" val="1883" class="">1883</li><li onmousemove="Select.itemMouseMove(6, 1882)" val="1882" class="">1882</li><li onmousemove="Select.itemMouseMove(6, 1881)" val="1881" class="">1881</li><li onmousemove="Select.itemMouseMove(6, 1880)" val="1880" class="">1880</li><li onmousemove="Select.itemMouseMove(6, 1879)" val="1879" class="">1879</li><li onmousemove="Select.itemMouseMove(6, 1878)" val="1878" class="">1878</li><li onmousemove="Select.itemMouseMove(6, 1877)" val="1877" class="">1877</li><li onmousemove="Select.itemMouseMove(6, 1876)" val="1876" class="">1876</li><li onmousemove="Select.itemMouseMove(6, 1875)" val="1875" class="">1875</li><li onmousemove="Select.itemMouseMove(6, 1874)" val="1874" class="">1874</li><li onmousemove="Select.itemMouseMove(6, 1873)" val="1873" class="">1873</li><li onmousemove="Select.itemMouseMove(6, 1872)" val="1872" class="">1872</li><li onmousemove="Select.itemMouseMove(6, 1871)" val="1871" class="">1871</li><li onmousemove="Select.itemMouseMove(6, 1870)" val="1870" class="">1870</li><li onmousemove="Select.itemMouseMove(6, 1869)" val="1869" class="">1869</li><li onmousemove="Select.itemMouseMove(6, 1868)" val="1868" class="">1868</li><li onmousemove="Select.itemMouseMove(6, 1867)" val="1867" class="">1867</li><li onmousemove="Select.itemMouseMove(6, 1866)" val="1866" class="">1866</li><li onmousemove="Select.itemMouseMove(6, 1865)" val="1865" class="">1865</li><li onmousemove="Select.itemMouseMove(6, 1864)" val="1864" class="">1864</li><li onmousemove="Select.itemMouseMove(6, 1863)" val="1863" class="">1863</li><li onmousemove="Select.itemMouseMove(6, 1862)" val="1862" class="">1862</li><li onmousemove="Select.itemMouseMove(6, 1861)" val="1861" class="">1861</li><li onmousemove="Select.itemMouseMove(6, 1860)" val="1860" class="">1860</li><li onmousemove="Select.itemMouseMove(6, 1859)" val="1859" class="">1859</li><li onmousemove="Select.itemMouseMove(6, 1858)" val="1858" class="">1858</li><li onmousemove="Select.itemMouseMove(6, 1857)" val="1857" class="">1857</li><li onmousemove="Select.itemMouseMove(6, 1856)" val="1856" class="">1856</li><li onmousemove="Select.itemMouseMove(6, 1855)" val="1855" class="">1855</li><li onmousemove="Select.itemMouseMove(6, 1854)" val="1854" class="">1854</li><li onmousemove="Select.itemMouseMove(6, 1853)" val="1853" class="">1853</li><li onmousemove="Select.itemMouseMove(6, 1852)" val="1852" class="">1852</li><li onmousemove="Select.itemMouseMove(6, 1851)" val="1851" class="">1851</li><li onmousemove="Select.itemMouseMove(6, 1850)" val="1850" class="">1850</li><li onmousemove="Select.itemMouseMove(6, 1849)" val="1849" class="">1849</li><li onmousemove="Select.itemMouseMove(6, 1848)" val="1848" class="">1848</li><li onmousemove="Select.itemMouseMove(6, 1847)" val="1847" class="">1847</li><li onmousemove="Select.itemMouseMove(6, 1846)" val="1846" class="">1846</li><li onmousemove="Select.itemMouseMove(6, 1845)" val="1845" class="">1845</li><li onmousemove="Select.itemMouseMove(6, 1844)" val="1844" class="">1844</li><li onmousemove="Select.itemMouseMove(6, 1843)" val="1843" class="">1843</li><li onmousemove="Select.itemMouseMove(6, 1842)" val="1842" class="">1842</li><li onmousemove="Select.itemMouseMove(6, 1841)" val="1841" class="">1841</li><li onmousemove="Select.itemMouseMove(6, 1840)" val="1840" class="">1840</li><li onmousemove="Select.itemMouseMove(6, 1839)" val="1839" class="">1839</li><li onmousemove="Select.itemMouseMove(6, 1838)" val="1838" class="">1838</li><li onmousemove="Select.itemMouseMove(6, 1837)" val="1837" class="">1837</li><li onmousemove="Select.itemMouseMove(6, 1836)" val="1836" class="">1836</li><li onmousemove="Select.itemMouseMove(6, 1835)" val="1835" class="">1835</li><li onmousemove="Select.itemMouseMove(6, 1834)" val="1834" class="">1834</li><li onmousemove="Select.itemMouseMove(6, 1833)" val="1833" class="">1833</li><li onmousemove="Select.itemMouseMove(6, 1832)" val="1832" class="">1832</li><li onmousemove="Select.itemMouseMove(6, 1831)" val="1831" class="">1831</li><li onmousemove="Select.itemMouseMove(6, 1830)" val="1830" class="">1830</li><li onmousemove="Select.itemMouseMove(6, 1829)" val="1829" class="">1829</li><li onmousemove="Select.itemMouseMove(6, 1828)" val="1828" class="">1828</li><li onmousemove="Select.itemMouseMove(6, 1827)" val="1827" class="">1827</li><li onmousemove="Select.itemMouseMove(6, 1826)" val="1826" class="">1826</li><li onmousemove="Select.itemMouseMove(6, 1825)" val="1825" class="">1825</li><li onmousemove="Select.itemMouseMove(6, 1824)" val="1824" class="">1824</li><li onmousemove="Select.itemMouseMove(6, 1823)" val="1823" class="">1823</li><li onmousemove="Select.itemMouseMove(6, 1822)" val="1822" class="">1822</li><li onmousemove="Select.itemMouseMove(6, 1821)" val="1821" class="">1821</li><li onmousemove="Select.itemMouseMove(6, 1820)" val="1820" class="">1820</li><li onmousemove="Select.itemMouseMove(6, 1819)" val="1819" class="">1819</li><li onmousemove="Select.itemMouseMove(6, 1818)" val="1818" class="">1818</li><li onmousemove="Select.itemMouseMove(6, 1817)" val="1817" class="">1817</li><li onmousemove="Select.itemMouseMove(6, 1816)" val="1816" class="">1816</li><li onmousemove="Select.itemMouseMove(6, 1815)" val="1815" class="">1815</li><li onmousemove="Select.itemMouseMove(6, 1814)" val="1814" class="">1814</li><li onmousemove="Select.itemMouseMove(6, 1813)" val="1813" class="">1813</li><li onmousemove="Select.itemMouseMove(6, 1812)" val="1812" class="">1812</li><li onmousemove="Select.itemMouseMove(6, 1811)" val="1811" class="">1811</li><li onmousemove="Select.itemMouseMove(6, 1810)" val="1810" class="">1810</li><li onmousemove="Select.itemMouseMove(6, 1809)" val="1809" class="">1809</li><li onmousemove="Select.itemMouseMove(6, 1808)" val="1808" class="">1808</li><li onmousemove="Select.itemMouseMove(6, 1807)" val="1807" class="">1807</li><li onmousemove="Select.itemMouseMove(6, 1806)" val="1806" class="">1806</li><li onmousemove="Select.itemMouseMove(6, 1805)" val="1805" class="">1805</li><li onmousemove="Select.itemMouseMove(6, 1804)" val="1804" class="">1804</li><li onmousemove="Select.itemMouseMove(6, 1803)" val="1803" class="">1803</li><li onmousemove="Select.itemMouseMove(6, 1802)" val="1802" class="">1802</li><li onmousemove="Select.itemMouseMove(6, 1801)" val="1801" class="">1801</li><li onmousemove="Select.itemMouseMove(6, 1800)" val="1800" class="">1800</li>'));
					$tpl->set('{month_id}', intval($_GET['month']));
					$tpl->set('{month_name}', convertMonth(intval($_GET['month'])));
					$tpl->set('{month}', InstallationSelectedNew(intval($_GET['month']),'<li onmousemove="Select.itemMouseMove(5, 0)" val="0" class="">Месяц</li><li onmousemove="Select.itemMouseMove(5, 1)" val="1" class="">Января</li><li onmousemove="Select.itemMouseMove(5, 2)" val="2" class="">Февраля</li><li onmousemove="Select.itemMouseMove(5, 3)" val="3" class="">Марта</li><li onmousemove="Select.itemMouseMove(5, 4)" val="4" class="">Апреля</li><li onmousemove="Select.itemMouseMove(5, 5)" val="5" class="">Мая</li><li onmousemove="Select.itemMouseMove(5, 6)" val="6" class="">Июня</li><li onmousemove="Select.itemMouseMove(5, 7)" val="7" class="">Июля</li><li onmousemove="Select.itemMouseMove(5, 8)" val="8" class="">Августа</li><li onmousemove="Select.itemMouseMove(5, 9)" val="9" class="">Сентября</li><li onmousemove="Select.itemMouseMove(5, 10)" val="10" class="">Отктября</li><li onmousemove="Select.itemMouseMove(5, 11)" val="11" class="">Ноября</li><li onmousemove="Select.itemMouseMove(5, 12)" val="12" class="">Декабря</li>'));
	
					if(intval($_GET['nacalosl']) == 0) 
					$yearsl = 'Год начала службы';
					else 
					$yearsl = intval($_GET['nacalosl']);
	
					$tpl->set('{nacalosl_name}', $yearsl);
					$tpl->set('{nacalosl_id}', intval($_GET['nacalosl']));
					$tpl->set('{nacalosl}', InstallationSelectedNew(intval($_GET['nacalosl']),'<li onmousemove="Select.itemMouseMove(13, 0)" val="0" class="">Год</li><li onmousemove="Select.itemMouseMove(13, 2013)" val="2013" class="">2013</li><li onmousemove="Select.itemMouseMove(13, 2012)" val="2012" class="">2012</li><li onmousemove="Select.itemMouseMove(13, 2011)" val="2011" class="">2011</li><li onmousemove="Select.itemMouseMove(13, 2010)" val="2010" class="">2010</li><li onmousemove="Select.itemMouseMove(13, 2009)" val="2009" class="">2009</li><li onmousemove="Select.itemMouseMove(13, 2008)" val="2008" class="">2008</li><li onmousemove="Select.itemMouseMove(13, 2007)" val="2007" class="">2007</li><li onmousemove="Select.itemMouseMove(13, 2006)" val="2006" class="">2006</li><li onmousemove="Select.itemMouseMove(13, 2005)" val="2005" class="">2005</li><li onmousemove="Select.itemMouseMove(13, 2004)" val="2004" class="">2004</li><li onmousemove="Select.itemMouseMove(13, 2003)" val="2003" class="">2003</li><li onmousemove="Select.itemMouseMove(13, 2002)" val="2002" class="">2002</li><li onmousemove="Select.itemMouseMove(13, 2001)" val="2001" class="">2001</li><li onmousemove="Select.itemMouseMove(13, 2000)" val="2000" class="">2000</li><li onmousemove="Select.itemMouseMove(13, 1999)" val="1999" class="">1999</li><li onmousemove="Select.itemMouseMove(13, 1998)" val="1998" class="">1998</li><li onmousemove="Select.itemMouseMove(13, 1997)" val="1997" class="">1997</li><li onmousemove="Select.itemMouseMove(13, 1996)" val="1996" class="">1996</li><li onmousemove="Select.itemMouseMove(13, 1995)" val="1995" class="">1995</li><li onmousemove="Select.itemMouseMove(13, 1994)" val="1994" class="">1994</li><li onmousemove="Select.itemMouseMove(13, 1993)" val="1993" class="">1993</li><li onmousemove="Select.itemMouseMove(13, 1992)" val="1992" class="">1992</li><li onmousemove="Select.itemMouseMove(13, 1991)" val="1991" class="">1991</li><li onmousemove="Select.itemMouseMove(13, 1990)" val="1990" class="">1990</li><li onmousemove="Select.itemMouseMove(13, 1989)" val="1989" class="">1989</li><li onmousemove="Select.itemMouseMove(13, 1988)" val="1988" class="">1988</li><li onmousemove="Select.itemMouseMove(13, 1987)" val="1987" class="">1987</li><li onmousemove="Select.itemMouseMove(13, 1986)" val="1986" class="">1986</li><li onmousemove="Select.itemMouseMove(13, 1985)" val="1985" class="">1985</li><li onmousemove="Select.itemMouseMove(13, 1984)" val="1984" class="">1984</li><li onmousemove="Select.itemMouseMove(13, 1983)" val="1983" class="">1983</li><li onmousemove="Select.itemMouseMove(13, 1982)" val="1982" class="">1982</li><li onmousemove="Select.itemMouseMove(13, 1981)" val="1981" class="">1981</li><li onmousemove="Select.itemMouseMove(13, 1980)" val="1980" class="">1980</li><li onmousemove="Select.itemMouseMove(13, 1979)" val="1979" class="">1979</li><li onmousemove="Select.itemMouseMove(13, 1978)" val="1978" class="">1978</li><li onmousemove="Select.itemMouseMove(13, 1977)" val="1977" class="">1977</li><li onmousemove="Select.itemMouseMove(13, 1976)" val="1976" class="">1976</li><li onmousemove="Select.itemMouseMove(13, 1975)" val="1975" class="">1975</li><li onmousemove="Select.itemMouseMove(13, 1974)" val="1974" class="">1974</li><li onmousemove="Select.itemMouseMove(13, 1973)" val="1973" class="">1973</li><li onmousemove="Select.itemMouseMove(13, 1972)" val="1972" class="">1972</li><li onmousemove="Select.itemMouseMove(13, 1971)" val="1971" class="">1971</li><li onmousemove="Select.itemMouseMove(13, 1970)" val="1970" class="">1970</li><li onmousemove="Select.itemMouseMove(13, 1969)" val="1969" class="">1969</li><li onmousemove="Select.itemMouseMove(13, 1968)" val="1968" class="">1968</li><li onmousemove="Select.itemMouseMove(13, 1967)" val="1967" class="">1967</li><li onmousemove="Select.itemMouseMove(13, 1966)" val="1966" class="">1966</li><li onmousemove="Select.itemMouseMove(13, 1965)" val="1965" class="">1965</li><li onmousemove="Select.itemMouseMove(13, 1964)" val="1964" class="">1964</li><li onmousemove="Select.itemMouseMove(13, 1963)" val="1963" class="">1963</li><li onmousemove="Select.itemMouseMove(13, 1962)" val="1962" class="">1962</li><li onmousemove="Select.itemMouseMove(13, 1961)" val="1961" class="">1961</li><li onmousemove="Select.itemMouseMove(13, 1960)" val="1960" class="">1960</li><li onmousemove="Select.itemMouseMove(13, 1959)" val="1959" class="">1959</li><li onmousemove="Select.itemMouseMove(13, 1958)" val="1958" class="">1958</li><li onmousemove="Select.itemMouseMove(13, 1957)" val="1957" class="">1957</li><li onmousemove="Select.itemMouseMove(13, 1956)" val="1956" class="">1956</li><li onmousemove="Select.itemMouseMove(13, 1955)" val="1955" class="">1955</li><li onmousemove="Select.itemMouseMove(13, 1954)" val="1954" class="">1954</li><li onmousemove="Select.itemMouseMove(13, 1953)" val="1953" class="">1953</li><li onmousemove="Select.itemMouseMove(13, 1952)" val="1952" class="">1952</li><li onmousemove="Select.itemMouseMove(13, 1951)" val="1951" class="">1951</li><li onmousemove="Select.itemMouseMove(13, 1950)" val="1950" class="">1950</li><li onmousemove="Select.itemMouseMove(13, 1949)" val="1949" class="">1949</li><li onmousemove="Select.itemMouseMove(13, 1948)" val="1948" class="">1948</li><li onmousemove="Select.itemMouseMove(13, 1947)" val="1947" class="">1947</li><li onmousemove="Select.itemMouseMove(13, 1946)" val="1946" class="">1946</li><li onmousemove="Select.itemMouseMove(13, 1945)" val="1945" class="">1945</li><li onmousemove="Select.itemMouseMove(13, 1944)" val="1944" class="">1944</li><li onmousemove="Select.itemMouseMove(13, 1943)" val="1943" class="">1943</li><li onmousemove="Select.itemMouseMove(13, 1942)" val="1942" class="">1942</li><li onmousemove="Select.itemMouseMove(13, 1941)" val="1941" class="">1941</li><li onmousemove="Select.itemMouseMove(13, 1940)" val="1940" class="">1940</li><li onmousemove="Select.itemMouseMove(13, 1939)" val="1939" class="">1939</li><li onmousemove="Select.itemMouseMove(13, 1938)" val="1938" class="">1938</li><li onmousemove="Select.itemMouseMove(13, 1937)" val="1937" class="">1937</li><li onmousemove="Select.itemMouseMove(13, 1936)" val="1936" class="">1936</li><li onmousemove="Select.itemMouseMove(13, 1935)" val="1935" class="">1935</li><li onmousemove="Select.itemMouseMove(13, 1934)" val="1934" class="">1934</li><li onmousemove="Select.itemMouseMove(13, 1933)" val="1933" class="">1933</li><li onmousemove="Select.itemMouseMove(13, 1932)" val="1932" class="">1932</li><li onmousemove="Select.itemMouseMove(13, 1931)" val="1931" class="">1931</li><li onmousemove="Select.itemMouseMove(13, 1930)" val="1930" class="">1930</li><li onmousemove="Select.itemMouseMove(13, 1929)" val="1929" class="">1929</li><li onmousemove="Select.itemMouseMove(13, 1928)" val="1928" class="">1928</li><li onmousemove="Select.itemMouseMove(13, 1927)" val="1927" class="">1927</li><li onmousemove="Select.itemMouseMove(13, 1926)" val="1926" class="">1926</li><li onmousemove="Select.itemMouseMove(13, 1925)" val="1925" class="">1925</li><li onmousemove="Select.itemMouseMove(13, 1924)" val="1924" class="">1924</li><li onmousemove="Select.itemMouseMove(13, 1923)" val="1923" class="">1923</li><li onmousemove="Select.itemMouseMove(13, 1922)" val="1922" class="">1922</li><li onmousemove="Select.itemMouseMove(13, 1921)" val="1921" class="">1921</li><li onmousemove="Select.itemMouseMove(13, 1920)" val="1920" class="">1920</li><li onmousemove="Select.itemMouseMove(13, 1919)" val="1919" class="">1919</li><li onmousemove="Select.itemMouseMove(13, 1918)" val="1918" class="">1918</li><li onmousemove="Select.itemMouseMove(13, 1917)" val="1917" class="">1917</li><li onmousemove="Select.itemMouseMove(13, 1916)" val="1916" class="">1916</li><li onmousemove="Select.itemMouseMove(13, 1915)" val="1915" class="">1915</li><li onmousemove="Select.itemMouseMove(13, 1914)" val="1914" class="">1914</li><li onmousemove="Select.itemMouseMove(13, 1913)" val="1913" class="">1913</li><li onmousemove="Select.itemMouseMove(13, 1912)" val="1912" class="">1912</li><li onmousemove="Select.itemMouseMove(13, 1911)" val="1911" class="">1911</li><li onmousemove="Select.itemMouseMove(13, 1910)" val="1910" class="">1910</li><li onmousemove="Select.itemMouseMove(13, 1909)" val="1909" class="">1909</li><li onmousemove="Select.itemMouseMove(13, 1908)" val="1908" class="">1908</li><li onmousemove="Select.itemMouseMove(13, 1907)" val="1907" class="">1907</li><li onmousemove="Select.itemMouseMove(13, 1906)" val="1906" class="">1906</li><li onmousemove="Select.itemMouseMove(13, 1905)" val="1905" class="">1905</li><li onmousemove="Select.itemMouseMove(13, 1904)" val="1904" class="">1904</li><li onmousemove="Select.itemMouseMove(13, 1903)" val="1903" class="">1903</li><li onmousemove="Select.itemMouseMove(13, 1902)" val="1902" class="">1902</li><li onmousemove="Select.itemMouseMove(13, 1901)" val="1901" class="">1901</li><li onmousemove="Select.itemMouseMove(13, 1900)" val="1900" class="">1900</li><li onmousemove="Select.itemMouseMove(13, 1899)" val="1899" class="">1899</li><li onmousemove="Select.itemMouseMove(13, 1898)" val="1898" class="">1898</li><li onmousemove="Select.itemMouseMove(13, 1897)" val="1897" class="">1897</li><li onmousemove="Select.itemMouseMove(13, 1896)" val="1896" class="">1896</li><li onmousemove="Select.itemMouseMove(13, 1895)" val="1895" class="">1895</li><li onmousemove="Select.itemMouseMove(13, 1894)" val="1894" class="">1894</li><li onmousemove="Select.itemMouseMove(13, 1893)" val="1893" class="">1893</li><li onmousemove="Select.itemMouseMove(13, 1892)" val="1892" class="">1892</li><li onmousemove="Select.itemMouseMove(13, 1891)" val="1891" class="">1891</li><li onmousemove="Select.itemMouseMove(13, 1890)" val="1890" class="">1890</li><li onmousemove="Select.itemMouseMove(13, 1889)" val="1889" class="">1889</li><li onmousemove="Select.itemMouseMove(13, 1888)" val="1888" class="">1888</li><li onmousemove="Select.itemMouseMove(13, 1887)" val="1887" class="">1887</li><li onmousemove="Select.itemMouseMove(13, 1886)" val="1886" class="">1886</li><li onmousemove="Select.itemMouseMove(13, 1885)" val="1885" class="">1885</li><li onmousemove="Select.itemMouseMove(13, 1884)" val="1884" class="">1884</li><li onmousemove="Select.itemMouseMove(13, 1883)" val="1883" class="">1883</li><li onmousemove="Select.itemMouseMove(13, 1882)" val="1882" class="">1882</li><li onmousemove="Select.itemMouseMove(13, 1881)" val="1881" class="">1881</li><li onmousemove="Select.itemMouseMove(13, 1880)" val="1880" class="">1880</li><li onmousemove="Select.itemMouseMove(13, 1879)" val="1879" class="">1879</li><li onmousemove="Select.itemMouseMove(13, 1878)" val="1878" class="">1878</li><li onmousemove="Select.itemMouseMove(13, 1877)" val="1877" class="">1877</li><li onmousemove="Select.itemMouseMove(13, 1876)" val="1876" class="">1876</li><li onmousemove="Select.itemMouseMove(13, 1875)" val="1875" class="">1875</li><li onmousemove="Select.itemMouseMove(13, 1874)" val="1874" class="">1874</li><li onmousemove="Select.itemMouseMove(13, 1873)" val="1873" class="">1873</li><li onmousemove="Select.itemMouseMove(13, 1872)" val="1872" class="">1872</li><li onmousemove="Select.itemMouseMove(13, 1871)" val="1871" class="">1871</li><li onmousemove="Select.itemMouseMove(13, 1870)" val="1870" class="">1870</li><li onmousemove="Select.itemMouseMove(13, 1869)" val="1869" class="">1869</li><li onmousemove="Select.itemMouseMove(13, 1868)" val="1868" class="">1868</li><li onmousemove="Select.itemMouseMove(13, 1867)" val="1867" class="">1867</li><li onmousemove="Select.itemMouseMove(13, 1866)" val="1866" class="">1866</li><li onmousemove="Select.itemMouseMove(13, 1865)" val="1865" class="">1865</li><li onmousemove="Select.itemMouseMove(13, 1864)" val="1864" class="">1864</li><li onmousemove="Select.itemMouseMove(13, 1863)" val="1863" class="">1863</li><li onmousemove="Select.itemMouseMove(13, 1862)" val="1862" class="">1862</li><li onmousemove="Select.itemMouseMove(13, 1861)" val="1861" class="">1861</li><li onmousemove="Select.itemMouseMove(13, 1860)" val="1860" class="">1860</li><li onmousemove="Select.itemMouseMove(13, 1859)" val="1859" class="">1859</li><li onmousemove="Select.itemMouseMove(13, 1858)" val="1858" class="">1858</li><li onmousemove="Select.itemMouseMove(13, 1857)" val="1857" class="">1857</li><li onmousemove="Select.itemMouseMove(13, 1856)" val="1856" class="">1856</li><li onmousemove="Select.itemMouseMove(13, 1855)" val="1855" class="">1855</li><li onmousemove="Select.itemMouseMove(13, 1854)" val="1854" class="">1854</li><li onmousemove="Select.itemMouseMove(13, 1853)" val="1853" class="">1853</li><li onmousemove="Select.itemMouseMove(13, 1852)" val="1852" class="">1852</li><li onmousemove="Select.itemMouseMove(13, 1851)" val="1851" class="">1851</li><li onmousemove="Select.itemMouseMove(13, 1850)" val="1850" class="">1850</li><li onmousemove="Select.itemMouseMove(13, 1849)" val="1849" class="">1849</li><li onmousemove="Select.itemMouseMove(13, 1848)" val="1848" class="">1848</li><li onmousemove="Select.itemMouseMove(13, 1847)" val="1847" class="">1847</li><li onmousemove="Select.itemMouseMove(13, 1846)" val="1846" class="">1846</li><li onmousemove="Select.itemMouseMove(13, 1845)" val="1845" class="">1845</li><li onmousemove="Select.itemMouseMove(13, 1844)" val="1844" class="">1844</li><li onmousemove="Select.itemMouseMove(13, 1843)" val="1843" class="">1843</li><li onmousemove="Select.itemMouseMove(13, 1842)" val="1842" class="">1842</li><li onmousemove="Select.itemMouseMove(13, 1841)" val="1841" class="">1841</li><li onmousemove="Select.itemMouseMove(13, 1840)" val="1840" class="">1840</li><li onmousemove="Select.itemMouseMove(13, 1839)" val="1839" class="">1839</li><li onmousemove="Select.itemMouseMove(13, 1838)" val="1838" class="">1838</li><li onmousemove="Select.itemMouseMove(13, 1837)" val="1837" class="">1837</li><li onmousemove="Select.itemMouseMove(13, 1836)" val="1836" class="">1836</li><li onmousemove="Select.itemMouseMove(13, 1835)" val="1835" class="">1835</li><li onmousemove="Select.itemMouseMove(13, 1834)" val="1834" class="">1834</li><li onmousemove="Select.itemMouseMove(13, 1833)" val="1833" class="">1833</li><li onmousemove="Select.itemMouseMove(13, 1832)" val="1832" class="">1832</li><li onmousemove="Select.itemMouseMove(13, 1831)" val="1831" class="">1831</li><li onmousemove="Select.itemMouseMove(13, 1830)" val="1830" class="">1830</li><li onmousemove="Select.itemMouseMove(13, 1829)" val="1829" class="">1829</li><li onmousemove="Select.itemMouseMove(13, 1828)" val="1828" class="">1828</li><li onmousemove="Select.itemMouseMove(13, 1827)" val="1827" class="">1827</li><li onmousemove="Select.itemMouseMove(13, 1826)" val="1826" class="">1826</li><li onmousemove="Select.itemMouseMove(13, 1825)" val="1825" class="">1825</li><li onmousemove="Select.itemMouseMove(13, 1824)" val="1824" class="">1824</li><li onmousemove="Select.itemMouseMove(13, 1823)" val="1823" class="">1823</li><li onmousemove="Select.itemMouseMove(13, 1822)" val="1822" class="">1822</li><li onmousemove="Select.itemMouseMove(13, 1821)" val="1821" class="">1821</li><li onmousemove="Select.itemMouseMove(13, 1820)" val="1820" class="">1820</li><li onmousemove="Select.itemMouseMove(13, 1819)" val="1819" class="">1819</li><li onmousemove="Select.itemMouseMove(13, 1818)" val="1818" class="">1818</li><li onmousemove="Select.itemMouseMove(13, 1817)" val="1817" class="">1817</li><li onmousemove="Select.itemMouseMove(13, 1816)" val="1816" class="">1816</li><li onmousemove="Select.itemMouseMove(13, 1815)" val="1815" class="">1815</li><li onmousemove="Select.itemMouseMove(13, 1814)" val="1814" class="">1814</li><li onmousemove="Select.itemMouseMove(13, 1813)" val="1813" class="">1813</li><li onmousemove="Select.itemMouseMove(13, 1812)" val="1812" class="">1812</li><li onmousemove="Select.itemMouseMove(13, 1811)" val="1811" class="">1811</li><li onmousemove="Select.itemMouseMove(13, 1810)" val="1810" class="">1810</li><li onmousemove="Select.itemMouseMove(13, 1809)" val="1809" class="">1809</li><li onmousemove="Select.itemMouseMove(13, 1808)" val="1808" class="">1808</li><li onmousemove="Select.itemMouseMove(13, 1807)" val="1807" class="">1807</li><li onmousemove="Select.itemMouseMove(13, 1806)" val="1806" class="">1806</li><li onmousemove="Select.itemMouseMove(13, 1805)" val="1805" class="">1805</li><li onmousemove="Select.itemMouseMove(13, 1804)" val="1804" class="">1804</li><li onmousemove="Select.itemMouseMove(13, 1803)" val="1803" class="">1803</li><li onmousemove="Select.itemMouseMove(13, 1802)" val="1802" class="">1802</li><li onmousemove="Select.itemMouseMove(13, 1801)" val="1801" class="">1801</li><li onmousemove="Select.itemMouseMove(13, 1800)" val="1800" class="">1800</li>'));

	
	
	
	if(intval($_GET['jizn']) == 0){
	$tpl->set('{jizn_name}',	'Главное в жизни');
	$tpl->set('{jizn_id}',	'0');
	}
	if(intval($_GET['jizn']) == 1){
	$tpl->set('{jizn_name}',	'Семья и дети');
	$tpl->set('{jizn_id}',	'1');
	}
	if(intval($_GET['jizn']) == 2){
	$tpl->set('{jizn_name}',	'Карьера и деньги');
	$tpl->set('{jizn_id}',	'2');
	}
	if(intval($_GET['jizn']) == 3){
	$tpl->set('{jizn_name}',	'Развлечения и отдых');
	$tpl->set('{jizn_id}',	'3');
	}
	if(intval($_GET['jizn']) == 4){
	$tpl->set('{jizn_name}',	'Наука и исследование');
	$tpl->set('{jizn_id}',	'4');
	}
	if(intval($_GET['jizn']) == 5){
	$tpl->set('{jizn_name}',	'Совершенствование мира');
	$tpl->set('{jizn_id}',	'5');
	}
	if(intval($_GET['jizn']) == 6){
	$tpl->set('{jizn_name}',	'Саморазвитие');
	$tpl->set('{jizn_id}',	'6');
	}
	if(intval($_GET['jizn']) == 7){
	$tpl->set('{jizn_name}',	'Красота и искуство');
	$tpl->set('{jizn_id}',	'7');
	}
	if(intval($_GET['jizn']) == 8){
	$tpl->set('{jizn_name}',	'Слава и влияние');
	$tpl->set('{jizn_id}',	'8');
	}
	
	$tpl->set('{jizn}', InstallationSelectedNew(intval($_GET['jizn']),'<li onmousemove="Select.itemMouseMove(8, 0)"  val="0" class="">- Не выбрано -</li><li onmousemove="Select.itemMouseMove(8, 1)"  val="1" class="">Семья и дети</li><li onmousemove="Select.itemMouseMove(8, 2)"  val="2" class="">Карьера и деньги</li><li onmousemove="Select.itemMouseMove(8, 3)"  val="3" class="">Развлечения и отдых</li><li onmousemove="Select.itemMouseMove(8, 4)"  val="4" class="">Наука и исследование</li><li onmousemove="Select.itemMouseMove(8, 5)"  val="5" class="">Совершенствование мира</li><li onmousemove="Select.itemMouseMove(8, 6)"  val="6" class="">Саморазвитие</li><li onmousemove="Select.itemMouseMove(8, 7)"  val="7" class="">Красота и искуство</li><li onmousemove="Select.itemMouseMove(8, 8)"  val="8" class="">Слава и влияние</li>'));

	

	
	
	
	if(intval($_GET['ludi']) == 0){
	$tpl->set('{ludi_name}',	'Главное в людях');
	$tpl->set('{ludi_id}',	'0');
	}
	if(intval($_GET['ludi']) == 1){
	$tpl->set('{ludi_name}',	'Ум и креативность');
	$tpl->set('{ludi_id}',	'1');
	}
	if(intval($_GET['ludi']) == 2){
	$tpl->set('{ludi_name}',	'Доброта и честность');
	$tpl->set('{ludi_id}',	'2');
	}
	if(intval($_GET['ludi']) == 3){
	$tpl->set('{ludi_name}',	'Красота и здоровье');
	$tpl->set('{ludi_id}',	'3');
	}
	if(intval($_GET['ludi']) == 4){
	$tpl->set('{ludi_name}',	'Власть и богатство');
	$tpl->set('{ludi_id}',	'4');
	}
	if(intval($_GET['ludi']) == 5){
	$tpl->set('{ludi_name}',	'Смелость и упорство');
	$tpl->set('{ludi_id}',	'5');
	}
	if(intval($_GET['ludi']) == 6){
	$tpl->set('{ludi_name}',	'Юмор и жизнелюбие');
	$tpl->set('{ludi_id}',	'6');
	}
	
	$tpl->set('{ludi}', InstallationSelectedNew(intval($_GET['ludi']),'<li onmousemove="Select.itemMouseMove(9, 0)"  val="0" class="">- Не выбрано -</li><li onmousemove="Select.itemMouseMove(9, 1)"  val="1" class="">Ум и креативность</li><li onmousemove="Select.itemMouseMove(9, 2)"  val="2" class="">Доброта и честность</li><li onmousemove="Select.itemMouseMove(9, 3)"  val="3" class="">Красота и здоровье</li><li onmousemove="Select.itemMouseMove(9, 4)"  val="4" class="">Власть и богатство</li><li onmousemove="Select.itemMouseMove(9, 5)"  val="5" class="">Смелость и упорство</li><li onmousemove="Select.itemMouseMove(9, 6)"  val="6" class="">Юмор и жизнелюбие</li>'));

	



	if(intval($_GET['kurenie']) == 0){
	$tpl->set('{kurenie_name}',	'Отношение к курению');
	$tpl->set('{kurenie_id}',	'0');
	}
	if(intval($_GET['kurenie']) == 1){
	$tpl->set('{kurenie_name}',	'Резко негативное');
	$tpl->set('{kurenie_id}',	'1');
	}
	if(intval($_GET['kurenie']) == 2){
	$tpl->set('{kurenie_name}',	'Негативное');
	$tpl->set('{kurenie_id}',	'2');
	}
	if(intval($_GET['kurenie']) == 3){
	$tpl->set('{kurenie_name}',	'Компромиссное');
	$tpl->set('{kurenie_id}',	'3');
	}
	if(intval($_GET['kurenie']) == 4){
	$tpl->set('{kurenie_name}',	'Нейтральное');
	$tpl->set('{kurenie_id}',	'4');
	}
	if(intval($_GET['kurenie']) == 5){
	$tpl->set('{kurenie_name}',	'Положительное');
	$tpl->set('{kurenie_id}',	'5');
	}

	
	$tpl->set('{kurenie}', InstallationSelectedNew(intval($_GET['kurenie']),'<li onmousemove="Select.itemMouseMove(10, 0)"  val="0" class="">- Не выбрано -</li><li onmousemove="Select.itemMouseMove(10, 1)"  val="1" class="">Резко негативное</li><li onmousemove="Select.itemMouseMove(10, 2)"  val="2" class="">Негативное</li><li onmousemove="Select.itemMouseMove(10, 3)"  val="3" class="">Компромиссное</li><li onmousemove="Select.itemMouseMove(10, 4)"  val="4" class="">Нейтральное</li><li onmousemove="Select.itemMouseMove(10, 5)"  val="5" class="">Положительное</li>'));


	if(intval($_GET['alkogol']) == 0){
	$tpl->set('{alkogol_name}',	'Отношение к алкоголю');
	$tpl->set('{alkogol_id}',	'0');
	}
	if(intval($_GET['alkogol']) == 1){
	$tpl->set('{alkogol_name}',	'Резко негативное');
	$tpl->set('{alkogol_id}',	'1');
	}
	if(intval($_GET['alkogol']) == 2){
	$tpl->set('{alkogol_name}',	'Негативное');
	$tpl->set('{alkogol_id}',	'2');
	}
	if(intval($_GET['alkogol']) == 3){
	$tpl->set('{alkogol_name}',	'Компромиссное');
	$tpl->set('{alkogol_id}',	'3');
	}
	if(intval($_GET['alkogol']) == 4){
	$tpl->set('{alkogol_name}',	'Нейтральное');
	$tpl->set('{alkogol_id}',	'4');
	}
	if(intval($_GET['alkogol']) == 5){
	$tpl->set('{alkogol_name}',	'Положительное');
	$tpl->set('{alkogol_id}',	'5');
	}

	
	$tpl->set('{alkogol}', InstallationSelectedNew(intval($_GET['alkogol']),'<li onmousemove="Select.itemMouseMove(11, 0)"  val="0" class="">- Не выбрано -</li><li onmousemove="Select.itemMouseMove(11, 1)"  val="1" class="">Резко негативное</li><li onmousemove="Select.itemMouseMove(11, 2)"  val="2" class="">Негативное</li><li onmousemove="Select.itemMouseMove(11, 3)"  val="3" class="">Компромиссное</li><li onmousemove="Select.itemMouseMove(11, 4)"  val="4" class="">Нейтральное</li><li onmousemove="Select.itemMouseMove(11, 5)"  val="5" class="">Положительное</li>'));
		
	if($count['cnt']){
		$tpl->set('[yes]', '');
		$tpl->set('[/yes]', '');
		
		if($type == 1) //Если критерий поиск "по людям"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'fave'));
		elseif($type == 2 AND $config['video_mod'] == 'yes') //Если критерий поиск "по видеозаписям"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'videos'));
		elseif($type == 3) //Если критерий поиск "по заметкам"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'notes'));
		elseif($type == 4) //Если критерий поиск "по сообществам"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'se_groups'));
		elseif($type == 5) //Если критерий поиск "по аудиозаписям"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'audio'));
		elseif($type == 6) //Если критерий поиск "по сообществам"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'se_clubs'));
		elseif($type == 7) //Если критерий поиск "по новостям"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'news'));
	} else 
		$tpl->set_block("'\\[yes\\](.*?)\\[/yes\\]'si","");

	if($type == 1){
		$tpl->set('[search-tab]', '');
		$tpl->set('[/search-tab]', '');
	} else
		$tpl->set_block("'\\[search-tab\\](.*?)\\[/search-tab\\]'si","");
		
	if($type == 2){
		$tpl->set('[search-tabv]', '');
		$tpl->set('[/search-tabv]', '');
	} else
		$tpl->set_block("'\\[search-tabv\\](.*?)\\[/search-tabv\\]'si","");
		
	if($type == 5){
		$tpl->set('[search-taba]', '');
		$tpl->set('[/search-taba]', '');
	} else
		$tpl->set_block("'\\[search-taba\\](.*?)\\[/search-taba\\]'si","");
		
	if($type == 4){
		$tpl->set('[search-tabg]', '');
		$tpl->set('[/search-tabg]', '');
	} else
		$tpl->set_block("'\\[search-tabg\](.*?)\\[/search-tabg\\]'si","");
		
	if($type == 6){
		$tpl->set('[search-tabc]', '');
		$tpl->set('[/search-tabc]', '');
	} else
		$tpl->set_block("'\\[search-tabc\\](.*?)\\[/search-tabc\\]'si","");
		
	if($type == 7){
		$tpl->set('[search-tabn]', '');
		$tpl->set('[/search-tabn]', '');
	} else
		$tpl->set_block("'\\[search-tabn\\](.*?)\\[/search-tabn\\]'si","");
		
	//################## Загружаем Страны для Военной службы ##################//
	$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `id` ASC", 1);

					$explode_type_sl = explode('|', $sql_['user_country_city_namesl']);
					
				$cl = intval($_GET['countrysl']);
					
					if($cl == 0){
					$class_on = 'active';
					$name_countrysl = 'Выбор страны';
					$id_countrysl = '0';
					}
					
					$countrysl = InstallationSelectedNew($explode_type_sl[0],'<li onmousemove="Select.itemMouseMove(12, 0)" val="0" class="">- Не выбрано -</li>');
					foreach($sql_country as $sql) {
						if($cl == $sql['id']) {
						$class = 'active';
						$name_countrysl = $sql['name'];
						$id_countrysl = $sql['id'];
						}
						$countrysl .= InstallationSelectedNew($explode_type_sl[0],'<li onmousemove="Select.itemMouseMove(12, '.$sql['id'].')" val="'.$sql['id'].'" class="">'.$sql['name'].'</li>');
					
					}
					
					$tpl->set('{country_army}', $countrysl);
					$tpl->set('{country_army_id}', $id_countrysl);
					$tpl->set('{country_army_name}', $name_countrysl);
	
	//################## Загружаем Страны ##################//
	$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `id` ASC", 1);

					$explode_type = explode('|', $sql_['user_country_city_name']);
					
				$c = intval($_GET['country']);
					
					if($c == 0){
					$class_on = 'active';
					$name_country = 'Выбор страны';
					$id_country = '0';
					}
					
					$country1 = InstallationSelectedNew($explode_type[0],'<li onmousemove="Select.itemMouseMove(1, 0)" val="0" class="">- Не выбрано -</li>');
					foreach($sql_country as $sql) {
						if($c == $sql['id']) {
						$class = 'active';
						$name_country = $sql['name'];
						$id_country = $sql['id'];
						}
						$country1 .= InstallationSelectedNew($explode_type[0],'<li onmousemove="Select.itemMouseMove(1, '.$sql['id'].')" val="'.$sql['id'].'" class="">'.$sql['name'].'</li>');
					
					}
					
					$tpl->set('{country}', $country1);
					$tpl->set('{country_id}', $id_country);
					$tpl->set('{country_name}', $name_country);
	
	//################## Загружаем Города ##################//
	if($type == 1){
		
		
		
		$sql_city = $db->super_query("SELECT  id, name FROM `".PREFIX."_city` WHERE id_country = '{$country}' ORDER by `name` ASC", true, "country_city_".$country, true);


					$explode_type = explode('|', $sql_['user_country_city_name']);
					
				$ci = intval($_GET['city']);
					
					if($ci == 0){
					$class_on = 'active';
					$name_city = 'Выбор города';
					$id_city = '0';
					}
					
					$country1 = InstallationSelectedNew($explode_type[1],'<li onmousemove="Select.itemMouseMove(2, 0)" val="0" class="">- Не выбрано -</li>');
					foreach($sql_city as $sql) {
						if($ci == $sql['id']) {
						$class = 'active';
						$name_city = $sql['name'];
						$id_city = $sql['id'];
						}
						$city1 .= InstallationSelectedNew($explode_type[1],'<li onmousemove="Select.itemMouseMove(2, '.$sql['id'].')" val="'.$sql['id'].'" class="">'.$sql['name'].'</li>');
					
					}
					
					$tpl->set('{city}', $city1);
					$tpl->set('{city_id}', $id_city);
					$tpl->set('{city_name}', $name_city);
					
	}
	
	$tpl->compile('info');
	
	//Загружаем шаблон на вывод если он есть одного юзера и выводим
	if($sql_){
	
		//Если критерий поиск "по людям"
		if($type == 1){
			$tpl->load_template('search/result_people.tpl');
			foreach($sql_ as $row){
				$tpl->set('{user-id}', $row['user_id']);
				$tpl->set('{big-ava}', $row['user_photo']);
				$tpl->set('{vuz}', $row['user_vuz']);
				$tpl->set('{name}', $row['user_search_pref']);
				if($row['user_real'] == 1){  
				$tpl->set('{user_real}', '<a href="/verify" class="page_verified"></a>');  
				} else {  
				$tpl->set('{user_real}', '');  
				} 
				$row_view_photos = $db->super_query("SELECT * FROM `".PREFIX."_photos` WHERE user_id = '{$row['user_id']}'");
				$tpl->set('{photoid}', $row_view_photos['id']);
				$tpl->set('{albumid}', $row_view_photos['album_id']);
				if($row['user_photo']) 
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
				else 
					$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
					
				if($row['user_photo'] != ''){
					$tpl->set('[yes_photo]', '');
					$tpl->set('[/yes_photo]', '');
				} else
					$tpl->set_block("'\\[yes_photo\\](.*?)\\[/yes_photo\\]'si","");
				//Возраст юзера
				$user_birthday = explode('-', $row['user_birthday']);
				$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
				
				$user_country_city_name = explode('|', $row['user_country_city_name']);
				$tpl->set('{country}', $user_country_city_name[0]);
				if($user_country_city_name[1])
					$tpl->set('{city}', ', '.$user_country_city_name[1]);
				else
					$tpl->set('{city}', '');
					
				if($row['user_id'] != $user_id){
					$tpl->set('[owner]', '');
					$tpl->set('[/owner]', '');
				} else
					$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
				
				if($row['user_last_visit'] >= $online_time)
					$tpl->set('{online}', $lang['online']);
				else
					$tpl->set('{online}', '');
				
				//Проверка естьли запрашиваемый юзер в друзьях у юзера который смотрит стр
				$check_friend = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$user_info['user_id']}' AND friend_id = '{$row['user_id']}'");
				if($check_friend)
					$tpl->set_block("'\\[no-friends\\](.*?)\\[/no-friends\\]'si","");
				else {
					$tpl->set('[no-friends]', '');
					$tpl->set('[/no-friends]', '');
				}
				$tpl->compile('content');
			}

		//Если критерий поиск "по видеозаписям"
		} elseif($type == 2){
			$tpl->load_template('search/result_video.tpl');
			foreach($sql_ as $row){
				$tpl->set('{photo}', $row['photo']);
				$tpl->set('{title}', stripslashes($row['title']));
				$tpl->set('{user-id}', $row['owner_user_id']);
				$tpl->set('{id}', $row['id']);
				$tpl->set('{close-link}', '/index.php?'.$query_string.'&page='.$page);
				$tpl->set('{comm}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
				megaDate(strtotime($row['add_date']), 1, 1);
				$tpl->compile('content');
			}
			
		//Если критерий поиск "по заметкам"
		} elseif($type == 3){
			$tpl->load_template('search/result_note.tpl');
			foreach($sql_ as $row){
				if($row['user_photo'])
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['owner_user_id'].'/50_'.$row['user_photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
				
				$tpl->set('{user-id}', $row['owner_user_id']);
				$tpl->set('{short-text}', stripslashes(strip_tags(substr($row['full_text'], 0, 200))).'...');
				$tpl->set('{title}', stripslashes($row['title']));
				$tpl->set('{name}', $row['user_search_pref']);
				$tpl->set('{note-id}', $row['id']);
				megaDate(strtotime($row['date']), 1, 1);
				if($row['comm_num'])
					$tpl->set('{comm-num}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
				else
					$tpl->set('{comm-num}', $lang['note_no_comments']);
				$tpl->compile('content');
			}

		//Если критерий поиск "по сообещствам"
		} elseif($type == 4){
			$tpl->load_template('search/result_groups.tpl');
			foreach($sql_ as $row){
				if($row['photo'])
					$tpl->set('{ava}', '/uploads/groups/'.$row['id'].'/100_'.$row['photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_groups_100.gif');
					
			if($row['com_real'] == 1){  
			$tpl->set('{com_real}', '<a href="/verify" class="page_verified" title="Подтвержденное сообщество"></a>');  
			} else {  
			$tpl->set('{com_real}', '');  
			} 
				
				$tpl->set('{public-id}', $row['id']);
				$tpl->set('{gtype}', $row['gtype']);
				$tpl->set('{name}', stripslashes($row['title']));
				$tpl->set('{note-id}', $row['id']);
				$tpl->set('{traf}', $row['traf'].' '.gram_record($row['traf'], 'groups_users'));
				if($row['adres']) $tpl->set('{adres}', $row['adres']);
				else $tpl->set('{adres}', 'public'.$row['id']);
				$tpl->compile('content');
			}
			
		} elseif($type == 6){
			$tpl->load_template('search/result_clubs.tpl');
			foreach($sql_ as $row){
				if($row['photo'])
					$tpl->set('{ava}', '/uploads/clubs/'.$row['id'].'/100_'.$row['photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_groups_100.gif');
				
				$rowd = xfieldsdataload($row['privacy']);
				$tpl->set('{gtype2}', $rowd['val_intog']);
				$tpl->set('{gtype}', strtr($rowd['val_intog'], array('1' => 'Открытая группа', '2' => 'Закрытая группа')));
				$tpl->set('{public-id}', $row['id']);				
				$tpl->set('{name}', stripslashes($row['title']));
				$tpl->set('{note-id}', $row['id']);
				$tpl->set('{traf}', $row['traf'].' '.gram_record($row['traf'], 'groups_users'));
				if($row['adres']) $tpl->set('{adres}', $row['adres']);
				else $tpl->set('{adres}', 'club'.$row['id']);
				$tpl->compile('content');
			}
			
		//Если критерий поиск "по новостям"
		} elseif($type == 7){
			$tpl->load_template('search/result_news.tpl');
			foreach($sql_ as $row){
				
					if($row['action_type'] != 11){
						$rowInfoUser = $db->super_query("SELECT user_search_pref, user_last_visit, user_photo, user_sex, user_privacy FROM `".PREFIX."_users` WHERE user_id = '{$row['ac_user_id']}'");
						$row['user_search_pref'] = $rowInfoUser['user_search_pref'];
						$row['user_last_visit'] = $rowInfoUser['user_last_visit'];
						$row['user_photo'] = $rowInfoUser['user_photo'];
						$row['user_sex'] = $rowInfoUser['user_sex'];
						$row['user_privacy'] = $rowInfoUser['user_privacy'];
						$tpl->set('{link}', 'id');
					} else {
						$rowInfoUser = $db->super_query("SELECT title, photo, comments FROM `".PREFIX."_communities` WHERE id = '{$row['ac_user_id']}'");
						$row['user_search_pref'] = $rowInfoUser['title'];
						$tpl->set('{link}', 'public');
					}				
					
					//Выводим данные о том кто инсцинировал действие
					if($row['user_sex'] == 2){
						$sex_text = 'добавила';
						$sex_text_2 = 'ответила';
						$sex_text_3 = 'оценила';
						$sex_text_4 = 'прокомментировала';
					} else {
						$sex_text = 'добавил';
						$sex_text_2 = 'ответил';
						$sex_text_3 = 'оценил';
						$sex_text_4 = 'прокомментировал';
					}
					
					$tpl->set('{author}', $row['user_search_pref']);
					$tpl->set('{author-id}', $row['ac_user_id']);
					OnlineTpl($row['user_last_visit']);

					if($row['action_type'] != 11)
						if($row['user_photo'])
							$tpl->set('{ava}', '/uploads/users/'.$row['ac_user_id'].'/50_'.$row['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
					else
						if($rowInfoUser['photo'])
							$tpl->set('{ava}', '/uploads/groups/'.$row['ac_user_id'].'/50_'.$rowInfoUser['photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');

					//Выводим данные о действии
					megaDate($row['action_time'], 1, 1);
					$tpl->set('{comment}', stripslashes($row['action_text']));
					$tpl->set('{news-id}', $row['ac_id']);

					$tpl->set('{action-type-updates}', '');
					$tpl->set('{action-type}', '');
					
					$expFriensList = explode('||', $row['action_text']);
					$action_cnt = 0;
					
					//Если видео
					if($row['action_type'] == 2){
						if($expFriensList){
							foreach($expFriensList as $ac_id){
								$row_action = explode('|', $ac_id);
								if(file_exists(ROOT_DIR.$row_action[1])){
									$comment .= "<a href=\"/video{$row['ac_user_id']}_{$row_action[0]}_sec=news\" onClick=\"videos.show({$row_action[0]}, this.href, '/news/videos'); return false\"><img src=\"{$row_action[1]}\" style=\"margin-right:5px\" /></a>";
									$action_cnt++;
								}
							}
							$tpl->set('{action-type}', $action_cnt.' '.gram_record($action_cnt, 'videos').', ');
							$tpl->set('{comment}', $comment);
							$comment = '';
						}
					//Если фотография
					} else if($row['action_type'] == 3){
						if($expFriensList){
							foreach($expFriensList as $ac_id){
								$row_action = explode('|', $ac_id);
								if(file_exists(ROOT_DIR.$row_action[1])){
									$comment .= "<a href=\"/photo{$row['ac_user_id']}_{$row_action[0]}_sec=news\" onClick=\"Photo.Show(this.href); return false\"><img src=\"{$row_action[1]}\" style=\"margin-right:5px\" /></a>";
									$action_cnt++;
								}
							}
							$tpl->set('{action-type}', $action_cnt.' '.gram_record($action_cnt, 'photos').', ');
							$tpl->set('{comment}', $comment);
							$comment = '';
						}
					//Если новый друг(ья)
					} else if($row['action_type'] == 4){
						$newfriends = '';
						if($expFriensList){
							foreach($expFriensList as $fr_id){
								$fr_info = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$fr_id}'");
								if($fr_info){
									if($fr_info['user_photo'])
										$ava = "/uploads/users/{$fr_id}/100_{$fr_info['user_photo']}";
									else
										$ava = '{theme}/images/100_no_ava.png';
										
									$newfriends .= "<div class=\"newsnewfriend\"><a href=\"/id{$fr_id}\" onClick=\"Page.Go(this.href); return false\"><img src=\"{$ava}\" alt=\"\" />{$fr_info['user_search_pref']}</a></div>";
									
									$action_cnt++;
								}
							}
							$newfriends .= '<div class="clear"></div>';
							
							$tpl->set('{action-type-updates}', $sex_text.' в друзья '.$action_cnt.' '.gram_record($action_cnt, 'updates').'.');
							$tpl->set('{action-type}', '');
							$tpl->set('{comment}', $newfriends);
						}
					}
					//Если новая заметка(и)
					else if($row['action_type'] == 5){
						if($expFriensList){
							foreach($expFriensList as $nt_id){
								$note_info = $db->super_query("SELECT title FROM `".PREFIX."_notes` WHERE id = '{$nt_id}'");
								if($note_info){
									$newnotes .= '<a href="/notes/view/'.$nt_id.'" onClick="Page.Go(this.href); return false" class="news_ic_note">'.stripslashes($note_info['title']).'</a>';

									$action_cnt++;
								}
							}
							
							$type_updates = $action_cnt == 1 ? $type_updates = 'новую заметку' : $action_cnt.' '.gram_record($action_cnt, 'notes');

							$tpl->set('{action-type-updates}', $sex_text.' '.$type_updates.'.');
							$tpl->set('{action-type}', '');
							$tpl->set('{comment}', $newnotes);
							$newnotes = '';
						}
					}
					
					//Если страница ответов "стена"
					else if($row['action_type'] == 6){
						
						//Выводим текст на который ответил юзер
						$row_info = $db->super_query("SELECT id, author_user_id, for_user_id, text, add_date, tell_uid, tell_date, type, public, attach, tell_comm FROM `".PREFIX."_wall` WHERE id = '{$row['obj_id']}'");
						if($row_info){
							$str_text = strip_tags(substr($row_info['text'], 0, 70));

							//Прикрипленные файлы
							if($row_info['attach']){
								$attach_arr = explode('||', $row_info['attach']);
								$cnt_attach = 1;
								$cnt_attach_link = 1;
								$jid = 0;
								$attach_result = '';
								foreach($attach_arr as $attach_file){
									$attach_type = explode('|', $attach_file);
									
									//Фото со стены сообщества
									if($attach_type[0] == 'photo' AND file_exists(ROOT_DIR."/uploads/groups/{$row_info['tell_uid']}/photos/c_{$attach_type[1]}")){
										if($cnt_attach < 2)
											$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row_info['id']}\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '{$row_info['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\"><img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/groups/{$row_info['tell_uid']}/photos/{$attach_type[1]}\" align=\"left\" /></div>";
										else
											$attach_result .= "<img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/groups/{$row_info['tell_uid']}/photos/c_{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '{$row_info['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row_info['id']}\" />";
										
										$cnt_attach++;
										
										$resLinkTitle = '';
									//Фото со стены юзера
									} elseif($attach_type[0] == 'photo_u'){
										if($row_info['tell_uid']) $attauthor_user_id = $row_info['tell_uid'];
										else $attauthor_user_id = $row_info['author_user_id'];

										if($attach_type[1] == 'attach' AND file_exists(ROOT_DIR."/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}")){
											if($cnt_attach < 2)
												$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row_info['id']}\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '{$attauthor_user_id}', '{$attach_type[1]}', '{$cnt_attach}', 'photo_u')\"><img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/{$attach_type[2]}\" align=\"left\" /></div>";
											else
												$attach_result .= "<img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row_info['id']}\" />";
												
											$cnt_attach++;
										} elseif(file_exists(ROOT_DIR."/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}")){
											if($cnt_attach < 2)
												$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row_info['id']}\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '{$attauthor_user_id}', '{$attach_type[1]}', '{$cnt_attach}', 'photo_u')\"><img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/{$attach_type[1]}\" align=\"left\" /></div>";
											else
												$attach_result .= "<img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '{$row_info['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row_info['id']}\" />";
												
											$cnt_attach++;
										}
										
										$resLinkTitle = '';
									//Видео
									} elseif($attach_type[0] == 'video' AND file_exists(ROOT_DIR."/uploads/videos/{$attach_type[3]}/{$attach_type[1]}")){
										$attach_result .= "<div><a href=\"/video{$attach_type[3]}_{$attach_type[2]}\" onClick=\"videos.show({$attach_type[2]}, this.href, location.href); return false\"><img src=\"/uploads/videos/{$attach_type[3]}/{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" /></a></div>";
										
										$resLinkTitle = '';
									//Музыка
									} elseif($attach_type[0] == 'audio'){
										$audioId = intval($attach_type[1]);
										$audioInfo = $db->super_query("SELECT artist, name, url FROM `".PREFIX."_audio` WHERE aid = '".$audioId."'");
										if($audioInfo){
											if($_GET['uid']) $appClassWidth = 'player_mini_mbar_wall_all';
											$jid++;
											$attach_result .= '<div class="audio_onetrack audio_wall_onemus"><div class="audio_playic cursor_pointer fl_l" onClick="music.newStartPlay(\''.$jid.'\', '.$row_info['id'].')" id="icPlay_'.$row_info['id'].$jid.'"></div><div id="music_'.$row_info['id'].$jid.'" data="'.$audioInfo['url'].'" class="fl_l" style="margin-top:-1px"><a href="/?go=search&type=5&query='.$audioInfo['artist'].'&n=1" onClick="Page.Go(this.href); return false"><b>'.stripslashes($audioInfo['artist']).'</b></a> &ndash; '.stripslashes($audioInfo['name']).'</div><div id="play_time'.$row_info['id'].$jid.'" class="color777 fl_r no_display" style="margin-top:2px;margin-right:5px">00:00</div><div class="player_mini_mbar fl_l no_display player_mini_mbar_wall '.$appClassWidth.'" id="ppbarPro'.$row_info['id'].$jid.'"></div></div>';
										}
										
										$resLinkTitle = '';
									//Смайлик
									} elseif($attach_type[0] == 'smile' AND file_exists(ROOT_DIR."/uploads/smiles/{$attach_type[1]}")){
										$attach_result .= '<img src=\"/uploads/smiles/'.$attach_type[1].'\" style="margin-right:5px" />';

										$resLinkTitle = '';
										
									//Если ссылка
									} elseif($attach_type[0] == 'link' AND preg_match('/http:\/\/(.*?)+$/i', $attach_type[1]) AND $cnt_attach_link == 1){
										$count_num = count($attach_type);
										$domain_url_name = explode('/', $attach_type[1]);
										$rdomain_url_name = str_replace('http://', '', $domain_url_name[2]);
										
										$attach_type[3] = stripslashes($attach_type[3]);
										$attach_type[3] = substr($attach_type[3], 0, 200);
											
										$attach_type[2] = stripslashes($attach_type[2]);
										$str_title = substr($attach_type[2], 0, 55);
										
										if(stripos($attach_type[4], '/uploads/attach/') === false){
											$attach_type[4] = '{theme}/images/no_ava_groups_100.gif';
											$no_img = false;
										} else
											$no_img = true;
										
										if(!$attach_type[3]) $attach_type[3] = '';
											
										if($no_img AND $attach_type[2]){
											if($row_info['tell_comm']) $no_border_link = 'border:0px';
											
											$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div><div class="clear"></div><div class="wall_show_block_link" style="'.$no_border_link.'"><a href="/away.php?url='.$attach_type[1].'" target="_blank"><div style="width:108px;height:80px;float:left;text-align:center"><img src="'.$attach_type[4].'" /></div></a><div class="attatch_link_title"><a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$str_title.'</a></div><div style="max-height:50px;overflow:hidden">'.$attach_type[3].'</div></div></div>';

											$resLinkTitle = $attach_type[2];
											$resLinkUrl = $attach_type[1];
										} else if($attach_type[1] AND $attach_type[2]){
											$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div></div><div class="clear"></div>';
											
											$resLinkTitle = $attach_type[2];
											$resLinkUrl = $attach_type[1];
										}
										
										$cnt_attach_link++;
										
									//Если документ
									} elseif($attach_type[0] == 'doc'){
									
										$doc_id = intval($attach_type[1]);
										
										$row_doc = $db->super_query("SELECT dname, dsize FROM `".PREFIX."_doc` WHERE did = '{$doc_id}'");
										
										if($row_doc){
											
											$attach_result .= '<div style="margin-top:5px;margin-bottom:5px" class="clear"><div class="doc_attach_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Файл <a href="/index.php?go=doc&act=download&did='.$doc_id.'" target="_blank" onMouseOver="myhtml.title(\''.$doc_id.$cnt_attach.$row_info['id'].'\', \'<b>Размер файла: '.$row_doc['dsize'].'</b>\', \'doc_\')" id="doc_'.$doc_id.$cnt_attach.$row_info['id'].'">'.$row_doc['dname'].'</a></div></div></div><div class="clear"></div>';
												
											$cnt_attach++;
										}
										
									//Если опрос
									} elseif($attach_type[0] == 'vote'){
									
										$vote_id = intval($attach_type[1]);
										
										$row_vote = $db->super_query("SELECT title, answers, answer_num FROM `".PREFIX."_votes` WHERE id = '{$vote_id}'", false, "votes/vote_{$vote_id}");
										
										if($vote_id){

											$checkMyVote = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE user_id = '{$user_id}' AND vote_id = '{$vote_id}'", false, "votes/check{$user_id}_{$vote_id}");
											
											$row_vote['title'] = stripslashes($row_vote['title']);
											
											if(!$row_info['text'])
												$row_info['text'] = $row_vote['title'];

											$arr_answe_list = explode('|', stripslashes($row_vote['answers']));
											$max = $row_vote['answer_num'];
											
											$sql_answer = $db->super_query("SELECT answer, COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE vote_id = '{$vote_id}' GROUP BY answer", 1, "votes/vote_answer_cnt_{$vote_id}");
											$answer = array();
											foreach($sql_answer as $row_answer){
											
												$answer[$row_answer['answer']]['cnt'] = $row_answer['cnt'];
												
											}
											
											$attach_result .= "<div class=\"clear\" style=\"height:10px\"></div><div id=\"result_vote_block{$vote_id}\"><div class=\"wall_vote_title\">{$row_vote['title']}</div>";
											
											for($ai = 0; $ai < sizeof($arr_answe_list); $ai++){

												if(!$checkMyVote['cnt']){
												
													$attach_result .= "<div class=\"wall_vote_oneanswe\" onClick=\"Votes.Send({$ai}, {$vote_id})\" id=\"wall_vote_oneanswe{$ai}\"><input type=\"radio\" name=\"answer\" /><span id=\"answer_load{$ai}\">{$arr_answe_list[$ai]}</span></div>";
												
												} else {

													$num = $answer[$ai]['cnt'];

													if(!$num ) $num = 0;
													if($max != 0) $proc = (100 * $num) / $max;
													else $proc = 0;
													$proc = round($proc, 2);
													
													$attach_result .= "<div class=\"wall_vote_oneanswe cursor_default\">
													{$arr_answe_list[$ai]}<br />
													<div class=\"wall_vote_proc fl_l\"><div class=\"wall_vote_proc_bg\" style=\"width:".intval($proc)."%\"></div><div style=\"margin-top:-16px\">{$num}</div></div>
													<div class=\"fl_l\" style=\"margin-top:-1px\"><b>{$proc}%</b></div>
													</div><div class=\"clear\"></div>";
							
												}
											
											}
											
											if($row_vote['answer_num']) $answer_num_text = gram_record($row_vote['answer_num'], 'fave');
											else $answer_num_text = 'человек';
											
											if($row_vote['answer_num'] <= 1) $answer_text2 = 'Проголосовал';
											else $answer_text2 = 'Проголосовало';
												
											$attach_result .= "{$answer_text2} <b>{$row_vote['answer_num']}</b> {$answer_num_text}.<div class=\"clear\" style=\"margin-top:10px\"></div></div>";
											
										}
										
									} else
									
										$attach_result .= '';
										
								}

								if($resLinkTitle AND $row_info['text'] == $resLinkUrl OR !$row_info['text'])
									$row_info['text'] = $resLinkTitle.$attach_result;
								else if($attach_result)
									$row_info['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_info['text']).$attach_result;
								else
									$row_info['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_info['text']);
							} else
								$row_info['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_info['text']);
								
							$resLinkTitle = '';
							
							//Если это запись с "рассказать друзьям"
							if($row_info['tell_uid']){
								if($row_info['public'])
									$rowUserTell = $db->super_query("SELECT title, photo FROM `".PREFIX."_communities` WHERE id = '{$row_info['tell_uid']}'");
								else
									$rowUserTell = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$row_info['tell_uid']}'");

								if(date('Y-m-d', $row_info['tell_date']) == date('Y-m-d', $server_time))
									$dateTell = langdate('сегодня в H:i', $row_info['tell_date']);
								elseif(date('Y-m-d', $row_info['tell_date']) == date('Y-m-d', ($server_time-84600)))
									$dateTell = langdate('вчера в H:i', $row_info['tell_date']);
								else
									$dateTell = langdate('j F Y в H:i', $row_info['tell_date']);
								
								if($row_info['public']){
									$rowUserTell['user_search_pref'] = stripslashes($rowUserTell['title']);
									$tell_link = 'public';
									if($rowUserTell['photo'])
										$avaTell = '/uploads/groups/'.$row_info['tell_uid'].'/50_'.$rowUserTell['photo'];
									else
										$avaTell = '{theme}/images/no_ava_50.png';
								} else {
									$tell_link = 'u';
									if($rowUserTell['user_photo'])
										$avaTell = '/uploads/users/'.$row_info['tell_uid'].'/50_'.$rowUserTell['user_photo'];
									else
										$avaTell = '{theme}/images/no_ava_50.png';
								}

								if($row_info['tell_comm']) $border_tell_class = 'wall_repost_border'; else $border_tell_class = 'wall_repost_border2';

								$row_info['text'] = <<<HTML
{$row_info['tell_comm']}
<div class="{$border_tell_class}" style="margin-top:-5px">
<div class="wall_tell_info"><div class="wall_tell_ava"><a href="/{$tell_link}{$row_info['tell_uid']}" onClick="Page.Go(this.href); return false"><img src="{$avaTell}" width="30" /></a></div><div class="wall_tell_name"><a href="/{$tell_link}{$row_info['tell_uid']}" onClick="Page.Go(this.href); return false"><b>{$rowUserTell['user_search_pref']}</b></a></div><div class="wall_tell_date">{$dateTell}</div></div>{$row_info['text']}<div class="clear"></div>
</div>
HTML;
							}
							
							$tpl->set('{wall-text}', stripslashes($row_info['text']));

							if(!$str_text){
								if(date('Y-m-d', $row_info['add_date']) == date('Y-m-d', $server_time))
									$nDate = langdate('сегодня в H:i', $row_info['add_date']);
								elseif(date('Y-m-d', $row_info['add_date']) == date('Y-m-d', ($server_time-84600)))
									$nDate = langdate('вчера в H:i', $row_info['add_date']);
								else
									$nDate = langdate('j F Y в H:i', $row_info['add_date']);
									
								$str_text = 'от '.$nDate;
							}
							
							if(strlen($str_text) == 70)
								$tocheks = '...';
							$tpl->set('{action-type}', $sex_text_2.' на Вашу запись <a href="/wall'.$row_info['for_user_id'].'_'.$row['obj_id'].'" onMouseOver="news.showWallText('.$row['ac_id'].')" onMouseOut="news.hideWallText('.$row['ac_id'].')" onClick="Page.Go(this.href); return false"><span id="2href_text_'.$row['ac_id'].'">'.$str_text.'</span></a>'.$tocheks);
							$tocheks = '';

							$tpl->set('[like]', '');
							$tpl->set('[/like]', '');
							$tpl->set_block("'\\[no-like\\](.*?)\\[/no-like\\]'si","");
							$tpl->set_block("'\\[action\\](.*?)\\[/action\\]'si","");
							$action_cnt = 1;
						}
					}
					
					//Если страница ответов "мне нравится"
					else if($row['action_type'] == 7){
						
						//Выводим текст на который ответил юзер
						$row_info = $db->super_query("SELECT id, author_user_id, for_user_id, text, add_date, tell_uid, tell_date, type, public, attach, tell_comm FROM `".PREFIX."_wall` WHERE id = '{$row['obj_id']}'");
						if($row_info){
							$str_text = strip_tags(substr($row_info['text'], 0, 70));

							//Прикрипленные файлы
							if($row_info['attach']){
								$attach_arr = explode('||', $row_info['attach']);
								$cnt_attach = 1;
								$cnt_attach_link = 1;
								$jid = 0;
								$attach_result = '';
								foreach($attach_arr as $attach_file){
									$attach_type = explode('|', $attach_file);
									
									//Фото со стены сообщества
									if($attach_type[0] == 'photo' AND file_exists(ROOT_DIR."/uploads/groups/{$row_info['tell_uid']}/photos/c_{$attach_type[1]}")){
										if($cnt_attach < 2)
											$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row_info['id']}\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '{$row_info['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\"><img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/groups/{$row_info['tell_uid']}/photos/{$attach_type[1]}\" align=\"left\" /></div>";
										else
											$attach_result .= "<img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/groups/{$row_info['tell_uid']}/photos/c_{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '{$row_info['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row_info['id']}\" />";
										
										$cnt_attach++;
										
										$resLinkTitle = '';
									//Фото со стены юзера
									} elseif($attach_type[0] == 'photo_u'){
										if($row_info['tell_uid']) $attauthor_user_id = $row_info['tell_uid'];
										else $attauthor_user_id = $row_info['author_user_id'];

										if($attach_type[1] == 'attach' AND file_exists(ROOT_DIR."/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}")){
											if($cnt_attach < 2)
												$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row_info['id']}\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '{$attauthor_user_id}', '{$attach_type[1]}', '{$cnt_attach}', 'photo_u')\"><img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/{$attach_type[2]}\" align=\"left\" /></div>";
											else
												$attach_result .= "<img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row_info['id']}\" />";
												
											$cnt_attach++;
										} elseif(file_exists(ROOT_DIR."/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}")){
											if($cnt_attach < 2)
												$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row_info['id']}\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '{$attauthor_user_id}', '{$attach_type[1]}', '{$cnt_attach}', 'photo_u')\"><img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/{$attach_type[1]}\" align=\"left\" /></div>";
											else
												$attach_result .= "<img id=\"photo_wall_{$row_info['id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row_info['id']}', '{$row_info['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row_info['id']}\" />";
												
											$cnt_attach++;
										}
										
										$resLinkTitle = '';
									//Видео
									} elseif($attach_type[0] == 'video' AND file_exists(ROOT_DIR."/uploads/videos/{$attach_type[3]}/{$attach_type[1]}")){
										$attach_result .= "<div><a href=\"/video{$attach_type[3]}_{$attach_type[2]}\" onClick=\"videos.show({$attach_type[2]}, this.href, location.href); return false\"><img src=\"/uploads/videos/{$attach_type[3]}/{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" /></a></div>";
										
										$resLinkTitle = '';
									//Музыка
									} elseif($attach_type[0] == 'audio'){
										$audioId = intval($attach_type[1]);
										$audioInfo = $db->super_query("SELECT artist, name, url FROM `".PREFIX."_audio` WHERE aid = '".$audioId."'");
										if($audioInfo){
											if($_GET['uid']) $appClassWidth = 'player_mini_mbar_wall_all';
											$jid++;
											$attach_result .= '<div class="audio_onetrack audio_wall_onemus"><div class="audio_playic cursor_pointer fl_l" onClick="music.newStartPlay(\''.$jid.'\', '.$row_info['id'].')" id="icPlay_'.$row_info['id'].$jid.'"></div><div id="music_'.$row_info['id'].$jid.'" data="'.$audioInfo['url'].'" class="fl_l" style="margin-top:-1px"><a href="/?go=search&type=5&query='.$audioInfo['artist'].'&n=1" onClick="Page.Go(this.href); return false"><b>'.stripslashes($audioInfo['artist']).'</b></a> &ndash; '.stripslashes($audioInfo['name']).'</div><div id="play_time'.$row_info['id'].$jid.'" class="color777 fl_r no_display" style="margin-top:2px;margin-right:5px">00:00</div><div class="player_mini_mbar fl_l no_display player_mini_mbar_wall '.$appClassWidth.'" id="ppbarPro'.$row_info['id'].$jid.'"></div></div>';
										}
										
										$resLinkTitle = '';
									//Смайлик
									} elseif($attach_type[0] == 'smile' AND file_exists(ROOT_DIR."/uploads/smiles/{$attach_type[1]}")){
										$attach_result .= '<img src=\"/uploads/smiles/'.$attach_type[1].'\" style="margin-right:5px" />';

										$resLinkTitle = '';
										
									//Если ссылка
									} elseif($attach_type[0] == 'link' AND preg_match('/http:\/\/(.*?)+$/i', $attach_type[1]) AND $cnt_attach_link == 1){
										$count_num = count($attach_type);
										$domain_url_name = explode('/', $attach_type[1]);
										$rdomain_url_name = str_replace('http://', '', $domain_url_name[2]);
										
										$attach_type[3] = stripslashes($attach_type[3]);
										$attach_type[3] = substr($attach_type[3], 0, 200);
											
										$attach_type[2] = stripslashes($attach_type[2]);
										$str_title = substr($attach_type[2], 0, 55);
										
										if(stripos($attach_type[4], '/uploads/attach/') === false){
											$attach_type[4] = '{theme}/images/no_ava_groups_100.gif';
											$no_img = false;
										} else
											$no_img = true;
										
										if(!$attach_type[3]) $attach_type[3] = '';
											
										if($no_img AND $attach_type[2]){
											if($row_info['tell_comm']) $no_border_link = 'border:0px';
											
											$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div><div class="clear"></div><div class="wall_show_block_link" style="'.$no_border_link.'"><a href="/away.php?url='.$attach_type[1].'" target="_blank"><div style="width:108px;height:80px;float:left;text-align:center"><img src="'.$attach_type[4].'" /></div></a><div class="attatch_link_title"><a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$str_title.'</a></div><div style="max-height:50px;overflow:hidden">'.$attach_type[3].'</div></div></div>';

											$resLinkTitle = $attach_type[2];
											$resLinkUrl = $attach_type[1];
										} else if($attach_type[1] AND $attach_type[2]){
											$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div></div><div class="clear"></div>';
											
											$resLinkTitle = $attach_type[2];
											$resLinkUrl = $attach_type[1];
										}
										
										$cnt_attach_link++;
										
									//Если документ
									} elseif($attach_type[0] == 'doc'){
									
										$doc_id = intval($attach_type[1]);
										
										$row_doc = $db->super_query("SELECT dname, dsize FROM `".PREFIX."_doc` WHERE did = '{$doc_id}'");
										
										if($row_doc){
											
											$attach_result .= '<div style="margin-top:5px;margin-bottom:5px" class="clear"><div class="doc_attach_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Файл <a href="/index.php?go=doc&act=download&did='.$doc_id.'" target="_blank" onMouseOver="myhtml.title(\''.$doc_id.$cnt_attach.$row_info['id'].'\', \'<b>Размер файла: '.$row_doc['dsize'].'</b>\', \'doc_\')" id="doc_'.$doc_id.$cnt_attach.$row_info['id'].'">'.$row_doc['dname'].'</a></div></div></div><div class="clear"></div>';
												
											$cnt_attach++;
										}
										
									//Если опрос
									} elseif($attach_type[0] == 'vote'){
									
										$vote_id = intval($attach_type[1]);
										
										$row_vote = $db->super_query("SELECT title, answers, answer_num FROM `".PREFIX."_votes` WHERE id = '{$vote_id}'", false, "votes/vote_{$vote_id}");
										
										if($vote_id){

											$checkMyVote = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE user_id = '{$user_id}' AND vote_id = '{$vote_id}'", false, "votes/check{$user_id}_{$vote_id}");
											
											$row_vote['title'] = stripslashes($row_vote['title']);
											
											if(!$row_info['text'])
												$row_info['text'] = $row_vote['title'];

											$arr_answe_list = explode('|', stripslashes($row_vote['answers']));
											$max = $row_vote['answer_num'];
											
											$sql_answer = $db->super_query("SELECT answer, COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE vote_id = '{$vote_id}' GROUP BY answer", 1, "votes/vote_answer_cnt_{$vote_id}");
											$answer = array();
											foreach($sql_answer as $row_answer){
											
												$answer[$row_answer['answer']]['cnt'] = $row_answer['cnt'];
												
											}
											
											$attach_result .= "<div class=\"clear\" style=\"height:10px\"></div><div id=\"result_vote_block{$vote_id}\"><div class=\"wall_vote_title\">{$row_vote['title']}</div>";
											
											for($ai = 0; $ai < sizeof($arr_answe_list); $ai++){

												if(!$checkMyVote['cnt']){
												
													$attach_result .= "<div class=\"wall_vote_oneanswe\" onClick=\"Votes.Send({$ai}, {$vote_id})\" id=\"wall_vote_oneanswe{$ai}\"><input type=\"radio\" name=\"answer\" /><span id=\"answer_load{$ai}\">{$arr_answe_list[$ai]}</span></div>";
												
												} else {

													$num = $answer[$ai]['cnt'];

													if(!$num ) $num = 0;
													if($max != 0) $proc = (100 * $num) / $max;
													else $proc = 0;
													$proc = round($proc, 2);
													
													$attach_result .= "<div class=\"wall_vote_oneanswe cursor_default\">
													{$arr_answe_list[$ai]}<br />
													<div class=\"wall_vote_proc fl_l\"><div class=\"wall_vote_proc_bg\" style=\"width:".intval($proc)."%\"></div><div style=\"margin-top:-16px\">{$num}</div></div>
													<div class=\"fl_l\" style=\"margin-top:-1px\"><b>{$proc}%</b></div>
													</div><div class=\"clear\"></div>";
							
												}
											
											}
											
											if($row_vote['answer_num']) $answer_num_text = gram_record($row_vote['answer_num'], 'fave');
											else $answer_num_text = 'человек';
											
											if($row_vote['answer_num'] <= 1) $answer_text2 = 'Проголосовал';
											else $answer_text2 = 'Проголосовало';
												
											$attach_result .= "{$answer_text2} <b>{$row_vote['answer_num']}</b> {$answer_num_text}.<div class=\"clear\" style=\"margin-top:10px\"></div></div>";
											
										}
										
									} else
									
										$attach_result .= '';
										
								}

								if($resLinkTitle AND $row_info['text'] == $resLinkUrl OR !$row_info['text'])
									$row_info['text'] = $resLinkTitle.$attach_result;
								else if($attach_result)
									$row_info['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_info['text']).$attach_result;
								else
									$row_info['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_info['text']);
							} else
								$row_info['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_info['text']);
								
							$resLinkTitle = '';
							
							//Если это запись с "рассказать друзьям"
							if($row_info['tell_uid']){
								if($row_info['public'])
									$rowUserTell = $db->super_query("SELECT title, photo FROM `".PREFIX."_communities` WHERE id = '{$row_info['tell_uid']}'");
								else
									$rowUserTell = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$row_info['tell_uid']}'");

								if(date('Y-m-d', $row_info['tell_date']) == date('Y-m-d', $server_time))
									$dateTell = langdate('сегодня в H:i', $row_info['tell_date']);
								elseif(date('Y-m-d', $row_info['tell_date']) == date('Y-m-d', ($server_time-84600)))
									$dateTell = langdate('вчера в H:i', $row_info['tell_date']);
								else
									$dateTell = langdate('j F Y в H:i', $row_info['tell_date']);
								
								if($row_info['public']){
									$rowUserTell['user_search_pref'] = stripslashes($rowUserTell['title']);
									$tell_link = 'public';
									if($rowUserTell['photo'])
										$avaTell = '/uploads/groups/'.$row_info['tell_uid'].'/50_'.$rowUserTell['photo'];
									else
										$avaTell = '{theme}/images/no_ava_50.png';
								} else {
									$tell_link = 'u';
									if($rowUserTell['user_photo'])
										$avaTell = '/uploads/users/'.$row_info['tell_uid'].'/50_'.$rowUserTell['user_photo'];
									else
										$avaTell = '{theme}/images/no_ava_50.png';
								}

								if($row_info['tell_comm']) $border_tell_class = 'wall_repost_border'; else $border_tell_class = 'wall_repost_border2';

								$row_info['text'] = <<<HTML
{$row_info['tell_comm']}
<div class="{$border_tell_class}" style="margin-top:-5px">
<div class="wall_tell_info"><div class="wall_tell_ava"><a href="/{$tell_link}{$row_info['tell_uid']}" onClick="Page.Go(this.href); return false"><img src="{$avaTell}" width="30" /></a></div><div class="wall_tell_name"><a href="/{$tell_link}{$row_info['tell_uid']}" onClick="Page.Go(this.href); return false"><b>{$rowUserTell['user_search_pref']}</b></a></div><div class="wall_tell_date">{$dateTell}</div></div>{$row_info['text']}<div class="clear"></div>
</div>
HTML;
							}
							
							$tpl->set('{wall-text}', stripslashes($row_info['text']));
							
							if(!$str_text){
								if(date('Y-m-d', $row_info['add_date']) == date('Y-m-d', $server_time))
									$nDate = langdate('сегодня в H:i', $row_info['add_date']);
								elseif(date('Y-m-d', $row_info['add_date']) == date('Y-m-d', ($server_time-84600)))
									$nDate = langdate('вчера в H:i', $row_info['add_date']);
								else
									$nDate = langdate('j F Y в H:i', $row_info['add_date']);
									
								$str_text = 'от '.$nDate;
							}
							
							$likesUseList = explode('|', str_replace('u', '', $row['action_text']));
							$rList = '';
							$uNames = '';
							$cntUse = 0;
							foreach($likesUseList as $likeUser){
								if($likeUser){
									$rowUser = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$likeUser}'");
									if($rowUser['user_photo'])
										$luAva = '/uploads/users/'.$likeUser.'/50_'.$rowUser['user_photo'];
									else
										$luAva = '{theme}/images/no_ava_50.png';
									$rList .= '<a href="/u'.$likeUser.'" onClick="Page.Go(this.href); return false"><img src="'.$luAva.'" width="32" style="margin-right:5px;margin-top:3px" /></a>';
									$uNames .= '<a href="/u'.$likeUser.'" onClick="Page.Go(this.href); return false">'.$rowUser['user_search_pref'].'</a>, ';
									$cntUse++;
								}
							}
							$uNames = substr($uNames, 0, (strlen($uNames)-2));
							$tpl->set('{comment}', $rList);
							$tpl->set('{author}', $uNames);

							if($cntUse == 1) 
								$sex_text = $sex_text_3;
							else 
								$sex_text = '<b>'.$cntUse.'</b> '.gram_record($cntUse, 'fave').' оценили';
								
							if(strlen($str_text) == 70)
								$tocheks = '...';
							$tpl->set('{action-type}', $sex_text.' Вашу запись <a href="/wall'.$row_info['for_user_id'].'_'.$row['obj_id'].'" onMouseOver="news.showWallText('.$row['ac_id'].')" onMouseOut="news.hideWallText('.$row['ac_id'].')" onClick="Page.Go(this.href); return false"><span id="2href_text_'.$row['ac_id'].'">'.$str_text.'</span></a>'.$tocheks);
							$tocheks = '';

							$tpl->set('[no-like]', '');
							$tpl->set('[/no-like]', '');
							$tpl->set_block("'\\[like\\](.*?)\\[/like\\]'si","");
							$tpl->set_block("'\\[action\\](.*?)\\[/action\\]'si","");
							$action_cnt = 1;
						} else
							$db->query("DELETE FROM `".PREFIX."_news` WHERE ac_id = '{$row['ac_id']}'");
					}
					
					//Если страница ответов "комменатрий к фотографии"
					else if($row['action_type'] == 8){
						$photo_info = explode('|', $row['action_text']);
						if(file_exists(ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$photo_info[3].'/c_'.$photo_info[1])){
							$tpl->set('{comment}', stripslashes($photo_info[0])); 
							$tpl->set('{action-type}', $sex_text_4.' Вашу <a href="/photo'.$user_id.'_'.$photo_info[2].'_sec=news" onClick="Photo.Show(this.href); return false">фотографию</a>');
							$tpl->set('{act-photo}', '/uploads/users/'.$user_id.'/albums/'.$photo_info[3].'/c_'.$photo_info[1]);
							$tpl->set('{user-id}', $user_id);
							$tpl->set('{ac-id}', $photo_info[2]);
							$tpl->set('{type-name}', 'photo');
							$tpl->set('{function}', 'Photo.Show(this.href)');
							$tpl->set('[like]', '');
							$tpl->set('[/like]', '');
							$tpl->set('[action]', '');
							$tpl->set('[/action]', '');
							$tpl->set_block("'\\[no-like\\](.*?)\\[/no-like\\]'si","");
							$action_cnt = 1;
						} else
							$db->query("DELETE FROM `".PREFIX."_news` WHERE ac_id = '{$row['ac_id']}'");
					}
					
					//Если страница ответов "комменатрий к видеозаписи"
					else if($row['action_type'] == 9){
						$photo_info = explode('|', $row['action_text']);
						if(file_exists(ROOT_DIR.$photo_info[1])){
							$tpl->set('{comment}', stripslashes($photo_info[0])); 
							$tpl->set('{action-type}', $sex_text_4.' Вашу <a href="/video'.$user_id.'_'.$photo_info[2].'_sec=news" onClick="videos.show('.$photo_info[2].', this.href); return false">видеозапись</a>');
							$tpl->set('{act-photo}', $photo_info[1]);
							$tpl->set('{user-id}', $user_id);
							$tpl->set('{ac-id}', $photo_info[2]);
							$tpl->set('{type-name}', 'video');
							$tpl->set('{function}', "videos.show({$photo_info[2]}, this.href, '/news/notifications')");
							$tpl->set('[like]', '');
							$tpl->set('[/like]', '');
							$tpl->set('[action]', '');
							$tpl->set('[/action]', '');
							$tpl->set_block("'\\[no-like\\](.*?)\\[/no-like\\]'si","");
							$action_cnt = 1;
						} else
							$db->query("DELETE FROM `".PREFIX."_news` WHERE ac_id = '{$row['ac_id']}'");
					}
					
					//Если страница ответов "комменатрий к заметке"
					else if($row['action_type'] == 10){
						$note_info = explode('|', $row['action_text']);
						$row_note = $db->super_query("SELECT title FROM `".PREFIX."_notes` WHERE id = '{$note_info[1]}'");
						if($row_note){
							$tpl->set('{comment}', stripslashes($note_info[0])); 
							$tpl->set('{action-type}', $sex_text_4.' Вашу заметку <a href="/notes/view/'.$note_info[1].'" onClick="Page.Go(this.href); return false">'.$row_note['title'].'</a>');
							$tpl->set('[like]', '');
							$tpl->set('[/like]', '');
							$tpl->set_block("'\\[no-like\\](.*?)\\[/no-like\\]'si","");
							$tpl->set_block("'\\[action\\](.*?)\\[/action\\]'si","");
							$action_cnt = 1;
						} else
							$db->query("DELETE FROM `".PREFIX."_news` WHERE ac_id = '{$row['ac_id']}'");
					} else {
						//пустой ответ
						echo '';
					}
					
					$c++;

					//Если запись со стены
					if($row['action_type'] == 1){
						
						//Приватность
						$user_privacy = xfieldsdataload($row['user_privacy']);
						$check_friend = CheckFriends($row['ac_user_id']);
						
						//Выводим кол-во комментов, мне нравится, и список юзеров кто поставил лайки к записи если это не страница "ответов"
						$rec_info = $db->super_query("SELECT fasts_num, likes_num, likes_users, tell_uid, tell_date, type, public, attach, tell_comm FROM `".PREFIX."_wall` WHERE id = '{$row['obj_id']}'");
						
						//КНопка Показать полностью..
						$expBR = explode('<br />', $row['action_text']);
						$textLength = count($expBR);
						$strTXT = strlen($row['action_text']);
						if($textLength > 9 OR $strTXT > 600)
							$row['action_text'] = '<div class="wall_strlen" id="hide_wall_rec'.$row['obj_id'].'">'.$row['action_text'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row['obj_id'].', this.id)" id="hide_wall_rec_lnk'.$row['obj_id'].'">Показать полностью..</div>';
						
						//Прикрипленные файлы
						if($rec_info['attach']){
							$attach_arr = explode('||', $rec_info['attach']);
							$cnt_attach = 1;
							$cnt_attach_link = 1;
							$jid = 0;
							$attach_result = '';
							foreach($attach_arr as $attach_file){
								$attach_type = explode('|', $attach_file);
								
								//Фото со стены сообщества
								if($attach_type[0] == 'photo' AND file_exists(ROOT_DIR."/uploads/groups/{$rec_info['tell_uid']}/photos/c_{$attach_type[1]}")){
									if($cnt_attach < 2)
										$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row['obj_id']}\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$rec_info['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\"><img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/groups/{$rec_info['tell_uid']}/photos/{$attach_type[1]}\" align=\"left\" /></div>";
									else
										$attach_result .= "<img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/groups/{$rec_info['tell_uid']}/photos/c_{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$rec_info['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row['obj_id']}\" />";
									
									$cnt_attach++;
									
									$resLinkTitle = '';
									
								//Фото со стены юзера
								} elseif($attach_type[0] == 'photo_u'){
									if($rec_info['tell_uid']) $attauthor_user_id = $rec_info['tell_uid'];
									else $attauthor_user_id = $row['ac_user_id'];
									if($attach_type[1] == 'attach' AND file_exists(ROOT_DIR."/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}")){
										if($cnt_attach < 2)
											$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row['obj_id']}\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$attauthor_user_id}', '{$attach_type[1]}', '{$cnt_attach}', 'photo_u')\"><img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/{$attach_type[2]}\" align=\"left\" /></div>";
										else
											$attach_result .= "<img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$row_wall['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row['obj_id']}\" />";
											
										$cnt_attach++;
									} elseif(file_exists(ROOT_DIR."/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}")){
										if($cnt_attach < 2)
											$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row['obj_id']}\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$attauthor_user_id}', '{$attach_type[1]}', '{$cnt_attach}', 'photo_u')\"><img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/{$attach_type[1]}\" align=\"left\" /></div>";
										else
											$attach_result .= "<img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$row_wall['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row['obj_id']}\" />";
											
										$cnt_attach++;
									}
									
									$resLinkTitle = '';

								//Видео
								} elseif($attach_type[0] == 'video' AND file_exists(ROOT_DIR."/uploads/videos/{$attach_type[3]}/{$attach_type[1]}")){
									$attach_result .= "<div><a href=\"/video{$attach_type[3]}_{$attach_type[2]}\" onClick=\"videos.show({$attach_type[2]}, this.href, location.href); return false\"><img src=\"/uploads/videos/{$attach_type[3]}/{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" /></a></div>";
									
									$resLinkTitle = '';
								
								//Музыка
								} elseif($attach_type[0] == 'audio'){
									$audioId = intval($attach_type[1]);
									$audioInfo = $db->super_query("SELECT artist, name, url FROM `".PREFIX."_audio` WHERE aid = '".$audioId."'");
									if($audioInfo){
										$jid++;
										$attach_result .= '<div class="audio_onetrack audio_wall_onemus"><div class="audio_playic cursor_pointer fl_l" onClick="music.newStartPlay(\''.$jid.'\', '.$row['obj_id'].')" id="icPlay_'.$row['obj_id'].$jid.'"></div><div id="music_'.$row['obj_id'].$jid.'" data="'.$audioInfo['url'].'" class="fl_l" style="margin-top:-1px"><a href="/?go=search&type=5&query='.$audioInfo['artist'].'&n=1" onClick="Page.Go(this.href); return false"><b>'.stripslashes($audioInfo['artist']).'</b></a> &ndash; '.stripslashes($audioInfo['name']).'</div><div id="play_time'.$row['obj_id'].$jid.'" class="color777 fl_r no_display" style="margin-top:2px;margin-right:5px">00:00</div><div class="player_mini_mbar fl_l no_display player_mini_mbar_wall player_mini_mbar_wall_all" id="ppbarPro'.$row['obj_id'].$jid.'"></div></div>';
									}
									
									$resLinkTitle = '';
									
								//Смайлик
								} elseif($attach_type[0] == 'smile' AND file_exists(ROOT_DIR."/uploads/smiles/{$attach_type[1]}")){
									$attach_result .= '<img src=\"/uploads/smiles/'.$attach_type[1].'\" />';
									
									$resLinkTitle = '';
								//Если ссылка
								} elseif($attach_type[0] == 'link' AND preg_match('/http:\/\/(.*?)+$/i', $attach_type[1]) AND $cnt_attach_link == 1){
									$count_num = count($attach_type);
									$domain_url_name = explode('/', $attach_type[1]);
									$rdomain_url_name = str_replace('http://', '', $domain_url_name[2]);
									
									$attach_type[3] = stripslashes($attach_type[3]);
									$attach_type[3] = substr($attach_type[3], 0, 200);
										
									$attach_type[2] = stripslashes($attach_type[2]);
									$str_title = substr($attach_type[2], 0, 55);
									
									if(stripos($attach_type[4], '/uploads/attach/') === false){
										$attach_type[4] = '{theme}/images/no_ava_groups_100.gif';
										$no_img = false;
									} else
										$no_img = true;
									
									if(!$attach_type[3]) $attach_type[3] = '';
										
									if($no_img AND $attach_type[2]){
										if($rec_info['tell_comm']) $no_border_link = 'border:0px';
										
										$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div><div class="clear"></div><div class="wall_show_block_link" style="'.$no_border_link.'"><a href="/away.php?url='.$attach_type[1].'" target="_blank"><div style="width:108px;height:80px;float:left;text-align:center"><img src="'.$attach_type[4].'" /></div></a><div class="attatch_link_title"><a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$str_title.'</a></div><div style="max-height:50px;overflow:hidden">'.$attach_type[3].'</div></div></div>';

										$resLinkTitle = $attach_type[2];
										$resLinkUrl = $attach_type[1];
									} else if($attach_type[1] AND $attach_type[2]){
										$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div></div><div class="clear"></div>';
										
										$resLinkTitle = $attach_type[2];
										$resLinkUrl = $attach_type[1];
									}
									
									$cnt_attach_link++;
									
								//Если документ
								} elseif($attach_type[0] == 'doc'){
								
									$doc_id = intval($attach_type[1]);
									
									$row_doc = $db->super_query("SELECT dname, dsize FROM `".PREFIX."_doc` WHERE did = '{$doc_id}'");
									
									if($row_doc){
										
										$attach_result .= '<div style="margin-top:5px;margin-bottom:5px" class="clear"><div class="doc_attach_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Файл <a href="/index.php?go=doc&act=download&did='.$doc_id.'" target="_blank" onMouseOver="myhtml.title(\''.$doc_id.$cnt_attach.$row['obj_id'].'\', \'<b>Размер файла: '.$row_doc['dsize'].'</b>\', \'doc_\')" id="doc_'.$doc_id.$cnt_attach.$row['obj_id'].'">'.$row_doc['dname'].'</a></div></div></div><div class="clear"></div>';
											
										$cnt_attach++;
									}
									
									//Если опрос
									} elseif($attach_type[0] == 'vote'){
									
										$vote_id = intval($attach_type[1]);
										
										$row_vote = $db->super_query("SELECT title, answers, answer_num FROM `".PREFIX."_votes` WHERE id = '{$vote_id}'", false, "votes/vote_{$vote_id}");
										
										if($vote_id){

											$checkMyVote = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE user_id = '{$user_id}' AND vote_id = '{$vote_id}'", false, "votes/check{$user_id}_{$vote_id}");
											
											$row_vote['title'] = stripslashes($row_vote['title']);
											
											if(!$row_wall['text'])
												$row_wall['text'] = $row_vote['title'];

											$arr_answe_list = explode('|', stripslashes($row_vote['answers']));
											$max = $row_vote['answer_num'];
											
											$sql_answer = $db->super_query("SELECT answer, COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE vote_id = '{$vote_id}' GROUP BY answer", 1, "votes/vote_answer_cnt_{$vote_id}");
											$answer = array();
											foreach($sql_answer as $row_answer){
											
												$answer[$row_answer['answer']]['cnt'] = $row_answer['cnt'];
												
											}
											
											$attach_result .= "<div class=\"clear\" style=\"height:10px\"></div><div id=\"result_vote_block{$vote_id}\"><div class=\"wall_vote_title\">{$row_vote['title']}</div>";
											
											for($ai = 0; $ai < sizeof($arr_answe_list); $ai++){

												if(!$checkMyVote['cnt']){
												
													$attach_result .= "<div class=\"wall_vote_oneanswe\" onClick=\"Votes.Send({$ai}, {$vote_id})\" id=\"wall_vote_oneanswe{$ai}\"><input type=\"radio\" name=\"answer\" /><span id=\"answer_load{$ai}\">{$arr_answe_list[$ai]}</span></div>";
												
												} else {

													$num = $answer[$ai]['cnt'];

													if(!$num ) $num = 0;
													if($max != 0) $proc = (100 * $num) / $max;
													else $proc = 0;
													$proc = round($proc, 2);
													
													$attach_result .= "<div class=\"wall_vote_oneanswe cursor_default\">
													{$arr_answe_list[$ai]}<br />
													<div class=\"wall_vote_proc fl_l\"><div class=\"wall_vote_proc_bg\" style=\"width:".intval($proc)."%\"></div><div style=\"margin-top:-16px\">{$num}</div></div>
													<div class=\"fl_l\" style=\"margin-top:-1px\"><b>{$proc}%</b></div>
													</div><div class=\"clear\"></div>";
							
												}
											
											}
											
											if($row_vote['answer_num']) $answer_num_text = gram_record($row_vote['answer_num'], 'fave');
											else $answer_num_text = 'человек';
											
											if($row_vote['answer_num'] <= 1) $answer_text2 = 'Проголосовал';
											else $answer_text2 = 'Проголосовало';
												
											$attach_result .= "{$answer_text2} <b>{$row_vote['answer_num']}</b> {$answer_num_text}.<div class=\"clear\" style=\"margin-top:10px\"></div></div>";
											
										}
										
									} else
					
										$attach_result .= '';
									
							}

							if($resLinkTitle AND $row['action_text'] == $resLinkUrl OR !$row['action_text'])
								$row['action_text'] = $resLinkTitle.$attach_result;
							else if($attach_result)
								$row['action_text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row['action_text']).$attach_result;
							else
								$row['action_text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row['action_text']);
						}
						
						$resLinkTitle = '';
						
						//Если это запись с "рассказать друзьям"
						if($rec_info['tell_uid']){
							if($rec_info['public'])
								$rowUserTell = $db->super_query("SELECT title, photo FROM `".PREFIX."_communities` WHERE id = '{$rec_info['tell_uid']}'");
							else
								$rowUserTell = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$rec_info['tell_uid']}'");

							if(date('Y-m-d', $rec_info['tell_date']) == date('Y-m-d', $server_time))
								$dateTell = langdate('сегодня в H:i', $rec_info['tell_date']);
							elseif(date('Y-m-d', $rec_info['tell_date']) == date('Y-m-d', ($server_time-84600)))
								$dateTell = langdate('вчера в H:i', $rec_info['tell_date']);
							else
								$dateTell = langdate('j F Y в H:i', $rec_info['tell_date']);

							if($rec_info['public']){
								$rowUserTell['user_search_pref'] = stripslashes($rowUserTell['title']);
								$tell_link = 'public';
								if($rowUserTell['photo'])
									$avaTell = '/uploads/groups/'.$rec_info['tell_uid'].'/50_'.$rowUserTell['photo'];
								else
									$avaTell = '{theme}/images/no_ava_50.png';
							} else {
								$tell_link = 'u';
								if($rowUserTell['user_photo'])
									$avaTell = '/uploads/users/'.$rec_info['tell_uid'].'/50_'.$rowUserTell['user_photo'];
								else
									$avaTell = '{theme}/images/no_ava_50.png';
							}
							
							if($rec_info['tell_comm']) $border_tell_class = 'wall_repost_border'; else $border_tell_class = '';
				
							$row['action_text'] = <<<HTML
{$rec_info['tell_comm']}
<div class="{$border_tell_class}">
<div class="wall_tell_info"><div class="wall_tell_ava"><a href="/{$tell_link}{$rec_info['tell_uid']}" onClick="Page.Go(this.href); return false"><img src="{$avaTell}" width="30" /></a></div><div class="wall_tell_name"><a href="/{$tell_link}{$rec_info['tell_uid']}" onClick="Page.Go(this.href); return false"><b>{$rowUserTell['user_search_pref']}</b></a></div><div class="wall_tell_date">{$dateTell}</div></div>{$row['action_text']}
<div class="clear"></div>
</div>
HTML;
						}
						
						$tpl->set('{comment}', stripslashes($row['action_text']));

						//Если есть комменты к записи, то выполняем след. действия
						if($rec_info['fasts_num'])
							$tpl->set_block("'\\[comments-link\\](.*?)\\[/comments-link\\]'si","");
						else {
							$tpl->set('[comments-link]', '');
							$tpl->set('[/comments-link]', '');
						}

						if($user_privacy['val_wall3'] == 1 OR $user_privacy['val_wall3'] == 2 AND $check_friend OR $user_id == $row['ac_user_id']){
							$tpl->set('[comments-link]', '');
							$tpl->set('[/comments-link]', '');
						} else
							$tpl->set_block("'\\[comments-link\\](.*?)\\[/comments-link\\]'si","");

						if($rec_info['type'])
							$tpl->set('{action-type-updates}', $rec_info['type']);
						else
							$tpl->set('{action-type-updates}', '');

						//Мне нравится
						if(stripos($rec_info['likes_users'], "u{$user_id}|") !== false){
							$tpl->set('{yes-like}', 'public_wall_like_yes');
							$tpl->set('{yes-like-color}', 'public_wall_like_yes_color');
							$tpl->set('{like-js-function}', 'groups.wall_remove_like('.$row['obj_id'].', '.$user_id.', \'uPages\')');
						} else {
							$tpl->set('{yes-like}', '');
							$tpl->set('{yes-like-color}', '');
							$tpl->set('{like-js-function}', 'groups.wall_add_like('.$row['obj_id'].', '.$user_id.', \'uPages\')');
						}
						
						if($rec_info['likes_num']){
							$tpl->set('{likes}', $rec_info['likes_num']);
							$tpl->set('{likes-text}', '<span id="like_text_num'.$row['obj_id'].'">'.$rec_info['likes_num'].'</span> '.gram_record($rec_info['likes_num'], 'like'));
						} else {
							$tpl->set('{likes}', '');
							$tpl->set('{likes-text}', '<span id="like_text_num'.$row['obj_id'].'">0</span> человеку');
						}
						
						//Выводим информцию о том кто смотрит страницу для себя
						$tpl->set('{viewer-id}', $user_id);
						if($user_info['user_photo'])
							$tpl->set('{viewer-ava}', '/uploads/users/'.$user_id.'/50_'.$user_info['user_photo']);
						else
							$tpl->set('{viewer-ava}', '{theme}/images/no_ava_50.png');
				
						$tpl->set('{rec-id}', $row['obj_id']);
						$tpl->set('[record]', '');
						$tpl->set('[/record]', '');
						$tpl->set('[wall]', '');
						$tpl->set('[/wall]', '');
						$tpl->set('[wall-func]', '');
						$tpl->set('[/wall-func]', '');
						$tpl->set_block("'\\[groups\\](.*?)\\[/groups\\]'si","");
						$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
						$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
						$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
						$tpl->compile('content');

						//Если есть комменты, то выводим и страница не "ответы"
						if($user_privacy['val_wall3'] == 1 OR $user_privacy['val_wall3'] == 2 AND $check_friend OR $user_id == $row['ac_user_id']){
						
							//Помещаем все комменты в id wall_fast_block_{id} это для JS
							$tpl->result['content'] .= '<div id="wall_fast_block_'.$row['obj_id'].'">';
							if($rec_info['fasts_num']){
								if($rec_info['fasts_num'] > 3)
									$comments_limit = $rec_info['fasts_num']-3;
								else
									$comments_limit = 0;
								
								$sql_comments = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.id, author_user_id, text, add_date, tb2.user_photo, user_search_pref FROM `".PREFIX."_wall` tb1, `".PREFIX."_users` tb2 WHERE tb1.author_user_id = tb2.user_id AND tb1.fast_comm_id = '{$row['obj_id']}' ORDER by `add_date` ASC LIMIT {$comments_limit}, 3", 1);

								//Загружаем кнопку "Показать N запсии"
								$tpl->set('{gram-record-all-comm}', gram_record(($rec_info['fasts_num']-3), 'prev').' '.($rec_info['fasts_num']-3).' '.gram_record(($rec_info['fasts_num']-3), 'comments'));
								if($rec_info['fasts_num'] < 4)
									$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
								else {
									$tpl->set('{rec-id}', $row['obj_id']);
									$tpl->set('[all-comm]', '');
									$tpl->set('[/all-comm]', '');
								}
								$tpl->set('{author-id}', $row['ac_user_id']);
								$tpl->set('[wall-func]', '');
								$tpl->set('[/wall-func]', '');
								$tpl->set_block("'\\[groups\\](.*?)\\[/groups\\]'si","");
								$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
								$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
								$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
								$tpl->compile('content');
							
								//Сообственно выводим комменты
								foreach($sql_comments as $row_comments){
									$tpl->set('{name}', $row_comments['user_search_pref']);
									if($row_comments['user_photo'])
										$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comments['author_user_id'].'/50_'.$row_comments['user_photo']);
									else
										$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
									$tpl->set('{comm-id}', $row_comments['id']);
									$tpl->set('{user-id}', $row_comments['author_user_id']);
									
									$expBR2 = explode('<br />', $row_comments['text']);
									$textLength2 = count($expBR2);
									$strTXT2 = strlen($row_comments['text']);
									if($textLength2 > 6 OR $strTXT2 > 470)
										$row_comments['text'] = '<div class="wall_strlen" id="hide_wall_rec'.$row_comments['id'].'" style="max-height:102px"">'.$row_comments['text'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row_comments['id'].', this.id)" id="hide_wall_rec_lnk'.$row_comments['id'].'">Показать полностью..</div>';
					
									$tpl->set('{text}', stripslashes($row_comments['text']));
									megaDate($row_comments['add_date']);
									if($user_id == $row_comments['author_user_id']){
										$tpl->set('[owner]', '');
										$tpl->set('[/owner]', '');
									} else
										$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
								
									$tpl->set('[comment]', '');
									$tpl->set('[/comment]', '');
									$tpl->set('[wall-func]', '');
									$tpl->set('[/wall-func]', '');
									$tpl->set_block("'\\[groups\\](.*?)\\[/groups\\]'si","");
									$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
									$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
									$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
									$tpl->compile('content');
								}

								//Загружаем форму ответа
								$tpl->set('{rec-id}', $row['obj_id']);
								$tpl->set('{author-id}', $row['ac_user_id']);
								$tpl->set('[comment-form]', '');
								$tpl->set('[/comment-form]', '');
								$tpl->set('[wall-func]', '');
								$tpl->set('[/wall-func]', '');
								$tpl->set_block("'\\[groups\\](.*?)\\[/groups\\]'si","");
								$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
								$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
								$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
								$tpl->compile('content');
							}
							$tpl->result['content'] .= '</div>';
						}
						
					//====================================//
					//Если запись со стены сообщества
					} else if($row['action_type'] == 11){

						//Выводим кол-во комментов, мне нравится, и список юзеров кто поставил лайки к записи если это не страница "ответов"
						$rec_info_groups = $db->super_query("SELECT fasts_num, likes_num, likes_users, attach, tell_uid, tell_date, tell_comm, public FROM `".PREFIX."_communities_wall` WHERE id = '{$row['obj_id']}'");
						
						//КНопка Показать полностью..
						$expBR = explode('<br />', $row['action_text']);
						$textLength = count($expBR);
						$strTXT = strlen($row['action_text']);
						if($textLength > 9 OR $strTXT > 600)
							$row['action_text'] = '<div class="wall_strlen" id="hide_wall_rec'.$row['obj_id'].'">'.$row['action_text'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row['obj_id'].', this.id)" id="hide_wall_rec_lnk'.$row['obj_id'].'">Показать полностью..</div>';
							
						//Прикрипленные файлы
						if($rec_info_groups['attach']){
							$attach_arr = explode('||', $rec_info_groups['attach']);
							$cnt_attach = 1;
							$cnt_attach_link = 1;
							$jid = 0;
							$attach_result = '';
							foreach($attach_arr as $attach_file){
								$attach_type = explode('|', $attach_file);
								
								//Фото со стены сообщества
								if($attach_type[0] == 'photo' AND file_exists(ROOT_DIR."/uploads/groups/{$row['ac_user_id']}/photos/c_{$attach_type[1]}")){
									if($cnt_attach < 2)
										$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row['obj_id']}\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$row['ac_user_id']}', '{$attach_type[1]}', '{$cnt_attach}')\"><img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/groups/{$row['ac_user_id']}/photos/{$attach_type[1]}\" align=\"left\" /></div>";
									else
										$attach_result .= "<img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/groups/{$row['ac_user_id']}/photos/c_{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$row['ac_user_id']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row['obj_id']}\" />";
									
									$cnt_attach++;
									
								//Фото со стены юзера
								} elseif($attach_type[0] == 'photo_u'){
									if($rec_info_groups['tell_uid']) $attauthor_user_id = $rec_info_groups['tell_uid'];
									else $attauthor_user_id = $row['ac_user_id'];

									if($attach_type[1] == 'attach' AND file_exists(ROOT_DIR."/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}")){
										if($cnt_attach < 2)
											$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row['obj_id']}\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$attauthor_user_id}', '{$attach_type[1]}', '{$cnt_attach}', 'photo_u')\"><img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/{$attach_type[2]}\" align=\"left\" /></div>";
										else
											$attach_result .= "<img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row['obj_id']}\" />";
											
										$cnt_attach++;
									} elseif(file_exists(ROOT_DIR."/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}")){
										if($cnt_attach < 2)
											$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row['obj_id']}\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$attauthor_user_id}', '{$attach_type[1]}', '{$cnt_attach}', 'photo_u')\"><img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/{$attach_type[1]}\" align=\"left\" /></div>";
										else
											$attach_result .= "<img id=\"photo_wall_{$row['obj_id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row['obj_id']}', '{$row['obj_id']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row['obj_id']}\" />";
											
										$cnt_attach++;
									}
									
									$resLinkTitle = '';
						
								//Видео
								} elseif($attach_type[0] == 'video' AND file_exists(ROOT_DIR."/uploads/videos/{$attach_type[3]}/{$attach_type[1]}")){
									$attach_result .= "<div><a href=\"/video{$attach_type[3]}_{$attach_type[2]}\" onClick=\"videos.show({$attach_type[2]}, this.href, location.href); return false\"><img src=\"/uploads/videos/{$attach_type[3]}/{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" /></a></div>";
									
									$resLinkTitle = '';
									
								//Музыка
								} elseif($attach_type[0] == 'audio'){
									$audioId = intval($attach_type[1]);
									$audioInfo = $db->super_query("SELECT artist, name, url FROM `".PREFIX."_audio` WHERE aid = '".$audioId."'");
									if($audioInfo){
										$jid++;
										$attach_result .= '<div class="audio_onetrack audio_wall_onemus"><div class="audio_playic cursor_pointer fl_l" onClick="music.newStartPlay(\''.$jid.'\', '.$row['obj_id'].')" id="icPlay_'.$row['obj_id'].$jid.'"></div><div id="music_'.$row['obj_id'].$jid.'" data="'.$audioInfo['url'].'" class="fl_l" style="margin-top:-1px"><a href="/?go=search&type=5&query='.$audioInfo['artist'].'&n=1" onClick="Page.Go(this.href); return false"><b>'.stripslashes($audioInfo['artist']).'</b></a> &ndash; '.stripslashes($audioInfo['name']).'</div><div id="play_time'.$row['obj_id'].$jid.'" class="color777 fl_r no_display" style="margin-top:2px;margin-right:5px">00:00</div><div class="player_mini_mbar fl_l no_display player_mini_mbar_wall_all" id="ppbarPro'.$row['obj_id'].$jid.'"></div></div>';
									}
									
									$resLinkTitle = '';
									
								//Смайлик
								} elseif($attach_type[0] == 'smile' AND file_exists(ROOT_DIR."/uploads/smiles/{$attach_type[1]}")){
									$attach_result .= '<img src=\"/uploads/smiles/'.$attach_type[1].'\" style="margin-right:5px" />';
									
									$resLinkTitle = '';
									
								//Если ссылка
								} elseif($attach_type[0] == 'link' AND preg_match('/http:\/\/(.*?)+$/i', $attach_type[1]) AND $cnt_attach_link == 1){
									$count_num = count($attach_type);
									$domain_url_name = explode('/', $attach_type[1]);
									$rdomain_url_name = str_replace('http://', '', $domain_url_name[2]);
									
									$attach_type[3] = stripslashes($attach_type[3]);
									$attach_type[3] = substr($attach_type[3], 0, 200);
										
									$attach_type[2] = stripslashes($attach_type[2]);
									$str_title = substr($attach_type[2], 0, 55);
									
									if(stripos($attach_type[4], '/uploads/attach/') === false){
										$attach_type[4] = '{theme}/images/no_ava_groups_100.gif';
										$no_img = false;
									} else
										$no_img = true;
									
									if(!$attach_type[3]) $attach_type[3] = '';
										
									if($no_img AND $attach_type[2]){
										if($rec_info_groups['tell_comm']) $no_border_link = 'border:0px';
										
										$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div><div class="clear"></div><div class="wall_show_block_link" style="'.$no_border_link.'"><a href="/away.php?url='.$attach_type[1].'" target="_blank"><div style="width:108px;height:80px;float:left;text-align:center"><img src="'.$attach_type[4].'" /></div></a><div class="attatch_link_title"><a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$str_title.'</a></div><div style="max-height:50px;overflow:hidden">'.$attach_type[3].'</div></div></div>';

										$resLinkTitle = $attach_type[2];
										$resLinkUrl = $attach_type[1];
									} else if($attach_type[1] AND $attach_type[2]){
										$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div></div><div class="clear"></div>';
										
										$resLinkTitle = $attach_type[2];
										$resLinkUrl = $attach_type[1];
									}
									
									$cnt_attach_link++;
									
								//Если документ
								} elseif($attach_type[0] == 'doc'){
								
									$doc_id = intval($attach_type[1]);
									
									$row_doc = $db->super_query("SELECT dname, dsize FROM `".PREFIX."_doc` WHERE did = '{$doc_id}'");
									
									if($row_doc){
										
										$attach_result .= '<div style="margin-top:5px;margin-bottom:5px" class="clear"><div class="doc_attach_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Файл <a href="/index.php?go=doc&act=download&did='.$doc_id.'" target="_blank" onMouseOver="myhtml.title(\''.$doc_id.$cnt_attach.$row['obj_id'].'\', \'<b>Размер файла: '.$row_doc['dsize'].'</b>\', \'doc_\')" id="doc_'.$doc_id.$cnt_attach.$row['obj_id'].'">'.$row_doc['dname'].'</a></div></div></div><div class="clear"></div>';
											
										$cnt_attach++;
									}
									
									//Если опрос
									} elseif($attach_type[0] == 'vote'){
									
										$vote_id = intval($attach_type[1]);
										
										$row_vote = $db->super_query("SELECT title, answers, answer_num FROM `".PREFIX."_votes` WHERE id = '{$vote_id}'", false, "votes/vote_{$vote_id}");
										
										if($vote_id){

											$checkMyVote = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE user_id = '{$user_id}' AND vote_id = '{$vote_id}'", false, "votes/check{$user_id}_{$vote_id}");
											
											$row_vote['title'] = stripslashes($row_vote['title']);
											
											if(!$row_wall['text'])
												$row_wall['text'] = $row_vote['title'];

											$arr_answe_list = explode('|', stripslashes($row_vote['answers']));
											$max = $row_vote['answer_num'];
											
											$sql_answer = $db->super_query("SELECT answer, COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE vote_id = '{$vote_id}' GROUP BY answer", 1, "votes/vote_answer_cnt_{$vote_id}");
											$answer = array();
											foreach($sql_answer as $row_answer){
											
												$answer[$row_answer['answer']]['cnt'] = $row_answer['cnt'];
												
											}
											
											$attach_result .= "<div class=\"clear\" style=\"height:10px\"></div><div id=\"result_vote_block{$vote_id}\"><div class=\"wall_vote_title\">{$row_vote['title']}</div>";
											
											for($ai = 0; $ai < sizeof($arr_answe_list); $ai++){

												if(!$checkMyVote['cnt']){
												
													$attach_result .= "<div class=\"wall_vote_oneanswe\" onClick=\"Votes.Send({$ai}, {$vote_id})\" id=\"wall_vote_oneanswe{$ai}\"><input type=\"radio\" name=\"answer\" /><span id=\"answer_load{$ai}\">{$arr_answe_list[$ai]}</span></div>";
												
												} else {

													$num = $answer[$ai]['cnt'];

													if(!$num ) $num = 0;
													if($max != 0) $proc = (100 * $num) / $max;
													else $proc = 0;
													$proc = round($proc, 2);
													
													$attach_result .= "<div class=\"wall_vote_oneanswe cursor_default\">
													{$arr_answe_list[$ai]}<br />
													<div class=\"wall_vote_proc fl_l\"><div class=\"wall_vote_proc_bg\" style=\"width:".intval($proc)."%\"></div><div style=\"margin-top:-16px\">{$num}</div></div>
													<div class=\"fl_l\" style=\"margin-top:-1px\"><b>{$proc}%</b></div>
													</div><div class=\"clear\"></div>";
							
												}
											
											}
											
											if($row_vote['answer_num']) $answer_num_text = gram_record($row_vote['answer_num'], 'fave');
											else $answer_num_text = 'человек';
											
											if($row_vote['answer_num'] <= 1) $answer_text2 = 'Проголосовал';
											else $answer_text2 = 'Проголосовало';
												
											$attach_result .= "{$answer_text2} <b>{$row_vote['answer_num']}</b> {$answer_num_text}.<div class=\"clear\" style=\"margin-top:10px\"></div></div>";
											
										}
										
									} else
					
										$attach_result .= '';
						
							}
							
							if($resLinkTitle AND $row['action_text'] == $resLinkUrl OR !$row['action_text'])
								$row['action_text'] = $resLinkTitle.$attach_result;
							else if($attach_result)
								$row['action_text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row['action_text']).$attach_result;
							else
								$row['action_text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row['action_text']);
		
						}
						
						$resLinkTitle = '';
						
						//Если это запись с "рассказать друзьям"
						if($rec_info_groups['tell_uid']){
							if($rec_info_groups['public'])
								$rowUserTell = $db->super_query("SELECT title, photo FROM `".PREFIX."_communities` WHERE id = '{$rec_info_groups['tell_uid']}'");
							else
								$rowUserTell = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$rec_info_groups['tell_uid']}'");

							if(date('Y-m-d', $rec_info_groups['tell_date']) == date('Y-m-d', $server_time))
								$dateTell = langdate('сегодня в H:i', $rec_info_groups['tell_date']);
							elseif(date('Y-m-d', $rec_info_groups['tell_date']) == date('Y-m-d', ($server_time-84600)))
								$dateTell = langdate('вчера в H:i', $rec_info_groups['tell_date']);
							else
								$dateTell = langdate('j F Y в H:i', $rec_info_groups['tell_date']);

							if($rec_info_groups['public']){
								$rowUserTell['user_search_pref'] = stripslashes($rowUserTell['title']);
								$tell_link = 'public';
								if($rowUserTell['photo'])
									$avaTell = '/uploads/groups/'.$rec_info_groups['tell_uid'].'/50_'.$rowUserTell['photo'];
								else
									$avaTell = '{theme}/images/no_ava_50.png';
							} else {
								$tell_link = 'u';
								if($rowUserTell['user_photo'])
									$avaTell = '/uploads/users/'.$rec_info_groups['tell_uid'].'/50_'.$rowUserTell['user_photo'];
								else
									$avaTell = '{theme}/images/no_ava_50.png';
							}
							
							if($rec_info_groups['tell_comm']) $border_tell_class = 'wall_repost_border'; else $border_tell_class = 'wall_repost_border3';
				
							$row['action_text'] = <<<HTML
{$rec_info_groups['tell_comm']}
<div class="{$border_tell_class}">
<div class="wall_tell_info"><div class="wall_tell_ava"><a href="/{$tell_link}{$rec_info_groups['tell_uid']}" onClick="Page.Go(this.href); return false"><img src="{$avaTell}" width="30" /></a></div><div class="wall_tell_name"><a href="/{$tell_link}{$rec_info_groups['tell_uid']}" onClick="Page.Go(this.href); return false"><b>{$rowUserTell['user_search_pref']}</b></a></div><div class="wall_tell_date">{$dateTell}</div></div>{$row['action_text']}
<div class="clear"></div>
</div>
HTML;
						}
						
						$tpl->set('{comment}', stripslashes($row['action_text']));
						

						//Если есть комменты к записи, то выполняем след. действия
						if($rec_info_groups['fasts_num'] OR $rowInfoUser['comments'] == false)
							$tpl->set_block("'\\[comments-link\\](.*?)\\[/comments-link\\]'si","");
						else {
							$tpl->set('[comments-link]', '');
							$tpl->set('[/comments-link]', '');
						}	

						//Мне нравится
						if(stripos($rec_info_groups['likes_users'], "u{$user_id}|") !== false){
							$tpl->set('{yes-like}', 'public_wall_like_yes');
							$tpl->set('{yes-like-color}', 'public_wall_like_yes_color');
							$tpl->set('{like-js-function}', 'groups.wall_remove_like('.$row['obj_id'].', '.$user_id.')');
						} else {
							$tpl->set('{yes-like}', '');
							$tpl->set('{yes-like-color}', '');
							$tpl->set('{like-js-function}', 'groups.wall_add_like('.$row['obj_id'].', '.$user_id.')');
						}
						
						if($rec_info_groups['likes_num']){
							$tpl->set('{likes}', $rec_info_groups['likes_num']);
							$tpl->set('{likes-text}', '<span id="like_text_num'.$row['obj_id'].'">'.$rec_info_groups['likes_num'].'</span> '.gram_record($rec_info_groups['likes_num'], 'like'));
						} else {
							$tpl->set('{likes}', '');
							$tpl->set('{likes-text}', '<span id="like_text_num'.$row['obj_id'].'">0</span> человеку');
						}
						
						//Выводим информцию о том кто смотрит страницу для себя
						$tpl->set('{viewer-id}', $user_id);
						if($user_info['user_photo'])
							$tpl->set('{viewer-ava}', '/uploads/users/'.$user_id.'/50_'.$user_info['user_photo']);
						else
							$tpl->set('{viewer-ava}', '{theme}/images/no_ava_50.png');
				
						$tpl->set('{rec-id}', $row['obj_id']);
						$tpl->set('[record]', '');
						$tpl->set('[/record]', '');
						$tpl->set('[wall]', '');
						$tpl->set('[/wall]', '');
						$tpl->set('[groups]', '');
						$tpl->set('[/groups]', '');
						$tpl->set_block("'\\[wall-func\\](.*?)\\[/wall-func\\]'si","");
						$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
						$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
						$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
						$tpl->compile('content');

						//Если есть комменты, то выводим и страница не "ответы"
						if($rowInfoUser['comments']){
						
							//Помещаем все комменты в id wall_fast_block_{id} это для JS
							$tpl->result['content'] .= '<div id="wall_fast_block_'.$row['obj_id'].'">';
							if($rec_info_groups['fasts_num']){
								if($rec_info_groups['fasts_num'] > 3)
									$comments_limit = $rec_info_groups['fasts_num']-3;
								else
									$comments_limit = 0;
								
								$sql_comments = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.id, public_id, text, add_date, for_groups, rec_answer, tb2.user_photo, user_search_pref FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_users` tb2 WHERE tb1.public_id = tb2.user_id AND tb1.fast_comm_id = '{$row['obj_id']}' ORDER by `add_date` ASC LIMIT {$comments_limit}, 3", 1);

								//Загружаем кнопку "Показать N запсии"
								$tpl->set('{gram-record-all-comm}', gram_record(($rec_info_groups['fasts_num']-3), 'prev').' '.($rec_info_groups['fasts_num']-3).' '.gram_record(($rec_info_groups['fasts_num']-3), 'comments'));
								if($rec_info_groups['fasts_num'] < 4)
									$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
								else {
									$tpl->set('{rec-id}', $row['obj_id']);
									$tpl->set('[all-comm]', '');
									$tpl->set('[/all-comm]', '');
								}
								$tpl->set('{author-id}', $row['ac_user_id']);
								$tpl->set('[groups]', '');
								$tpl->set('[/groups]', '');
								$tpl->set_block("'\\[wall-func\\](.*?)\\[/wall-func\\]'si","");
								$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
								$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
								$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
								$tpl->compile('content');
							
								//Сообственно выводим комменты
								foreach($sql_comments as $row_comments){
									$tpl->set('{public-id}', $row['ac_user_id']);
					$tpl->set('{rec-id}', $rec_id);
					
					if($row_comments['for_groups']) {
						$row_public = $db->super_query("SELECT title, photo FROM `".PREFIX."_communities` WHERE id = '{$row['ac_user_id']}'");
						$tpl->set('{name}', $row_public['title']);
						if($row_public['photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/groups/'.$row['ac_user_id'].'/50_'.$row_public['photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						$tpl->set('{comm-id}', $row_comments['id']);
						$tpl->set('{user-id}', $row['ac_user_id']);
						$tpl->set('{link}', 'public');
					} else {
						$tpl->set('{name}', $row_comments['user_search_pref']);
						if($row_comments['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comments['public_id'].'/50_'.$row_comments['user_photo']);
							else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');	
						$tpl->set('{comm-id}', $row_comments['id']);
						$tpl->set('{user-id}', $row_comments['public_id']);
						$tpl->set('{link}', 'id');
					}
									
									$expBR2 = explode('<br />', $row_comments['text']);
									$textLength2 = count($expBR2);
									$strTXT2 = strlen($row_comments['text']);
									if($textLength2 > 6 OR $strTXT2 > 470)
										$row_comments['text'] = '<div class="wall_strlen" id="hide_wall_rec'.$row_comments['id'].'" style="max-height:102px"">'.$row_comments['text'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row_comments['id'].', this.id)" id="hide_wall_rec_lnk'.$row_comments['id'].'">Показать полностью..</div>';
										
									$tpl->set('{text}', stripslashes($row_comments['text']));
									megaDate($row_comments['add_date']);
									
									if($row_comments['rec_answer']) {
							$row_rec_id = $db->super_query("SELECT public_id, for_groups FROM `".PREFIX."_communities_wall` WHERE id = '{$row_comments['rec_answer']}'");
							$row_rec_name = $db->super_query("SELECT user_name FROM `".PREFIX."_users` WHERE user_id = '{$row_rec_id['public_id']}'");
							if($row_rec_id['for_groups']) $tpl->set('{rec_answer_name}', 'Сообществу');
							else $tpl->set('{rec_answer_name}', gramatikName1($row_rec_name['user_name']));
							$tpl->set('{rec_answer_id}', $row_comments['rec_answer']);
						} else {
							$tpl->set('{rec_answer_name}', '');
							$tpl->set('{rec_answer_id}', '');
						}
								
									
									if($user_id == $row_comments['public_id']){
										$tpl->set('[owner]', '');
										$tpl->set('[/owner]', '');
									} else
										$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
										
										if($user_id == $row_comments['public_id']) {
						$tpl->set('[uowner]', '');
						$tpl->set('[/uowner]', '');
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
					} else {
						$tpl->set('[not-owner]', '');
						$tpl->set('[/not-owner]', '');
						$tpl->set_block("'\\[uowner\\](.*?)\\[/uowner\\]'si","");
					}
								
									$tpl->set('[comment]', '');
									$tpl->set('[/comment]', '');
									$tpl->set('[groups]', '');
									$tpl->set('[/groups]', '');
									$tpl->set_block("'\\[wall-func\\](.*?)\\[/wall-func\\]'si","");
									$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
									$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
									$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
									$tpl->compile('content');
								}

								//Загружаем форму ответа
								$tpl->set('{rec-id}', $row['obj_id']);
								$tpl->set('{author-id}', $row['ac_user_id']);
								if(stripos($row['admin'], "u{$user_id}|") !== false) {
					$tpl->set('[owner]', '');
					$tpl->set('[/owner]', '');
				} else $tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
								$tpl->set('[comment-form]', '');
								$tpl->set('[/comment-form]', '');
								$tpl->set('[groups]', '');
								$tpl->set('[/groups]', '');
								$tpl->set_block("'\\[wall-func\\](.*?)\\[/wall-func\\]'si","");
								$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
								$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
								$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
								$tpl->compile('content');
							}
							$tpl->result['content'] .= '</div>';
						}
					} else {
						$tpl->set('[record]', '');
						$tpl->set('[/record]', '');
						$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
						$tpl->set_block("'\\[wall\\](.*?)\\[/wall\\]'si","");
						$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
						$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
						$tpl->set_block("'\\[comments-link\\](.*?)\\[/comments-link\\]'si","");
						
						if($action_cnt)
							$tpl->compile('content');
					}
				}				

		//Если критерий поиск "по аудизаписям"
		} elseif($type == 5){
			$tpl->load_template('search/result_audio.tpl');
			$jid = 0;
			foreach($sql_ as $row){
				$jid++;
				$tpl->set('{jid}', $jid);
				$tpl->set('{aid}', $row['aid']);
				$tpl->set('{url}', $row['url']);
				$tpl->set('{artist}', stripslashes($row['artist']));
				$tpl->set('{name}', stripslashes($row['name']));
				$tpl->set('{author-n}', substr($row['user_search_pref'], 0, 1));
				$expName = explode(' ', $row['user_search_pref']);
				$tpl->set('{author-f}', $expName[1]);
				$tpl->set('{author-id}', $row['auser_id']);
				$tpl->compile('content');
			}
		} else
			msgbox('', $lang['search_none'], 'info_2');

		navigation($gcount, $count['cnt'], '/index.php?'.$query_string.'&page=');
	} else
		msgbox('', '', 'info_search');
	
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>