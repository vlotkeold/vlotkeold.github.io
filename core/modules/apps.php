<?php

if(!defined('MOZG'))
	die('И че ты тут забыл??');

if($ajax == 'yes')

	NoAjaxQuery();

$user_id = $user_info['user_id'];

$key = '0PFXXTE349BMNFSV9801DZ843VUAA482';

$tpl->set('{hash}', md5($key.'asd4465a4das56d4as65'.$user_id));

$act = $_GET['act'];

if($logged){

	switch($act){

		case "view":

			NoAjaxQuery();

			$id = intval($_POST['id']);

			$row = $db->super_query("SELECT `id`,`cols`,`title`,`img`,`desc` FROM `".PREFIX."_apps` WHERE id='{$id}'");

			$num = $row['cols'];

			//Склонение поля человека смотрящего обьявление
			if($user_info['user_sex'] == '1'){

				$user_sex = 'первым';

			}else{

				$user_sex = 'первой';

			}

			//Проверка устанавливал ли кто нибудь Приложения
			if($row['cols'] == 0){

				$application_f = 'Приложения еще ни кто не установил будь '.$user_sex;

			}else{

				$application_f = 'Приложения установили '.$num.' '.gram_record($num, 'apps');

			}
			
			//Если нету Изображение Приложения то ставим стандарт..

			if($row['img']){

				$application_img = $config['home_url'].'uploads/apps/'.$row['id'].'/'.$row['img'];

			} else {

				$application_img = '/images/no_apps.gif';

			}

			$tpl->set('{id}', $row['id']);

			$tpl->set('{nums}', $application_f);

			$tpl->set('{title}', $row['title']);

			$tpl->set('{desc}', $row['desc']);

			$tpl->set('{ava}', $application_img);

			$tpl->load_template('apps/viewapplication.tpl');

			$tpl->compile('content');

			AjaxTpl();

			die();

		break;
		
		//############### Вывод игры ###############

		case "app":

			$id = intval($_GET['id']);

			//Вывод игры из базы
			$row = $db->super_query("SELECT id,url,cols,title,img,width,height,secret,user_id,status,type,flash,igames FROM `".PREFIX."_apps` WHERE id='{$id}'");

			$metatags['title'] = 'Игра | '.$row['title'].'';

			if($row['status'] == '1' or $row['user_id'] == $user_id){

				if($row['user_id'] == $user_id){

					$tpl->set('[edit]', '');

					$tpl->set('[/edit]', '');

					$tpl->set_block("'\\[not-edit\\](.*?)\\[/not-edit\\]'si","");

				} else {

					$tpl->set('[not-edit]', '');

					$tpl->set('[/not-edit]', '');

					$tpl->set_block("'\\[edit\\](.*?)\\[/edit\\]'si","");

				}

				$rows = $db->super_query("SELECT user_id,application_id FROM `".PREFIX."_apps_users` WHERE user_id='{$user_id}' AND  application_id='{$id}'");

				if($rows['user_id'] != $user_id && $rows['application_id'] != $id){

					$tpl->set('[install]', '');

					$tpl->set('[/install]', '');

					$tpl->set_block("'\\[not-install\\](.*?)\\[/not-install\\]'si","");

				} else {

					$tpl->set('[not-install]', '');

					$tpl->set('[/not-install]', '');

					$tpl->set_block("'\\[install\\](.*?)\\[/install\\]'si","");

				}

				if($row['type'] == '1'){

					$tpl->set('[iframe]', '');

					$tpl->set('[/iframe]', '');

					$tpl->set_block("'\\[flash\\](.*?)\\[/flash\\]'si","");

				} else {

					$tpl->set('[flash]', '');

					$tpl->set('[/flash]', '');

					$tpl->set_block("'\\[iframe\\](.*?)\\[/iframe\\]'si","");

				}

				if($row['igames'] == '1'){

					$tpl->set('[igames]', '');

					$tpl->set('[/igames]', '');

					$tpl->set_block("'\\[noigames\\](.*?)\\[/noigames\\]'si","");

				} else {

					$tpl->set('[noigames]', '');

					$tpl->set('[/noigames]', '');

					$tpl->set_block("'\\[igames\\](.*?)\\[/igames\\]'si","");

				}	

				if($row['img'] == '') $img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$row['id'].'/100_'.$row['img'];

				$num = $row['cols'];

            	$tpl->set('{nums}', $num.' '.gram_record($num, 'apps'));

				$tpl->set('{title}', $row['title']);

				$tpl->set('{id}', $row['id']);

				$tpl->set('{height}', $row['height']);

				$tpl->set('{width}', $row['width']);

				$tpl->set('{api_url}', $config['home_url']);

				$tpl->set('{viewer_id}', $user_id);

				$tpl->set('{auth_key}', md5($row['id']."_".$user_id."_".$row['secret']));

				$tpl->set('{ava}', $img);

				$tpl->set('{site}', $config['home_url']);

				$tpl->set('{url}', $row['url']);

				$tpl->set('{flash}', $row['flash']);

				if($row['url'] == '' && $row['flash'] == '')  $tpl->load_template('apps/editapp/no_app.tpl'); else $tpl->load_template('apps/application.tpl');

			} else $tpl->load_template('apps/editapp/ofline.tpl');

			$tpl->compile('content');

		break;

		case "show_settings":

			NoAjaxQuery();

			$id = intval($_POST['id']);						

			$row = $db->super_query("SELECT user_id,user_balance,user_photo FROM `".PREFIX."_users` WHERE user_id='{$user_id}'");

			$app = $db->super_query("SELECT user_id,balance,application_id FROM `".PREFIX."_apps_users` WHERE user_id='{$user_id}'  AND application_id='{$id}'");
			
			if($app['user_id'] != $user_id && $app['application_id'] != $id){

					$tpl->set('[install]', '');

					$tpl->set('[/install]', '');

					$tpl->set_block("'\\[not-install\\](.*?)\\[/not-install\\]'si","");

				} else {

					$tpl->set('[not-install]', '');

					$tpl->set('[/not-install]', '');

					$tpl->set_block("'\\[install\\](.*?)\\[/install\\]'si","");

				}

			$tpl->set('{id}', $id);

			$tpl->set('{balance}', $row['user_balance']);

			$tpl->set('{app_balance}', $app['balance']);

			$tpl->set('{userid}', $user_id);

			$tpl->load_template('/apps/show_settings.tpl');

			$tpl->compile('content');

			AjaxTpl();

			die();
		
		break;

		case"save_settings":

			$id = intval($_POST['aid']);

			$balance = intval($_POST['add']);			

			$hash = $_POST['hash'];

			if($hash == md5($key.'asd4465a4das56d4as65'.$user_id) && $balance >= '0'){

				$row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id='{$user_id}'");							

				if($balance <= $row['user_balance']) {

					$db->query("UPDATE `".PREFIX."_apps_users` SET balance=balance+'{$balance}' WHERE application_id='{$id}' and user_id='{$user_id}'");
					
					$db->query("UPDATE `".PREFIX."_apps` SET balance=balance+'{$balance}' WHERE id='{$id}'");

					$db->super_query("UPDATE `".PREFIX."_users` SET user_balance=user_balance-'{$balance}' WHERE user_id='{$user_id}'");					

					$db->query("INSERT INTO `".PREFIX."_apps_transactions` (votes,whom,date,application_id) VALUES ('".$balance."','".$user_id."','".$server_time."','".$id."')");
					echo "ok";

				} else echo "not";

			}

		break;

		//##################### Удаление игр у пользователя #####################
		case"quit":

			$id = intval($_POST['id']);

			$hash = $_POST['hash'];

			if($hash == md5($key.'asd4465a4das56d4as65'.$user_id)){

				$db->query("DELETE FROM `".PREFIX."_apps_users` WHERE user_id='{$user_id}' AND application_id='{$id}'");

				$db->query("UPDATE `".PREFIX."_apps` SET cols=cols-1 WHERE id='{$id}'");

				echo 'ok';

			}

		break;

		//##################### Установка игры #####################
		case 'install':

			$id = intval($_POST['id']);

			$hash = $_POST['hash'];

			//Проверка добавлял ли игру пользователь
			$rows = $db->super_query("SELECT user_id,application_id FROM `".PREFIX."_apps_users` WHERE user_id='{$user_id}' AND  application_id='{$id}'");

			if($rows['user_id'] != $user_id && $rows['application_id'] != $id && $hash == md5($key.'asd4465a4das56d4as65'.$user_id)){

				$db->query("INSERT INTO `".PREFIX."_apps_users` (user_id,application_id,date) VALUES ('".$user_id."','".$id."','".$server_time."')");
				
				$db->query("INSERT INTO `".PREFIX."_compare_u` (uid) VALUES ('".$user_id."')");

				$db->query("UPDATE `".PREFIX."_apps` SET cols=cols+1 WHERE id='{$id}'");

				echo 'ok';

			}

			break;

		//########## Отправка рассказать друзьям об игре ################

		case"mywall":

			$id = intval($_POST['id']);

			$hash = $_POST['hash'];

			$sql = $db->super_query("SELECT id,cols,title,img FROM `".PREFIX."_apps` WHERE id='{$id}'");

			if($user_info['user_sex'] <= 1){

				$sex = 'Я начал';

			}else{

				$sex = 'Я начала';

			}

			$text = $sex.' играть в приложение <a href="/app'.$sql['id'].'" onclick="apps.view(\''.$attach_type[1].'\', this.href, \' \'); return false;">'.$sql['title'].'</a>.<br> Присоединяйся!';

			$attach = 'apps|'.$sql['id'].'|'.$sql['img'].'||';

			$db->query("INSERT INTO `".PREFIX."_wall` (author_user_id,add_date,text,attach,for_user_id,noedit) VALUES ('".$user_id."','".$server_time."','".$text."','".$attach."','".$user_id."', '1')");

			$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$user_id}'");

			//Чистим кеш
			mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);

			mozg_clear_cache();

		break;

		//############### Поиск по приложениям ##################

		case"search":

			$application = $db->safesql(ajax_utf8(strip_data(urldecode($_POST['query_application']))));

			$application = strtr($application, array(' ' => '%'));


			$sql = $db->super_query("SELECT * FROM `".PREFIX."_apps` WHERE title LIKE '%{$application}%'",1);

			foreach($sql as $row_app){

			$num = $row_app['cols'];

			//Если нету Изображение Приложения то ставим стандарт..
			if($row_app['img']){

				$application_img = $config['home_url'].'uploads/apps/'.$row_app['id'].'/'.$row_app['img'];

			} else {

				$application_img = '/images/no_apps.gif';

			}

			$search_g .='

					<div class="apps_application apps_application2 apps_last_new" id="{id}">

					<a class="apps_mr" href="/apps?i='.$row_app['id'].'" onClick="apps.view(\''.$row_app['id'].'\', this.href, \'/apps\'); return false">

					<img src="'.$application_img.'" class="fl_l" width="75" height="75" /></a>

					<a href="/apps?i='.$row_app['id'].'" onClick="apps.view(\''.$row_app['id'].'\', this.href, \'/apps\'); return false">'.$row_app['title'].'</a>

					<div class="apps_num">'.$num.' '.gram_record($num, 'apps').'</div>

					<div class="clear"></div>

					</div>

				';
			}

			echo $search_g;

			AjaxTpl();

            die();

		break;

		//################# Подгружаем игры ######################
		case"doload":

			$start = intval($_POST['num']);

			$sqll_ = $db->super_query("SELECT tb1.user_id,tb1.application_id,tb2.title,tb2.img,tb2.cols FROM `".PREFIX."_apps_users` tb1,`".PREFIX."_apps` tb2 WHERE tb1.user_id='{$user_id}' AND tb2.id=tb1.application_id ORDER BY tb1.date DESC LIMIT {$start}, 5",1);
			
			$tpl->load_template('apps/my_application.tpl');
			
			foreach($sqll_ as $rows){

				$num = $rows['cols'];

				$my_application .='

				<div id="app'.$rows['application_id'].'" class="apps_application">

				<a class="apps_mr" onclick="Page.Go(this.href); return false" href="/app'.$rows['application_id'].'">

				<img class="fl_l" width="50" height="50" src="/uploads/apps/'.$rows['application_id'].'/'.$rows['img'].'">

				</a>

				<a onclick="Page.Go(this.href); return false" href="/app'.$rows['application_id'].'">'.$rows['title'].'</a>

				<div id="appsgan'.$rows['application_id'].'" class="apps_fast_del fl_r cursor_pointer" onmouseover="myhtml.title(\''.$rows['application_id'].'\', \'Удалить игру\', \'appsgan\')" onclick="apps.mydel(\''.$rows['application_id'].'\', true)">

				<img src="/images/close_a.png">

				</div>

				<div class="clear"></div>

				</div>

				';

			}
			
			$sqlls_ = $db->super_query("

			SELECT tb1.*,tb2.*,tb3.application_id,tb3.img,tb4.user_id,tb4.user_name,tb4.user_sex,tb4.user_photo 

			FROM `".PREFIX."_apps_users` tb1,`".PREFIX."_friends` tb2,`".PREFIX."_apps` tb3,`".PREFIX."_users` tb4 

			WHERE tb2.friend_id=tb1.user_id AND tb2.user_id='{$user_id}' AND tb2.subscriptions='0' AND tb3.id=tb1.application_id AND tb4.user_id=tb2.friend_id 

			ORDER BY tb1.date DESC LIMIT {$start}, 5",1);

			foreach($sqlls_ as $rowsa){

				if($rowsa['user_sex'] == 1){

					$m = 'запустил игру';

				}else{

					$m = 'запустила игру';

				}

				if(date('Y-m-d', $rowsa['date']) == date('Y-m-d', $server_time))

						$dateTell = langdate('сегодня в H:i', $rowsa['date']);

					elseif(date('Y-m-d', $rowsa['date']) == date('Y-m-d', ($server_time-84600)))

						$dateTell = langdate('вчера в H:i',$rowsa['date']);

					else

						$dateTell = langdate('j F Y в H:i', $rowsa['date']);

                if($rowsa['user_photo'])

			    $ava = $config['home_url'].'uploads/users/'.$rowsa['user_id'].'/50_'.$rowsa['user_photo'];

					else

			    $ava = '/images/no_ava_50.png';


				$friends_application .= '
				
				
<div class="apps_application">

<a class="apps_mr" href="/id'.$rowsa['user_id'].'" onClick="Page.Go(this.href); return false">

<img src="'.$ava.'" class="fl_l" width="50" style="max-height:50px;" id="apps_user'.$rowsa['user_id'].'" />

</a>

<img src="'.$rowsa['img'].'" class="fl_r" width="50" height="50" id="apps_gane'.$rowsa['application_id'].'" />

</a> 

<div class="apps_gr">

<div class="apps_grtext"><a href="/id'.$rowsa['user_id'].'">'.$rowsa['user_name'].'</a> '.$m.' <a onclick="Page.Go(this.href); return false" style="font-weight:normal" href="/app'.$rows['application_id'].'">'.$rows['title'].'</a><br /><small>'.$dateTell.'</small></div>

</div>

<div class="clear"></div>

</div>


				';

			}

			echo $my_application.'||'.$friends_application;

			AjaxTpl();

            die();

		break;

		case"loads":

		$start = intval($_POST['num']);

		$sql_ = $db->super_query("SELECT id,cols,title,img FROM `".PREFIX."_apps` where status!='-1' ORDER BY id DESC LIMIT {$start},20",1);

		$tpl->load_template('apps/newapplication.tpl');

		//#################### Вывод популярных игр ######################
		foreach($sql_ as $rowsd){

			if($rowsd['cols'] >= 2){

				$num = $rowsd['cols'];

				$le .='

				<div class="apps_application apps_application2 apps_last_new" id="{id}">

				<a class="apps_mr" href="/apps?i='. $rowsd['id'].'" onClick="apps.view(\''. $rowsd['id'].'\', this.href,\'/apps\'); return false"><img src="/uploads/apps/'.$rowsd['id'].'/100_'.$rowsd['img'].'" class="fl_l" width="75" height="75" /></a>

				<a href="/apps?i='. $rowsd['id'].'" onClick="apps.view(\''. $rowsd['id'].'\', this.href, \'/apps\'); return false">'.$rowsd['title'].'</a>

				<div class="apps_num"></div>

				<div class="clear"></div>

				</div>

				';
			}
		}

		//#################### Вывод новых игр ######################
		foreach($sql_ as $row){

			$num = $row['cols'];

			$new .='

			<div class="apps_application apps_application2 apps_last_new" id="{id}">

				<a class="apps_mr" href="/apps?i='. $row['id'].'" onClick="apps.view(\''. $row['id'].'\', this.href,\'/apps\'); return false">

				<img src="/uploads/apps/'.$row['id'].'/100_'.$row['img'].'" class="fl_l" width="75" height="75" /></a>

				<a href="/apps?i='. $row['id'].'" onClick="apps.view(\''. $row['id'].'\', this.href, \'/apps\'); return false">'.$row['title'].'</a>

				<div class="apps_num">'.$num.' '.gram_record($num, 'apps').'</div>

				<div class="clear"></div>

				</div>

			';

		}

		echo $le.'||'.$new;

			AjaxTpl();

            die();

		break;

		default:

		$sqls_ = $db->super_query("SELECT id,cols,title,img FROM `".PREFIX."_apps` where status!='-1' ORDER BY id DESC LIMIT 9",1);

		$tpl->load_template('apps/slider.tpl');

		//#################### Вывод популярных игр ######################
		foreach($sqls_ as $rowsds){

				if($rowsds['img'] == '') $img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rowsds['id'].'/'.$rowsds['img'];

				$db->query("SELECT * FROM `".PREFIX."_apps_users` WHERE user_id = '$user_id' and application_id = '$rowsds[id]'");

				if(!$db->num_rows()){

					$tpl->set('{link}', '<a href="/apps?i='.$rowsds['id'].'" onClick="apps.view('.$rowsds['id'].', this.href, "/apps"); return false">');

				} else $tpl->set('{link}', '<a href="/app'.$rowsds['id'].'">');

				$tpl->set('{title}', $rowsds['title']);

				$tpl->set('{id}', $rowsds['id']);

				$tpl->set('{ava}', $img);

				$tpl->compile('slider');

		}

		//############# Вывод моих игр #####################

		$sqll_ = $db->super_query("SELECT tb1.user_id,tb1.application_id,tb2.title,tb2.img,tb2.cols FROM `".PREFIX."_apps_users` tb1,`".PREFIX."_apps` tb2 WHERE tb1.user_id='{$user_id}' AND tb2.id=tb1.application_id ORDER BY tb1.date DESC LIMIT 5",1);

		$tpl->load_template('apps/my_application.tpl');

		foreach($sqll_ as $rows){

			if($rows['img'] == '')	$img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rows['application_id'].'/100_'.$rows['img'];

			$num = $rows['cols'];

            $tpl->set('{nums}', $num.' '.gram_record($num, 'apps'));

			$tpl->set('{title}', $rows['title']);

			$tpl->set('{id}', $rows['application_id']);

			$tpl->set('{ava}', $img);

			$tpl->set('{hash}', md5($key.'asd4465a4das56d4as65'.$user_id));

			$tpl->compile('my_application');

		}

		//################ Игры друзей ###################
		$sqlls_ = $db->super_query("

		SELECT tb1.*,tb2.*,tb3.*,tb4.user_id,tb4.user_name,tb4.user_sex,tb4.user_photo 

		FROM `".PREFIX."_apps_users` tb1,`".PREFIX."_friends` tb2,`".PREFIX."_apps` tb3,`".PREFIX."_users` tb4 

		WHERE 

		tb2.friend_id=tb1.user_id

		AND tb2.user_id='{$user_id}'

		AND tb2.subscriptions='0'

		AND tb3.id=tb1.application_id

		AND tb4.user_id=tb2.friend_id

		ORDER BY tb1.date DESC LIMIT 5",1);

		$tpl->load_template('apps/friends_application.tpl');

		foreach($sqlls_ as $rowsa){

			if($rowsa['user_sex'] == 1){

				$tpl->set('{application_start}', 'запустил игру');

			}else{

				$tpl->set('{application_start}', 'запустила игру');

			}

			if(date('Y-m-d', $rowsa['date']) == date('Y-m-d', $server_time))

					$dateTell = langdate('сегодня в H:i', $rowsa['date']);

				elseif(date('Y-m-d', $rowsa['date']) == date('Y-m-d', ($server_time-84600)))

					$dateTell = langdate('вчера в H:i',$rowsa['date']);

				else

					$dateTell = langdate('j F Y в H:i', $rowsa['date']);

	        if($rowsa['user_photo'])

				$ava = $config['home_url'].'uploads/users/'.$rowsa['user_id'].'/50_'.$rowsa['user_photo'];

		    else

				$ava = '/images/no_ava_50.png';

			if($rowsa['img'] == '')	$img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rowsa['id'].'/100_'.$rowsa['img'];

			$db->query("SELECT * FROM `".PREFIX."_apps_users` WHERE user_id = '$user_id' and application_id = '$rowsa[id]'");

			if(!$db->num_rows())$tpl->set('{link}', '<a class="apps_ml" href="/apps?i='.$rowsa['id'].'" onClick="apps.view('.$rowsa['id'].', this.href, "/apps"); return false">');

			else $tpl->set('{link}', '<a class="apps_ml" href="/app'.$rowsa['id'].'">');

			$tpl->set('{title}', $rowsa['title']);

			$tpl->set('{date}', $dateTell);

			$tpl->set('{name}', $rowsa['user_name']);

			$tpl->set('{user-id}', $rowsa['user_id']);

			$tpl->set('{id}', $rowsa['id']);

			$tpl->set('{ava}', $ava);

			$tpl->set('{img}', $img);

			$tpl->compile('friends_application');

		}


		//################### Вывод новых и популярных игр #####################
		$metatags['title'] = 'Игры';

		$sql_ = $db->super_query("SELECT `id`,`cols`,`title`,`img`,`desc` FROM `".PREFIX."_apps` WHERE status!='-1' ORDER BY id DESC LIMIT 20",1);

		$tpl->load_template('apps/newapplication.tpl');

		//#################### Вывод популярных игр ######################
		foreach($sql_ as $rowsd){

			if($rowsd['cols'] >= 2){

				if($rowsd['img'] == '')	$img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rowsd['id'].'/100_'.$rowsd['img'];

				$db->query("SELECT * FROM `".PREFIX."_apps_users` WHERE user_id = '$user_id' and application_id = '$rowsd[id]'");

				if(!$db->num_rows())$tpl->set('{link}', '<a href="/apps?i='.$rowsd['id'].'" onClick="apps.view('.$rowsd['id'].', this.href, "/apps"); return false">');

				else $tpl->set('{link}', '<a href="/app'.$rowsd['id'].'">');

				$num = $rowsd['cols'];

                $tpl->set('{nums}', $num.' '.gram_record($num, 'apps'));

				$tpl->set('{title}', $rowsd['title']);	
				
				$tpl->set('{descr}', substr($rowsd['desc'], 0, 500));
				
				$tpl->set('{id}', $rowsd['id']);

				$tpl->set('{ava}', $img);

				$tpl->compile('popular_application');

			}
		}

		//#################### Вывод новых игр ######################
		foreach($sql_ as $row){

			if($row['img'] == '') $img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$row['id'].'/100_'.$row['img'];

				$db->query("SELECT * FROM `".PREFIX."_apps_users` WHERE user_id = '$user_id' and application_id = '$row[id]'");

			if(!$db->num_rows()) $tpl->set('{link}', '<a href="/apps?i='.$row['id'].'" onClick="apps.view('.$row['id'].', this.href, "/apps"); return false">');

				else $tpl->set('{link}', '<a href="/app'.$row['id'].'" onClick="Page.Go(this.href); return false;">');

				$num = $row['cols'];

				$tpl->set('{nums}', $num.' '.gram_record($num, 'apps'));

				$tpl->set('{title}', $row['title']);
				
				$tpl->set('{descr}', substr($row['desc'], 0, 500));

				$tpl->set('{id}', $row['id']);

				$tpl->set('{ava}', $img);

				$tpl->compile('newapplication');

		}

		$tpl->load_template('apps/content.tpl');

		$tpl->set('{slider}', $tpl->result['slider']);

		$tpl->set('{my_application}', $tpl->result['my_application']);

		$tpl->set('{friends_application}', $tpl->result['friends_application']);

		$tpl->set('{popular_application}', $tpl->result['popular_application']);

		$tpl->set('{newapplication}', $tpl->result['newapplication']);

		$tpl->compile('content');

	}

	$db->free();

	$tpl->clear();

} else {

	$user_speedbar = 'Информация';

	msgbox('', $lang['not_logged'], 'info');

}

?>