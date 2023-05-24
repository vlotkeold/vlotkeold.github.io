<?php
/* 
	Appointment: abouts
	File: abouts.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	
	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 20;
	$limit_page = ($page-1)*$gcount;
	
	switch($act){
		
		//################### �������� ���������� �� ###################//
		case "send":
			NoAjaxQuery();
			$title = ajax_utf8(textFilter($_POST['title'], false, true));
			if(isset($title) AND !empty($title)){
				$check = $db->super_query("SELECT time FROM `".PREFIX."_about` WHERE real_admin = '{$user_id}' order by id DESC limit 0,1");
				if($check['time'] > (time()-60)) die('ddos'); //60 - ��� ����������� ����� ����� ������� ����� ������� ����� ������.
				$db->query("INSERT INTO `".PREFIX."_about` SET title = '� �����', type = 1, traf = 0, ulist = '|{$user_id}|', date = NOW(), admin = 'u{$user_id}|', real_admin = '{$user_id}', time={$server_time}, comments = 1, privacy = 'p_contact|1||p_audio|1||'");
				$cid = $db->insert_id();
				
				@mkdir(ROOT_DIR.'/uploads/about/'.$cid.'/', 0777);
				@chmod(ROOT_DIR.'/uploads/about/'.$cid.'/', 0777);
				
				@mkdir(ROOT_DIR.'/uploads/about/'.$cid.'/photos/', 0777);
				@chmod(ROOT_DIR.'/uploads/about/'.$cid.'/photos/', 0777);
				
				mozg_mass_clear_cache_file("user_{$user_id}/profile_{$user_id}|about/{$user_id}");
				
				echo $cid;
			} else
				echo 'no_title';
				
			die();
		break;
		
		//################### �������� �������� �������� ���� ���������� ###################//
		case "loadphoto_page":
			NoAjaxQuery();
			$tpl->load_template('about/load_photo.tpl');
			$tpl->set('{id}', $_POST['id']);
			$tpl->compile('content');
			AjaxTpl();
			die();
		break;
		
		//################### �������� � ��������� �������� ���� ���������� ###################//
		case "loadphoto":
			NoAjaxQuery();
			
			$id = intval($_GET['id']);
			
			//�������� �� ��, ��� ���� ��������� ����H
			$row = $db->super_query("SELECT admin, photo, del, ban FROM `".PREFIX."_about` WHERE id = '{$id}'");
			if(stripos($row['admin'], "u{$user_id}|") !== false AND $row['del'] == 0 AND $row['ban'] == 0){
			
				//����������� �������
				$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');
				
				//�������� ������ � ����������
				$image_tmp = $_FILES['uploadfile']['tmp_name'];
				$image_name = totranslit($_FILES['uploadfile']['name']); // ������������ �������� ��� ����������� �������
				$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20); // ��� ����������
				$image_size = $_FILES['uploadfile']['size']; // ������ �����
				$type = end(explode(".", $image_name)); // ������ �����
				
				//�������� ����, ������ ������ �� ����������
				if(in_array(strtolower($type), $allowed_files)){
					if($image_size < 5000000){
						$res_type = strtolower('.'.$type);
						
						$upload_dir = ROOT_DIR."/uploads/about/{$id}/";

						if(move_uploaded_file($image_tmp, $upload_dir.$image_rename.$res_type)){
							//���������� ����� ��� ����������
							include ENGINE_DIR.'/classes/images.php';
							
							//�������� ���������
							$tmb = new thumbnail($upload_dir.$image_rename.$res_type);
							$tmb->size_auto(770);
							$tmb->jpeg_quality(95);
							$tmb->save($upload_dir.'o_'.$image_rename.$res_type);
							
							//�������� ��������� 200
							$tmb = new thumbnail($upload_dir.$image_rename.$res_type);
							$tmb->size_auto(200, 1);
							$tmb->jpeg_quality(97);
							$tmb->save($upload_dir.$image_rename.$res_type);

							//�������� ��������� ����� 100
							$tmb = new thumbnail($upload_dir.$image_rename.$res_type);
							$tmb->size_auto('100x100');
							$tmb->jpeg_quality('100');
							$tmb->save($upload_dir.'100_'.$image_rename.$res_type);
							
							//�������� ��������� ����� 50
							$tmb = new thumbnail($upload_dir.$image_rename.$res_type);
							$tmb->size_auto('50x50');
							$tmb->jpeg_quality('100');
							$tmb->save($upload_dir.'50_'.$image_rename.$res_type);

							if($row['photo']){
								@unlink($upload_dir.$row['photo']);
								@unlink($upload_dir.'50_'.$row['photo']);
								@unlink($upload_dir.'100_'.$row['photo']);
							}

							//��������� ����������
							$db->query("UPDATE `".PREFIX."_about` SET photo = '{$image_rename}{$res_type}' WHERE id = '{$id}'");

							//��������� ��� ������
							echo $image_rename.$res_type;
							
							mozg_clear_cache_folder('abouts');
						} else
							echo 'big_size';
					} else
						echo 'big_size';
				} else
					echo 'bad_format';
			}
			die();
		break;
		
		//################### ���������� ���� ���������� ###################//
		case "vphoto":
				$uid = intval($_POST['uid']);
				
				if($_POST['type'])
					$photo = ROOT_DIR."/uploads/attach/{$uid}/{$_POST['photo']}";
				else
					$photo = ROOT_DIR."/uploads/about/{$uid}/{$_POST['photo']}";
				
				if(file_exists($photo)){
					$tpl->load_template('photos/photo_profile.tpl');
					$tpl->set('{uid}', $uid);
					if($_POST['type'])
						$tpl->set('{photo}', "/uploads/attach/{$uid}/{$_POST['photo']}");
					else
						$tpl->set('{photo}', "/uploads/about/{$uid}/o_{$_POST['photo']}");
					$tpl->set('{close-link}', $_POST['close_link']);
					$tpl->compile('content');
					AjaxTpl();
				} else
					echo 'no_photo';
		break;
		
		//################### �������� ���� ���������� ###################//
		case "delphoto":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			
			//�������� �� ��, ��� ���� ������ �����
			$row = $db->super_query("SELECT photo, admin FROM `".PREFIX."_about` WHERE id = '{$id}'");
			if(stripos($row['admin'], "u{$user_id}|") !== false){				
				@unlink($upload_dir.$row['photo']);
				$db->query("UPDATE `".PREFIX."_about` SET photo = '' WHERE id = '{$id}'");
				
				mozg_clear_cache_folder('abouts');
			}
			die();
		break;
		
		//################### �������� ���������� ��������� ###################//
		case "addfeedback_pg":
			NoAjaxQuery();
			$tpl->load_template('about/addfeedback_pg.tpl');
			$tpl->set('{id}', $_POST['id']);
			$tpl->compile('content');
			AjaxTpl();
			die();
		break;
		
		//################### ���������� ������� � �� ###################//
		case "addfeedback_db":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			$upage = intval($_POST['upage']);
			$office = ajax_utf8(textFilter($_POST['office'], false, true));
			$phone = ajax_utf8(textFilter($_POST['phone'], false, true));
			$email = ajax_utf8(textFilter($_POST['email'], false, true));
			
			//�������� �� ��, ��� ��������� ������ �����
			$checkAdmin = $db->super_query("SELECT admin FROM `".PREFIX."_about` WHERE id = '{$id}'");
			
			//��������� ��� ����� ���� ���� �� �����
			$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_id = '{$upage}'");
			
			//��������� �� �� ��� ����� ��� � ������ ���������
			$checkSec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_about_feedback` WHERE fuser_id = '{$upage}' AND cid = '{$id}'");

			if($row['cnt'] AND stripos($checkAdmin['admin'], "u{$user_id}|") !== false AND !$checkSec['cnt']){
				$db->query("UPDATE `".PREFIX."_about` SET feedback = feedback+1 WHERE id = '{$id}'");
				$db->query("INSERT INTO `".PREFIX."_about_feedback` SET cid = '{$id}', fuser_id = '{$upage}', office = '{$office}', fphone = '{$phone}', femail = '{$email}', fdate = '{$server_time}'");
			} else
				echo 1;
			
			die();
		break;

		//################### �������� �������� �� �� ###################//
		case "delfeedback":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			$uid = intval($_POST['uid']);
			
			//�������� �� ��, ��� ��������� ������ �����
			$checkAdmin = $db->super_query("SELECT admin FROM `".PREFIX."_about` WHERE id = '{$id}'");
			
			//��������� �� �� ��� ����� ���� � ������ ���������
			$checkSec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_about_feedback` WHERE fuser_id = '{$uid}' AND cid = '{$id}'");
			
			if(stripos($checkAdmin['admin'], "u{$user_id}|") !== false AND $checkSec['cnt']){
				$db->query("UPDATE `".PREFIX."_about` SET feedback = feedback-1 WHERE id = '{$id}'");
				$db->query("DELETE FROM `".PREFIX."_about_feedback` WHERE fuser_id = '{$uid}' AND cid = '{$id}'");
			}
			
			die();
		break;
		
		//################### ������� ���������� ����� ��� �������� �� �������� ###################//
		case "checkFeedUser":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			$row = $db->super_query("SELECT user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
			if($row) echo $row['user_search_pref']."|".$row['user_photo'];
			die();
		break;
		
		//################### ���������� ���������������� ������ ������� � �� ###################//
		case "editfeeddave":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			$upage = intval($_POST['uid']);
			$office = ajax_utf8(textFilter($_POST['office'], false, true));
			$phone = ajax_utf8(textFilter($_POST['phone'], false, true));
			$email = ajax_utf8(textFilter($_POST['email'], false, true));
			
			//�������� �� ��, ��� ��������� ������ �����
			$checkAdmin = $db->super_query("SELECT admin FROM `".PREFIX."_about` WHERE id = '{$id}'");
			
			//��������� �� �� ��� ����� ���� � ������ ���������
			$checkSec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_about_feedback` WHERE fuser_id = '{$upage}' AND cid = '{$id}'");
			
			if(stripos($checkAdmin['admin'], "u{$user_id}|") !== false AND $checkSec['cnt']){
				$db->query("UPDATE `".PREFIX."_about_feedback` SET office = '{$office}', fphone = '{$phone}', femail = '{$email}' WHERE fuser_id = '{$upage}' AND cid = '{$id}'");
			} else
				echo 1;
			
			die();
		break;
		
		//################### ��� �������� (����) ###################//
		case "allfeedbacklist":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			
			//������� �� ������
			$owner = $db->super_query("SELECT admin FROM `".PREFIX."_about` WHERE id = '{$id}'");
			
			$sql_ = $db->super_query("SELECT tb1.fuser_id, office, fphone, femail, tb2.user_search_pref, user_photo FROM `".PREFIX."_about_feedback` tb1, `".PREFIX."_users` tb2 WHERE tb1.cid = '{$id}' AND tb1.fuser_id = tb2.user_id ORDER by `fdate` ASC", 1);
			$tpl->load_template('about/allfeedbacklist.tpl');
			if($sql_){
				foreach($sql_ as $row){
					$tpl->set('{id}', $id);
					$tpl->set('{name}', $row['user_search_pref']);
					$tpl->set('{office}', stripslashes($row['office']));
					$tpl->set('{phone}', stripslashes($row['fphone']));
					$tpl->set('{user-id}', $row['fuser_id']);
					if($row['fphone'] AND $row['femail']) $tpl->set('{email}', ', '.stripslashes($row['femail']));
					else $tpl->set('{email}', stripslashes($row['femail']));
					if($row['user_photo']) $tpl->set('{ava}', '/uploads/users/'.$row['fuser_id'].'/50_'.$row['user_photo']);
					else $tpl->set('{ava}', '{theme}/images/no_ava_50.png');
					if(stripos($owner['admin'], "u{$user_id}|") !== false){
						$tpl->set('[admin]', '');
						$tpl->set('[/admin]', '');
					} else
						$tpl->set_block("'\\[admin\\](.*?)\\[/admin\\]'si","");
					$tpl->compile('content');
				}
				AjaxTpl();
			} else
				echo '<div align="center" style="padding-top:10px;color:#777;font-size:13px;">������ ��������� ����.</div>';

			if(stripos($owner['admin'], "u{$user_id}|") !== false)
				echo "<style>#box_bottom_left_text{padding-top:6px;float:left}</style><script>$('#box_bottom_left_text').html('<a href=\"/\" onClick=\"about.addcontact({$id}); return false\">�������� �������</a>');</script>";
			
			die();
		break;
		
		//################### ���������� ���������������� ������ ������ ###################//
		case "saveinfo":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			$comments = intval($_POST['comments']);
			$audio = intval($_POST['audio']);
			$videos = intval($_POST['videos']);
			$contact = intval($_POST['contact']);
			$title = ajax_utf8(textFilter($_POST['title'], false, true));
			$adres_page = ajax_utf8(strtolower(textFilter($_POST['adres_page'], false, true)));
			$descr = ajax_utf8(textFilter($_POST['descr'], 5000));
			$_POST['gtype'] = str_replace(array('"', "'"), '', $_POST['gtype']);
            $gtype = ajax_utf8(textFilter($_POST['gtype'], false, true));
			$_POST['web'] = str_replace(array('"', "'"), '', $_POST['web']);
            $web = ajax_utf8(textFilter($_POST['web'], false, true));
			
			if($contact<0 or $contact>1) $contact = 0;
			if($audio<0 or $audio>1) $audio = 0;
			if($videos<0 or $videos>1) $videos = 0;
			
			if(!preg_match("/^[a-zA-Z0-9_-]+$/", $adres_page)) $adress_ok = false;
			else $adress_ok = true;
			
			$privacy = "p_audio|{$audio}||p_videos|{$videos}||p_contact|{$contact}|";

			//�������� �� ��, ��� ��������� ������ �����
			$checkAdmin = $db->super_query("SELECT admin FROM `".PREFIX."_about` WHERE id = '".$id."'");

			if(stripos($checkAdmin['admin'], "u{$user_id}|") !== false AND isset($title) AND !empty($title) AND $adress_ok){
				if(preg_match('/public[0-9]/i', $adres_page))
					$adres_page = '';
					
				//�������� �� ��, ��� ����� �������� ��������
				if($adres_page)
					$checkAdres = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities` WHERE adres = '".$adres_page."' AND id != '".$id."'");
					$chek_user = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE alias = '".$adres_page."' "); // ��������� ������ � �������������
				
				if(!$checkAdres['cnt'] AND !$chek_user['cnt'] OR $adres_page == ''){
					$db->query("UPDATE `".PREFIX."_communities` SET title = '".$title."', descr = '".$descr."', comments = '".$comments."', adres = 'about', gtype = '{$gtype}', web = '{$web}', privacy = '".$privacy."' WHERE id = '".$id."'");
					if(!$adres_page)
						echo 'no_new';
				} else
					echo 'err_adres';
					
				mozg_clear_cache_folder('abouts');
			}
			
			die();
		break;
		
		//################### ���������� ������ �� ����� ###################//
		case "wall_send":
			NoAjaxQuery();
			$about_id = intval($_POST['id']);
			$wall_text = ajax_utf8(textFilter($_POST['wall_text']));
			$attach_files = ajax_utf8(textFilter($_POST['attach_files'], false, true));
			
			//�������� �� ������
			$row = $db->super_query("SELECT admin, del, ban FROM `".PREFIX."_about` WHERE id = '{$about_id}'");
			if(stripos($row['admin'], "u{$user_id}|") !== false AND isset($wall_text) AND !empty($wall_text) OR isset($attach_files) AND !empty($attach_files) AND $row['del'] == 0 AND $row['ban'] == 0){
		
					//����������� ����������� � ������
					if(stripos($attach_files, 'link|') !== false){
						$attach_arr = explode('||', $attach_files);
						$cnt_attach_link = 1;
						foreach($attach_arr as $attach_file){
							$attach_type = explode('|', $attach_file);
							if($attach_type[0] == 'link' AND preg_match('/http:\/\/(.*?)+$/i', $attach_type[1]) AND $cnt_attach_link == 1){
								$domain_url_name = explode('/', $attach_type[1]);
								$rdomain_url_name = str_replace('http://', '', $domain_url_name[2]);
								$rImgUrl = $attach_type[4];
								$rImgUrl = str_replace("\\", "/", $rImgUrl);
								$img_name_arr = explode(".", $rImgUrl);
								$img_format = totranslit(end($img_name_arr));
								$image_name = substr(md5($server_time.md5($rImgUrl)), 0, 15);
										
								//����������� �������
								$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');

								//��������� �������� �� ����
								if(in_array(strtolower($img_format), $allowed_files) AND preg_match("/http:\/\/(.*?)(.jpg|.png|.gif|.jpeg|.jpe)/i", $rImgUrl)){
													
									//���������� �������� ����
									$upload_dir = ROOT_DIR.'/uploads/attach/'.$user_id;
														
									//���� ��� ����� �����, �� ������ �
									if(!is_dir($upload_dir)){ 
										@mkdir($upload_dir, 0777);
										@chmod($upload_dir, 0777);
									}
														
									//���������� ����� ��� ����������
									include ENGINE_DIR.'/classes/images.php';

									if(@copy($rImgUrl, $upload_dir.'/'.$image_name.'.'.$img_format)){
										$tmb = new thumbnail($upload_dir.'/'.$image_name.'.'.$img_format);
										$tmb->size_auto('100x80');
										$tmb->jpeg_quality(100);
										$tmb->save($upload_dir.'/'.$image_name.'.'.$img_format);
														
										$attach_files = str_replace($attach_type[4], '/uploads/attach/'.$user_id.'/'.$image_name.'.'.$img_format, $attach_files);
									}
								}
								$cnt_attach_link++;
							}
						}
					}
			
				$attach_files = str_replace('vote|', 'hack|', $attach_files);
				$attach_files = str_replace(array('&amp;#124;', '&amp;raquo;', '&amp;quot;'), array('&#124;', '&raquo;', '&quot;'), $attach_files);
							
				//�����������
				$vote_title = ajax_utf8(textFilter($_POST['vote_title'], false, true));
				$vote_answer_1 = ajax_utf8(textFilter($_POST['vote_answer_1'], false, true));

				$ansers_list = array();
							
				if(isset($vote_title) AND !empty($vote_title) AND isset($vote_answer_1) AND !empty($vote_answer_1)){
								
					for($vote_i = 1; $vote_i <= 10; $vote_i++){
									
						$vote_answer = ajax_utf8(textFilter($_POST['vote_answer_'.$vote_i], false, true));
						$vote_answer = str_replace('|', '&#124;', $vote_answer);
									
						if($vote_answer)
							$ansers_list[] = $vote_answer;
								
					}
								
					$sql_answers_list = implode('|', $ansers_list);
									
					//��������� ����������� � ��
					$db->query("INSERT INTO `".PREFIX."_votes` SET title = '{$vote_title}', answers = '{$sql_answers_list}'");
									
					$attach_files = $attach_files."vote|{$db->insert_id()}||";
								
				}
				
				//��������� ���� ������ � ��
				$db->query("INSERT INTO `".PREFIX."_about_wall` SET public_id = '{$about_id}', text = '{$wall_text}', attach = '{$attach_files}', add_date = '{$server_time}'");
				$dbid = $db->insert_id();
				$db->query("UPDATE `".PREFIX."_about` SET rec_num = rec_num+1 WHERE id = '{$about_id}'");
				
				//��������� ��� ������
				if(stripos($row['admin'], "u{$user_id}|") !== false)
					$about_admin = true;
				else
					$about_admin = false;
			
				$limit_select = 10;
				$about_id = $id;
				include ENGINE_DIR.'/classes/wall.about.php';
				$wall = new wall();
				$wall->query("SELECT SQL_CALC_FOUND_ROWS tb1.id, text, public_id, add_date, fasts_num, attach, likes_num, likes_users, tell_uid, public, tell_date, tell_comm, tb2.title, photo, comments FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_communities` tb2 WHERE tb1.public_id = '{$about_id}' AND tb1.public_id = tb2.id AND fast_comm_id = 0 ORDER by `add_date` DESC LIMIT 0, {$limit_select}");
				$wall->template('about/record.tpl');
				$wall->compile('content');
				$wall->select($about_admin, $server_time);
				AjaxTpl();
			}
			die();
		break;
		
		//################### �������� ������ ###################//
		case "wall_del":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			$about_id = intval($_POST['public_id']);

			//�������� �� ������ � ��������� �������� �� ��������
			if($about_id){
				$row = $db->super_query("SELECT admin FROM `".PREFIX."_about` WHERE id = '{$about_id}'");
				$row_rec = $db->super_query("SELECT fast_comm_id, public_id FROM `".PREFIX."_about_wall` WHERE id = '{$rec_id}'");
			} else
				$row = $db->super_query("SELECT tb1.public_id, attach, tb2.admin FROM `".PREFIX."_about_wall` tb1, `".PREFIX."_about` tb2 WHERE tb1.public_id = tb2.id AND tb1.id = '{$rec_id}'");

			if(stripos($row['admin'], "u{$user_id}|") !== false OR $user_id == $row_rec['public_id']){
				if($about_id)
					$db->query("UPDATE `".PREFIX."_communities_wall` SET fasts_num = fasts_num-1 WHERE id = '{$row_rec['fast_comm_id']}'");
				else {
					$db->query("DELETE FROM `".PREFIX."_communities_wall` WHERE fast_comm_id = '{$rec_id}'");
					$db->query("DELETE FROM `".PREFIX."_news` WHERE obj_id = '{$rec_id}' AND action_type = '11'");
					$db->query("UPDATE `".PREFIX."_communities` SET rec_num = rec_num-1 WHERE id = '{$row['about_id']}'");
					
					//������� ����� �� ������������ ������, ���� ��� ����
					if(stripos($row['attach'], 'link|') !== false){
						$attach_arr = explode('link|', $row['attach']);
						$attach_arr2 = explode('|/uploads/attach/'.$user_id.'/', $attach_arr[1]);
						$attach_arr3 = explode('||', $attach_arr2[1]);
						if($attach_arr3[0])
							@unlink(ROOT_DIR.'/uploads/attach/'.$user_id.'/'.$attach_arr3[0]);	
					}
				}
				
				$db->query("DELETE FROM `".PREFIX."_about_wall` WHERE id = '{$rec_id}'");
			}
			die();
		break;
		
		//################### �������� �������� ���� � ���������� ###################//
		case "photos":
			NoAjaxQuery();
			$about_id = intval($_POST['public_id']);
			$rowPublic = $db->super_query("SELECT admin, photos_num FROM `".PREFIX."_about` WHERE id = '{$about_id}'");
			if(stripos($rowPublic['admin'], "u{$user_id}|") !== false){
				
				if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
				$gcount = 36;
				$limit_page = ($page-1)*$gcount;
			
				//HEAD
				$tpl->load_template('about/photos/head.tpl');
				$tpl->set('{photo-num}', $rowPublic['photos_num'].' '.gram_record($rowPublic['photos_num'], 'photos'));
				$tpl->set('{public_id}', $about_id);
				$tpl->set('[top]', '');
				$tpl->set('[/top]', '');
				$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
				$tpl->compile('info');
				
				//������� ����������
				if($rowPublic['photos_num']){
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS photo FROM `".PREFIX."_communities_photos` WHERE public_id = '{$about_id}' ORDER by `add_date` DESC LIMIT {$limit_page}, {$gcount}", 1);
					$tpl->load_template('about/photos/photo.tpl');
					foreach($sql_ as $row){
						$tpl->set('{photo}', $row['photo']);
						$tpl->set('{public-id}', $about_id);
						$tpl->compile('content');
					}
					box_navigation($gcount, $rowPublic['photos_num'], $page, 'about.wall_attach_addphoto', $about_id);
				} else
					msgbox('', '<div class="clear" style="margin-top:150px;margin-left:27px"></div>� ������� ���������� ��� ����������� ����������.', 'info_2');
				
				//BOTTOM
				$tpl->load_template('about/photos/head.tpl');
				$tpl->set('[bottom]', '');
				$tpl->set('[/bottom]', '');
				$tpl->set_block("'\\[top\\](.*?)\\[/top\\]'si","");
				$tpl->compile('content');
				
				AjaxTpl();
			}
			die();
		break;
		
		//################### ������� ���� � ����� ��� ������������ ����� �� ����� ###################//
		case "select_video_info":
			NoAjaxQuery();
			$video_id = intval($_POST['video_id']);
			$row = $db->super_query("SELECT photo FROM `".PREFIX."_videos` WHERE id = '".$video_id."'");
			if($row){
				$photo = end(explode('/', $row['photo']));
				echo $photo;
			} else
				echo '1';
			
			die();
		break;
		
		//################### ������ ��� �������� ###################//
		case "wall_like_yes":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			$row = $db->super_query("SELECT likes_users FROM `".PREFIX."_about_wall` WHERE id = '".$rec_id."'");
			if($row AND stripos($row['likes_users'], "u{$user_id}|") === false){
				$likes_users = "u{$user_id}|".$row['likes_users'];
				$db->query("UPDATE `".PREFIX."_about_wall` SET likes_num = likes_num+1, likes_users = '{$likes_users}' WHERE id = '".$rec_id."'");
				$db->query("INSERT INTO `".PREFIX."_about_wall_like` SET rec_id = '".$rec_id."', user_id = '".$user_id."', date = '".$server_time."'");
			}
			die();
		break;
		
		//################### ������� ��� �������� ###################//
		case "wall_like_remove":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			$row = $db->super_query("SELECT likes_users FROM `".PREFIX."_about_wall` WHERE id = '".$rec_id."'");
			if(stripos($row['likes_users'], "u{$user_id}|") !== false){
				$likes_users = str_replace("u{$user_id}|", '', $row['likes_users']);
				$db->query("UPDATE `".PREFIX."_about_wall` SET likes_num = likes_num-1, likes_users = '{$likes_users}' WHERE id = '".$rec_id."'");
				$db->query("DELETE FROM `".PREFIX."_about_wall_like` WHERE rec_id = '".$rec_id."' AND user_id = '".$user_id."'");
			}
			die();
		break;
		
		//################### ������� ��������� 7 ������ ��� �������� "��� ��������" ###################//
		case "wall_like_users_five":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, user_search_pref, tb2.user_photo FROM `".PREFIX."_about_wall_like` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.rec_id = '{$rec_id}' ORDER by `date` DESC LIMIT 0, 7", 1);
			if($sql_){
				foreach($sql_ as $row){
					if($row['user_photo']) $ava = '/uploads/users/'.$row['user_id'].'/50_'.$row['user_photo'];
					else $ava = '/templates/'.$config['temp'].'/images/no_ava_50.png';
					echo '<a href="/id'.$row['user_id'].'" id="Xlike_user'.$row['user_id'].'_'.$rec_id.'" onClick="Page.Go(this.href); return false"><img src="'.$ava.'" width="32" title="'.$row['user_search_pref'].'"/></a>';
				}
			}
			die();
		break;
		
		//################### ������� ���� ������ ������� ��������� "��� ��������" ###################//
		case "all_liked_users":
			NoAjaxQuery();
			$rid = intval($_POST['rid']);
			$liked_num = intval($_POST['liked_num']);
			
			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 24;
			$limit_page = ($page-1)*$gcount;
			
			if(!$liked_num)
				$liked_num = 24;
			
			if($rid AND $liked_num){
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, tb2.user_photo, user_search_pref FROM `".PREFIX."_about_wall_like` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.rec_id = '{$rid}' ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);
				
				if($sql_){
					$tpl->load_template('profile_subscription_box_top_like.tpl');
					$tpl->set('[top]', '');
					$tpl->set('[/top]', '');
					$tpl->set('{subcr-num}', $liked_num.' ');
					$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
					$tpl->compile('content');
					
					$tpl->result['content'] = str_replace('�����', '', $tpl->result['content']);
					
					$tpl->load_template('profile_likes.tpl');
					foreach($sql_ as $row){
						if($row['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava.gif');
						$friend_info_online = explode(' ', $row['user_search_pref']);
						$tpl->set('{user-id}', $row['user_id']);
						$tpl->set('{name}', $friend_info_online[0]);
						$tpl->set('{last-name}', $friend_info_online[1]);
						$tpl->compile('content');
					}
					box_navigation($gcount, $liked_num, $rid, 'about.wall_all_liked_users', $liked_num);
					
					AjaxTpl();
				}
			}
			die();
		break;
		
	default:
		
			//################### �������� ###################//
			$owner = $db->super_query("SELECT user_public_num FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$admin_site = $db->super_query("SELECT user_group FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			if(stripos($admin_site['user_group'], "1") !== false){
			if($act == 'admin'){
				$tpl->load_template('about/head_admin.tpl');
				$sql_sort = "SELECT SQL_CALC_FOUND_ROWS id, title, photo, traf, adres FROM `".PREFIX."_about` WHERE admin regexp '[[:<:]](u{$user_id})[[:>:]]' ORDER by `traf` DESC LIMIT {$limit_page}, {$gcount}";
				$sql_count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_about` WHERE admin regexp '[[:<:]](u{$user_id})[[:>:]]'");
				$owner['user_public_num'] = $sql_count['cnt'];
			} else {
				$sql_sort = "SELECT SQL_CALC_FOUND_ROWS tb1.friend_id, tb2.id, title, photo, traf, adres, gtype FROM `".PREFIX."_friends` tb1, `".PREFIX."_communities` tb2 WHERE tb1.user_id = '{$user_id}' AND tb1.friend_id = tb2.id AND tb1.subscriptions = 2 ORDER by `traf` DESC LIMIT {$limit_page}, {$gcount}";
				$tpl->load_template('about/head.tpl');
			}
			$tpl->compile('info');
	}
	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>