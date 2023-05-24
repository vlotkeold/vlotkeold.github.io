<?php
/* 
	Appointment: �����
	File: videos.php 
	Author: f0rt1 
	Engine: Vii Engine
	Copyright: NiceWeb Group (�) 2011
	e-mail: niceweb@i.ua
	URL: http://www.niceweb.in.ua/
	ICQ: 427-825-959
	������ ��� ������� ���������� �������
*/
if(!defined('MOZG')){
	die('Hacking attempt!');
}

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	$limit_vieos = 20;
	
	switch($act){
		
		//################### �������� ���������� ����� ###################//
		case "add":
			NoAjaxQuery();
			$tpl->load_template('videos/add.tpl');
			$tpl->compile('content');
			AjaxTpl();
			die();
		break;
		
		//################### ���������� ����� � �� ###################//
		case "send":
			NoAjaxQuery();
			
			if($config['video_mod_add'] == 'yes'){
				$good_video_lnk = ajax_utf8(textFilter($_POST['good_video_lnk']));
				$title = ajax_utf8(textFilter($_POST['title'], false, true));
				$descr = ajax_utf8(textFilter($_POST['descr'], 3000));
				$privacy = intval($_POST['privacy']);
				if($privacy <= 0 OR $privacy > 3) $privacy = 1;

				//���� youtube �� ��������� ������� src=" � ���������� ����� ��� �������, ��� ������� � ��
				if(preg_match("/src=\"http:\/\/www.youtube.com|src=\"http:\/\/youtube.com/i", 'src="'.$good_video_lnk)){
					$good_video_lnk = str_replace(array('#', '!'), '', $good_video_lnk);
					$exp_y = explode('v=', $good_video_lnk);
					$exp_x = explode('&', $exp_y[1]);
					$result_video_lnk = '<iframe width="770" height="420" src="http://www.youtube.com/embed/'.$exp_x[0].'" frameborder="0" allowfullscreen></iframe>';
				}
				
				//���� rutube, �� ��������� ������� value="
				if(preg_match("/value=\"http:\/\/www.rutube.ru|value=\"http:\/\/rutube.ru/i", 'value="'.$good_video_lnk)){
					$exp_frutube = explode('?v=', $good_video_lnk);
					$result_video_lnk = '<OBJECT width="770" height="420"><PARAM name="movie" value="http://video.rutube.ru/'.$exp_frutube[1].'"></PARAM><PARAM name="wmode" value="window"></PARAM><PARAM name="allowFullScreen" value="true"></PARAM><EMBED src="http://video.rutube.ru/'.$exp_frutube[1].'" type="application/x-shockwave-flash" wmode="window" width="770" height="420" allowFullScreen="true" ></EMBED></OBJECT>';
				}
				
				//���� vimeo, �� ��������� ������� src="
				if(preg_match("/src=\"http:\/\/www.vimeo.com|src=\"http:\/\/vimeo.com/i", 'src="'.$good_video_lnk)){
					$exp_frutube = explode('com/', $good_video_lnk);
					$result_video_lnk = '<iframe src="http://player.vimeo.com/video/'.$exp_frutube[1].'" width="770" height="420" frameborder="0"></iframe>';
				}
				
				//���� smotri, �� ��������� ������� src="
				if(preg_match("/src=\"http:\/\/www.smotri.com|src=\"http:\/\/smotri.com/i", 'src="'.$good_video_lnk)){
					$exp = explode('id=', str_replace('#', '', $good_video_lnk));
					$result_video_lnk = '<object id="smotriComVideoPlayer'.$exp[1].'_1314557535.5897_7726" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="770" height="420"><param name="movie" value="http://pics.smotri.com/player.swf?file='.$exp[1].'&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.smotri.com%2Fcskins%2Fblue%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.smotri.com%2Fskin_ng.xml" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><param name="bgcolor" value="#ffffff" /><embed src="http://pics.smotri.com/player.swf?file='.$exp[1].'&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.smotri.com%2Fcskins%2Fblue%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.smotri.com%2Fskin_ng.xml" quality="high" allowscriptaccess="always" allowfullscreen="true" wmode="opaque"  width="770" height="420" type="application/x-shockwave-flash"></embed></object>';
				}
				
				//��������� ������ � ����
				$photo = $db->safesql(ajax_utf8(htmlspecialchars(trim($_POST['photo']))));
				$photo = str_replace("\\", "/", $photo);
				$img_name_arr = explode(".", $photo);
				$img_format = totranslit(end($img_name_arr));
				$image_name = substr(md5(time().md5($good_video_lnk)), 0, 15);
				
				//����������� �������
				$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');

				//��������� �������� �� ����
				if(in_array(strtolower($img_format), $allowed_files) && preg_match("/http:\/\//i", $photo) && $result_video_lnk){
							
					//���������� �������� ����
					$upload_dir = ROOT_DIR.'/uploads/videos/'.$user_id;
							
					//���� ��� ����� �����, �� ������ �
					if(!is_dir($upload_dir)){ 
						@mkdir($upload_dir, 0777);
						@chmod($upload_dir, 0777);
					}
							
					//���������� ����� ��� ����������
					include ENGINE_DIR.'/classes/images.php';

					@copy($photo, $upload_dir.'/'.$image_name.'.'.$img_format);

					$tmb = new thumbnail($upload_dir.'/'.$image_name.'.'.$img_format);
					$tmb->size_auto('175x131');
					$tmb->jpeg_quality(100);
					$tmb->save($upload_dir.'/'.$image_name.'.'.$img_format);
				}
				
				if($result_video_lnk AND $title){
					$photo = $config['home_url'].'uploads/videos/'.$user_id.'/'.$image_name.'.'.$img_format;
					$db->query("INSERT INTO `".PREFIX."_videos` SET owner_user_id = '{$user_id}', video = '{$result_video_lnk}', photo = '{$photo}', title = '{$title}', descr = '{$descr}', add_date = NOW(), privacy = '{$privacy}', system = '0', profile = '1'");
					$dbid = $db->insert_id();
					
					$db->query("UPDATE `".PREFIX."_users` SET user_videos_num = user_videos_num+1 WHERE user_id = '{$user_id}'");
					
					$photo = str_replace($config['home_url'], '/', $photo);
					
					//��������� �������� � ����� ��������
					$generateLastTime = $server_time-10800;
					$row = $db->super_query("SELECT ac_id, action_text FROM `".PREFIX."_news` WHERE action_time > '{$generateLastTime}' AND action_type = 2 AND ac_user_id = '{$user_id}'");
					if($row)
						$db->query("UPDATE `".PREFIX."_news` SET action_text = '{$dbid}|{$photo}||{$row['action_text']}', action_time = '{$server_time}' WHERE ac_id = '{$row['ac_id']}'");
					else
						$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 2, action_text = '{$dbid}|{$photo}', action_time = '{$server_time}'");

					//������ ���
					mozg_mass_clear_cache_file("user_{$user_id}/page_videos_user|user_{$user_id}/page_videos_user_friends|user_{$user_id}/page_videos_user_all|user_{$user_id}/profile_{$user_id}|user_{$user_id}/videos_num_all|user_{$user_id}/videos_num_friends");
					
					if($_POST['notes'] == 1)
						echo "{$photo}|{$user_id}|{$dbid}";
				}
			} else
				echo 'error';
			
			die();
		break;
		
		//################### ������ . �������� ������ � ����� ###################//
		case "load":
			NoAjaxQuery();
			
			$video_lnk = $_POST['video_lnk'];
			
			if(preg_match("/http:\/\/www.youtube.com|http:\/\/youtube.com|http:\/\/rutube.ru|http:\/\/www.rutube.ru|http:\/\/www.vimeo.com|http:\/\/vimeo.com|http:\/\/smotri.com|http:\/\/www.smotri.com/i", $video_lnk)){
			
				//��������� ������
				
				//���� ������ youtube, �� ��������� xml ������ ��� ��������� ������
				if(preg_match("/http:\/\/www.youtube.com|http:\/\/youtube.com/i", $video_lnk)){
					$exp_y = explode('v=', $video_lnk);
					$exp_x = explode('&', $exp_y[1]);
					$sock = fopen('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v='.$exp_x[0].'&format=xml', 'r');
				} elseif(preg_match("/http:\/\/www.vimeo.com|http:\/\/vimeo.com/i", $video_lnk)){
					$sock = fopen('http://vimeo.com/api/oembed.xml?url='.$video_lnk, 'r');
				} else {
					$sock = fopen($video_lnk, 'r');
				}
				
				if(!$sock){
					echo 'no_serviece';
				} else {
					$html = '';
					
					//���� ������ youtube, rutube, smotri �� ������ ������
					if(preg_match("/http:\/\/www.youtube.com|http:\/\/youtube.com|http:\/\/rutube.ru|http:\/\/www.rutube.ru|http:\/\/smotri.com|http:\/\/www.smotri.com/i", $video_lnk)){
						while(!feof($sock)){
							$html .= fgets($sock);
						}
					}
					
					//���� ������ Vimeo, �� ����� ��������� ��������� utf-8, win-1251
					if(preg_match("/http:\/\/www.vimeo.com|http:\/\/vimeo.com/i", $video_lnk)){
						while(!feof($sock)){
							$html .= ajax_utf8(fgets($sock));
						}
					}
					
					fclose($sock);
					
					//���� ������ Vimeo, �� ������� ��� ���������
					$data = str_replace(array('[', ']'), array('&iqu;', '&iqu2;'), $html);
					
					//���� ������ youtube ��������� ��������� utf-8, win-1251
					$data_all = ajax_utf8(str_replace(array('[', ']'), array('&iqu;', '&iqu2;'), $html));

					//���� ����������� youtube
					if(preg_match("/http:\/\/www.youtube.com|http:\/\/youtube.com/i", $video_lnk)){
						preg_match_all('`(<title>[^\[]+\</title>)`si', $data_all, $parse);
						$res_title = rn_replace(str_replace(array('<title>', '</title>'), '', $parse[1][0]));

						//������ ����� ��� youtube
						$parse_start = explode('v=', $video_lnk);
						$parse_end = explode('&', $parse_start[1]);
						$res_img = "http://img.youtube.com/vi/{$parse_end[0]}/0.jpg";
					}
					
					//���� ����������� rutube
					if(preg_match("/http:\/\/rutube.ru|http:\/\/www.rutube.ru/i", $video_lnk)){
						$data_rutube = iconv('koi8-u', 'windows-1251', str_replace(array('[', ']'), array('&iqu;', '&iqu2;'), $html));
						
						preg_match_all('`(<meta property="og:title" content="[^\[]+\<meta property="og:description")`si', $data_rutube, $parse_rutube);
						$res_title = rn_replace(str_replace(array('<meta property="og:title" content="', '<meta property="og:description"', '" />'), '', $parse_rutube[1][0]));
						
						preg_match_all('`(<meta property="og:description" content="[^\[]+\<meta property="og:image")`si', $data_rutube, $parse_rutube_descr);
						$res_descr = rn_replace(str_replace(array('<meta property="og:description" content="', '<meta property="og:image"', '" />'), '', $parse_rutube_descr[1][0]));
						
						$exp_rutube_img = explode('v=', $video_lnk);
						$exp_img_dir = substr($exp_rutube_img[1], 0, 2);
						$exp_img_dir_2 = substr($exp_rutube_img[1], 2, 2);
						$res_img = "http://tub.rutube.ru/thumbs/{$exp_img_dir}/{$exp_img_dir_2}/{$exp_rutube_img[1]}-1.jpg";
					}
					
					//���� ����������� vimeo
					if(preg_match("/http:\/\/www.vimeo.com|http:\/\/vimeo.com/i", $video_lnk)){
						preg_match_all('`(<title>[^\[]+\</title>)`si', $data, $parse);
						$res_title = str_replace(array('<title>', '</title>'), '', $parse[1][0]);
						
						preg_match_all('`(<thumbnail_url>[^\[]+\</thumbnail_url>)`si', $data, $parse_img);
						$res_img = str_replace(array('<thumbnail_url>', '</thumbnail_url>'), '', $parse_img[1][0]);
						
						preg_match_all('`(<description>[^\[]+\</description>)`si', $data, $parse_descr);
						$res_descr = myBrRn(rn_replace($parse_descr[1][0]));
					}
					
					//���� ����������� smotri
					if(preg_match("/http:\/\/smotri.com|http:\/\/www.smotri.com/i", $video_lnk)){
						$html = iconv('utf-8', 'windows-1251', $html);
					
						preg_match_all('`(<meta property="og:title" content="[^\[]+\<meta property="og:image")`si', $html, $parse_title);
						$res_title = rn_replace(str_replace(array('<meta property="og:title" content="', '<meta property="og:image"', '" />'), '', $parse_title[1][0]));
						
						preg_match_all('`(<link rel="image_src" href="[^\[]+\<!-- Open Graf Protocol. Facebook/Yandex -->)`si', $html, $parse_img);
						$res_img = rn_replace(str_replace(array('<link rel="image_src" href="', '<!-- Open Graf Protocol. Facebook/Yandex -->', '" />'), '', $parse_img[1][0]));
					}

					$result_img = $res_img;
					$result_title = trim(strip_tags(strtr($res_title, array('&#39;' => "'", '&quot;' => '"', '&iqu;' => '[', '&iqu2;' => ']'))));
					$result_descr = trim(strip_tags($res_descr));
					
					if($result_img && $result_title)
						echo "{$result_img}:|:{$result_title}:|:{$result_descr}";
					else
						echo 'no_serviece';
				}
			} else
				echo 'no_serviece';
			
			die();
		break;
		
		//################### �������� ����� ###################//
		case "delet":
			NoAjaxQuery();
			$vid = intval($_POST['vid']);
			
			if($vid){
				$row = $db->super_query("SELECT owner_user_id, photo, public_id FROM `".PREFIX."_videos` WHERE id = '{$vid}'");
				if($row['owner_user_id'] == $user_id AND !$row['public_id']){
					$db->query("DELETE FROM `".PREFIX."_videos` WHERE id = '{$vid}'");
					$db->query("DELETE FROM `".PREFIX."_videos_comments` WHERE video_id = '{$vid}'");
					$db->query("UPDATE `".PREFIX."_users` SET user_videos_num = user_videos_num-1 WHERE user_id = '{$row['owner_user_id']}'");
					
					//������� �����
					$exp_photo = explode('/', $row['photo']);
					$photo_name = end($exp_photo);
					@unlink(ROOT_DIR.'/uploads/videos/'.$row['owner_user_id'].'/'.$photo_name);
					
					//������ ���
					mozg_mass_clear_cache_file("user_{$row['owner_user_id']}/page_videos_user|user_{$row['owner_user_id']}/page_videos_user_friends|user_{$row['owner_user_id']}/page_videos_user_all|user_{$row['owner_user_id']}/profile_{$row['owner_user_id']}|user_{$row['owner_user_id']}/videos_num_all|user_{$row['owner_user_id']}/videos_num_friends|wall/video{$vid}");
				}
			}
			die();
		break;
		
		//################### �������� �������������� ����� ###################//
		case "edit":
			NoAjaxQuery();
			$vid = intval($_POST['vid']);
			if($vid){
				$row = $db->super_query("SELECT title, descr, privacy FROM `".PREFIX."_videos` WHERE id = '{$vid}' AND owner_user_id = '{$user_id}'");
				if($row){
					$tpl->load_template('videos/editpage.tpl');
					$tpl->set('{title}', stripslashes($row['title']));
					$tpl->set('{descr}', stripslashes(myBrRn($row['descr'])));
					$tpl->set('{privacy}', $row['privacy']);
					$tpl->set('{privacy-text}', strtr($row['privacy'], array('1' => '��� ������������', '2' => '������ ������', '3' => '������ �')));
					$tpl->compile('content');
					AjaxTpl();
				}
			}
			die();
		break;
		
		//################### ���������� ���������������� ������ ###################//
		case "editsave":
			NoAjaxQuery();
			$vid = intval($_POST['vid']);
			
			if($vid){
				$title = ajax_utf8(textFilter($_POST['title'], false, true));
				$descr = ajax_utf8(textFilter($_POST['descr'], 3000));
				$privacy = intval($_POST['privacy']);
				if($privacy <= 0 OR $privacy > 3) $privacy = 1;

				//�������� �� ������������� ������
				$row = $db->super_query("SELECT owner_user_id, public_id FROM `".PREFIX."_videos` WHERE id = '{$vid}'");
				if($row['owner_user_id'] == $user_id AND !$row['public_id']){
					$db->query("UPDATE `".PREFIX."_videos` SET title = '{$title}', descr = '{$descr}', privacy = '{$privacy}', system = '0', profile = '1' WHERE id = '{$vid}'");
					echo stripslashes($descr);
					
					//������ ���
					mozg_mass_clear_cache_file("user_{$row['owner_user_id']}/page_videos_user|user_{$row['owner_user_id']}/page_videos_user_friends|user_{$row['owner_user_id']}/page_videos_user_all|user_{$row['owner_user_id']}/videos_num_all|user_{$row['owner_user_id']}/videos_num_friends|wall/video{$vid}");
				}
			}
			die();
		break;

		//################### �������� ����� ###################//
		case "view":
			NoAjaxQuery();
			include ENGINE_DIR.'/modules/video.php';
			die();
		break;
		
		//################### ���������� ����������� � ���� ###################//
		case "addcomment":
			NoAjaxQuery();
			if($config['video_mod_comm'] == 'yes'){
				$vid = intval($_POST['vid']);
				$comment = ajax_utf8(textFilter($_POST['comment']));
				
				//�������� �� ������������� �����
				$check_video = $db->super_query("SELECT owner_user_id, photo, public_id FROM `".PREFIX."_videos` WHERE id = '{$vid}'");
					
				//��
				$CheckBlackList = CheckBlackList($check_video['owner_user_id']);
				if(!$CheckBlackList){
					if($check_video AND isset($comment) AND !empty($comment)){
						$db->query("INSERT INTO `".PREFIX."_videos_comments` SET author_user_id = '{$user_id}', video_id = '{$vid}', text = '{$comment}', add_date = NOW()");
						$id = $db->insert_id();
						$db->query("UPDATE `".PREFIX."_videos` SET comm_num = comm_num+1 WHERE id = '{$vid}'");

						$tpl->load_template('videos/comment.tpl');
						$tpl->set('{online}', $lang['online']);
						$tpl->set('{uid}', $user_id);
						$tpl->set('{author}', $user_info['user_search_pref']);
						$tpl->set('{comment}', stripslashes($comment));
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
						$tpl->set('{id}', $id);
						$tpl->set('{date}', langdate('������� � H:i', time()));
						if($user_info['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$user_id.'/50_'.$user_info['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						$tpl->compile('content');
						
						if(!$check_video['public_id']){
						
							//��������� �������� � ����� �������� "������" ��������� ����������
							if($user_id != $check_video['owner_user_id']){
								$check_video['photo'] = str_replace($config['home_url'], '/', $check_video['photo']);
								$comment = str_replace("|", "&#124;", $comment);
								$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 9, action_text = '{$comment}|{$check_video['photo']}|{$vid}', obj_id = '{$id}', for_user_id = '{$check_video['owner_user_id']}', action_time = '{$server_time}'");

								//��������� ������� � ������������ ����������
								$row_userOW = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$check_video['owner_user_id']}'");
								$update_time = $server_time - 70;
												
								if($row_userOW['user_last_visit'] >= $update_time){
												
									$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$check_video['owner_user_id']}', from_user_id = '{$user_id}', type = '3', date = '{$server_time}', text = '{$comment}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '/video{$check_video['owner_user_id']}_{$vid}'");
												
									mozg_create_cache("user_{$check_video['owner_user_id']}/updates", 1);
								
								//����� ��������� +1 ����� ��� ����������
								} else {

									$cntCacheNews = mozg_cache('user_'.$check_video['owner_user_id'].'/new_news');
									mozg_create_cache('user_'.$check_video['owner_user_id'].'/new_news', ($cntCacheNews+1));
								
								}
						
								//�������� ����������� �� E-mail
								if($config['news_mail_3'] == 'yes'){
									$rowUserEmail = $db->super_query("SELECT user_name, user_email FROM `".PREFIX."_users` WHERE user_id = '".$check_video['owner_user_id']."'");
									if($rowUserEmail['user_email']){
										include_once ENGINE_DIR.'/classes/mail.php';
										$mail = new dle_mail($config);
										$rowMyInfo = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$user_id."'");
										$rowEmailTpl = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '3'");
										$rowEmailTpl['text'] = str_replace('{%user%}', $rowUserEmail['user_name'], $rowEmailTpl['text']);
										$rowEmailTpl['text'] = str_replace('{%user-friend%}', $rowMyInfo['user_search_pref'], $rowEmailTpl['text']);
										$rowEmailTpl['text'] = str_replace('{%rec-link%}', $config['home_url'].'video'.$check_video['owner_user_id'].'_'.$vid, $rowEmailTpl['text']);
										$mail->send($rowUserEmail['user_email'], '����� ����������� � ����� �����������', $rowEmailTpl['text']);
									}
								}
							}
							
							//������ ���
							mozg_mass_clear_cache_file("user_{$check_video['owner_user_id']}/page_videos_user|user_{$check_video['owner_user_id']}/page_videos_user_friends|user_{$check_video['owner_user_id']}/page_videos_user_all");
						
						} else
							mozg_clear_cache_file("groups/video{$check_video['public_id']}");

						AjaxTpl();

					}
				}
			} else
				echo 'error';
			
			die();
		break;
		
		//################### �������� ����������� ###################//
		case "delcomment":
		
			NoAjaxQuery();
			$comm_id = intval($_POST['comm_id']);
			
			//�������� �� ������������� �����������, � ������� �� ��������� �����
			$row = $db->super_query("SELECT tb1.video_id, author_user_id, tb2.owner_user_id, public_id FROM `".PREFIX."_videos_comments` tb1, `".PREFIX."_videos` tb2 WHERE tb1.id = '{$comm_id}' AND tb1.video_id = tb2.id");
			
			if($row['public_id']){
			
				$infoGroup = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$row['public_id']}'");
				
				if(strpos($infoGroup['admin'], "u{$user_id}|") !== false) $public_admin = true;
				else $public_admin = false;
				
				if($public_admin AND $row){
					
					$db->query("DELETE FROM `".PREFIX."_videos_comments` WHERE id = '{$comm_id}'");
					$db->query("DELETE FROM `".PREFIX."_news` WHERE obj_id = '{$comm_id}' AND action_type = 9");
					$db->query("UPDATE `".PREFIX."_videos` SET comm_num = comm_num-1 WHERE id = '{$row['video_id']}'");
					
					mozg_clear_cache_file("groups/video{$row['public_id']}");
					
				}
			
			} else {
				
				if($row['author_user_id'] == $user_id OR $row['owner_user_id'] == $user_id){
				
					$db->query("DELETE FROM `".PREFIX."_videos_comments` WHERE id = '{$comm_id}'");
					$db->query("DELETE FROM `".PREFIX."_news` WHERE obj_id = '{$comm_id}' AND action_type = 9");
					$db->query("UPDATE `".PREFIX."_videos` SET comm_num = comm_num-1 WHERE id = '{$row['video_id']}'");
					
					//������ ���
					mozg_mass_clear_cache_file("user_{$row['owner_user_id']}/page_videos_user|user_{$row['owner_user_id']}/page_videos_user_friends|user_{$row['owner_user_id']}/page_videos_user_all");
					
				}
			
			}
			
			die();
			
		break;
		
		//################### ����� ���� ������������ ###################//
		case "all_comm":
			NoAjaxQuery();
			$vid = intval($_POST['vid']);
			$comm_num = intval($_POST['num']);
			$owner_id = intval($_POST['owner_id']);

				
			$row = $db->super_query("SELECT public_id FROM `".PREFIX."_videos` WHERE id = '{$vid}'");
			
			if($row['public_id']){
			
				$infoGroup = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$row['public_id']}'");
				
				if(strpos($infoGroup['admin'], "u{$user_id}|") !== false) $public_admin = true;
				else $public_admin = false;
				
			}
			
			if($comm_num > 3 AND $vid AND $owner_id){
			
				$limit_comm = $comm_num-3;
				
				$sql_comm = $db->super_query("SELECT tb1.id, author_user_id, text, add_date, tb2.user_search_pref, user_photo, user_last_visit, user_logged_mobile FROM `".PREFIX."_videos_comments` tb1, `".PREFIX."_users` tb2 WHERE tb1.video_id = '{$vid}' AND tb1.author_user_id = tb2.user_id ORDER by `add_date` ASC LIMIT 0, {$limit_comm}", 1);
				
				$tpl->load_template('videos/comment.tpl');
				
				foreach($sql_comm as $row_comm){
				
					$tpl->set('{uid}', $row_comm['author_user_id']);
					$tpl->set('{author}', $row_comm['user_search_pref']);
					$tpl->set('{comment}', stripslashes($row_comm['text']));
					$tpl->set('{id}', $row_comm['id']);
					OnlineTpl($row_comm['user_last_visit'], $row_comm['user_logged_mobile']);
					megaDate(strtotime($row_comm['add_date']));
					
					if($row_comm['author_user_id'] == $user_id OR $owner_id == $user_id OR $public_admin){
					
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
						
					} else
					
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");

					if($row_comm['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comm['author_user_id'].'/50_'.$row_comm['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
					$tpl->compile('content');
					
				}
				
			}	
			
			AjaxTpl();

			die();
		break;
		
		//################### �������� ���� ����� �����, ��� ������������ ����� ����-�� �� ����� ###################//
		case "all_videos":
			NoAjaxQuery();
			$notes = intval($_POST['notes']);
			
			//��� ���������
			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 24;
			$limit_page = ($page-1)*$gcount;

			//������ SQL ������ �� �����
			$sql_ = $db->super_query("SELECT id, photo, title FROM `".PREFIX."_videos` WHERE owner_user_id = '{$user_id}' AND public_id = '0' ORDER by `add_date` DESC LIMIT {$limit_page}, {$gcount}", 1);
			
			//������� ���-�� �����
			$count = $db->super_query("SELECT user_videos_num FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");

			if($count['user_videos_num']){
				if($notes)
					$tpl->load_template('videos/box_all_video_notes_top.tpl');
				else
					$tpl->load_template('videos/box_all_video_top.tpl');
					
				$tpl->set('[top]', '');
				$tpl->set('[/top]', '');
				$tpl->set('{photo-num}', $count['user_videos_num'].' '.gram_record($count['user_videos_num'], 'videos'));
				$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
				$tpl->compile('content');
				
				//������� ������ �����
				if(!$notes)
					$tpl->load_template('videos/box_all_video.tpl');
				else
					$tpl->load_template('videos/box_all_video_notes.tpl');
				
				foreach($sql_ as $row){
					$tpl->set('{photo}', $row['photo']);
					$tpl->set('{title}', stripslashes($row['title']));
					$tpl->set('{video-id}', $row['id']);
					$tpl->set('{user-id}', $user_id);
					$tpl->compile('content');
				}
				box_navigation($gcount, $count['user_videos_num'], $page, 'wall.attach_addvideo', $notes);
				
				$tpl->load_template('albums_editcover.tpl');
				$tpl->set('[bottom]', '');
				$tpl->set('[/bottom]', '');
				$tpl->set_block("'\\[top\\](.*?)\\[/top\\]'si","");
				$tpl->compile('content');
			} else
				if($notes)
					echo $lang['videos_box_none'].'<div class="button_div_gray fl_l" style="margin-left:210px;margin-top:20px"><button onClick="videos.add(1)">�������� ����� ����������</button></div>';
				else
					echo $lang['videos_box_none'];
			
			AjaxTpl();

			die();
		break;
		
		//################### �������� ���� ����� �����, ��� ������������ ����� � ���������� ###################//
		case "all_videos_public":
		
			NoAjaxQuery();

			$pid = intval($_POST['pid']);
			
			//��� ���������
			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 24;
			$limit_page = ($page-1)*$gcount;

			//������ SQL ������ �� �����
			$sql_ = $db->super_query("SELECT id, photo, title FROM `".PREFIX."_videos` WHERE public_id = '{$pid}' ORDER by `add_date` DESC LIMIT {$limit_page}, {$gcount}", 1);
			
			//������� ���-�� �����
			$count = $db->super_query("SELECT videos_num FROM `".PREFIX."_communities` WHERE id = '{$pid}'");

			if($count['videos_num']){
			
				$tpl->load_template('videos/box_all_video_top.tpl');
					
				$tpl->set('[top]', '');
				$tpl->set('[/top]', '');
				$tpl->set('{photo-num}', $count['videos_num'].' '.gram_record($count['videos_num'], 'videos'));
				$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
				$tpl->compile('content');
				
				//������� ������ �����
				$tpl->load_template('videos/box_all_video.tpl');
				
				foreach($sql_ as $row){
				
					$tpl->set('{photo}', $row['photo']);
					$tpl->set('{title}', stripslashes($row['title']));
					$tpl->set('{video-id}', $row['id']);
					$tpl->set('{user-id}', $user_id);
					$tpl->compile('content');
					
				}
				
				box_navigation($gcount, $count['videos_num'], $page, 'wall.attach_addvideo_public', $pid);
				
				$tpl->load_template('albums_editcover.tpl');
				$tpl->set('[bottom]', '');
				$tpl->set('[/bottom]', '');
				$tpl->set_block("'\\[top\\](.*?)\\[/top\\]'si","");
				$tpl->compile('content');
				
			} else
			
				echo '<div class="info_center" style="padding-top:170px">��� �� ����� �����������.</div>';
			
			AjaxTpl();

			die();
			
		break;
		
		//################### ����������� ��������� ����� �� �� ###################//
		case "page":
			NoAjaxQuery();
			
			$get_user_id = intval($_POST['get_user_id']);
			$last_id = intval($_POST['last_id']);
			if(!$get_user_id)
				$get_user_id = $user_id;
			
			//��
			$CheckBlackList = CheckBlackList($get_user_id);
			if(!$CheckBlackList){
				if($last_id){
					if($user_id != $get_user_id)
						//�������� ������ ������������� ���� � ������� � ����� ������� ������� ���
						$check_friend = CheckFriends($get_user_id);
					
					//��������� �����������
					if($user_id == $get_user_id)
						$sql_privacy = "";
					elseif($check_friend)
						$sql_privacy = "AND privacy regexp '[[:<:]](1|2)[[:>:]]'";
					else
						$sql_privacy = "AND privacy = 1";

					//SQL ������
					$sql_ = $db->super_query("SELECT id, title, photo, comm_num, add_date, SUBSTRING(descr, 1, 180) AS descr FROM `".PREFIX."_videos` WHERE owner_user_id = '{$get_user_id}' AND id < '{$last_id}' {$sql_privacy} AND public_id = '0' ORDER by `add_date` DESC LIMIT 0, {$limit_vieos}", 1);
					
					//���� ���� ����� �� ��
					if($sql_){
						$tpl->load_template('videos/short.tpl');
						foreach($sql_ as $row){
							$tpl->set('{photo}', stripslashes($row['photo']));
							$tpl->set('{title}', stripslashes($row['title']));
							$tpl->set('{id}', $row['id']);
							$tpl->set('{user-id}', $get_user_id);
							if($row['descr'])
								$tpl->set('{descr}', stripslashes($row['descr']).'...');
							else
								$tpl->set('{descr}', '');
							$tpl->set('{comm}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
							megaDate(strtotime($row['add_date']));
							if($get_user_id == $user_id){
								$tpl->set('[owner]', '');
								$tpl->set('[/owner]', '');
							} else 
								$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
							$tpl->compile('content');
						}
					}
					AjaxTpl();
				}
			}
			die();
		break;
		
		//################### ���������� ����� � ���� � ������ ###################//
		case "addmylist":
			NoAjaxQuery();
			$vid = intval($_POST['vid']);
			$row = $db->super_query("SELECT video, photo, title, descr FROM `".PREFIX."_videos` WHERE id = '{$vid}'");
			if($row AND $config['video_mod_add_my'] == 'yes'){
							
				//��������� ������ � ����
				$newPhoto = $db->safesql(ajax_utf8(htmlspecialchars(trim($_POST['photo']))));
				$newPhoto = str_replace("\\", "/", $newPhoto);
				$img_name_arr = explode(".", $newPhoto);
				$img_format = totranslit(end($img_name_arr));
				$image_name = substr(md5(time().md5($good_video_lnk)), 0, 15);
				
				//���������� �������� ����
				$upload_dir = ROOT_DIR.'/uploads/videos/'.$user_id;
						
				//���� ��� ����� �����, �� ������ �
				if(!is_dir($upload_dir)){ 
					@mkdir($upload_dir, 0777);
					@chmod($upload_dir, 0777);
				}
				
				$expPhoto = end(explode('/', $row['photo']));
				@copy($row['photo'], ROOT_DIR."/uploads/videos/{$user_id}/{$expPhoto}");
				$newPhoto = "{$config['home_url']}uploads/videos/{$user_id}/{$expPhoto}";
				$row['video'] = $db->safesql($row['video']);
				$row['descr'] = $db->safesql($row['descr']);
				$row['title'] = $db->safesql($row['title']);
				$db->query("INSERT INTO `".PREFIX."_videos` SET owner_user_id = '{$user_id}', video = '{$row['video']}', photo = '{$newPhoto}', title = '{$row['title']}', descr = '{$row['descr']}', add_date = NOW(), privacy = '1', system = '1', profile = '1'");
				$dbid = $db->insert_id();
				$db->query("UPDATE `".PREFIX."_users` SET user_videos_num = user_videos_num+1 WHERE user_id = '{$user_id}'");

				//������ ���
				mozg_mass_clear_cache_file("user_{$user_id}/page_videos_user|user_{$user_id}/page_videos_user_friends|user_{$user_id}/page_videos_user_all|user_{$user_id}/profile_{$user_id}|user_{$user_id}/videos_num_all|user_{$user_id}/videos_num_friends");
			}
			die();
		break;
		
			default:
		
			//################### ����� ���� ����� ###################//
			$get_user_id = intval($_GET['get_user_id']);
			if(!$get_user_id)
				$get_user_id = $user_id;

			//��
			$CheckBlackList = CheckBlackList($get_user_id);
			if(!$CheckBlackList){
				
				//������ ���-�� ����� �������
				$owner = $db->super_query("SELECT user_videos_num, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$get_user_id}'");
				if($owner){
					$name_info = explode(' ', $owner['user_search_pref']);
					$metatags['title'] = $lang['videos'].' '.gramatikName($name_info[0]).' '.gramatikName($name_info[1]);
					
					if($user_id != $get_user_id)
						//�������� ������ ������������� ���� � ������� � ����� ������� ������� ���
						$check_friend = CheckFriends($get_user_id);
					
					//��������� �����������
					if($user_id == $get_user_id)
						$sql_privacy = "";
					elseif($check_friend){
						$sql_privacy = "AND privacy regexp '[[:<:]](1|2)[[:>:]]'";
						$cache_pref = '_friends';
					} else {
						$sql_privacy = "AND privacy = 1";
						$cache_pref = '_all';
					}
					
					//���� �������� ������� ������ ����, �� ������� ���-�� �����
					if($user_id != $get_user_id){
						$video_cnt = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_videos` WHERE owner_user_id = '{$get_user_id}' {$sql_privacy} AND public_id = '0'", false, "user_{$get_user_id}/videos_num{$cache_pref}");
						$owner['user_videos_num'] = $video_cnt['cnt'];
					}
					
					if($get_user_id == $user_id)
						$user_speedbar = '� ��� <span id="nums">'.($owner['user_videos_num'] ? $owner['user_videos_num'] : false).'</span> '.gram_record($owner['user_videos_num'], 'videos');
					else
						$user_speedbar = '� '.gramatikName($name_info[0]).' '.($owner['user_videos_num'] ? $owner['user_videos_num'] : false).' '.gram_record($owner['user_videos_num'], 'videos');
					
					if($owner['user_videos_num']){
					
						//SQL ������
						$sql_ = $db->super_query("SELECT id, title, photo, comm_num, add_date, SUBSTRING(descr, 1, 180) AS descr FROM `".PREFIX."_videos` WHERE owner_user_id = '{$get_user_id}' {$sql_privacy} AND public_id = '0' ORDER by `add_date` DESC LIMIT 0, {$limit_vieos}", 1);

						//��������� ���� �� �����
						$tpl->load_template('videos/head.tpl');
						$tpl->set('{user-id}', $get_user_id);
						$tpl->set('{videos_num}', $owner['user_videos_num']);
						$tpl->set('{name}', gramatikName($name_info[0]));
						if($get_user_id == $user_id){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
							$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
						} else {
							$tpl->set('[not-owner]', '');
							$tpl->set('[/not-owner]', '');
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
						}
						
						if($config['video_mod_add'] == 'yes'){
							$tpl->set('[admin-video-add]', '');
							$tpl->set('[/admin-video-add]', '');
						} else
							$tpl->set_block("'\\[admin-video-add\\](.*?)\\[/admin-video-add\\]'si","");
			
						$tpl->compile('info');
							
						if($sql_){
							$tpl->load_template('videos/short.tpl');
							$tpl->result['content'] .= '<span id="video_page" class="scroll_page">';
							foreach($sql_ as $row){
								$tpl->set('{photo}', stripslashes($row['photo']));
								$tpl->set('{title}', stripslashes($row['title']));
								$tpl->set('{user-id}', $get_user_id);
								$tpl->set('{id}', $row['id']);
								if($row['descr'])
									$tpl->set('{descr}', stripslashes($row['descr']).'...');
								else
									$tpl->set('{descr}', '');
								$tpl->set('{comm}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
								megaDate(strtotime($row['add_date']));
								if($get_user_id == $user_id){
									$tpl->set('[owner]', '');
									$tpl->set('[/owner]', '');
								} else 
									$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
								$tpl->compile('content');
							}
							$tpl->result['content'] .= '</span>';
							
						} else
							msgbox('', $lang['videos_nones_videos_user'], 'info_2');
					} else {
						if($get_user_id == $user_id)
							msgbox('', $lang['videos_nones_videos_user'], 'info_2');
						else
							msgbox('', $owner['user_search_pref'].' '.$lang['videos_none'], 'info_2');
					}
				} else
					Hacking();
			} else {
				$user_speedbar = $lang['error'];
				msgbox('', $lang['no_notes'], 'info');
			}
	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>