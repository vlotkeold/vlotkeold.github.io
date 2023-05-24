<?php
/* 
	Appointment: Подарки
	File: gifts.php 
	Данный код защищен авторскими правами
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];

	switch($act){
		
		//################### Страница всех подарков ###################//
		case "view":
			NoAjaxQuery();
			$for_user_id = intval($_POST['user_id']);
			
			$section = intval($_POST['section']);
			if(!$section) $section = 1;
			
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS gid, img, price FROM `".PREFIX."_gifts_list` WHERE category = '{$section}' ORDER by `gid` DESC", 1);
		
				if(!$_POST['section']) $tpl->load_template('gifts/gifts_box.tpl');
			
				foreach($sql_ as $gift){
					$gift_list .= "<a class=\"gift_cell fl_l\" onmouseover=\"gifts.showGiftPrice('{$gift['gid']}','{$gift['price']} голос')\" onmouseout=\"gifts.hideGiftPrice()\" onClick=\"gifts.select('{$gift['img']}', '{$for_user_id}'); return false\" id=\"gift_{$gift['gid']}\"><img class=\"gift_img\" src=\"/uploads/gifts/{$gift['img']}.png\" width=\"96\" height=\"96\"></a>";
				}
				
				if(!$_POST['section']) {
					$row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
					$tpl->set('{balance}', 'У вас <b>'.$row['user_balance'].' '.gram_record($row['user_balance'], 'votes').'</b>');
					$tpl->set('{top}', '50');
					$tpl->set('{gifts}', $gift_list);
					$tpl->set('{from}', $for_user_id);
					$tpl->compile('content');
				} else echo $gift_list;

			AjaxTpl();
			die();
		break;
		
		//################### Отправка подарка в БД ###################//
		case "send":
			NoAjaxQuery();
			$for_user_id = intval($_POST['for_user_id']);
			$gift = intval($_POST['gift']);
			$privacy = intval($_POST['privacy']);
			if($privacy == 0) $privacy = 1;
			else if($privacy == 1) $privacy = 2;
			else $privacy = 1;
			$msg = ajax_utf8(textFilter($_POST['msg']));
			$gifts = $db->super_query("SELECT price FROM `".PREFIX."_gifts_list` WHERE img = '".$gift."'");
			$str_date = time();
			
			//Выводим текущий баланс свой
			$row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			if($gifts['price'] AND $user_id != $for_user_id){
				if($row['user_balance'] >= $gifts['price']){
					//Отправляем сообщение получателю
					$db->query("INSERT INTO `".PREFIX."_messages` SET theme = 'Подарок', text = '<b>Подарок</b><center><img src=\"/uploads/gifts/{$gift}.jpg\"></center>', for_user_id = '{$for_user_id}', from_user_id = '{$user_id}', date = '{$server_time}', pm_read = 'no', folder = 'inbox', history_user_id = '{$user_id}'");
					$dbid = $db->insert_id();

					//Сохраняем сообщение в папку отправленные
					$db->query("INSERT INTO `".PREFIX."_messages` SET theme = 'Подарок', text = '<b>Подарок</b><center><img src=\"/uploads/gifts/{$gift}.jpg\"></center>', for_user_id = '{$user_id}', from_user_id = '{$for_user_id}', date = '{$server_time}', pm_read = 'no', folder = 'outbox', history_user_id = '{$user_id}'");

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
							
					$db->query("INSERT INTO `".PREFIX."_gifts` SET uid = '{$for_user_id}', gift = '{$gift}', msg = '{$msg}', privacy = '{$privacy}', gdate = '{$str_date}', from_uid = '{$user_id}', status = 1");
					$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance-{$gifts['price']} WHERE user_id = '{$user_id}'");
					$db->query("UPDATE `".PREFIX."_users` SET user_gifts = user_gifts+1 WHERE user_id = '{$for_user_id}'");
					
						//Вставляем событие в моментальные оповещания
						$row_owner = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$for_user_id}'");
						$update_time = $server_time - 70;

						if($row_owner['user_last_visit'] >= $update_time){

							$action_update_text = "<img src=\"/uploads/gifts/{$gift}.png\" align=\"right\" width=\"50\">";
	
							$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$for_user_id}', from_user_id = '{$user_info['user_id']}', type = '7', date = '{$str_date}', text = '{$action_update_text}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '/gifts{$user_info['user_id']}'");

							mozg_create_cache("user_{$for_user_id}/updates", 1);

							}
					
					//Добавляем +1 юзеру для оповещания
					$cntCacheNews = mozg_cache("user_{$for_user_id}/new_gift");
					mozg_create_cache("user_{$for_user_id}/new_gift", ($cntCacheNews+1));
					
					mozg_mass_clear_cache_file("user_{$for_user_id}/profile_{$for_user_id}|user_{$for_user_id}/gifts");
					
					//Отправка уведомления на E-mail
					if($config['news_mail_6'] == 'yes'){
						$rowUserEmail = $db->super_query("SELECT user_name, user_email FROM `".PREFIX."_users` WHERE user_id = '".$for_user_id."'");
						if($rowUserEmail['user_email']){
							include_once ENGINE_DIR.'/classes/mail.php';
							$mail = new dle_mail($config);
							$rowMyInfo = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$user_id."'");
							$rowEmailTpl = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '6'");
							$rowEmailTpl['text'] = str_replace('{%user%}', $rowUserEmail['user_name'], $rowEmailTpl['text']);
							$rowEmailTpl['text'] = str_replace('{%user-friend%}', $rowMyInfo['user_search_pref'], $rowEmailTpl['text']);
							$rowEmailTpl['text'] = str_replace('{%rec-link%}', $config['home_url'].'gifts'.$for_user_id, $rowEmailTpl['text']);
							$mail->send($rowUserEmail['user_email'], 'Вам отправили новый подарок', $rowEmailTpl['text']);
						}
					}		
				} else
					echo '1';
			}
			die();
		break;
		
		case "update":
			NoAjaxQuery();
			$for_user_id = intval($_POST['for_user_id']);
			$last_id = intval($_POST['last_id']);
			$sess_last_id = mozg_cache('user_'.$user_id.'/im');
				$typograf = mozg_cache("user_{$user_id}/typograf{$for_user_id}");
			if($typograf) echo "<script>$('#im_typograf').fadeIn()</script>";
			if($last_id == $sess_last_id){
				echo 'no_new';
				die();
			}

			$count = $db->super_query("SELECT msg_num, all_msg_num FROM `".PREFIX."_im` WHERE iuser_id = '".$user_id."' AND im_user_id = '".$for_user_id."'");
			if($count['all_msg_num'] > 20)
				$limit = $count['all_msg_num']-20;
			else
				$limit = 0;

			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.id, text, date, pm_read, folder, history_user_id, from_user_id, attach, tell_uid, tell_date, public, tell_comm, tb2.user_name, user_photo FROM `".PREFIX."_messages` tb1, `".PREFIX."_users` tb2 WHERE tb1.for_user_id = '{$user_id}' AND tb1.from_user_id = '{$for_user_id}' AND tb1.history_user_id = tb2.user_id ORDER by `date` ASC LIMIT ".$limit.", 20", 1);
			
			mozg_create_cache('user_'.$user_id.'/im', $last_id);
			
			if($sql_){
				$tpl->load_template('im/msg.tpl');
				foreach($sql_ as $row){
					$tpl->set('{name}', $row['user_name']);
					$tpl->set('{folder}', $row['folder']);
					$tpl->set('{user-id}', $row['history_user_id']);
					$tpl->set('{msg-id}', $row['id']);
					if(date('Y-m-d', $row['date']) == date('Y-m-d', $server_time)) $tpl->set('{date}', langdate('H:i:s', $row['date']));
					else $tpl->set('{date}', langdate('d.m.y', $row['date']));
					if($row['user_photo']) $tpl->set('{ava}', '/uploads/users/'.$row['history_user_id'].'/50_'.$row['user_photo']);
					else $tpl->set('{ava}', '{theme}/images/no_ava_50.png');
					if($row['pm_read'] == 'no'){
						$tpl->set('{new}', 'im_class_new');
						$tpl->set('{read-js-func}', 'onMouseOver="im.read(\''.$row['id'].'\', '.$row['history_user_id'].', '.$user_id.')"');
					} else {
						$tpl->set('{new}', '');
						$tpl->set('{read-js-func}', '');
					}
					
					//Прикрипленные файлы
					if($row['attach']){
						$attach_arr = explode('||', $row['attach']);
						$cnt_attach = 1;
						$cnt_attach_link = 1;
						$jid = 0;
						$attach_result = '';
						foreach($attach_arr as $attach_file){
							$attach_type = explode('|', $attach_file);

							//Фото со стены сообщества
							if($attach_type[0] == 'photo' AND file_exists(ROOT_DIR."/uploads/groups/{$row['tell_uid']}/photos/c_{$attach_type[1]}")){
								
								$size = getimagesize(ROOT_DIR."/uploads/groups/{$row['tell_uid']}/photos/c_{$attach_type[1]}");
								
								$attach_result .= "<div class=\"mgclr\"></div><img id=\"photo_wall_{$row['id']}_{$cnt_attach}\" src=\"/uploads/groups/{$row['tell_uid']}/photos/c_{$attach_type[1]}\" {$size[3]} style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row['id']}', '{$row['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row['id']}\" />";
								
								$cnt_attach++;
								
								$resLinkTitle = '';
								
							//Фото со стены юзера
							} elseif($attach_type[0] == 'photo_u'){
								if($row['tell_uid']) $attauthor_user_id = $row['tell_uid'];
								elseif($row['history_user_id'] == $user_id) $attauthor_user_id = $user_id;
								else $attauthor_user_id = $row['from_user_id'];

								if($attach_type[1] == 'attach' AND file_exists(ROOT_DIR."/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}")){
									
									$size = getimagesize(ROOT_DIR."/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}");
									
									$attach_result .= "<div class=\"mgclr\"></div><img id=\"photo_wall_{$row['id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}\" {$size[3]} style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row['id']}', '', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row['id']}\" />";
										
									$cnt_attach++;
									
								} elseif(file_exists(ROOT_DIR."/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}")){

									$size = getimagesize(ROOT_DIR."/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}");
									
									$attach_result .= "<div class=\"mgclr\"></div><img id=\"photo_wall_{$row['id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}\" {$size[3]} style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"groups.wall_photo_view('{$row['id']}', '', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row['id']}\" />";
										
									$cnt_attach++;
								}

								$resLinkTitle = '';
								
							//Видео
							} elseif($attach_type[0] == 'video' AND file_exists(ROOT_DIR."/uploads/videos/{$attach_type[3]}/{$attach_type[1]}")){
							
								$size = getimagesize(ROOT_DIR."/uploads/videos/{$attach_type[3]}/{$attach_type[1]}");
								
								$attach_result .= "<div><a href=\"/video{$attach_type[3]}_{$attach_type[2]}\" onClick=\"videos.show({$attach_type[2]}, this.href, location.href); return false\"><img src=\"/uploads/videos/{$attach_type[3]}/{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" {$size[3]} align=\"left\" /></a></div>";
								
								$resLinkTitle = '';
								
							//Музыка
							} elseif($attach_type[0] == 'audio'){
								$audioId = intval($attach_type[1]);
								$audioInfo = $db->super_query("SELECT artist, name, url FROM `".PREFIX."_audio` WHERE aid = '".$audioId."'");
								if($audioInfo){
									$jid++;
									$attach_result .= '<div class="audioForSize'.$row['id'].' player_mini_mbar_wall_all2" id="audioForSize" style="width:440px"><div class="audio_onetrack audio_wall_onemus" style="width:440px"><div class="audio_playic cursor_pointer fl_l" onClick="music.newStartPlay(\''.$jid.'\', '.$row['id'].')" id="icPlay_'.$row['id'].$jid.'"></div><div id="music_'.$row['id'].$jid.'" data="'.$audioInfo['url'].'" class="fl_l" style="margin-top:-1px"><a href="/?go=search&type=5&query='.$audioInfo['artist'].'" onClick="Page.Go(this.href); return false"><b>'.stripslashes($audioInfo['artist']).'</b></a> &ndash; '.stripslashes($audioInfo['name']).'</div><div id="play_time'.$row['id'].$jid.'" class="color777 fl_r no_display" style="margin-top:2px;margin-right:5px">00:00</div><div class="player_mini_mbar fl_l no_display player_mini_mbar_wall player_mini_mbar_wall_all2" id="ppbarPro'.$row['id'].$jid.'" style="width:442px"></div></div></div>';
								}
								
								$resLinkTitle = '';

							//Смайлик
							} elseif($attach_type[0] == 'smile' AND file_exists(ROOT_DIR."/uploads/smiles/{$attach_type[1]}")){
								$attach_result .= '<img src=\"/uploads/smiles/'.$attach_type[1].'\" style="margin-right:5px" />';
								
								$resLinkTitle = '';
								
							//Стикер
							} elseif($attach_type[0] == 'stiker' AND file_exists(ROOT_DIR."/uploads/stiker/{$attach_type[1]}")){
								$attach_result .= '<img src=\"/uploads/stiker/'.$attach_type[1].'\" style="margin-right:5px" />';
								
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

									$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div><div class="clear"></div><div class="wall_show_block_link" style="border:0px"><a href="/away.php?url='.$attach_type[1].'" target="_blank"><div style="width:108px;height:80px;float:left;text-align:center"><img src="'.$attach_type[4].'" /></div></a><div class="attatch_link_title"><a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$str_title.'</a></div><div style="max-height:50px;overflow:hidden">'.$attach_type[3].'</div></div></div>';

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
									
									$attach_result .= '<div style="margin-top:5px;margin-bottom:5px" class="clear"><div class="doc_attach_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">Файл <a href="/index.php?go=doc&act=download&did='.$doc_id.'" target="_blank" onMouseOver="myhtml.title(\''.$doc_id.$cnt_attach.$row['id'].'\', \'<b>Размер файла: '.$row_doc['dsize'].'</b>\', \'doc_\')" id="doc_'.$doc_id.$cnt_attach.$row['id'].'">'.$row_doc['dname'].'</a></div></div></div><div class="clear"></div>';
										
									$cnt_attach++;
								}
							
							//Если опрос
							} elseif($attach_type[0] == 'vote'){
							
								$vote_id = intval($attach_type[1]);
								
								$row_vote = $db->super_query("SELECT title, answers, answer_num FROM `".PREFIX."_votes` WHERE id = '{$vote_id}'", false, "votes/vote_{$vote_id}");
								
								if($vote_id){

									$checkMyVote = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE user_id = '{$user_id}' AND vote_id = '{$vote_id}'", false, "votes/check{$user_id}_{$vote_id}");
									
									$row_vote['title'] = stripslashes($row_vote['title']);
									
									if(!$row['text'])
										$row['text'] = $row_vote['title'];

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
						
						if($resLinkTitle AND $row['text'] == $resLinkUrl OR !$row['text'])
							$row['text'] = $resLinkTitle.'<div class="clear"></div>'.$attach_result;
						else if($attach_result)
							$row['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row['text']).$attach_result;
						else
							$row['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row['text']);
							
					} else
						$row['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row['text']);

					$resLinkTitle = '';
					
					//Если это запись с "рассказать друзьям"
					if($row['tell_uid']){
						if($row['public'])
							$rowUserTell = $db->super_query("SELECT title, photo FROM `".PREFIX."_communities` WHERE id = '{$row['tell_uid']}'");
						else
							$rowUserTell = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$row['tell_uid']}'");

						if(date('Y-m-d', $row['tell_date']) == date('Y-m-d', $server_time))
							$dateTell = langdate('сегодня в H:i', $row['tell_date']);
						elseif(date('Y-m-d', $row['tell_date']) == date('Y-m-d', ($server_time-84600)))
							$dateTell = langdate('вчера в H:i', $row['tell_date']);
						else
							$dateTell = langdate('j F Y в H:i', $row['tell_date']);
						
						if($row['public']){
							$rowUserTell['user_search_pref'] = stripslashes($rowUserTell['title']);
							$tell_link = 'public';
							if($rowUserTell['photo'])
								$avaTell = '/uploads/groups/'.$row['tell_uid'].'/50_'.$rowUserTell['photo'];
							else
								$avaTell = '{theme}/images/no_ava_50.png';
						} else {
							$tell_link = 'u';
							if($rowUserTell['user_photo'])
								$avaTell = '/uploads/users/'.$row['tell_uid'].'/50_'.$rowUserTell['user_photo'];
							else
								$avaTell = '{theme}/images/no_ava_50.png';
						}

						$row['text'] = <<<HTML
{$row['tell_comm']}
<div class="wall_repost_border">
<div class="wall_tell_info"><div class="wall_tell_ava"><a href="/{$tell_link}{$row['tell_uid']}" onClick="Page.Go(this.href); return false"><img src="{$avaTell}" width="30" /></a></div><div class="wall_tell_name"><a href="/{$tell_link}{$row['tell_uid']}" onClick="Page.Go(this.href); return false"><b>{$rowUserTell['user_search_pref']}</b></a></div><div class="wall_tell_date">{$dateTell}</div></div>{$row['text']}
<div class="clear"></div>
</div>
HTML;
					}
					
					$tpl->set('{text}', stripslashes($row['text']));
					
					$tpl->compile('content');
				}
				
				AjaxTpl();
				
			}
				
			die();
		break;
		
		case "upDialogs":
			NoAjaxQuery();
			$update = mozg_cache('user_'.$user_id.'/im_update');
			
			if($update){
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.msg_num, im_user_id FROM `".PREFIX."_im` tb1, `".PREFIX."_users` tb2 WHERE tb1.iuser_id = '".$user_id."' AND tb1.im_user_id = tb2.user_id AND msg_num > 0 ORDER by `idate` DESC LIMIT 0, 50", 1);
				foreach($sql_ as $row){
					$res .= '$("#upNewMsg'.$row['im_user_id'].'").html(\''.$row['msg_num'].'\').show();';
				}

				if($user_info['user_pm_num']){
					$user_pm_num_2 = "+".$user_info['user_pm_num'];
					$doc_title = 'document.title = \''.$user_info['user_pm_num'].' Новые сообщения\';';
				} else {
					$doc_title = 'document.title = \'Диалоги\';';
					mozg_create_cache('user_'.$user_id.'/im_update', '0');
				}
		
				if($user_pm_num_2) {echo '<script type="text/javascript">
				'.$doc_title.'
				$(\'#new_msg\').html(\''.$user_pm_num_2.'\');
				'.$res.'
				</script>';}
				else {echo '<script type="text/javascript">
				'.$doc_title.'
				$(\'#new_msg\').html(\'+\');
				'.$res.'
				</script>';}
			}
			die();
		break;
		
		//################### Удаление подарка ###################//
		case "delet":
				NoAjaxQuery();
			
			$gid = intval($_POST['gid']);
			$folders = $db->safesql($_POST['folders']);
			
			if($folder == 'inbox')
				$folder = 'inbox';
			else
				$folder = 'outbox';
			
			$row = $db->super_query("SELECT uid FROM `".PREFIX."_gifts` WHERE gid = '{$gid}'");
			die();
		break;
		
		//################### Удаление подарка ###################//
		case "del":
			NoAjaxQuery();
			$gid = intval($_POST['gid']);
			$row = $db->super_query("SELECT uid FROM `".PREFIX."_gifts` WHERE gid = '{$gid}'");
			if($user_id == $row['uid']){
				$db->query("DELETE FROM `".PREFIX."_gifts` WHERE gid = '{$gid}'");
				$db->query("UPDATE `".PREFIX."_users` SET user_gifts = user_gifts-1 WHERE user_id = '{$user_id}'");
				mozg_mass_clear_cache_file("user_{$user_id}/profile_{$user_id}|user_{$user_id}/gifts");
			}
			die();
		break;
		
		case "view_ajax":

			$uid = intval($_POST['uid']);
			
			if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
			$gcount = 15;
			$limit_page = ($page-1)*$gcount;
			
			$owner = $db->super_query("SELECT user_name, user_gifts FROM `".PREFIX."_users` WHERE user_id = '{$uid}'");
			
			$tpl->load_template('gifts/head_ajax.tpl');
			$tpl->set('{uid}', $uid);
			if($user_id == $uid){
				$tpl->set('[owner]', '');
				$tpl->set('[/owner]', '');
				$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
			} else {
				$tpl->set('[not-owner]', '');
				$tpl->set('[/not-owner]', '');
				$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
			}
			$tpl->set('{name}', gramatikName($owner['user_name']));
			$tpl->set('{gifts-num}', '<span id="num">'.$owner['user_gifts'].'</span> '.gram_record($owner['user_gifts'], 'gifts'));
			if($owner['user_gifts']){
				$tpl->set('[yes]', '');
				$tpl->set('[/yes]', '');
				$tpl->set_block("'\\[no\\](.*?)\\[/no\\]'si","");
			} else {
				$tpl->set('[no]', '');
				$tpl->set('[/no]', '');
				$tpl->set_block("'\\[yes\\](.*?)\\[/yes\\]'si","");
			}

			if($_GET['new'] AND $user_id == $uid){
				$tpl->set('[new]', '');
				$tpl->set('[/new]', '');
				$tpl->set_block("'\\[no-new\\](.*?)\\[/no-new\\]'si","");
				$sql_where = "AND status = 1";
				$gcount = 50;
				mozg_create_cache("user_{$user_id}/new_gift", '');
			} else {
				$tpl->set('[no-new]', '');
				$tpl->set('[/no-new]', '');
				$tpl->set_block("'\\[new\\](.*?)\\[/new\\]'si","");
			}
			
			$tpl->compile('info');
			if($owner['user_gifts']){
				$sql_ = $db->super_query("SELECT tb1.gid, gift, from_uid, msg, gdate, privacy, tb2.user_search_pref, user_photo, user_last_visit FROM `".PREFIX."_gifts` tb1, `".PREFIX."_users` tb2 WHERE tb1.uid = '{$uid}' AND tb1.from_uid = tb2.user_id {$sql_where} ORDER by `gdate` DESC LIMIT {$limit_page}, {$gcount}", 1);
				$tpl->load_template('gifts/gifta.tpl');
				foreach($sql_ as $row){
					$tpl->set('{id}', $row['gid']);
					$tpl->set('{uid}', $row['from_uid']);
					if($row['privacy'] == 0 OR $user_id == $row['from_uid'] OR $user_id == $uid AND $row['privacy'] != 2){
						$tpl->set('{author}', $row['user_search_pref']);
						$tpl->set('{msg}', stripslashes($row['msg']));
						$tpl->set('[link]', '<a href="/id'.$row['from_uid'].'" onClick="Page.Go(this.href); return false">');
						$tpl->set('[/link]', '</a>');
						OnlineTpl($row['user_last_visit']);
					} else {
						$tpl->set('{author}', 'Неизвестный отправитель');
						$tpl->set('{msg}', '');
						$tpl->set('{online}', '');
						$tpl->set('[link]', '');
						$tpl->set('[/link]', '');
					}
					$tpl->set('{gift}', $row['gift']);
					megaDate($row['gdate'], 1, 1);
					$tpl->set('[privacy]', '');
					$tpl->set('[/privacy]', '');
					if($row['privacy'] == 2 AND $user_id == $uid){
						$tpl->set('{msg}', stripslashes($row['msg']));
						$tpl->set_block("'\\[privacy\\](.*?)\\[/privacy\\]'si","");
					}
					if($row['privacy'] == 0 OR $user_id == $row['from_uid'] OR $user_id == $uid AND $row['privacy'] != 2)
						if($row['user_photo'])
							$tpl->set('{ava}', '/uploads/users/'.$row['from_uid'].'/50_'.$row['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
					else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						
					if($user_id == $uid){
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
					} else
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
						
					if($sql_where)
						$db->query("UPDATE `".PREFIX."_gifts` SET status = 0 WHERE gid = '{$row['gid']}'");
						
					$tpl->compile('info');
				}

				
				navigation($gcount, $owner['user_gifts'], "/gifts{$uid}?page=");

				if($sql_where AND !$sql_)
					msgbox('', '<br /><br />Новых подарков еще нет<br /><br /><br />', 'info_2');
			}
		$tpl->load_template('gifts/bottom_ajax.tpl');
		$tpl->compile('content');	
			AjaxTpl();
			die();
			break;
		
		default:
		
			//################### Всех подарков пользователя ###################//
			$metatags['title'] = $lang['gifts'];
			$uid = intval($_GET['uid']);
			
			$row = $db->super_query("SELECT user_id, user_privacy FROM `".PREFIX."_users` WHERE user_id = '{$uid}'");
			
			$user_privacy = xfieldsdataload($row['user_privacy']);
			
			$check_friend = CheckFriends($row['user_id']);
			
			if($user_privacy['val_gift'] == 1 OR $user_privacy['val_gift'] == 2 AND $check_friend OR $user_id == $uid){
			
			if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
			$gcount = 15;
			$limit_page = ($page-1)*$gcount;
			
			$owner = $db->super_query("SELECT user_name, user_gifts FROM `".PREFIX."_users` WHERE user_id = '{$uid}'");
			
			$tpl->load_template('gifts/head.tpl');
			$tpl->set('{uid}', $uid);
			if($user_id == $uid){
				$tpl->set('[owner]', '');
				$tpl->set('[/owner]', '');
				$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
			} else {
				$tpl->set('[not-owner]', '');
				$tpl->set('[/not-owner]', '');
				$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
			}
			$tpl->set('{name}', gramatikName($owner['user_name']));
			$tpl->set('{gifts-num}', '<span id="num">'.$owner['user_gifts'].'</span> '.gram_record($owner['user_gifts'], 'gifts'));
			if($owner['user_gifts']){
				$tpl->set('[yes]', '');
				$tpl->set('[/yes]', '');
				$tpl->set_block("'\\[no\\](.*?)\\[/no\\]'si","");
			} else {
				$tpl->set('[no]', '');
				$tpl->set('[/no]', '');
				$tpl->set_block("'\\[yes\\](.*?)\\[/yes\\]'si","");
			}

			if($_GET['new'] AND $user_id == $uid){
				$tpl->set('[new]', '');
				$tpl->set('[/new]', '');
				$tpl->set_block("'\\[no-new\\](.*?)\\[/no-new\\]'si","");
				$sql_where = "AND status = 1";
				$gcount = 50;
				mozg_create_cache("user_{$user_id}/new_gift", '');
			} else {
				$tpl->set('[no-new]', '');
				$tpl->set('[/no-new]', '');
				$tpl->set_block("'\\[new\\](.*?)\\[/new\\]'si","");
			}
			
			$tpl->compile('info');
			if($owner['user_gifts']){
				$sql_ = $db->super_query("SELECT tb1.gid, gift, from_uid, msg, gdate, privacy, tb2.user_search_pref, user_photo, user_last_visit FROM `".PREFIX."_gifts` tb1, `".PREFIX."_users` tb2 WHERE tb1.uid = '{$uid}' AND tb1.from_uid = tb2.user_id {$sql_where} ORDER by `gdate` DESC LIMIT {$limit_page}, {$gcount}", 1);
				$tpl->load_template('gifts/gift.tpl');
				foreach($sql_ as $row){
					$tpl->set('{id}', $row['gid']);
					$tpl->set('{uid}', $row['from_uid']);
					if($row['privacy'] == 1 OR $user_id == $row['from_uid'] OR $user_id == $uid AND $row['privacy'] != 3){
						$tpl->set('{author}', $row['user_search_pref']);
						$tpl->set('{msg}', stripslashes($row['msg']));
						$tpl->set('[link]', '<a href="/id'.$row['from_uid'].'" onClick="Page.Go(this.href); return false">');
						$tpl->set('[/link]', '</a>');
						OnlineTpl($row['user_last_visit']);
					} else {
						$tpl->set('{author}', 'Неизвестный отправитель');
						$tpl->set('{msg}', '');
						$tpl->set('{online}', '');
						$tpl->set('[link]', '');
						$tpl->set('[/link]', '');
					}
					$tpl->set('{gift}', $row['gift']);
					megaDate($row['gdate'], 1, 1);
					$tpl->set('[privacy]', '');
					$tpl->set('[/privacy]', '');
					if($row['privacy'] == 3 AND $user_id == $uid){
						$tpl->set('{msg}', stripslashes($row['msg']));
						$tpl->set_block("'\\[privacy\\](.*?)\\[/privacy\\]'si","");
					}
					if($row['privacy'] == 1 OR $user_id == $row['from_uid'] OR $user_id == $uid AND $row['privacy'] != 3)
						if($row['user_photo'])
							$tpl->set('{ava}', '/uploads/users/'.$row['from_uid'].'/50_'.$row['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
					else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						
					if($user_id == $uid){
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
					} else
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
						
					if($sql_where)
						$db->query("UPDATE `".PREFIX."_gifts` SET status = 0 WHERE gid = '{$row['gid']}'");
						
					$tpl->compile('content');
				}
				navigation($gcount, $owner['user_gifts'], "/gifts{$uid}?page=");
				
				if($sql_where AND !$sql_)
					msgbox('', '<br /><br />Новых подарков еще нет.<br /><br /><br />', 'info_2');
			}
			
			} else {
			
				$tpl->load_template('info_red.tpl');
				$tpl->set('{error}','Страница защищена настройками приватности!');
				$tpl->compile('content');
			
			}
	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>