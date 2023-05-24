<?php
/* 
	Appointment: Просмотр фотографии
	File: photo.php 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];

	switch($act){
	
		//################### Добавления комментария ###################//
		case "addcomm":
			NoAjaxQuery();
			$pid = intval($_POST['pid']);
			include ENGINE_DIR.'/classes/forwall.php';
			$parse = new parse();		
			$comment = $parse->BBparse(ajax_utf8(textFilter($_POST['comment'])));
			$date = date('Y-m-d H:i:s', $server_time);
			$hash = md5($user_id.$server_time.$_IP.$user_info['user_email'].rand(0, 1000000000)).$comment.$pid;
			
			$check_photo = $db->super_query("SELECT album_id, user_id, photo_name FROM `".PREFIX."_photos` WHERE id = '{$pid}'");

			//Проверка естьли запрашиваемый юзер в друзьях у юзера который смотрит стр
			if($user_info['user_id'] != $check_photo['user_id']){
				$check_friend = CheckFriends($check_photo['user_id']);
				
				$row_album = $db->super_query("SELECT privacy, system FROM `".PREFIX."_albums` WHERE aid = '{$check_photo['album_id']}'");
				$album_privacy = explode('|', $row_album['privacy']);
			}
				
			//ЧС
			$CheckBlackList = CheckBlackList($check_photo['user_id']);
			
			//Проверка на существование фотки и приватность
			if(!$CheckBlackList AND $check_photo AND $album_privacy[1] == 1 OR $album_privacy[1] == 2 AND $check_friend OR $user_info['user_id'] == $check_photo['user_id']){
				$db->query("INSERT INTO `".PREFIX."_photos_comments` (pid, user_id, text, date, hash, album_id, owner_id, photo_name) VALUES ('{$pid}', '{$user_id}', '{$comment}', '{$date}', '{$hash}', '{$check_photo['album_id']}', '{$check_photo['user_id']}', '{$check_photo['photo_name']}')");
				$id = $db->insert_id();
				$db->query("UPDATE `".PREFIX."_photos` SET comm_num = comm_num+1 WHERE id = '{$pid}'");
				$db->query("UPDATE `".PREFIX."_albums` SET comm_num = comm_num+1 WHERE aid = '{$check_photo['album_id']}'");

				$date = langdate('сегодня в H:i', $server_time);
				$tpl->load_template('photo_comment.tpl');
				$tpl->set('{author}', $user_info['user_search_pref']);
				$tpl->set('{comment}', stripslashes($comment));
				$tpl->set('{uid}', $user_id);
				$tpl->set('{hash}', $hash);
				$tpl->set('{id}', $id);
				
				if($user_info['user_photo'])
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$user_id.'/50_'.$user_info['user_photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
				
				$tpl->set('{online}', $lang['online']);
				$tpl->set('{date}', langdate('сегодня в H:i', $server_time));
				$tpl->set('[owner]', '');
				$tpl->set('[/owner]', '');
				
				//Мне нравится
								if(stripos($row_comm['likes_users'], "u{$user_info['user_id']}|") !== false){
									$tpl->set('{yes-like}', 'public_wall_like_yes');
									$tpl->set('{yes-like-color}', 'public_wall_like_yes_color');
									$tpl->set('{like-js-function}', 'Photo.wall_remove_like('.$row_comm['id'].', '.$user_info['user_id'].')');
								} else {
									$tpl->set('{yes-like}', '');
									$tpl->set('{yes-like-color}', '');
									$tpl->set('{like-js-function}', 'Photo.wall_add_like('.$row_comm['id'].', '.$user_info['user_id'].')');
								}
								
								if($row_comm['likes_num']){
									$tpl->set('{likes}', $row_comm['likes_num']);
									$tpl->set('{likes-text}', '<span id="like_text_num'.$row_comm['id'].'">'.$row_comm['likes_num'].'</span> '.gram_record($row_comm['likes_num'], 'like'));
								} else {
									$tpl->set('{likes}', '');
									$tpl->set('{likes-text}', '<span id="like_text_num'.$row_comm['id'].'">0</span> человеку');
								}
								
								//Выводим информцию о том кто смотрит страницу для себя
								$tpl->set('{viewer-id}', $user_info['user_id']);
								if($user_info['user_photo'])
									$tpl->set('{viewer-ava}', '/uploads/users/'.$user_info['user_id'].'/50_'.$user_info['user_photo']);
								else
									$tpl->set('{viewer-ava}', '{theme}/images/no_ava_50.png');
				$tpl->compile('content');
				
				//Добавляем действие в ленту новостей "ответы" владельцу фотографии
				if($user_id != $check_photo['user_id']){
					$comment = str_replace("|", "&#124;", $comment);
					$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 8, action_text = '{$comment}|{$check_photo['photo_name']}|{$pid}|{$check_photo['album_id']}', obj_id = '{$id}', for_user_id = '{$check_photo['user_id']}', action_time = '{$server_time}'");

					//Вставляем событие в моментальные оповещания
					$row_userOW = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$check_photo['user_id']}'");
					$update_time = $server_time - 70;
									
					if($row_userOW['user_last_visit'] >= $update_time){
									
						$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$check_photo['user_id']}', from_user_id = '{$user_id}', type = '2', date = '{$server_time}', text = '{$comment}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '/photo{$check_photo['user_id']}_{$pid}_{$check_photo['album_id']}'");
									
						mozg_create_cache("user_{$check_photo['user_id']}/updates", 1);
						
					//ИНАЧЕ Добавляем +1 юзеру для оповещания				
					} else {
					
						//Добавляем +1 юзеру для оповещания
						$cntCacheNews = mozg_cache('user_'.$check_photo['user_id'].'/new_news');
						mozg_create_cache('user_'.$check_photo['user_id'].'/new_news', ($cntCacheNews+1));
					
					}
									
					//Отправка уведомления на E-mail
					if($config['news_mail_4'] == 'yes'){
						$rowUserEmail = $db->super_query("SELECT user_name, user_email FROM `".PREFIX."_users` WHERE user_id = '".$check_photo['user_id']."'");
						if($rowUserEmail['user_email']){
							include_once ENGINE_DIR.'/classes/mail.php';
							$mail = new dle_mail($config);
							$rowMyInfo = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$user_id."'");
							$rowEmailTpl = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '4'");
							$rowEmailTpl['text'] = str_replace('{%user%}', $rowUserEmail['user_name'], $rowEmailTpl['text']);
							$rowEmailTpl['text'] = str_replace('{%user-friend%}', $rowMyInfo['user_search_pref'], $rowEmailTpl['text']);
							$rowEmailTpl['text'] = str_replace('{%rec-link%}', $config['home_url'].'photo'.$check_photo['user_id'].'_'.$vid.'_'.$check_photo['album_id'], $rowEmailTpl['text']);
							$mail->send($rowUserEmail['user_email'], 'Новый комментарий к Вашей фотографии', $rowEmailTpl['text']);
						}
					}
				}
				
				//Чистим кеш кол-во комментов
				mozg_mass_clear_cache_file("user_{$check_photo['user_id']}/albums_{$check_photo['user_id']}_comm|user_{$check_photo['user_id']}/albums_{$check_photo['user_id']}_comm_all|user_{$check_photo['user_id']}/albums_{$check_photo['user_id']}_comm_friends");

				AjaxTpl();
			} else
				echo 'err_privacy';
		break;
		
		//################### Удаление комментария ###################//
		case "del_comm":
NoAjaxQuery();
$hash = $db->safesql(substr($_POST['hash'], 0, 32));
echo $hash;
$check_comment = $db->super_query("SELECT id, pid, album_id, owner_id FROM `".PREFIX."_photos_comments` WHERE hash like '%{$hash}%'");
var_dump($check_comment);
if($check_comment){
$db->query("DELETE FROM `".PREFIX."_photos_comments` WHERE hash like '%{$hash}%'");
$db->query("DELETE FROM `".PREFIX."_news` WHERE obj_id = '{$check_comment['id']}' AND action_type = 8");
$db->query("UPDATE `".PREFIX."_photos` SET comm_num = comm_num-1 WHERE id = '{$check_comment['pid']}'");
$db->query("UPDATE `".PREFIX."_albums` SET comm_num = comm_num-1 WHERE aid = '{$check_comment['album_id']}'");
//Чистим кеш кол-во комментов
mozg_mass_clear_cache_file("user_{$check_comment['owner_id']}/albums_{$check_comment['owner_id']}_comm|user_{$check_comment['owner_id']}/albums_{$check_comment['owner_id']}_comm_all|user_{$check_comment['owner_id']}/albums_{$check_comment['owner_id']}_comm_friends");
}
die();
break;
		
		//################### Помещение фотографии на свою страницу ###################//
		case "crop":
			NoAjaxQuery();
			$pid = intval($_POST['pid']);
			$i_left = intval($_POST['i_left']);
			$i_top = intval($_POST['i_top']);
			$i_width = intval($_POST['i_width']);
			$i_height = intval($_POST['i_height']);
			$check_photo = $db->super_query("SELECT photo_name, album_id FROM `".PREFIX."_photos` WHERE id = '{$pid}' AND user_id = '{$user_id}'");
			if($check_photo AND $i_width >= 100 AND $i_height >= 100 AND $i_left >= 0 AND $i_height >= 0){
				$imgInfo = explode('.', $check_photo['photo_name']);
				$newName = substr(md5($server_time.$check_photo['check_photo']), 0, 15).".".$imgInfo[1];
				$newDir = ROOT_DIR."/uploads/users/{$user_id}/";
				
				include ENGINE_DIR.'/classes/images.php';
				
				//Создаём оригинал
				$tmb = new thumbnail(ROOT_DIR."/uploads/users/{$user_id}/albums/{$check_photo['album_id']}/{$check_photo['photo_name']}");
				$tmb->size_auto($i_width."x".$i_height, 0, "{$i_left}|{$i_top}");
				$tmb->jpeg_quality(90);
				$tmb->save($newDir."o_{$newName}");
				
				//Создание главной фотографии
				$tmb = new thumbnail($newDir."o_{$newName}");
				$tmb->size_auto(200, 1);
				$tmb->jpeg_quality(100);
				$tmb->save($newDir.$newName);
				
				//Создание уменьшеной копии 50х50
				$tmb = new thumbnail($newDir."o_{$newName}");
				$tmb->size_auto('50x50');
				$tmb->jpeg_quality(100);
				$tmb->save($newDir.'50_'.$newName);
				
				//Создание уменьшеной копии 100х100
				$tmb = new thumbnail($newDir."o_{$newName}");
				$tmb->size_auto('100x100');
				$tmb->jpeg_quality(100);
				$tmb->save($newDir.'100_'.$newName);

				//Добавляем на стену
				$row = $db->super_query("SELECT user_sex FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
				if($row['user_sex'] == 2)
					$sex_text = 'обновила';
				else
					$sex_text = 'обновил';
						
				$wall_text = "<div class=\"profile_update_photo\"><a href=\"\" onClick=\"Photo.Profile(\'{$user_id}\', \'{$newName}\'); return false\"><img src=\"/uploads/users/{$user_id}/o_{$newName}\" style=\"margin-top:3px\"></a></div>";
						
				$db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$user_id}', for_user_id = '{$user_id}', text = '{$wall_text}', add_date = '{$server_time}', type = '{$sex_text} фотографию на странице:'");
				$dbid = $db->insert_id();
						
				$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$user_id}'");
						
				//Добавляем в ленту новостей
				$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 1, action_text = '{$wall_text}', obj_id = '{$dbid}', action_time = '{$server_time}'");
						
				//Обновляем имя фотки в бд
				$db->query("UPDATE `".PREFIX."_users` SET user_photo = '{$newName}', user_wall_id = '{$dbid}' WHERE user_id = '{$user_id}'");
				
				mozg_clear_cache_file("user_{$user_id}/profile_{$user_id}");
				mozg_clear_cache();
			}
			die();
		break;
		
		//################### Показ всех комментариев ###################//
		case "all_comm":
			NoAjaxQuery();
			$pid = intval($_POST['pid']);
			$num = intval($_POST['num']);
			if($num > 7){
					$limit = $num-3;
					$sql_comm = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id,text,date,id,hash,pid, tb2.user_search_pref, user_photo, user_last_visit FROM `".PREFIX."_photos_comments` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.pid = '{$pid}' ORDER by `date` ASC LIMIT 0, {$limit}", 1);
					
					$tpl->load_template('photo_comment.tpl');
					foreach($sql_comm as $row_comm){
						$tpl->set('{comment}', stripslashes($row_comm['text']));
						$tpl->set('{uid}', $row_comm['user_id']);
						$tpl->set('{id}', $row_comm['id']);
						$tpl->set('{hash}', $row_comm['hash']);
						$tpl->set('{author}', $row_comm['user_search_pref']);
						
						if($row_comm['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comm['user_id'].'/50_'.$row_comm['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						

						OnlineTpl($row_comm['user_last_visit']);
						megaDate(strtotime($row_comm['date']));
							
						$row_photo = $db->super_query("SELECT user_id FROM `".PREFIX."_photos` WHERE id = '{$row_comm['pid']}'");
						
						if($row_comm['user_id'] == $user_info['user_id'] OR $row_photo['user_id'] == $user_info['user_id']){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
						} else
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
							
							//Мне нравится
								if(stripos($row_comm['likes_users'], "u{$user_info['user_id']}|") !== false){
									$tpl->set('{yes-like}', 'public_wall_like_yes');
									$tpl->set('{yes-like-color}', 'public_wall_like_yes_color');
									$tpl->set('{like-js-function}', 'Photo.wall_remove_like('.$row_comm['id'].', '.$user_info['user_id'].')');
								} else {
									$tpl->set('{yes-like}', '');
									$tpl->set('{yes-like-color}', '');
									$tpl->set('{like-js-function}', 'Photo.wall_add_like('.$row_comm['id'].', '.$user_info['user_id'].')');
								}
								
								if($row_comm['likes_num']){
									$tpl->set('{likes}', $row_comm['likes_num']);
									$tpl->set('{likes-text}', '<span id="like_text_num'.$row_comm['id'].'">'.$row_comm['likes_num'].'</span> '.gram_record($row_comm['likes_num'], 'like'));
								} else {
									$tpl->set('{likes}', '');
									$tpl->set('{likes-text}', '<span id="like_text_num'.$row_comm['id'].'">0</span> человеку');
								}
								
								//Выводим информцию о том кто смотрит страницу для себя
								$tpl->set('{viewer-id}', $user_info['user_id']);
								if($user_info['user_photo'])
									$tpl->set('{viewer-ava}', '/uploads/users/'.$user_info['user_id'].'/50_'.$user_info['user_photo']);
								else
									$tpl->set('{viewer-ava}', '{theme}/images/no_ava_50.png');
					
						$tpl->compile('content');
					}
				AjaxTpl();
			}
		break;
		
		//################### Просмотр ПРОСТОЙ фотографии не из альбома ###################//
		case "profile":
			$uid = intval($_POST['uid']);
			
			if($_POST['type'])
				$photo = ROOT_DIR."/uploads/attach/{$uid}/c_{$_POST['photo']}";
			else
				$photo = ROOT_DIR."/uploads/users/{$uid}/o_{$_POST['photo']}";
			
			if(file_exists($photo)){
				$tpl->load_template('photos/photo_profile.tpl');
				$tpl->set('{uid}', $uid);
				if($_POST['type'])
					$tpl->set('{photo}', "/uploads/attach/{$uid}/{$_POST['photo']}");
				else
					$tpl->set('{photo}', "/uploads/users/{$uid}/o_{$_POST['photo']}");
				$tpl->set('{close-link}', $_POST['close_link']);
				$tpl->compile('content');
				AjaxTpl();
			} else
				echo 'no_photo';
		break;
		
		//################### Поворот фотографии ###################//
		case "rotation":
			$id = intval($_POST['id']);
			$row = $db->super_query("SELECT photo_name, album_id, user_id FROM `".PREFIX."_photos` WHERE id = '".$id."'");
			
			if($row['photo_name'] AND $_POST['pos'] == 'left' OR $_POST['pos'] == 'right' AND $user_id == $row['user_id']){
				$filename = ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/'.$row['photo_name'];

				if($_POST['pos'] == 'right') $degrees = -90;
				if($_POST['pos'] == 'left') $degrees = 90;

				$source = imagecreatefromjpeg($filename);
				$rotate = imagerotate($source, $degrees, 0);

				imagejpeg($rotate, ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/'.$row['photo_name'], 93);

				//Подключаем класс для фотографий
				include ENGINE_DIR.'/classes/images.php';
				
				//Создание маленькой копии
				$tmb = new thumbnail(ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/'.$row['photo_name']);
				$tmb->size_auto('140x100');
				$tmb->jpeg_quality('100');
				$tmb->save(ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/c_'.$row['photo_name']);
								
				echo '/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/'.$row['photo_name'];
			}
		break;

			//################### Ставим "Мне нравится" ###################//
		case "plike_yes":
			NoAjaxQuery();	
			$photo_id = intval($_POST['photo_id']);
			//Проверка на существование записи
			$row = $db->super_query("SELECT likes_users, user_id FROM `".PREFIX."_photos` WHERE id = '{$photo_id}'");
			if($row){
				//Проверка на то что этот юзер ставил уже мне нрав или нет
				$likes_users = explode('|', str_replace('u', '', $row['likes_users']));
				if(!in_array($user_id, $likes_users)){
					$db->query("INSERT INTO `".PREFIX."_photos_like` SET photo_id = '{$photo_id}', user_id = '{$user_id}', date = '{$server_time}'");

					$db->query("UPDATE `".PREFIX."_photos` SET likes_num = likes_num+1, likes_users = '|u{$user_id}|{$row['likes_users']}' WHERE id = '{$photo_id}'");
				}
			}

			die();
		break;
		
		//################### Удаляем "Мне нравится" ###################//
		case "plike_no":
			NoAjaxQuery();
			$photo_id = intval($_POST['photo_id']);
			//Проверка на существование записи
			$row = $db->super_query("SELECT likes_users FROM `".PREFIX."_photos` WHERE id = '{$photo_id}'");
			if($row){
				//Проверка на то что этот юзер ставил уже мне нрав или нет
				$likes_users = explode('|', str_replace('u', '', $row['likes_users']));
				if(in_array($user_id, $likes_users)){
					$db->query("DELETE FROM `".PREFIX."_photos_like` WHERE photo_id = '{$photo_id}' AND user_id = '{$user_id}'");
					$newListLikesUsers = strtr($row['likes_users'], array('|u'.$user_id.'|' => ''));
					$db->query("UPDATE `".PREFIX."_photos` SET likes_num = likes_num-1, likes_users = '{$newListLikesUsers}' WHERE id = '{$photo_id}'");					
				}
			}

			die();
		break;
		
		//################### Выводим первых 7 юзеров которые поставили "мне нравится" ###################//
		case "pliked_users":
			NoAjaxQuery();
			$photo_id = intval($_POST['photo_id']);
			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, user_search_pref, tb2.user_photo FROM `".PREFIX."_photos_like` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.photo_id = '{$photo_id}' ORDER by `date` DESC LIMIT 0, 7", 1);
			if($sql_){
				foreach($sql_ as $row){
					if($row['user_photo']) $ava = '/uploads/users/'.$row['user_id'].'/50_'.$row['user_photo'];
					else $ava = '/templates/'.$config['temp'].'/images/no_ava_50.png';
					echo '<a href="/id'.$row['user_id'].'" id="Xlike_user'.$row['user_id'].'_'.$photo_id.'" onClick="Page.Go(this.href); return false"><img src="'.$ava.'" width="32" title="'.$row['user_search_pref'].'"/></a>';
				}
			}
			die();
		break;
		
		//################### Выводим всех юзеров которые поставили "мне нравится" ###################//
		case "pall_liked_users":
			NoAjaxQuery();
			$photo_id = intval($_POST['photo_id']);
			$liked_num = intval($_POST['liked_num']);
			
			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 1000000;
			$limit_page = ($page-1)*$gcount;
			
			if(!$liked_num)
				$liked_num = 1;
			
			if($photo_id AND $liked_num){
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, tb2.user_photo, user_search_pref FROM `".PREFIX."_photos_like` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.photo_id = '{$photo_id}' ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);
				
				if($sql_){
					$tpl->load_template('profile_subscription_box_top_like.tpl');
					$tpl->set('[top]', '');
					$tpl->set('[/top]', '');
					$tpl->set('{subcr-num2}', 'Понравилось '.$liked_num.' '.gram_record($liked_num, 'like'));
					$tpl->set('{subcr-num}', $liked_num.' ');
					$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
					$tpl->compile('content');
					
					$tpl->result['content'] = str_replace('Всего', '', $tpl->result['content']);
					
					$tpl->load_template('profile_likes.tpl');
					foreach($sql_ as $row){
						if($row['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						$friend_info_online = explode(' ', $row['user_search_pref']);
						$tpl->set('{user-id}', $row['user_id']);
						$tpl->set('{name}', $row['user_search_pref']);
						$tpl->compile('content');
					}
					box_navigation($gcount, $liked_num, $photo_id, 'likephoto.pall_liked_users', $liked_num);
					
					AjaxTpl();
				}
			}
			die();
		break;
		
		default:
		
			//################### Просмотр фотографии ###################//
			NoAjaxQuery();
			$user_id = intval($_POST['uid']);
			$photo_id = intval($_POST['pid']);
			$fuser = intval($_POST['fuser']);
			$section = $_POST['section'];

			//ЧС
			$CheckBlackList = CheckBlackList($user_id);
			if(!$CheckBlackList){
				//Получаем ID альбома
				$check_album = $db->super_query("SELECT album_id FROM `".PREFIX."_photos` WHERE id = '{$photo_id}'");

				//Если фотография вызвана не со стены
				if(!$fuser AND $check_album){
				
					//Проверяем на наличии файла с позициям только для этого фоток
					$check_pos = mozg_cache('user_'.$user_id.'/position_photos_album_'.$check_album['album_id']);
		 
					//Если нету, то вызываем функцию генерации
					if(!$check_pos){
						GenerateAlbumPhotosPosition($user_id, $check_album['album_id']);
						$check_pos = mozg_cache('user_'.$user_id.'/position_photos_album_'.$check_album['album_id']);
					}
						
					$position = xfieldsdataload($check_pos);
				}

				$row = $db->super_query("SELECT tb1.id, photo_name, likes_users, likes_num, comm_num, descr, date, position, tb2.user_id, user_search_pref, user_country_city_name FROM `".PREFIX."_photos` tb1, `".PREFIX."_users` tb2 WHERE id = '{$photo_id}' AND tb1.user_id = tb2.user_id");
				
				if($row){
					//Вывод названия альбома, приватноть из БД
					$info_album = $db->super_query("SELECT name, privacy FROM `".PREFIX."_albums` WHERE aid = '{$check_album['album_id']}'");
					$album_privacy = explode('|', $info_album['privacy']);
					
					//Проверка естьли запрашиваемый юзер в друзьях у юзера который смотрит стр
					if($user_info['user_id'] != $row['user_id'])
						$check_friend = CheckFriends($row['user_id']);

					//Приватность
					if($album_privacy[0] == 1 OR $album_privacy[0] == 2 AND $check_friend OR $user_info['user_id'] == $row['user_id']){
				
						//Если фотография вызвана не со стены
						if(!$fuser){
							$exp_photo_num = count(explode('||', $check_pos));
							$row_album['photo_num'] = $exp_photo_num-1;
						}

						//Выводим комментарии если они есть
						if($row['comm_num'] > 0){
							$tpl->load_template('photo_comment.tpl');
								
							if($row['comm_num'] > 7)
								$limit_comm = $row['comm_num']-3;
							else
								$limit_comm = 0;
								
							$sql_comm = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id,text,date,id,hash, tb2.user_search_pref, user_photo, user_last_visit, likes_users, likes_num FROM `".PREFIX."_photos_comments` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.pid = '{$photo_id}' ORDER by `date` ASC LIMIT {$limit_comm}, {$row['comm_num']}", 1);
							foreach($sql_comm as $row_comm){
								$tpl->set('{comment}', stripslashes($row_comm['text']));
								$tpl->set('{uid}', $row_comm['user_id']);
								$tpl->set('{id}', $row_comm['id']);
								$tpl->set('{hash}', $row_comm['hash']);
								$tpl->set('{author}', $row_comm['user_search_pref']);
									
								if($row_comm['user_photo'])
									$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comm['user_id'].'/50_'.$row_comm['user_photo']);
								else
									$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
										
								OnlineTpl($row_comm['user_last_visit']);
								megaDate(strtotime($row_comm['date']));
									
								if($row_comm['user_id'] == $user_info['user_id'] OR $row['user_id'] == $user_info['user_id']){
									$tpl->set('[owner]', '');
									$tpl->set('[/owner]', '');
								} else 
									$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
									
								//Мне нравится
								if(stripos($row_comm['likes_users'], "u{$user_info['user_id']}|") !== false){
									$tpl->set('{yes-like}', 'public_wall_like_yes');
									$tpl->set('{yes-like-color}', 'public_wall_like_yes_color');
									$tpl->set('{like-js-function}', 'Photo.wall_remove_like('.$row_comm['id'].', '.$user_info['user_id'].')');
								} else {
									$tpl->set('{yes-like}', '');
									$tpl->set('{yes-like-color}', '');
									$tpl->set('{like-js-function}', 'Photo.wall_add_like('.$row_comm['id'].', '.$user_info['user_id'].')');
								}
								
								if($row_comm['likes_num']){
									$tpl->set('{likes}', $row_comm['likes_num']);
									$tpl->set('{likes-text}', '<span id="like_text_num'.$row_comm['id'].'">'.$row_comm['likes_num'].'</span> '.gram_record($row_comm['likes_num'], 'like'));
								} else {
									$tpl->set('{likes}', '');
									$tpl->set('{likes-text}', '<span id="like_text_num'.$row_comm['id'].'">0</span> человеку');
								}															
								
								//Выводим информцию о том кто смотрит страницу для себя
								$tpl->set('{viewer-id}', $user_info['user_id']);
								if($user_info['user_photo'])
									$tpl->set('{viewer-ava}', '/uploads/users/'.$user_info['user_id'].'/50_'.$user_info['user_photo']);
								else
									$tpl->set('{viewer-ava}', '{theme}/images/no_ava_50.png');
							
								$tpl->compile('comments');
							}
						}

						//Сама фотография
						$tpl->load_template('photo_view.tpl');
						$tpl->set('{photo}', $config['home_url'].'uploads/users/'.$row['user_id'].'/albums/'.$check_album['album_id'].'/'.$row['photo_name'].'?'.$server_time);
						$tpl->set('{descr}', stripslashes($row['descr']));
						$row_album = $db->super_query("SELECT user_id, name, photo_num, privacy, system FROM `".PREFIX."_albums` WHERE aid = '{$check_album['album_id']}'");
						$tpl->set('{photo-num}', $row_album['photo_num']);
						if($row_album['system'] == 0){
						$tpl->set('[system]', '');
						$tpl->set('[/system]', '');
						}else
						$tpl->set_block("'\\[system\\](.*?)\\[/system\\]'si","");
						
						if($row['photo_name'] != $user_info['user_photo']){
						$tpl->set('[del]', '');
						$tpl->set('[/del]', '');
						}else
						$tpl->set_block("'\\[del\\](.*?)\\[/del\\]'si","");
						
						$tpl->set('{photo-id}', $row['id']);
						
						//Мне нравится
			if(stripos($row['likes_users'], "u{$user_info['user_id']}|") !== false){
				$tpl->set('{pyes-like}', 'public_wall_like_yes');
				$tpl->set('{pyes-like-color}', 'public_wall_like_yes_color');
				$tpl->set('{plike-js-function}', 'likephoto.wall_remove_like('.$row['id'].', '.$user_info['user_id'].', \'uPages\')');
			} else {
				$tpl->set('{pyes-like}', '');
				$tpl->set('{pyes-like-color}', '');
				$tpl->set('{plike-js-function}', 'likephoto.wall_add_like('.$row['id'].', '.$user_info['user_id'].', \'uPages\')');
			}

			if($row['likes_num']){
				$tpl->set('{plikes}', $row['likes_num']);
				$tpl->set('{plikes-text}', '<span id="like_text_num'.$row['id'].'">'.$row['likes_num'].'</span> '.gram_record($row['likes_num'], 'like'));
			} else {
				$tpl->set('{plikes}', '');
				$tpl->set('{plikes-text}', '<span id="like_text_num'.$row['id'].'">0</span> человеку');
			}
			
						//Выводим информцию о том кто смотрит страницу для себя
								$tpl->set('{viewer-id}', $user_info['user_id']);
								if($user_info['user_photo'])
									$tpl->set('{viewer-ava}', '/uploads/users/'.$user_info['user_id'].'/50_'.$user_info['user_photo']);
								else
									$tpl->set('{viewer-ava}', '{theme}/images/no_ava_50.png');
						
						$tpl->set('{id}', $row['id']);
						$tpl->set('{aid}', $check_album['album_id']);
						$tpl->set('{album-name}', stripslashes($info_album['name']));
						$tpl->set('{uid}', $row['user_id']);
							
						//Составляем адрес строки который будет после закрытия и опридиляем секцию
						if($section == 'all_comments'){
							$tpl->set('{close-link}', '/albums/comments/'.$row['user_id']);
							$tpl->set('{section}', '_sec=all_comments');
						} elseif($section == 'album_comments'){
							$tpl->set('{close-link}', '/albums'.$check_album['album_id'].'/comments/');
							$tpl->set('{section}', '_'.$check_album['album_id'].'_sec=album_comments');
						} elseif($section == 'user_page'){
							$tpl->set('{close-link}', '/id'.$row['user_id']);
							$tpl->set('{section}', '_sec=user_page');
						} elseif($section == 'wall'){
							$tpl->set('{close-link}', '/id'.$fuser);
							$tpl->set('{section}', '_sec=wall/fuser='.$fuser);
						} elseif($section == 'notes'){
							$tpl->set('{close-link}', '/notes/view/'.$fuser);
							$tpl->set('{section}', '_sec=notes/id='.$fuser);
						} elseif($section == 'loaded'){
							$tpl->set('{close-link}', '/albums/add/'.$check_album['album_id']);
							$tpl->set('{section}', '_sec=loaded');
						} elseif($section == 'news'){
							$fuser = 1;
							$tpl->set('{close-link}', '/feed&section=photos');
							$tpl->set('{section}', '_sec=news');
						} elseif($section == 'msg'){
							$tpl->set('{close-link}', '/messages/show/'.$fuser);
							$tpl->set('{section}', '_sec=msg');
						} elseif($section == 'newphotos'){
							$tpl->set('{close-link}', '/albums/newphotos');
							$tpl->set('{section}', '_'.$check_album['album_id'].'_sec=newphotos');
						} else {
							$tpl->set('{close-link}', '/album'.$check_album['album_id']);
							$tpl->set('{section}', '_'.$check_album['album_id']);
						}
							
						if(!$fuser){
							$tpl->set('[all]', '');
							$tpl->set('[/all]', '');
							$tpl->set_block("'\\[wall\\](.*?)\\[/wall\\]'si","");
						} else {
							$tpl->set('[wall]', '');
							$tpl->set('[/wall]', '');
							$tpl->set_block("'\\[all\\](.*?)\\[/all\\]'si","");
						}
											
						$tpl->set('{jid}', $row['position']);
						$tpl->set('{comm_num}', ($row['comm_num']-3).' '.gram_record(($row['comm_num']-3), 'comments'));
						$tpl->set('{num}', $row['comm_num']);

						$tpl->set('{author}', $row['user_search_pref']);
						$author_info = explode('|', $row['user_country_city_name']);
						
						if($author_info[0]) $tpl->set('{author-info}', $author_info[0]); 
						else $tpl->set('{author-info}', '');
						if($author_info[1]) $tpl->set('{author-info}', $author_info[0].', '.$author_info[1].'<br />');

						megaDate(strtotime($row['date']), 1, 1);

						if($user_id == $user_info['user_id']){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
						} else 
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");

						$tpl->set('{comments}', $tpl->result['comments']);
							
						//Показываем стрелочки если фотографий больше одной и фотография вызвана не со стены
						if($row_album['photo_num'] > 1 && !$fuser){
							
							//Если фотография вызвана из альбом "все фотографии" или вызвана со страницы юзера
							if($row['position'] == $row_album['photo_num'])
								$next_photo = $position[1];
							else
								$next_photo = $position[($row['position']+1)];
									
							if($row['position'] == 1)
								$prev_photo = $position[($row['position']+$row_album['photo_num']-1)];
							else
								$prev_photo = $position[($row['position']-1)];

							$tpl->set('{next-id}', $next_photo);
							$tpl->set('{prev-id}', $prev_photo);
						} else {
							$tpl->set('{next-id}', $row['id']);
							$tpl->set('{prev-id}', $row['id']);
						}

						if($row['comm_num'] < 8){
							$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
						} else {
							$tpl->set('[all-comm]', '');
							$tpl->set('[/all-comm]', '');
						}
							
						//Приватность комментариев
						if($album_privacy[1] == 1 OR $album_privacy[1] == 2 AND $check_friend OR $user_info['user_id'] == $row['user_id']){
							$tpl->set('[add-comm]', '');
							$tpl->set('[/add-comm]', '');
						} else
							$tpl->set_block("'\\[add-comm\\](.*?)\\[/add-comm\\]'si","");
							
						//Выводим отмеченых людей на фото если они есть
						$sql_mark = $db->super_query("SELECT SQL_CALC_FOUND_ROWS muser_id, mphoto_name, msettings_pos, mmark_user_id, mapprove FROM `".PREFIX."_photos_mark` WHERE mphoto_id = '".$photo_id."' ORDER by `mdate` ASC", 1, 'photos_mark/p'.$photo_id);
						if($sql_mark){
							$cnt_mark = 0;
							$mark_peoples .= '<div class="fl_l" id="peopleOnPhotoText'.$photo_id.'" style="margin-right:5px">На этой фотографии:</div>';
							foreach($sql_mark as $row_mark){
								$cnt_mark++;
								
								if($cnt_mark != 1) $comma = ', ';
								else $comma = '';

								if($row_mark['muser_id'] AND $row_mark['mphoto_name'] == ''){
									if($row['user_id'] == $user_info['user_id'] OR $user_info['user_id'] == $row_mark['muser_id'] OR $user_info['user_id'] == $row_mark['mmark_user_id'])
										$del_mark_link = '<div class="fl_l"><img src="/templates/Default/images/hide_lef.gif" class="distin_del_user" title="Удалить отметку" onclick="Distinguish.DeletUser('.$row_mark['muser_id'].', '.$photo_id.')"/></div>';
									else
										$del_mark_link = '';
										
									$row_user = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$row_mark['muser_id']."'");
									
									if($row_mark['mapprove'] OR $row['user_id'] == $user_info['user_id'] OR $user_info['user_id'] == $row_mark['mmark_user_id'] OR $row_mark['muser_id'] == $user_info['user_id']){
										$user_link = '<a href="/u'.$row_mark['muser_id'].'" id="selected_us_'.$row_mark['muser_id'].$photo_id.'" onclick="Page.Go(this.href); return false" onmouseover="Distinguish.ShowTag('.$row_mark['msettings_pos'].', '.$photo_id.')" onmouseout="Distinguish.HideTag('.$photo_id.')" class="one_dis_user'.$photo_id.'">';
										$user_link_end = '</a>';
									} else {
										$user_link = '<span style="color:#000" id="selected_us_'.$row_mark['muser_id'].$photo_id.'" onmouseover="Distinguish.ShowTag('.$row_mark['msettings_pos'].', '.$photo_id.')" onmouseout="Distinguish.HideTag('.$photo_id.')" class="one_dis_user'.$photo_id.'">';
										$user_link_end = '</span>';
									}
									
									$mark_peoples .= '<span id="selectedDivIser'.$row_mark['muser_id'].$photo_id.'"><div class="fl_l" style="margin-right:4px">'.$comma.'</div><div class="fl_l"> '.$user_link.$row_user['user_search_pref'].$user_link_end.'</div>'.$del_mark_link.'</span>';
								} else {
									if($row['user_id'] == $user_info['user_id'] OR $user_info['user_id'] == $row_mark['mmark_user_id'])
										$del_mark_link = '<div class="fl_l"><img src="/templates/Default/images/hide_lef.gif" class="distin_del_user" title="Удалить отметку" onclick="Distinguish.DeletUser('.$row_mark['muser_id'].', '.$photo_id.', \''.$row_mark['mphoto_name'].'\')"/></div>';
									else
										$del_mark_link = '';
										
									$mark_peoples .= '<span id="selectedDivIser'.$row_mark['muser_id'].$photo_id.'"><div class="fl_l" style="margin-right:4px">'.$comma.'</div><div class="fl_l"><span style="color:#000" id="selected_us_'.$row_mark['muser_id'].$photo_id.'" onmouseover="Distinguish.ShowTag('.$row_mark['msettings_pos'].', '.$photo_id.')" onmouseout="Distinguish.HideTag('.$photo_id.')" class="one_dis_user'.$photo_id.'">'.$row_mark['mphoto_name'].'</span></div>'.$del_mark_link.'</span>';
								}
								
								//Если человек отмечен но не потвердил
								if(!$row_mark['mapprove'] AND $row_mark['muser_id'] == $user_info['user_id']){
									$row_mmark_user_id = $db->super_query("SELECT user_search_pref, user_sex FROM `".PREFIX."_users` WHERE user_id = '".$row_mark['mmark_user_id']."'");
									if($row_mmark_user_id['user_sex'] == 1) $approve_mark_gram_text = 'отметил';
									else $approve_mark_gram_text = 'отметила';
									$approve_mark = $row_mmark_user_id['user_search_pref'];
									$approve_mark_user_id = $row_mark['mmark_user_id'];
									$approve_mark_del_link = 'Distinguish.DeletUser('.$row_mark['muser_id'].', '.$photo_id.', \''.$row_mark['mphoto_name'].'\')';
								} else {
									$approve_mark = '';
									$approve_mark_gram_text = '';
									$approve_mark_user_id = '';
								}
							}
						}
						$tpl->set('{mark-peoples}', $mark_peoples);
						if($approve_mark){
							$tpl->set('{mark-user-name}', $approve_mark);
							$tpl->set('{mark-gram-text}', $approve_mark_gram_text);
							$tpl->set('{mark-user-id}', $approve_mark_user_id);
							$tpl->set('{mark-del-link}', $approve_mark_del_link);
							$tpl->set('[mark-block]', '');
							$tpl->set('[/mark-block]', '');
						} else
							$tpl->set_block("'\\[mark-block\\](.*?)\\[/mark-block\\]'si","");						
						
						$tpl->compile('content');
							
						AjaxTpl();
							
						if($config['gzip'] == 'yes')
							GzipOut();
					} else
						echo 'err_privacy';
				} else
					echo 'no_photo';
			} else
				echo 'err_privacy';
	}
	$tpl->clear();
	$db->free();
} else
	echo 'no_photo';

die();
?>