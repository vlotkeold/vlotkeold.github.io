<?php
/* 
	Appointment: ������
	File: groups.php 
 
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
	
	$metatags['title'] = $lang['communities'];
	
	switch($act){
		
		//################### �������� ���������� �� ###################//
		case "send":
			NoAjaxQuery();
			$title = ajax_utf8(textFilter($_POST['title'], false, true));
			if(isset($title) AND !empty($title)){
				$check = $db->super_query("SELECT time FROM `".PREFIX."_communities` WHERE real_admin = '{$user_id}' order by id DESC limit 0,1");
				if($check['time'] > (time()-60)) die('ddos'); //60 - ��� ����������� ����� ����� ������� ����� ������� ����� ������.
				$db->query("INSERT INTO `".PREFIX."_communities` SET title = '{$title}', type = 1, traf = 1, ulist = '|{$user_id}|', date = NOW(), admin = 'u{$user_id}|', real_admin = '{$user_id}', time={$server_time}, comments = 1, privacy = 'p_audio|1||p_contact|1||p_videos|1||p_links|1||p_lastnews|1||p_albums|1||'");
				$cid = $db->insert_id();
				$db->query("INSERT INTO `".PREFIX."_friends` SET friend_id = '{$cid}', user_id = '{$user_id}', friends_date = NOW(), subscriptions = 2");
				$db->query("INSERT INTO `".PREFIX."_communities_admins` SET user_id = '{$user_id}', pid = '{$cid}', level = 1");
				$db->query("UPDATE `".PREFIX."_users` SET user_public_num = user_public_num+1 WHERE user_id = '{$user_id}'");
				
				@mkdir(ROOT_DIR.'/uploads/groups/'.$cid.'/', 0777);
				@chmod(ROOT_DIR.'/uploads/groups/'.$cid.'/', 0777);
				
				@mkdir(ROOT_DIR.'/uploads/groups/'.$cid.'/photos/', 0777);
				@chmod(ROOT_DIR.'/uploads/groups/'.$cid.'/photos/', 0777);
				
				mozg_mass_clear_cache_file("user_{$user_id}/profile_{$user_id}|groups/{$user_id}");
				
				echo $cid;
			} else
				echo 'no_title';
				
			die();
		break;
		
		//################### ����� �� ���������� ###################//
		case "exit":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			$check = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_friends` WHERE friend_id = '{$id}' AND user_id = '{$user_id}' AND subscriptions = 2");
			if($check['cnt']){
				$db->query("DELETE FROM `".PREFIX."_friends` WHERE friend_id = '{$id}' AND user_id = '{$user_id}' AND subscriptions = 2");
				$db->query("UPDATE `".PREFIX."_users` SET user_public_num = user_public_num-1 WHERE user_id = '{$user_id}'");
				$db->query("UPDATE `".PREFIX."_communities` SET traf = traf-1, ulist = REPLACE(ulist, '|{$user_id}|', '') WHERE id = '{$id}'");
				
				mozg_mass_clear_cache_file("user_{$user_id}/profile_{$user_id}|groups/{$user_id}");
			}
			die();
		break;
		
		//################### �������� �������� �������� ���� ���������� ###################//
		case "loadphoto_page":
			NoAjaxQuery();
			$tpl->load_template('groups/load_photo.tpl');
			$tpl->set('{id}', $_POST['id']);
			$tpl->compile('content');
			AjaxTpl();
			die();
		break;
		
		case "subscribes":
			NoAjaxQuery();
			$pid = $_POST['pid'];
			if(!$_POST['page_cnt'] or $_POST['fave']) $page_cnt = 0;
			else $page_cnt = $_POST['page_cnt']*40;
			$traf = $db->super_query("SELECT traf, ulist FROM `".PREFIX."_communities` WHERE id = '{$pid}'");
			$traf_users = array_slice(str_replace('|','',explode('||', $traf['ulist'])), $page_cnt, 40);
			$i = 0;
			$array_friends = array();
			foreach($traf_users as $row) {
				$check_friendlist = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE friend_id = '{$user_id}' AND user_id = '{$row}' AND subscriptions = 0");
				if($check_friendlist) {
					$i++;
					if($_GET['friends']) array_push($array_friends, $row);
				}
				if(!$_GET['friends']) {
					$rwi = $db->super_query("SELECT user_search_pref, alias, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$row}'");
					$tpl->load_template('groups/subsp.tpl');
					$tpl->set('{name}', $rwi['user_search_pref']);
					$row_view_photos = $db->super_query("SELECT * FROM `".PREFIX."_photos` WHERE user_id = '{$row['user_id']}'");
					$tpl->set('{photoid}', $row_view_photos['id']);
					$tpl->set('{albumid}', $row_view_photos['album_id']);
					if($rwi['user_photo'] != ''){
					$tpl->set('[yes_photo]', '');
					$tpl->set('[/yes_photo]', '');
					} else
					$tpl->set_block("'\\[yes_photo\\](.*?)\\[/yes_photo\\]'si","");
					if($rwi['user_photo']) $avatar = $config['home_url'].'uploads/users/'.$row.'/'.$rwi['user_photo'];
					else $avatar = $config['home_url'].'templates/Default/images/100_no_ava.png';
					$tpl->set('{ava}', $avatar);
					$tpl->set('{leftava}', $rwi['user_photo']);
					$tpl->set('{id}', $row);
					if($rwi['alias']) $adres = $rwi['alias'];
					else $adres = 'id'.$row;
					$tpl->set('{adres}', $adres);
					$tpl->compile('user');
				}
			}
			if($_GET['friends']) {
				foreach($array_friends as $row) {
					$rwi = $db->super_query("SELECT user_search_pref, alias, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$row}'");
					$tpl->load_template('groups/subsp.tpl');
					$tpl->set('{name}', $rwi['user_search_pref']);
					$row_view_photos = $db->super_query("SELECT * FROM `".PREFIX."_photos` WHERE user_id = '{$row['user_id']}'");
					$tpl->set('{photoid}', $row_view_photos['id']);
					$tpl->set('{albumid}', $row_view_photos['album_id']);
					if($rwi['user_photo'] != ''){
					$tpl->set('[yes_photo]', '');
					$tpl->set('[/yes_photo]', '');
					} else
					$tpl->set_block("'\\[yes_photo\\](.*?)\\[/yes_photo\\]'si","");
					if($rwi['user_photo']) $avatar = $config['home_url'].'uploads/users/'.$row.'/'.$rwi['user_photo'];
					else $avatar = $config['home_url'].'templates/Default/images/100_no_ava.png';
					$tpl->set('{ava}', $avatar);
					$tpl->set('{leftava}', $rwi['user_photo']);
					$tpl->set('{id}', $row);
					if($rwi['alias']) $adres = $rwi['alias'];
					else $adres = 'id'.$row;
					$tpl->set('{adres}', $adres);
					$tpl->compile('user');
				}
			}
			if($_GET['friends']) $m = $i;
			else $m = $traf['traf'];
			if($m>5 and $m<=10) $top = '150';
			else if($m>10 and $m<=20) $top = '50';
			else if($m>20) $top = '20';
			else $top = '250';
			if(!$_POST['page_cnt']) {
				$tpl->load_template('groups/subscribes.tpl');
				$tpl->set('{count_subscribe}', $traf['traf']);
				$tpl->set('{count_friends}', $i);
				$tpl->set('{top}', $top);
				$tpl->set('{users}', $tpl->result['user']);
				if($i) {
					$tpl->set('[friends]', '');
					$tpl->set('[/friends]', '');
				} else $tpl->set_block("'\\[friends\\](.*?)\\[/friends\\]'si","");
				$tpl->set('{pid}', $pid);
				$tpl->compile('content');
			}
			$tpl->result['user'] = $top.'<f>'.$tpl->result['user'];
			if($_POST['page_cnt']) echo $tpl->result['user'];
			AjaxTpl();
			die();
		break;
		
		//################### �������� � ��������� �������� ���� ���������� ###################//
		case "loadphoto":
			NoAjaxQuery();
			
			$id = intval($_GET['id']);
			
			//�������� �� ��, ��� ���� ��������� ����H
			$row = $db->super_query("SELECT admin, photo, del, ban FROM `".PREFIX."_communities` WHERE id = '{$id}'");
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
						
						$upload_dir = ROOT_DIR."/uploads/groups/{$id}/";

						if(move_uploaded_file($image_tmp, $upload_dir.$image_rename.$res_type)){
							//���������� ����� ��� ����������
							include ENGINE_DIR.'/classes/images.php';
							
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
						
							//��������� �� �����
							$wall_text = "<div class=\"profile_update_photo\"><a href=\"\" onClick=\"epage.vPhoto2(\'{$id}\', \'o_{$image_rename}{$res_type}\'); return false\"><img src=\"/uploads/groups/{$id}/o_{$image_rename}{$res_type}\" style=\"margin-top:3px\"></a></div>";
						
							$db->query("INSERT INTO `".PREFIX."_communities_wall` SET public_id = '{$id}', text = '{$wall_text}', add_date = '{$server_time}', type = '� ���������� ���������� ����������:'");
							$dbid = $db->insert_id();
						
							$db->query("UPDATE `".PREFIX."_communities` SET rec_num = rec_num+1 WHERE id = '{$id}'");

							//��������� ����������
							$db->query("UPDATE `".PREFIX."_communities` SET photo = '{$image_rename}{$res_type}' WHERE id = '{$id}'");

							//��������� ��� ������
							echo $image_rename.$res_type;
							
							mozg_clear_cache_folder('groups');
						} else
							echo 'big_size';
					} else
						echo 'big_size';
				} else
					echo 'bad_format';
			}
			die();
		break;
		
		//################### �������� ���� ���������� ###################//
		case "delphoto":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			
			//�������� �� ��, ��� ���� ������ �����
			$row = $db->super_query("SELECT photo, admin FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			if(stripos($row['admin'], "u{$user_id}|") !== false){				
				@unlink($upload_dir.$row['photo']);
				$db->query("UPDATE `".PREFIX."_communities` SET photo = '' WHERE id = '{$id}'");
				
				mozg_clear_cache_folder('groups');
			}
			die();
		break;
		
		//################### ���������� � ���������� ###################//
		case "login":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			
			//�������� �� ������������� ����� � ����������
			$row = $db->super_query("SELECT ulist, del, ban FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			if(stripos($row['ulist'], "|{$user_id}|") === false AND $row['del'] == 0 AND $row['ban'] == 0){
				$ulist = $row['ulist']."|{$user_id}|";
				$db->query("UPDATE `".PREFIX."_communities` SET traf = traf+1, ulist = '{$ulist}' WHERE id = '{$id}'");
				$db->query("UPDATE `".PREFIX."_users` SET user_public_num = user_public_num+1 WHERE user_id = '{$user_id}'");
				$db->query("INSERT INTO `".PREFIX."_friends` SET friend_id = '{$id}', user_id = '{$user_id}', friends_date = NOW(), subscriptions = 2");
				
				mozg_mass_clear_cache_file("user_{$user_id}/profile_{$user_id}|groups/{$user_id}");
			}
			die();
		break;
		
		//################### �������� ���������� ��������� ###################//
		case "addfeedback_pg":
			NoAjaxQuery();
			$tpl->load_template('groups/addfeedback_pg.tpl');
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
			$checkAdmin = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			
			//��������� ��� ����� ���� ���� �� �����
			$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_id = '{$upage}'");
			
			//��������� �� �� ��� ����� ��� � ������ ���������
			$checkSec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities_feedback` WHERE fuser_id = '{$upage}' AND cid = '{$id}'");

			if($row['cnt'] AND stripos($checkAdmin['admin'], "u{$user_id}|") !== false AND !$checkSec['cnt']){
				$db->query("UPDATE `".PREFIX."_communities` SET feedback = feedback+1 WHERE id = '{$id}'");
				$db->query("INSERT INTO `".PREFIX."_communities_feedback` SET cid = '{$id}', fuser_id = '{$upage}', visible = '1', office = '{$office}', fphone = '{$phone}', femail = '{$email}', fdate = '{$server_time}'");
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
			$checkAdmin = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			
			//��������� �� �� ��� ����� ���� � ������ ���������
			$checkSec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities_feedback` WHERE fuser_id = '{$uid}' AND cid = '{$id}'");
			
			if(stripos($checkAdmin['admin'], "u{$user_id}|") !== false AND $checkSec['cnt']){
				$db->query("UPDATE `".PREFIX."_communities` SET feedback = feedback-1 WHERE id = '{$id}'");
				$db->query("DELETE FROM `".PREFIX."_communities_feedback` WHERE fuser_id = '{$uid}' AND cid = '{$id}'");
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
			$checkAdmin = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			
			//��������� �� �� ��� ����� ���� � ������ ���������
			$checkSec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities_feedback` WHERE fuser_id = '{$upage}' AND cid = '{$id}'");
			
			if(stripos($checkAdmin['admin'], "u{$user_id}|") !== false AND $checkSec['cnt']){
				$db->query("UPDATE `".PREFIX."_communities_feedback` SET office = '{$office}', fphone = '{$phone}', femail = '{$email}' WHERE fuser_id = '{$upage}' AND cid = '{$id}'");
			} else
				echo 1;
			
			die();
		break;
		
		//################### ��� �������� (����) ###################//
		case "allfeedbacklist":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			
			//������� �� ������
			$owner = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			
			$sql_ = $db->super_query("SELECT tb1.fuser_id, office, fphone, femail, visible, tb2.user_search_pref, user_photo FROM `".PREFIX."_communities_feedback` tb1, `".PREFIX."_users` tb2 WHERE tb1.visible = '1' AND tb1.cid = '{$id}' AND tb1.fuser_id = tb2.user_id ORDER by `fdate` ASC", 1);
			$tpl->load_template('groups/allfeedbacklist.tpl');
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
				echo "<style>#box_bottom_left_text{padding-top:6px;float:left}</style><script>$('#box_bottom_left_text').html('<a href=\"/\" onClick=\"groups.addcontact({$id}); return false\">�������� �������</a>');</script>";
			
			die();
		break;
		
		case "links":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			
			//������� �� ������
			$owner = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			
			$linkSQL = $db->super_query("SELECT link, photo, descr, name, id, outweb, screen FROM `".PREFIX."_communities_links` WHERE pid = '{$id}' ORDER BY position ASC",1);
			$tpl->load_template('groups/links.tpl');
			if($linkSQL){
				foreach($linkSQL as $row){
					$tpl->set('{link}', $row['link']);
					$tpl->set('{name}', $row['name']);
					$tpl->set('{descr}', stripslashes($row['descr']));
					$tpl->set('{ava}', $row['photo']);
					if(stripos($owner['admin'], "u{$user_id}|") !== false){
						$tpl->set('[admin]', '');
						$tpl->set('[/admin]', '');
					} else
						$tpl->set_block("'\\[admin\\](.*?)\\[/admin\\]'si","");
					$tpl->compile('content');
				}
				AjaxTpl();
			} else
				echo '<div align="center" style="padding-top:10px;color:#777;font-size:13px;">������ ������ ����.</div>';

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
			$checkAdmin = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '".$id."'");

			if(stripos($checkAdmin['admin'], "u{$user_id}|") !== false AND isset($title) AND !empty($title) AND $adress_ok){
				if(preg_match('/public[0-9]/i', $adres_page))
					$adres_page = '';
					
				//�������� �� ��, ��� ����� �������� ��������
				if($adres_page)
					$checkAdres = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities` WHERE adres = '".$adres_page."' AND id != '".$id."'");
					$chek_user = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE alias = '".$adres_page."' "); // ��������� ������ � �������������
				
				if(!$checkAdres['cnt'] AND !$chek_user['cnt'] OR $adres_page == ''){
					$db->query("UPDATE `".PREFIX."_communities` SET title = '".$title."', descr = '".$descr."', comments = '".$comments."', adres = '".$adres_page."', gtype = '{$gtype}', web = '{$web}', privacy = '".$privacy."' WHERE id = '".$id."'");
					if(!$adres_page)
						echo 'no_new';
				} else
					echo 'err_adres';
					
				mozg_clear_cache_folder('groups');
			}
			
			die();
		break;
		
		//################### ������� ���������� � ������������ �������� ����� ������ ������� ###################//
		case "new_admin":
			NoAjaxQuery();
			$new_admin_id = intval($_POST['new_admin_id']);
			$row = $db->super_query("SELECT tb1.user_id, tb2.user_photo, user_search_pref, user_sex FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$new_admin_id}' AND tb1.user_id = tb2.user_id AND tb1.subscriptions = 2");
			if($row AND $user_id != $new_admin_id){
				if($row['user_photo']) $ava = "/uploads/users/{$new_admin_id}/100_{$row['user_photo']}";
				else $ava = "/templates/{$config['temp']}/images/100_no_ava.png";
				if($row['user_sex'] == 1) $gram = '���';
				else $gram = '����';
				echo "<div style=\"padding:15px\"><img src=\"{$ava}\" align=\"left\" style=\"margin-right:10px\" id=\"adm_ava\" />�� ������ ���� <b id=\"adm_name\">{$row['user_search_pref']}</b> {$gram} ����� �� ������������� ��������?</div>";
			} else
				echo "<div style=\"padding:15px\"><div class=\"err_red\">������������ � ����� ������� �������� �� �������� �� ��� ��������.</div></div><script>$('#box_but').hide()</script>";
			
			die();
		break;
		
		//################### ������ ������ ������ � �� ###################//
		case "send_new_admin":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			$new_admin_id = intval($_POST['new_admin_id']);
			$row = $db->super_query("SELECT admin, ulist FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			if(stripos($row['admin'], "u{$user_id}|") !== false AND stripos($row['admin'], "u{$new_admin_id}|") === false AND stripos($row['ulist'], "|{$user_id}|") !== false){
				$admin = $row['admin']."u{$new_admin_id}|";
				$db->query("UPDATE `".PREFIX."_communities` SET admin = '{$admin}' WHERE id = '{$id}'");
			}
			die();
		break;
		
		//################### �������� ������ �� �� ###################//
		case "deladmin":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			$uid = intval($_POST['uid']);
			$row = $db->super_query("SELECT admin, ulist, real_admin FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			if(stripos($row['admin'], "u{$user_id}|") !== false AND stripos($row['admin'], "u{$uid}|") !== false AND $uid != $row['real_admin']){
				$admin = str_replace("u{$uid}|", '', $row['admin']);
				$db->query("UPDATE `".PREFIX."_communities` SET admin = '{$admin}' WHERE id = '{$id}'");
			}
			die();
		break;
		
		//################### ���������� ������ �� ����� ###################//
		case "wall_send":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			include ENGINE_DIR.'/classes/forwall.php';
			$parse = new parse();		
			$wall_text = $parse->BBparse(ajax_utf8(textFilter($_POST['wall_text'])));	
			$attach_files = ajax_utf8(textFilter($_POST['attach_files'], false, true));
			$podpis = intval($_POST['podpis']);
			
			//�������� �� ������
			$row = $db->super_query("SELECT admin, del, ban FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			if($podpis == 1 and stripos($row['admin'], "u{$user_id}|") !== false) $podpis = 1;
			else $podpis = 0;
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
				$db->query("INSERT INTO `".PREFIX."_communities_wall` SET public_id = '{$id}', text = '{$wall_text}', attach = '{$attach_files}', add_date = '{$server_time}', uid = '{$user_id}', view_author = '{$podpis}'");
				$dbid = $db->insert_id();
				$db->query("UPDATE `".PREFIX."_communities` SET rec_num = rec_num+1 WHERE id = '{$id}'");
				
				//��������� � ����� ��������
				$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$id}', action_type = 11, action_text = '{$wall_text}', obj_id = '{$dbid}', action_time = '{$server_time}'");
				
				//��������� ��� ������
				if(stripos($row['admin'], "u{$user_id}|") !== false)
					$public_admin = true;
				else
					$public_admin = false;
			
				$limit_select = 10;
				$pid = $id;
				include ENGINE_DIR.'/classes/wall.public.php';
				$wall = new wall();
				$wall->query("SELECT SQL_CALC_FOUND_ROWS tb1.id, tb1.uid, tb1.view_author, text, public_id, add_date, fasts_num, attach, likes_num, likes_users, tell_uid, public, tell_date, tell_comm, tb2.title, photo, comments FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_communities` tb2 WHERE tb1.public_id = '{$id}' AND tb1.public_id = tb2.id AND fast_comm_id = 0 ORDER by `add_date` DESC LIMIT 0, {$limit_select}");
				$wall->template('groups/record.tpl');
				$wall->compile('content');
				$wall->select($public_admin, $server_time);
				AjaxTpl();
			}
			die();
		break;
		
		//################### ���������� ����������� � ������ ###################//
		case "wall_send_comm":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			$public_id = intval($_POST['public_id']);
			$for_groups = intval($_POST['for_groups']);
			include ENGINE_DIR.'/classes/forwall.php';
			$parse = new parse();		
			$wall_text = $parse->BBparse(ajax_utf8(textFilter($_POST['wall_text'])));
			$answer_comm = intval($_POST['answer_comm']);
			
			$row_rec_id = $db->super_query("SELECT fast_comm_id FROM `".PREFIX."_communities_wall` WHERE id = '{$answer_comm}'");
			if(!$row_rec_id OR $row_rec_id['fast_comm_id'] == 0) $answer_comm = 0;
	
			//�������� �� ������ � ��������� �������� �� ��������
			$row = $db->super_query("SELECT tb1.fasts_num, tb2.admin, comments FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_communities` tb2 WHERE tb1.public_id = tb2.id AND tb1.id = '{$rec_id}'");
			
			if($row['comments'] OR stripos($row['admin'], "u{$user_id}|") !== false AND isset($wall_text) AND !empty($wall_text)){

				//��������� ���� ������ � ��
				$db->query("INSERT INTO `".PREFIX."_communities_wall` SET public_id = '{$user_id}', text = '{$wall_text}', add_date = '{$server_time}', fast_comm_id = '{$rec_id}', for_groups = '{$for_groups}', rec_answer = '{$answer_comm}'");
				$db->query("UPDATE `".PREFIX."_communities_wall` SET fasts_num = fasts_num+1 WHERE id = '{$rec_id}'");

				$row['fasts_num'] = $row['fasts_num']+1;
				
				if($row['fasts_num'] > 3)
					$comments_limit = $row['fasts_num']-3;
				else
					$comments_limit = 0;
						
				$sql_comments = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.id, public_id, text, add_date, for_groups, rec_answer, tb2.user_photo, user_search_pref FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_users` tb2 WHERE tb1.public_id = tb2.user_id AND tb1.fast_comm_id = '{$rec_id}' ORDER by `add_date` ASC LIMIT {$comments_limit}, 3", 1);
				
				//��������� ������ "�������� N ������"
				$tpl->load_template('groups/record.tpl');
				$tpl->set('{gram-record-all-comm}', gram_record(($row['fasts_num']-3), 'prev').' '.($row['fasts_num']-3).' '.gram_record(($row['fasts_num']-3), 'comments'));
				if($row['fasts_num'] < 4)
					$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
				else {
					$tpl->set('{rec-id}', $rec_id);
					$tpl->set('[all-comm]', '');
					$tpl->set('[/all-comm]', '');
				}
				$tpl->set('{public-id}', $public_id);
				$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
				$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
				$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
				$tpl->compile('content');
					
				$tpl->load_template('groups/record.tpl');
				//����������� ������� ��������
				foreach($sql_comments as $row_comments){
					$tpl->set('{public-id}', $public_id);
					$tpl->set('{rec-id}', $rec_id);
					
					if($row_comments['for_groups']) {
						$row_public = $db->super_query("SELECT title, photo FROM `".PREFIX."_communities` WHERE id = '{$public_id}'");
						$tpl->set('{name}', $row_public['title']);
						if($row_public['photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/groups/'.$public_id.'/50_'.$row_public['photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						$tpl->set('{comm-id}', $row_comments['id']);
						$tpl->set('{user-id}', $public_id);
						$tpl->set('{prefix}', 'public');
					} else {
						$tpl->set('{name}', $row_comments['user_search_pref']);
						if($row_comments['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comments['public_id'].'/50_'.$row_comments['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						$tpl->set('{comm-id}', $row_comments['id']);
						$tpl->set('{user-id}', $row_comments['public_id']);
						$tpl->set('{prefix}', 'id');
					}
					
					$expBR2 = explode('<br />', $row_comments['text']);
					$textLength2 = count($expBR2);
					$strTXT2 = strlen($row_comments['text']);
					if($textLength2 > 6 OR $strTXT2 > 470)
						$row_comments['text'] = '<div class="wall_strlen" id="hide_wall_rec'.$row_comments['id'].'" style="max-height:102px"">'.$row_comments['text'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row_comments['id'].', this.id)" id="hide_wall_rec_lnk'.$row_comments['id'].'">�������� ���������..</div>';
										
					$tpl->set('{text}', stripslashes($row_comments['text']));
					megaDate($row_comments['add_date']);
					if($row_comments['rec_answer']) {
						$row_rec_id = $db->super_query("SELECT public_id FROM `".PREFIX."_communities_wall` WHERE id = '{$row_comments['rec_answer']}'");
						$row_rec_name = $db->super_query("SELECT user_name FROM `".PREFIX."_users` WHERE user_id = '{$row_rec_id['public_id']}'");
						$tpl->set('{rec_answer_name}', gramatikName($row_rec_name['user_name']));
						$tpl->set('{rec_answer_id}', $row_comments['rec_answer']);
					} else {
						$tpl->set('{rec_answer_name}', '');
						$tpl->set('{rec_answer_id}', '');
					}
					if(stripos($row['admin'], "u{$user_id}|") !== false OR $user_id == $row_comments['public_id']){
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
					$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
					$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
					$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
					$tpl->compile('content');
				}
				
				//��������� ����� ������
				$tpl->load_template('groups/record.tpl');
				$tpl->set('{rec-id}', $rec_id);
				$tpl->set('{user-id}', $public_id);
				if(stripos($row['admin'], "u{$user_id}|") !== false) {
					$tpl->set('[owner]', '');
					$tpl->set('[/owner]', '');
				} else $tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
				$tpl->set('[comment-form]', '');
				$tpl->set('[/comment-form]', '');
				$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
				$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
				$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
				$tpl->compile('content');
				
				AjaxTpl();
			}
			die();
		break;
		
		//################### �������� ������ ###################//
		case "wall_del":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			$public_id = intval($_POST['public_id']);

			//�������� �� ������ � ��������� �������� �� ��������
			if($public_id){
				$row = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$public_id}'");
				$row_rec = $db->super_query("SELECT fast_comm_id, public_id FROM `".PREFIX."_communities_wall` WHERE id = '{$rec_id}'");
			} else
				$row = $db->super_query("SELECT tb1.public_id, attach, tb2.admin FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_communities` tb2 WHERE tb1.public_id = tb2.id AND tb1.id = '{$rec_id}'");

			if(stripos($row['admin'], "u{$user_id}|") !== false OR $user_id == $row_rec['public_id']){
				if($public_id)
					$db->query("UPDATE `".PREFIX."_communities_wall` SET fasts_num = fasts_num-1 WHERE id = '{$row_rec['fast_comm_id']}'");
				else {
					$db->query("DELETE FROM `".PREFIX."_communities_wall` WHERE fast_comm_id = '{$rec_id}'");
					$db->query("DELETE FROM `".PREFIX."_news` WHERE obj_id = '{$rec_id}' AND action_type = '11'");
					$db->query("UPDATE `".PREFIX."_communities` SET rec_num = rec_num-1 WHERE id = '{$row['public_id']}'");
					
					//������� ����� �� ������������ ������, ���� ��� ����
					if(stripos($row['attach'], 'link|') !== false){
						$attach_arr = explode('link|', $row['attach']);
						$attach_arr2 = explode('|/uploads/attach/'.$user_id.'/', $attach_arr[1]);
						$attach_arr3 = explode('||', $attach_arr2[1]);
						if($attach_arr3[0])
							@unlink(ROOT_DIR.'/uploads/attach/'.$user_id.'/'.$attach_arr3[0]);	
					}
				}
				
				$db->query("DELETE FROM `".PREFIX."_communities_wall` WHERE id = '{$rec_id}'");
			}
			die();
		break;
		
		//################### ����� ���� ������������ � ������ ###################//
		case "all_comm":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			$public_id = intval($_POST['public_id']);

			//�������� �� ������ � ��������� �������� �� ��������
			$row = $db->super_query("SELECT tb2.admin, comments FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_communities` tb2 WHERE tb1.public_id = tb2.id AND tb1.id = '{$rec_id}'");

			if($row['comments'] OR stripos($row['admin'], "u{$user_id}|") !== false){
				$sql_comments = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.id, public_id, text, add_date, for_groups, rec_answer, tb2.user_photo, user_search_pref FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_users` tb2 WHERE tb1.public_id = tb2.user_id AND tb1.fast_comm_id = '{$rec_id}' ORDER by `add_date` ASC", 1);
				$tpl->load_template('groups/record.tpl');
				//����������� ������� ��������
				foreach($sql_comments as $row_comments){
					$tpl->set('{public-id}', $public_id);
					$tpl->set('{rec-id}', $rec_id);
					
					if($row_comments['for_groups']) {
						$row_public = $db->super_query("SELECT title, photo FROM `".PREFIX."_communities` WHERE id = '{$public_id}'");
						$tpl->set('{name}', $row_public['title']);
						if($row_public['photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/groups/'.$public_id.'/50_'.$row_public['photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						$tpl->set('{comm-id}', $row_comments['id']);
						$tpl->set('{user-id}', $public_id);
						$tpl->set('{prefix}', 'public');
					} else {
						$tpl->set('{name}', $row_comments['user_search_pref']);
						if($row_comments['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comments['public_id'].'/50_'.$row_comments['user_photo']);
							else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');	
						$tpl->set('{comm-id}', $row_comments['id']);
						$tpl->set('{user-id}', $row_comments['public_id']);
						$tpl->set('{prefix}', 'id');
					}
					
					$expBR2 = explode('<br />', $row_comments['text']);
					$textLength2 = count($expBR2);
					$strTXT2 = strlen($row_comments['text']);
					if($textLength2 > 6 OR $strTXT2 > 470)
					$row_comments['text'] = '<div class="wall_strlen" id="hide_wall_rec'.$row_comments['id'].'" style="max-height:102px"">'.$row_comments['text'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row_comments['id'].', this.id)" id="hide_wall_rec_lnk'.$row_comments['id'].'">�������� ���������..</div>';							
					$tpl->set('{text}', stripslashes($row_comments['text']));
					megaDate($row_comments['add_date']);
					if($row_comments['rec_answer']) {
						$row_rec_id = $db->super_query("SELECT public_id FROM `".PREFIX."_communities_wall` WHERE id = '{$row_comments['rec_answer']}'");
						$row_rec_name = $db->super_query("SELECT user_name FROM `".PREFIX."_users` WHERE user_id = '{$row_rec_id['public_id']}'");
						$tpl->set('{rec_answer_name}', gramatikName($row_rec_name['user_name']));
						$tpl->set('{rec_answer_id}', $row_comments['rec_answer']);
					} else {
						$tpl->set('{rec_answer_name}', '');
						$tpl->set('{rec_answer_id}', '');
					}
					if(stripos($row['admin'], "u{$user_id}|") !== false OR $user_id == $row_comments['public_id']){
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
					$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
					$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
					$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
					$tpl->compile('content');
				}
				
				//��������� ����� ������
				$tpl->load_template('groups/record.tpl');
				$tpl->set('{rec-id}', $rec_id);
				$tpl->set('{user-id}', $public_id);
				$tpl->set('[comment-form]', '');
				$tpl->set('[/comment-form]', '');
				$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
				$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
				$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
				$tpl->compile('content');
				
				AjaxTpl();
			}
			die();
		break;
		
		//################### �������� �������� ���� � ���������� ###################//
		case "photos":
			NoAjaxQuery();
			$public_id = intval($_POST['public_id']);
			$PHPSESSID = session_id($user_info['user_id']);
			$rowPublic = $db->super_query("SELECT admin, photos_num FROM `".PREFIX."_communities` WHERE id = '{$public_id}'");
			if(stripos($rowPublic['admin'], "u{$user_id}|") !== false){
				
				if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
				$gcount = 36;
				$limit_page = ($page-1)*$gcount;
			
				//HEAD
				$tpl->load_template('public/photos/head.tpl');
				$tpl->set('{photo-num}', $rowPublic['photos_num'].' '.gram_record($rowPublic['photos_num'], 'photos'));
				$tpl->set('{public_id}', $public_id);
				$tpl->set('[top]', '');
				$tpl->set('[/top]', '');
				$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
				$tpl->compile('info');
				
				//������� ����������
				if($rowPublic['photos_num']){
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS photo FROM `".PREFIX."_communities_photos` WHERE public_id = '{$public_id}' ORDER by `add_date` DESC LIMIT {$limit_page}, {$gcount}", 1);
					$tpl->load_template('public/photos/photo.tpl');
					foreach($sql_ as $row){
						$tpl->set('{photo}', $row['photo']);
						$tpl->set('{PHPSESSID}', $PHPSESSID);
						$tpl->set('{public-id}', $public_id);
						$tpl->compile('content');
					}
					box_navigation($gcount, $rowPublic['photos_num'], $page, 'groups.wall_attach_addphoto', $public_id);
				} else
					msgbox('', '<div class="clear" style="margin-top:150px;margin-left:27px"></div>� ������� ���������� ��� ����������� ����������.', 'info_2');
				
				//BOTTOM
				$tpl->load_template('public/photos/head.tpl');
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
			$row = $db->super_query("SELECT likes_users FROM `".PREFIX."_communities_wall` WHERE id = '".$rec_id."'");
			if($row AND stripos($row['likes_users'], "u{$user_id}|") === false){
				$likes_users = "u{$user_id}|".$row['likes_users'];
				$db->query("UPDATE `".PREFIX."_communities_wall` SET likes_num = likes_num+1, likes_users = '{$likes_users}' WHERE id = '".$rec_id."'");
				$db->query("INSERT INTO `".PREFIX."_communities_wall_like` SET rec_id = '".$rec_id."', user_id = '".$user_id."', date = '".$server_time."'");
			}
			die();
		break;
		
		//################### ������� ��� �������� ###################//
		case "wall_like_remove":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			$row = $db->super_query("SELECT likes_users FROM `".PREFIX."_communities_wall` WHERE id = '".$rec_id."'");
			if(stripos($row['likes_users'], "u{$user_id}|") !== false){
				$likes_users = str_replace("u{$user_id}|", '', $row['likes_users']);
				$db->query("UPDATE `".PREFIX."_communities_wall` SET likes_num = likes_num-1, likes_users = '{$likes_users}' WHERE id = '".$rec_id."'");
				$db->query("DELETE FROM `".PREFIX."_communities_wall_like` WHERE rec_id = '".$rec_id."' AND user_id = '".$user_id."'");
			}
			die();
		break;
		
		//################### ������� ��������� 7 ������ ��� �������� "��� ��������" ###################//
		case "wall_like_users_five":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, user_search_pref, tb2.user_photo FROM `".PREFIX."_communities_wall_like` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.rec_id = '{$rec_id}' ORDER by `date` DESC LIMIT 0, 7", 1);
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
			$gcount = 1000000;
			$limit_page = ($page-1)*$gcount;
			
			if(!$liked_num)
				$liked_num = 1;
			
			if($rid AND $liked_num){
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, tb2.user_photo, user_search_pref FROM `".PREFIX."_communities_wall_like` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.rec_id = '{$rid}' ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);
				
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
						$tpl->set('{name}', $row['user_search_pref']);
						$tpl->compile('content');
					}
					box_navigation($gcount, $liked_num, $rid, 'groups.wall_all_liked_users', $liked_num);
					
					AjaxTpl();
				}
			}
			die();
		break;
		
		//################### ���������� ������� "��� ��������" ###################//
		case "wall_tell":
			NoAjaxQuery();
			$rid = intval($_POST['rec_id']);
			
			//�������� �� ������������� ������
			$row = $db->super_query("SELECT add_date, text, public_id, attach, tell_uid, tell_date, public, type FROM `".PREFIX."_communities_wall` WHERE fast_comm_id = 0 AND id = '{$rid}'");

			if($row){
				if($row['tell_uid']){
					$row['add_date'] = $row['tell_date'];
					$row['author_user_id'] = $row['tell_uid'];
					$row['public_id'] = $row['tell_uid'];
				} else
					$row['public'] = 1;
						
				//��������� �� ������������� ���� ������ � ���� �� �����
				$myRow = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_wall` WHERE tell_uid = '{$row['public_id']}' AND tell_date = '{$row['add_date']}' AND author_user_id = '{$user_id}' AND public = '{$row['public']}'");
				if($row['tell_uid'] != $user_id AND $myRow['cnt'] == false){
					$row['text'] = $db->safesql($row['text']);
					$row['attach'] = $db->safesql($row['attach']);
						
					//��������� ���� �� �����
					$db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$user_id}', for_user_id = '{$user_id}', text = '{$row['text']}', add_date = '{$server_time}', fast_comm_id = 0, tell_uid = '{$row['public_id']}', tell_date = '{$row['add_date']}', public = '{$row['public']}', attach = '".$row['attach']."', noedit = 1");
					$dbid = $db->insert_id();
					$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$user_id}'");
						
					//��������� � ����� ��������
					$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 1, action_text = '{$row['text']}', obj_id = '{$dbid}', action_time = '{$server_time}'");
						
					//������ ���
					mozg_clear_cache_file("user_{$user_id}/profile_{$user_id}");
				} else
					echo 1;
			} else
				echo 1;
				
			die();
		break;
		
		//################### ���������� ������� "��� ��������" ###################//
		case "wall_tell_g":
			NoAjaxQuery();
			$rid = intval($_POST['id']);

			
			$row1 = $db->super_query("SELECT title,descr,photo FROM `".PREFIX."_communities` WHERE id = '{$rid}'");
			if($row1['photo']){
			$rava = '/uploads/groups/'.$rid.'/'.$row1['photo'];
			}else{
			$rava = '{theme}/images/no_ava.gif';
			}
			if($row1){

					//��������� ���� �� �����
					$db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$user_id}', for_user_id = '{$user_id}', text = '<div class=\"group_share clear clear_fix\"><div class=\"photo fl_l\"><a href=\"/public{$rid}\" onclick=\"Page.Go(this.href); return false;\"><img src=\"{$rava}\"></a></div><div class=\"info fl_l\"><div class=\"title\"><a href=\"/public{$rid}\" onclick=\"Page.Go(this.href); return false;\">{$row1['title']}</a></div><div class=\"desc\">{$row1['descr']}</div></div></div><div class=\"mgclr\"></div>', add_date = '{$server_time}', fast_comm_id = '0', noedit = 1");
					$dbid = $db->insert_id();
					$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$user_id}'");

					//��������� � ����� ��������
					$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 1, action_text = '<div class=\"group_share clear clear_fix\"><div class=\"photo fl_l\"><a href=\"/public{$rid}\" onclick=\"Page.Go(this.href); return false;\"><img src=\"{$rava}\"></a></div><div class=\"info fl_l\"><div class=\"title\"><a href=\"/public{$rid}\" onclick=\"Page.Go(this.href); return false;\">{$row1['title']}</a></div><div class=\"desc\">{$row1['descr']}</div></div></div><div class=\"mgclr\"></div>', obj_id = '{$dbid}', action_time = '{$server_time}'");

					//������ ���
					mozg_clear_cache_file("user_{$user_id}/profile_{$user_id}");
			} else {
				echo 1;
}
			die();
		break;
		
		//################### ����� ���� ��������� ###################//
		case "all_people":
			NoAjaxQuery();
			
			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 24;
			$limit_page = ($page-1)*$gcount;
			
			$public_id = intval($_POST['public_id']);
			$subscr_num = intval($_POST['num']);
			
			$sql_ = $db->super_query("SELECT tb1.user_id, tb2.user_name, user_lastname, user_photo FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.friend_id = '{$public_id}' AND tb1.user_id = tb2.user_id AND tb1.subscriptions = 2 ORDER by `friends_date` DESC LIMIT {$limit_page}, {$gcount}", 1);
			
			if($sql_){
				$tpl->load_template('profile_subscription_box_top_pub.tpl');
				$tpl->set('[top]', '');
				$tpl->set('[/top]', '');
				$tpl->set('{subcr-num}', $subscr_num.' '.gram_record($subscr_num, 'subscribers'));
				$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
				$tpl->compile('content');
						
				$tpl->load_template('profile_friends.tpl');
				foreach($sql_ as $row){
					if($row['user_photo'])
						$tpl->set('{ava}', '/uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
					$tpl->set('{user-id}', $row['user_id']);
					$tpl->set('{name}', $row['user_name']);
					$tpl->set('{last-name}', $row['user_lastname']);
					$tpl->compile('content');
				}
				
				box_navigation($gcount, $subscr_num, $public_id, 'groups.all_people', $subscr_num);
				
			}
			
			AjaxTpl();
			
			die();
		break;
		
		//################### ����� ���� ���������� ����� �� ������� �� �������� (BOX) ###################//
		case "all_groups_user":
			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 20;
			$limit_page = ($page-1)*$gcount;
			
			$for_user_id = intval($_POST['for_user_id']);
			$subscr_num = intval($_POST['num']);
			
			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.friend_id, tb2.id, title, photo, traf, adres, status_text FROM `".PREFIX."_friends` tb1, `".PREFIX."_communities` tb2 WHERE tb1.user_id = '{$for_user_id}' AND tb1.friend_id = tb2.id AND tb1.subscriptions = 2 ORDER by `traf` DESC LIMIT {$limit_page}, {$gcount}", 1);
			$owner = $db->super_query("SELECT user_sub_num FROM `".PREFIX."_users` WHERE user_id = '{$for_user_id}'");
			if($sql_ and $owner){
				$tpl->load_template('profile_subscription_box_top_pub.tpl');
				$tpl->set('[top]', '');
				$tpl->set('[/top]', '');
				$tpl->set('{subcr-num2}', $subscr_num.' '.gram_record($subscr_num, 'subscr'));
				$tpl->set('{subcr-num}', $subscr_num.' ');
				$tpl->set('{user-id}', $for_user_id.'');
				if($owner['user_sub_num'] >= 1){
				$tpl->set('[user_sub_num_yes]', '');
				$tpl->set('[/user_sub_num_yes]', '');
			} else
				$tpl->set_block("'\\[user_sub_num_yes\\](.*?)\\[/user_sub_num_yes\\]'si","");
				$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
				$tpl->compile('content');
						
				$tpl->load_template('profile_group.tpl');
				foreach($sql_ as $row){
					if($row['photo']) $tpl->set('{ava}', '/uploads/groups/'.$row['id'].'/100_'.$row['photo']);
					else $tpl->set('{ava}', '{theme}/images/no_ava_50.png');
					$tpl->set('{big-ava}', $row['photo']);
					$tpl->set('{id}', $row['id']);
					$tpl->set('{name}', substr($row['title'], 0, 23));
					$tpl->set('{status}', substr($row['status_text'], 0, 23));
					$tpl->set('{public-id}', $row['id']);
					$tpl->set('{num}', '<span id="traf">'.$row['traf'].' '.gram_record($row['traf'], 'subscribers'));
					if($row['adres']) $tpl->set('{adres}', $row['adres']);
					else $tpl->set('{adres}', 'public'.$row['id']);
					$tpl->compile('content');
				}
				
				box_navigation($gcount, $subscr_num, $for_user_id, 'groups.all_groups_user', $subscr_num);
				
			}
			
			AjaxTpl();
			
			die();
		break;
		
		default:
		
			//################### ����� ���� ��������� ###################//
			$owner = $db->super_query("SELECT user_public_num FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			if($act == 'admin'){
				$tpl->load_template('groups/head_admin.tpl');
				$sql_sort = "SELECT SQL_CALC_FOUND_ROWS id, title, photo, traf, adres FROM `".PREFIX."_communities` WHERE admin regexp '[[:<:]](u{$user_id})[[:>:]]' AND ban != '1' ORDER by `traf` DESC LIMIT {$limit_page}, {$gcount}";
				$sql_count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities` WHERE admin regexp '[[:<:]](u{$user_id})[[:>:]]' AND ban != '1'");
				$owner['user_public_num'] = $sql_count['cnt'];
			} else {
				$sql_sort = "SELECT SQL_CALC_FOUND_ROWS tb1.friend_id, tb2.id, title, photo, traf, adres, gtype, ban FROM `".PREFIX."_friends` tb1, `".PREFIX."_communities` tb2 WHERE tb1.user_id = '{$user_id}' AND tb1.friend_id = tb2.id AND tb1.subscriptions = 2 AND tb2.ban != '1' ORDER by `traf` DESC LIMIT {$limit_page}, {$gcount}";
				$tpl->load_template('groups/head.tpl');
			}
			
			if($owner['user_public_num']){
				$tpl->set('{num}', $owner['user_public_num'].' '.gram_record($owner['user_public_num'], 'groups'));
				$tpl->set('[yes]', '');
				$tpl->set('[/yes]', '');
				$tpl->set_block("'\\[no\\](.*?)\\[/no\\]'si","");
			} else {
				$tpl->set('[no]', '');
				$tpl->set('[/no]', '');
				$tpl->set_block("'\\[yes\\](.*?)\\[/yes\\]'si","");
			}
			$tpl->compile('info');
			
			if($owner['user_public_num']){

				$sql_ = $db->super_query($sql_sort, 1);
				
				$tpl->load_template('groups/group.tpl');
				foreach($sql_ as $row){
					$tpl->set('{id}', $row['id']);
					if($row['adres']) $tpl->set('{adres}', $row['adres']);
					else $tpl->set('{adres}', 'public'.$row['id']);
					
					$tpl->set('{gtype}', $row['gtype']);
					$tpl->set('{name}', stripslashes($row['title']));
					$tpl->set('{traf}', $row['traf'].' '.gram_record($row['traf'], 'groups_users'));
					
					if($act != 'admin'){
						$tpl->set('[admin]', '');
						$tpl->set('[/admin]', '');
					} else
						$tpl->set_block("'\\[admin\\](.*?)\\[/admin\\]'si","");
					
					if($row['photo'])
						$tpl->set('{photo}', "/uploads/groups/{$row['id']}/100_{$row['photo']}");
					else
						$tpl->set('{photo}', "{theme}/images/no_ava_groups_100.gif");
					
					$tpl->compile('content');
				}
				
				if($act == 'admin') $admn_act = 'act=admin&';
				
				navigation($gcount, $owner['user_public_num'], 'groups?'.$admn_act.'page=');
				
			}
	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>