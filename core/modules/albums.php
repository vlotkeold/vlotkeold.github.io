<?php
/*
	Appointment: �������
	File: albums.php

*/

if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

$user_id = $user_info['user_id'];
	
if($logged){
	$act = $_GET['act'];

	switch($act){

		//################### �������� ������� ###################//
		case "create":
			NoAjaxQuery();

			$name = ajax_utf8(textFilter($_POST['name'], false, true));
			$descr = ajax_utf8(textFilter($_POST['descr']));
			$privacy = intval($_POST['privacy']);
			$privacy_comm = intval($_POST['privacy_comm']);
			if($privacy <= 0 OR $privacy > 3) $privacy = 1;
			if($privacy_comm <= 0 OR $privacy_comm > 3) $privacy_comm = 1;
			$sql_privacy = $privacy.'|'.$privacy_comm;

			if(isset($name) AND !empty($name)){

				//������ ���-�� �������� � �����
				$row = $db->super_query("SELECT user_albums_num FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");

				if($row['user_albums_num'] < $config['max_albums']){
					//hash
					$hash = md5(md5($server_time).$name.$descr.md5($user_info['user_id']).md5($user_info['user_email']).$_IP);
					$date_create = date('Y-m-d H:i:s', $server_time);

					$sql_ = $db->query("INSERT INTO `".PREFIX."_albums` (user_id, name, descr, ahash, adate, position, privacy) VALUES ('{$user_info['user_id']}', '{$name}', '{$descr}', '{$hash}', '{$date_create}', '0', '{$sql_privacy}')");
					$id = $db->insert_id();
					$db->query("UPDATE `".PREFIX."_users` SET user_albums_num = user_albums_num+1 WHERE user_id = '{$user_info['user_id']}'");

					mozg_mass_clear_cache_file("user_{$user_info['user_id']}/albums|user_{$user_info['user_id']}/albums_all|user_{$user_info['user_id']}/albums_friends|user_{$user_info['user_id']}/albums_cnt_friends|user_{$user_info['user_id']}/albums_cnt_all|user_{$user_info['user_id']}/profile_{$user_info['user_id']}");
					if($sql_)
						echo '/albums/add/'.$id;
					else
						echo 'no';
				} else
					echo 'max';
			} else
				echo 'no_name';

			die();
		break;

		//################### �������� �������� ������� ###################//
		case "create_page":
			NoAjaxQuery();
			$tpl->load_template('albums_create.tpl');
			$tpl->compile('content');
			AjaxTpl();
			die();
		break;

		//################### �������� ���������� ���������� � ������ ###################//
		case "add":
			$aid = intval($_GET['aid']);
			$user_id = $user_info['user_id'];
			$PHPSESSID = session_id($user_info['user_id']);

			//�������� �� ������������� �������
			$row = $db->super_query("SELECT name, aid FROM `".PREFIX."_albums` WHERE aid = '{$aid}' AND user_id = '{$user_id}'");
			if($row){
				$metatags['title'] = $lang['add_photo'];
				$user_speedbar = $lang['add_photo_2'];
				$tpl->load_template('albums_addphotos.tpl');
				$tpl->set('{aid}', $aid);
				$tpl->set('{PHPSESSID}', $PHPSESSID);
				$tpl->set('{album-name}', stripslashes($row['name']));
				$tpl->set('{user-id}', $user_id);
				$tpl->compile('content');
			} else
				Hacking();
		break;

		//################### �������� ���������� � ������ ###################//
		case "upload":
			NoAjaxQuery();

			$aid = intval($_GET['aid']);
			$user_id = $user_info['user_id'];

			//�������� �� ������������� ������� � �� ��� ��������� �������� �������
			$row = $db->super_query("SELECT aid, photo_num, cover FROM `".PREFIX."_albums` WHERE aid = '{$aid}' AND user_id = '{$user_id}'");
			if($row){

				//�������� �� ���-�� ����� � �������
				if($row['photo_num'] < $config['max_album_photos']){

					//���������� ������
					$uploaddir = ROOT_DIR.'/uploads/users/';

					//���� ��� ����� �����, �� ������ ��
					if(!is_dir($uploaddir.$user_id)){
						@mkdir($uploaddir.$user_id, 0777 );
						@chmod($uploaddir.$user_id, 0777 );
						@mkdir($uploaddir.$user_id.'/albums', 0777 );
						@chmod($uploaddir.$user_id.'/albums', 0777 );
					}

					//���� ��� ����� �������, �� ������ �
					$album_dir = ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$aid.'/';
					if(!is_dir($album_dir)){
						@mkdir($album_dir, 0777);
						@chmod($album_dir, 0777);
					}

					//����������� �������
					$allowed_files = explode(', ', $config['photo_format']);

					//�������� ������ � ����������
					$image_tmp = $_FILES['uploadfile']['tmp_name'];
					$image_name = totranslit($_FILES['uploadfile']['name']); // ������������ �������� ��� ����������� �������
					$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20); // ��� ����������
					$image_size = $_FILES['uploadfile']['size']; // ������ �����
					$type = end(explode(".", $image_name)); // ������ �����

					//�������� ����, ������ ������ �� ����������
					if(in_array(strtolower($type), $allowed_files)){
						$config['max_photo_size'] = $config['max_photo_size'] * 1000;
						if($image_size < $config['max_photo_size']){
							$res_type = strtolower('.'.$type);

							if(move_uploaded_file($image_tmp, $album_dir.$image_rename.$res_type)){

								//���������� ����� ��� ����������
								include ENGINE_DIR.'/classes/images.php';

								//�������� ���������
								$tmb = new thumbnail($album_dir.$image_rename.$res_type);
								$tmb->size_auto('770');
								$tmb->jpeg_quality('85');
								$tmb->save($album_dir.$image_rename.$res_type);

								//�������� ��������� �����
								$tmb = new thumbnail($album_dir.$image_rename.$res_type);
								$tmb->size_auto('140x100');
								$tmb->jpeg_quality('90');
								$tmb->save($album_dir.'c_'.$image_rename.$res_type);

								$date = date('Y-m-d H:i:s', $server_time);

								//���������� position ����� ��� "���� ����������"
								$position_all = $_SESSION['position_all'];
								if($position_all){
									$position_all = $position_all+1;
									$_SESSION['position_all'] = $position_all;
								} else {
									$position_all = 100000;
									$_SESSION['position_all'] = $position_all;
								}

								//��������� ����������
								$db->query("INSERT INTO `".PREFIX."_photos` (album_id, photo_name, user_id, date, position) VALUES ('{$aid}', '{$image_rename}{$res_type}', '{$user_id}', '{$date}', '{$position_all}')");
								$ins_id = $db->insert_id();

								//��������� �� ������� ������� � �������, ���� ���� �� ������ ������� ����������� �����
								if(!$row['cover'])
									$db->query("UPDATE `".PREFIX."_albums` SET cover = '{$image_rename}{$res_type}' WHERE aid = '{$aid}'");

								$db->query("UPDATE `".PREFIX."_albums` SET photo_num = photo_num+1, adate = '{$date}' WHERE aid = '{$aid}'");

								$img_url = $config['home_url'].'uploads/users/'.$user_id.'/albums/'.$aid.'/c_'.$image_rename.$res_type;

								//��������� ��� ������
								echo $ins_id.'|||'.$img_url.'|||'.$user_id;

								//������� ��� ������� ����������
								if(!$photos_num)
									mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);

								//������ ���
								mozg_mass_clear_cache_file("user_{$user_info['user_id']}/albums|user_{$user_info['user_id']}/albums_all|user_{$user_info['user_id']}/albums_friends|user_{$user_info['user_id']}/position_photos_album_{$aid}");

								$img_url = str_replace($config['home_url'], '/', $img_url);

								//��������� �������� � ����� ��������
								$generateLastTime = $server_time-10800;
								$row = $db->super_query("SELECT ac_id, action_text FROM `".PREFIX."_news` WHERE action_time > '{$generateLastTime}' AND action_type = 3 AND ac_user_id = '{$user_id}'");
								if($row)
									$db->query("UPDATE `".PREFIX."_news` SET action_text = '{$ins_id}|{$img_url}||{$row['action_text']}', action_time = '{$server_time}' WHERE ac_id = '{$row['ac_id']}'");
								else
									$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 3, action_text = '{$ins_id}|{$img_url}', action_time = '{$server_time}'");
							} else
								echo 'big_size';
						} else
							echo 'big_size';
					} else
						echo 'bad_format';
				} else
					echo 'max_img';
			} else
				echo 'hacking';

			die();
		break;

		//################### �������� ���������� �� ������� ###################//
		case "del_photo":
			NoAjaxQuery();
			$id = intval($_GET['id']);
			$user_id = $user_info['user_id'];

			$row = $db->super_query("SELECT user_id, album_id, photo_name, comm_num, position FROM `".PREFIX."_photos` WHERE id = '{$id}'");

			//���� ���� ����� ���������� � ��������� ������������
			if($row['user_id'] == $user_id){

				//���������� ��������
				$del_dir = ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/';

				//�������� ����� � �������
				@unlink($del_dir.'c_'.$row['photo_name']);
				@unlink($del_dir.$row['photo_name']);

				//�������� ����� �� ��
				$db->query("DELETE FROM `".PREFIX."_photos` WHERE id = '{$id}'");

				$check_photo_album = $db->super_query("SELECT id FROM `".PREFIX."_photos` WHERE album_id = '{$row['album_id']}'");
				$album_row = $db->super_query("SELECT cover FROM `".PREFIX."_albums` WHERE aid = '{$row['album_id']}'");

				//���� ��������� ���������� �������� �������� �� ��������� ������� �� ��������� ����������, ���� ����� ��� ���� �� �������
				if($album_row['cover'] == $row['photo_name'] AND $check_photo_album){
					$row_last_photo = $db->super_query("SELECT photo_name FROM `".PREFIX."_photos` WHERE user_id = '{$user_id}' AND album_id = '{$row['album_id']}' ORDER by `id` DESC");
					$set_cover = ", cover = '{$row_last_photo['photo_name']}'";
				}

				//���� � ������� ��� ��� �����, �� ������� �������
				if(!$check_photo_album)
					$set_cover = ", cover = ''";

				//������� ����������� � ����������
				$db->query("DELETE FROM `".PREFIX."_photos_comments` WHERE pid = '{$id}'");

				//��������� ���������� ��������� � �������
				$db->query("UPDATE `".PREFIX."_albums` SET photo_num = photo_num-1, comm_num = comm_num-{$row['comm_num']} {$set_cover} WHERE aid = '{$row['album_id']}'");

				//������ ���
				mozg_mass_clear_cache_file("user_{$user_info['user_id']}/albums|user_{$user_info['user_id']}/albums_all|user_{$user_info['user_id']}/albums_friends|user_{$row['user_id']}/position_photos_album_{$row['album_id']}");

				//������� � ������� ������� ���� ��� ����
				$sql_mark = $db->super_query("SELECT muser_id FROM `".PREFIX."_photos_mark` WHERE mphoto_id = '".$id."' AND mapprove = '0'", 1);
				if($sql_mark){
					foreach($sql_mark as $row_mark){
						$db->query("UPDATE `".PREFIX."_users` SET user_new_mark_photos = user_new_mark_photos-1 WHERE user_id = '".$row_mark['muser_id']."'");
					}
				}
				$db->query("DELETE FROM `".PREFIX."_photos_mark` WHERE mphoto_id = '".$id."'");
			}

			die();
		break;

		//################### ��������� ����� ������� ��� ������� ###################//
		case "set_cover":
			NoAjaxQuery();
			$id = intval($_GET['id']);
			$user_id = $user_info['user_id'];

			//������ ����� �� ��, ���� ��� ����
			$row = $db->super_query("SELECT album_id, photo_name FROM `".PREFIX."_photos` WHERE id = '{$id}' AND user_id = '{$user_id}'");
			if($row){
				$db->query("UPDATE `".PREFIX."_albums` SET cover = '{$row['photo_name']}' WHERE aid = '{$row['album_id']}'");

				//������ ���
				mozg_mass_clear_cache_file("user_{$user_info['user_id']}/albums|user_{$user_info['user_id']}/albums_all|user_{$user_info['user_id']}/albums_friends");
			}

			die();
		break;

		//################### ���������� �������� � ���������� ###################//
		case "save_descr":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			$user_id = $user_info['user_id'];
			$descr = ajax_utf8(textFilter($_POST['descr']));

			//������� ����� �� ��, ���� ��� ����
			$row = $db->super_query("SELECT id FROM `".PREFIX."_photos` WHERE id = '{$id}' AND user_id = '{$user_id}'");
			if($row){
				$db->query("UPDATE `".PREFIX."_photos` SET descr = '{$descr}' WHERE id = '{$id}' AND user_id = '{$user_id}'");

				//����� �������
				echo stripslashes(myBr(htmlspecialchars(ajax_utf8(trim($_POST['descr'])))));
			}
			die();
		break;

		//################### �������� �������������� ���������� ###################//
		case "editphoto":
			NoAjaxQuery();
			$id = intval($_GET['id']);
			$user_id = $user_info['user_id'];
			$row = $db->super_query("SELECT descr FROM `".PREFIX."_photos` WHERE id = '{$id}' AND user_id = '{$user_id}'");
			if($row)
				echo stripslashes(myBrRn($row['descr']));
			die();
		break;

		//################### ���������� ���������� �������� ###################//
		case "save_pos_albums";
			NoAjaxQuery();
			$array = $_POST['album'];
			$count = 1;

			//���� ���� ������ � ������
			if($array AND $config['albums_drag'] == 'yes'){
				//������� ������� � ��������� �������
				foreach($array as $idval){
					$idval = intval($idval);
					$db->query("UPDATE `".PREFIX."_albums` SET position = ".$count." WHERE aid = '{$idval}' AND user_id = '{$user_info['user_id']}'");
					$count++;
				}

				//������ ���
				mozg_mass_clear_cache_file("user_{$user_info['user_id']}/albums|user_{$user_info['user_id']}/albums_all|user_{$user_info['user_id']}/albums_friends");
			}
			die();
		break;

		//################### ���������� ���������� ���������� ###################//
		case "save_pos_photos";
			NoAjaxQuery();
			$array	= $_POST['photo'];
			$count = 1;

			//���� ���� ������ � ������
			if($array AND $config['photos_drag'] == 'yes'){
				//������� ������� � ��������� �������
				$row = $db->super_query("SELECT album_id FROM `".PREFIX."_photos` WHERE id = '{$array[1]}'");
				if($row){
					foreach($array as $idval){
						$idval = intval($idval);
						$db->query("UPDATE `".PREFIX."_photos` SET position = '{$count}' WHERE id = '{$idval}' AND user_id = '{$user_info['user_id']}'");
						$photo_info .= $count.'|'.$idval.'||';
						$count ++;
					}
					mozg_create_cache('user_'.$user_info['user_id'].'/position_photos_album_'.$row['album_id'], $photo_info);
				}
			}
			die();
		break;

		//################### �������� �������������� ������� ###################//
		case "edit_page";
			NoAjaxQuery();
			$user_id = $user_info['user_id'];
			$id = $db->safesql(intval($_POST['id']));
			$row = $db->super_query("SELECT aid, name, descr, privacy, system FROM `".PREFIX."_albums` WHERE aid = '{$id}' AND user_id = '{$user_id}'");
			if($row){
				$album_privacy = explode('|', $row['privacy']);
				$tpl->load_template('albums_edit.tpl');
				$tpl->set('{id}', $row['aid']);
				if($row['system'] == 0){
					$tpl->set('[system]', '');
					$tpl->set('[/system]', '');
				} else
					$tpl->set_block("'\\[system\\](.*?)\\[/system\\]'si","");
				$tpl->set('{name}', stripslashes($row['name']));
				$tpl->set('{descr}', stripslashes(myBrRn($row['descr'])));
				$tpl->set('{privacy}', $album_privacy[0]);
				$tpl->set('{privacy-text}', strtr($album_privacy[0], array('1' => '��� ������������', '2' => '������ ������', '3' => '������ �')));
				$tpl->set('{privacy-comment}', $album_privacy[1]);
				$tpl->set('{privacy-comment-text}', strtr($album_privacy[1], array('1' => '��� ������������', '2' => '������ ������', '3' => '������ �')));
				$tpl->compile('content');
				AjaxTpl();
			}
			die();
		break;

		//################### ���������� �������� ������� ###################//
		case "save_album":
			NoAjaxQuery();
			$id = intval($_POST['id']);
			$user_id = $user_info['user_id'];
			$name = ajax_utf8(textFilter($_POST['name'], false, true));
			$descr = ajax_utf8(textFilter($_POST['descr']));

			$privacy = intval($_POST['privacy']);
			$privacy_comm = intval($_POST['privacy_comm']);
			if($privacy <= 0 OR $privacy > 3) $privacy = 1;
			if($privacy_comm <= 0 OR $privacy_comm > 3) $privacy_comm = 1;
			$sql_privacy = $privacy.'|'.$privacy_comm;

			//�������� �� ������������� �����
			$chekc_user = $db->super_query("SELECT privacy FROM `".PREFIX."_albums` WHERE aid = '{$id}' AND user_id = '{$user_id}'");
			if($chekc_user){
				if(isset($name) AND !empty($name)){
					$db->query("UPDATE `".PREFIX."_albums` SET name = '{$name}', descr = '{$descr}', privacy = '{$sql_privacy}' WHERE aid = '{$id}'");
					echo stripslashes($name).'|#|||#row#|||#|'.stripslashes($descr);

					mozg_mass_clear_cache_file("user_{$user_id}/albums|user_{$user_id}/albums_all|user_{$user_id}/albums_friends|user_{$user_id}/albums_cnt_friends|user_{$user_id}/albums_cnt_all");
				} else
					echo 'no_name';
			}
			die();
		break;

		//################### �������� ��������� ������� ###################//
		case "edit_cover";
			NoAjaxQuery();

			$user_id = $user_info['user_id'];
			$id = intval($_POST['id']);

			if($user_id AND $id){

				//��� ���������
				if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
				$gcount = 36;
				$limit_page = ($page-1)*$gcount;

				//������ SQL ������ �� �����
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id, photo_name FROM `".PREFIX."_photos` WHERE album_id = '{$id}' AND user_id = '{$user_id}' ORDER by `position` ASC LIMIT {$limit_page}, {$gcount}", 1);

				//���� ���� SQL ������ �� ����������
				if($sql_){

					//������� ������ � ������� (���-�� ���������)
					$row_album = $db->super_query("SELECT photo_num, system FROM `".PREFIX."_albums` WHERE aid = '{$id}' AND user_id = '{$user_id}'");

					$tpl->load_template('albums_editcover.tpl');
					$tpl->set('[top]', '');
					$tpl->set('[/top]', '');
					$tpl->set('{photo-num}', $row_album['photo_num'].' '.gram_record($row_album['photo_num'], 'photos'));
					$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
					$tpl->compile('content');

					//������� ������� ����������
					$tpl->load_template('albums_editcover_photo.tpl');
					foreach($sql_ as $row){
						$tpl->set('{photo}', $config['home_url'].'uploads/users/'.$user_id.'/albums/'.$id.'/c_'.$row['photo_name']);
						$tpl->set('{id}', $row['id']);
						$tpl->set('{aid}', $id);
						$tpl->compile('content');
					}
					box_navigation($gcount, $row_album['photo_num'], $id, 'Albums.EditCover', '');

					$tpl->load_template('albums_editcover.tpl');
					$tpl->set('[bottom]', '');
					$tpl->set('[/bottom]', '');
					$tpl->set_block("'\\[top\\](.*?)\\[/top\\]'si","");
					$tpl->compile('content');

					AjaxTpl();
				} else
					echo $lang['no_photo_alnumx'];
			} else
				Hacking();

			die();
		break;

		//################### �������� ���� ���������� �����, ��� ������������ ����� ����� ����-�� �� ����� ###################//
		case "all_photos_box";
			NoAjaxQuery();
			$user_id = $user_info['user_id'];
			$notes = intval($_POST['notes']);

			//��� ���������
			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 36;
			$limit_page = ($page-1)*$gcount;

			//������ SQL ������ �� �����
			$sql_ = $db->query("SELECT SQL_CALC_FOUND_ROWS id, photo_name, album_id FROM `".PREFIX."_photos` WHERE user_id = '{$user_id}' ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}");
			$row_album = $db->super_query("SELECT SUM(photo_num) AS photo_num FROM `".PREFIX."_albums` WHERE user_id = '{$user_id}'");

			//���� ���� ���������� �� ����������
			if($row_album['photo_num']){
				if($notes)
					$tpl->load_template('notes/attatch_addphoto_top.tpl');
				else
					$tpl->load_template('wall/attatch_addphoto_top.tpl');

				$tpl->set('[top]', '');
				$tpl->set('[/top]', '');
				$tpl->set('{photo-num}', $row_album['photo_num'].' '.gram_record($row_album['photo_num'], 'photos'));
				$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
				$tpl->compile('content');

				//������� ������ ����������
				if(!$notes)
					$tpl->load_template('albums_all_photos.tpl');
				else
					$tpl->load_template('albums_box_all_photos_notes.tpl');

				while($row = $db->get_row($sql_)){
					$tpl->set('{photo}', '/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/c_'.$row['photo_name']);
					$tpl->set('{photo-name}',$row['photo_name']);
					$tpl->set('{user-id}', $user_id);
					$tpl->set('{photo-id}', $row['id']);
					$tpl->set('{aid}', $row['album_id']);
					$tpl->compile('content');
				}
				box_navigation($gcount, $row_album['photo_num'], $page, 'wall.attach_addphoto', $notes);

				$tpl->load_template('albums_editcover.tpl');
				$tpl->set('[bottom]', '');
				$tpl->set('[/bottom]', '');
				$tpl->set_block("'\\[top\\](.*?)\\[/top\\]'si","");
				$tpl->compile('content');

				AjaxTpl();
			} else {
				if($notes)
					$scrpt_insert = "response[1] = response[1].replace('/c_', '/');wysiwyg.boxPhoto(response[1], 0, 0);";
				else
					$scrpt_insert = "var imgname = response[1].split('/');wall.attach_insert('photo', response[1], 'attach|'+imgname[6].replace('c_', ''), response[2]);";

				echo <<<HTML
<script type="text/javascript">
$(document).ready(function(){
	Xajax = new AjaxUpload('upload', {
		action: '/index.php?go=attach',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if (!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))) {
				addAllErr(lang_bad_format, 3300);
				return false;
			}
			Page.Loading('start');
		},
		onComplete: function (file, response){
			if(response == 'big_size'){
				addAllErr(lang_max_size, 3300);
				Page.Loading('stop');
			} else {
				var response = response.split('|||');
				{$scrpt_insert}
				Page.Loading('stop');
			}
		}
	});
});
</script>
HTML;
				echo "<script>
			$('.box_footer').hide();
			$('.bg_show_bottom').hide();
</script> <div class=\"photos_album_page\" style=\"margin-top:-4px;cursor:pointer\" id=\"upload\">
  <div id=\"photos_upload_area_wrap\" style=\"position: relative;\" >
  <a id=\"photos_upload_area\" onclick=\"Page.Go(this.href); return false;\">
    <div class=\"photos_upload_area_upload\">
      <span class=\"photos_upload_area_img\">
        ��������� ����������
      </span>
    </div>
  </a>
</div>
</div>";
			}

			die();
		break;

		//################### �������� ������� ###################//
		case "del_album":
			NoAjaxQuery();
			$hash = $db->safesql(substr($_POST['hash'], 0, 32));
			$row = $db->super_query("SELECT aid, user_id, photo_num FROM `".PREFIX."_albums` WHERE ahash = '{$hash}'");

			if($row){
				$aid = $row['aid'];
				$user_id = $row['user_id'];

				//������� ������
				$db->query("DELETE FROM `".PREFIX."_albums` WHERE ahash = '{$hash}'");

				//��������� ������ �� ����� � �������
				if($row['photo_num']){

					//������� �����
					$db->query("DELETE FROM `".PREFIX."_photos` WHERE album_id = '{$aid}'");

					//������� ����������� � �������
					$db->query("DELETE FROM `".PREFIX."_photos_comments` WHERE album_id = '{$aid}'");

					//������� ����� �� ����� �� �������
					$fdir = opendir(ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$aid);
					while($file = readdir($fdir))
						@unlink(ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$aid.'/'.$file);

					@rmdir(ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$aid);
				}

				//�������� ���-�� ������ � �����
				$db->query("UPDATE `".PREFIX."_users` SET user_albums_num = user_albums_num-1 WHERE user_id = '{$user_id}'");

				//������� ��� ������� ���������� � ��� �������
				mozg_clear_cache_file('user_'.$row['user_id'].'/position_photos_album_'.$row['aid']);
				mozg_clear_cache_file("user_{$user_info['user_id']}/profile_{$user_info['user_id']}");

				mozg_mass_clear_cache_file("user_{$user_id}/albums|user_{$user_id}/albums_all|user_{$user_id}/albums_friends|user_{$user_id}/albums_cnt_friends|user_{$user_id}/albums_cnt_all");
			}

			die();
		break;
		
		//################### ������ ��� �������� ###################//
		case "wall_like_yes":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			
			$row = $db->super_query("SELECT likes_users FROM `".PREFIX."_photos_comments` WHERE id = '".$rec_id."'");
			if($row AND stripos($row['likes_users'], "u{$user_id}|") === false){
				$likes_users = "u{$user_id}|".$row['likes_users'];
				$db->query("UPDATE `".PREFIX."_photos_comments` SET likes_num = likes_num+1, likes_users = '{$likes_users}' WHERE id = '".$rec_id."'");
				$db->query("INSERT INTO `".PREFIX."_photos_comments_like` SET rec_id = '".$rec_id."', user_id = '".$user_id."', date = '".$server_time."'");
			}
			die();
		break;
		
		//################### ������� ��� �������� ###################//
		case "wall_like_remove":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			
			$row = $db->super_query("SELECT likes_users FROM `".PREFIX."_photos_comments` WHERE id = '".$rec_id."'");
			if(stripos($row['likes_users'], "u{$user_id}|") !== false){
				$likes_users = str_replace("u{$user_id}|", '', $row['likes_users']);
				$db->query("UPDATE `".PREFIX."_photos_comments` SET likes_num = likes_num-1, likes_users = '{$likes_users}' WHERE id = '".$rec_id."'");
				$db->query("DELETE FROM `".PREFIX."_photos_comments_like` WHERE rec_id = '".$rec_id."' AND user_id = '".$user_id."'");
			}
			die();
		break;
		
		//################### ������� ��������� 7 ������ ��� �������� "��� ��������" ###################//
		case "wall_like_users_five":
			NoAjaxQuery();
			$rec_id = intval($_POST['rec_id']);
			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, tb2.user_photo FROM `".PREFIX."_photos_comments_like` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.rec_id = '{$rec_id}' ORDER by `date` DESC LIMIT 0, 7", 1);
			if($sql_){
				foreach($sql_ as $row){
					if($row['user_photo']) $ava = '/uploads/users/'.$row['user_id'].'/50_'.$row['user_photo'];
					else $ava = '/templates/'.$config['temp'].'/images/no_ava_50.png';
					echo '<a href="/id'.$row['user_id'].'" id="Xlike_user'.$row['user_id'].'_'.$rec_id.'" onClick="Page.Go(this.href); return false"><img src="'.$ava.'" width="32" /></a>';
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
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, tb2.user_photo, user_search_pref FROM `".PREFIX."_photos_comments_like` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.rec_id = '{$rid}' ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);

				if($sql_){
					$tpl->load_template('profile_subscription_box_top_like.tpl');
					$tpl->set('[top]', '');
					$tpl->set('[/top]', '');
					$tpl->set('{subcr-num2}', '����������� '.$liked_num.' '.gram_record($liked_num, 'like'));
					$tpl->set('{subcr-num}', ''.$liked_num.' ');
					$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
					$tpl->compile('content');

					$tpl->result['content'] = str_replace('�����', '', $tpl->result['content']);

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
					box_navigation($gcount, $liked_num, $rid, 'Photo.wall_all_liked_users', $liked_num);

					AjaxTpl();
				}
			}
			die();
		break;

		//################### �������� ���� ������������ � ������� ###################//
		case "all_comments":
			$user_id = $user_info['user_id'];
			$uid = intval($_GET['uid']);
			$aid = intval($_GET['aid']);

			if($aid) $uid = false;
			if($uid) $aid = false;

			if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
			$gcount = 25;
			$limit_page = ($page-1) * $gcount;

			$privacy = true;
			$row_num = $db->super_query("SELECT aid, photo_num, cover FROM `".PREFIX."_albums` WHERE aid = '{$aid}' AND user_id = '{$user_id}'");

			//���� ������� �������� � �������
			if($aid AND !$uid){
				$row_album = $db->super_query("SELECT user_id, name, privacy FROM `".PREFIX."_albums` WHERE aid = '{$aid}'");
				$album_privacy = explode('|', $row_album['privacy']);
				$uid = $row_album['user_id'];
				if(!$uid)
					Hacking();
			}

			$CheckBlackList = CheckBlackList($uid);

			if($user_id != $uid)
				//�������� ������ ������������� ���� � ������� � ����� ������� ������� ���
				$check_friend = CheckFriends($uid);

			if($aid AND $album_privacy){
				if($album_privacy[0] == 1 OR $album_privacy[0] == 2 AND $check_friend OR $user_id == $uid)
					$privacy = true;
				else
					$privacy = false;
			}

			//�����������
			if($privacy AND !$CheckBlackList){
				if($uid AND !$aid){
					$sql_tb3 = ", `".PREFIX."_albums` tb3";

					if($user_id == $uid){
						$privacy_sql = "";
						$sql_tb3 = "";
					} elseif($check_friend){
						$privacy_sql = "AND tb1.album_id = tb3.aid AND SUBSTRING(tb3.privacy, 1, 1) regexp '[[:<:]](1|2)[[:>:]]'";
						$cache_cnt_num = "_friends";
					} else {
						$privacy_sql = "AND tb1.album_id = tb3.aid AND SUBSTRING(tb3.privacy, 1, 1) regexp '[[:<:]](1)[[:>:]]'";
						$cache_cnt_num = "_all";
					}
				}

				//���� ������� �������� ���� ������������ �����, ���� ���, �� ������ ������� �������� ����������� �������
				if($uid AND !$aid)
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, tb1.likes_users, tb1.likes_num, text, date, id, hash, album_id, pid, owner_id, photo_name, tb2.user_search_pref, user_photo, user_last_visit FROM `".PREFIX."_photos_comments` tb1, `".PREFIX."_users` tb2 {$sql_tb3} WHERE tb1.owner_id = '{$uid}' AND tb1.user_id = tb2.user_id {$privacy_sql} ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);
				else
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, tb1.likes_users, tb1.likes_num, text, date, id, hash, album_id, pid, owner_id, photo_name, tb2.user_search_pref, user_photo, user_last_visit FROM `".PREFIX."_photos_comments` tb1, `".PREFIX."_users` tb2 WHERE tb1.album_id = '{$aid}' AND tb1.user_id = tb2.user_id ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);

				//������ ��� ��������� ��������
				$row_owner = $db->super_query("SELECT user_name FROM `".PREFIX."_users` WHERE user_id = '{$uid}'");

				//���� ������� �������� ���� ���������
				if($uid AND !$aid){
					$user_speedbar = $lang['comm_form_album_all'];
					$metatags['title'] = $lang['comm_form_album_all'];
				} else {
					$user_speedbar = $lang['comm_form_album'];
					$metatags['title'] = $lang['comm_form_album'];
				}

				//��������� HEADER �������
				$tpl->load_template('albums_top.tpl');
				$tpl->set('{user-id}', $uid);
				$tpl->set('{num}', $row_num['photo_num']);
				$tpl->set('{aid}', $aid);
				$tpl->set('{name}', gramatikName($row_owner['user_name']));
				$tpl->set('{album-name}', stripslashes($row_album['name']));
				$tpl->set('{photo-num}', $row_album['photo_num'].' '.gram_record($row_album['photo_num'], 'photos'));
				$tpl->set('[comments]', '');
				$tpl->set('[/comments]', '');
				$tpl->set_block("'\\[all-albums\\](.*?)\\[/all-albums\\]'si","");
				$tpl->set_block("'\\[view\\](.*?)\\[/view\\]'si","");
				$tpl->set_block("'\\[editphotos\\](.*?)\\[/editphotos\\]'si","");
				$tpl->set_block("'\\[all-photos\\](.*?)\\[/all-photos\\]'si","");
				if($uid AND !$aid){
					$tpl->set_block("'\\[albums-comments\\](.*?)\\[/albums-comments\\]'si","");
				} else {
					$tpl->set('[albums-comments]', '');
					$tpl->set('[/albums-comments]', '');
					$tpl->set_block("'\\[comments\\](.*?)\\[/comments\\]'si","");
				}
				if($uid == $user_id){
					$tpl->set('[owner]', '');
					$tpl->set('[/owner]', '');
					$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
				} else {
					$tpl->set('[not-owner]', '');
					$tpl->set('[/not-owner]', '');
					$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
				}
				$tpl->compile('info');

				//���� ���� ����� � ������� �� �������
				if($sql_){

					$tpl->load_template('albums_comment.tpl');
					foreach($sql_ as $row_comm){
						$tpl->set('{comment}', stripslashes($row_comm['text']));
						$tpl->set('{uid}', $row_comm['user_id']);
						$tpl->set('{id}', $row_comm['id']);
						$tpl->set('{hash}', $row_comm['hash']);
						$tpl->set('{author}', $row_comm['user_search_pref']);

						//������� ������ � ����������
						$tpl->set('{photo}', $config['home_url'].'uploads/users/'.$uid.'/albums/'.$row_comm['album_id'].'/c_'.$row_comm['photo_name']);
						$tpl->set('{pid}', $row_comm['pid']);
						$tpl->set('{user-id}', $row_comm['owner_id']);

						if($aid){
							$tpl->set('{aid}', '_'.$aid);
							$tpl->set('{section}', 'album_comments');
						} else {
							$tpl->set('{aid}', '');
							$tpl->set('{section}', 'all_comments');
						}

						if($row_comm['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comm['user_id'].'/50_'.$row_comm['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');

						OnlineTpl($row_comm['user_last_visit']);
						megaDate(strtotime($row_comm['date']));

						if($row_comm['user_id'] == $user_info['user_id'] OR $user_info['user_id'] == $uid){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
						} else
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
							
						//��� ��������
						if(stripos($row_comm['likes_users'], "u{$user_id}|") !== false){
							$tpl->set('{yes-like}', 'public_wall_like_yes');
							$tpl->set('{yes-like-color}', 'public_wall_like_yes_color');
							$tpl->set('{like-js-function}', 'Photo.wall_remove_like('.$row_comm['id'].', '.$user_id.')');
						} else {
							$tpl->set('{yes-like}', '');
							$tpl->set('{yes-like-color}', '');
							$tpl->set('{like-js-function}', 'Photo.wall_add_like('.$row_comm['id'].', '.$user_id.')');
						}
						
						if($row_comm['likes_num']){
							$tpl->set('{likes}', $row_comm['likes_num']);
							$tpl->set('{likes-text}', '<span id="like_text_num'.$row_comm['id'].'">'.$row_comm['likes_num'].'</span> '.gram_record($row_comm['likes_num'], 'like'));
						} else {
							$tpl->set('{likes}', '');
							$tpl->set('{likes-text}', '<span id="like_text_num'.$row_comm['id'].'">0</span> ��������');
						}
						
						$tpl->set('{viewer-id}', $user_id);
						if($user_info['user_photo'])
							$tpl->set('{viewer-ava}', '/uploads/users/'.$user_id.'/50_'.$user_info['user_photo']);
						else
							$tpl->set('{viewer-ava}', '{theme}/images/no_ava_50.png');

						$tpl->compile('content');
					}

					if($uid AND !$aid)
						if($user_id == $uid)
							$row_album = $db->super_query("SELECT SUM(comm_num) AS all_comm_num FROM `".PREFIX."_albums` WHERE user_id = '{$uid}'", false, "user_{$uid}/albums_{$uid}_comm{$cache_cnt_num}");
						else
							$row_album = $db->super_query("SELECT COUNT(*) AS all_comm_num FROM `".PREFIX."_photos_comments` tb1, `".PREFIX."_albums` tb3 WHERE tb1.owner_id = '{$uid}' {$privacy_sql}", false, "user_{$uid}/albums_{$uid}_comm{$cache_cnt_num}");
					else
						$row_album = $db->super_query("SELECT comm_num AS all_comm_num FROM `".PREFIX."_albums` WHERE aid = '{$aid}'");

					if($uid AND !$aid)
						navigation($gcount, $row_album['all_comm_num'], $config['home_url'].'albums/comments/'.$uid.'/page/');
					else
						navigation($gcount, $row_album['all_comm_num'], $config['home_url'].'albums/view/'.$aid.'/comments/page/');

					$user_speedbar = $row_album['all_comm_num'].' '.gram_record($row_album['all_comm_num'], 'comments');
				} else
					msgbox('', $lang['no_comments'], 'info_2');
			} else {
				$user_speedbar = $lang['title_albums'];
				msgbox('', $lang['no_notes'], 'info');
			}
		break;

		//################### �������� ��������� ������� ���������� ###################//
		case "edit_pos_photos":
			$user_id = $user_info['user_id'];
			$aid = intval($_GET['aid']);

			$check_album = $db->super_query("SELECT name FROM `".PREFIX."_albums` WHERE aid = '{$aid}' AND user_id = '{$user_id}'");
			$row_num = $db->super_query("SELECT aid, photo_num, cover FROM `".PREFIX."_albums` WHERE aid = '{$aid}' AND user_id = '{$user_id}'");
			if($check_album){
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id, photo_name FROM `".PREFIX."_photos` WHERE album_id = '{$aid}' AND user_id = '{$user_id}' ORDER by `position` ASC", 1);

				$metatags['title'] = $lang['editphotos'];
				$user_speedbar = $lang['editphotos'];

				$tpl->load_template('albums_top.tpl');
				$tpl->set('{user-id}', $user_id);
				$tpl->set('{num}', $row_num['photo_num']);
				$tpl->set('{aid}', $aid);
				$tpl->set('{photo-num}', $row_album['photo_num'].' '.gram_record($row_album['photo_num'], 'photos'));
				$tpl->set('{album-name}', stripslashes($check_album['name']));
				$tpl->set('[editphotos]', '');
				$tpl->set('[/editphotos]', '');
				$tpl->set_block("'\\[all-albums\\](.*?)\\[/all-albums\\]'si","");
				$tpl->set_block("'\\[view\\](.*?)\\[/view\\]'si","");
				$tpl->set_block("'\\[all-photos\\](.*?)\\[/all-photos\\]'si","");
				$tpl->set_block("'\\[comments\\](.*?)\\[/comments\\]'si","");
				$tpl->set_block("'\\[albums-comments\\](.*?)\\[/albums-comments\\]'si","");

				if($config['photos_drag'] == 'no')
					$tpl->set_block("'\\[admin-drag\\](.*?)\\[/admin-drag\\]'si","");
				else {
					$tpl->set('[admin-drag]', '');
					$tpl->set('[/admin-drag]', '');
				}

				$tpl->compile('info');

				if($sql_){
					//��������� ID ��� Drag-N-Drop jQuery
					$tpl->result['content'] .= '<div id="dragndrop"><ul>';
					$tpl->load_template('albums_editphotos.tpl');
					foreach($sql_ as $row){
						$tpl->set('{photo}', $config['home_url'].'uploads/users/'.$user_id.'/albums/'.$aid.'/c_'.$row['photo_name']);
						$tpl->set('{id}', $row['id']);
						$tpl->compile('content');
					}
					//����� ID ��� Drag-N-Drop jQuery
					$tpl->result['content'] .= '</div></ul>';
				} else
					msgbox('', $lang['no_photos'], 'info_2');

			} else {
				$metatags['title'] = $lang['hacking'];
				$user_speedbar = $lang['no_infooo'];
				msgbox('', $lang['hacking'], 'info_2');
			}
		break;

		//################### �������� ������� ###################//
		case "view":
			$user_id = $user_info['user_id'];
			$aid = intval($_GET['aid']);

			if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
			$gcount = 25;
			$limit_page = ($page-1) * $gcount;

			//������� ������ � ������
			$sql_photos = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id, photo_name FROM `".PREFIX."_photos` WHERE album_id = '{$aid}' ORDER by `position` ASC LIMIT {$limit_page}, {$gcount}", 1);

			//������� ������ � �������
			$row_album = $db->super_query("SELECT user_id, name, photo_num, privacy, system FROM `".PREFIX."_albums` WHERE aid = '{$aid}'");

			//��
			$CheckBlackList = CheckBlackList($row_album['user_id']);
			if(!$CheckBlackList){
				$album_privacy = explode('|', $row_album['privacy']);
				if(!$row_album)
					Hacking();

				//�������� ������ ������������� ���� � ������� � ����� ������� ������� ���
				if($user_id != $row_album['user_id'])
					$check_friend = CheckFriends($row_album['user_id']);

				//�����������
				if($album_privacy[0] == 1 OR $album_privacy[0] == 2 AND $check_friend OR $user_info['user_id'] == $row_album['user_id']){
					//������� ������ � ��������� �������(��)
					$row_owner = $db->super_query("SELECT user_name FROM `".PREFIX."_users` WHERE user_id = '{$row_album['user_id']}'");
					$row_num = $db->super_query("SELECT aid, photo_num, cover FROM `".PREFIX."_albums` WHERE aid = '{$aid}' AND user_id = '{$user_id}'");	
					$tpl->load_template('albums_top.tpl');
					$tpl->set('{user-id}', $row_album['user_id']);
					$tpl->set('{name}', gramatikName($row_owner['user_name']));
					$tpl->set('{aid}', $aid);
					$tpl->set('{num}', $row_num['photo_num']);
					$tpl->set('{photo-num}', $row_album['photo_num'].' '.gram_record($row_album['photo_num'], 'photos'));
					if($row_album['system'] == 0){
						$tpl->set('[system]', '');
						$tpl->set('[/system]', '');
					} else
						$tpl->set_block("'\\[system\\](.*?)\\[/system\\]'si","");
					$tpl->set('[view]', '');
					$tpl->set('[/view]', '');
					$tpl->set_block("'\\[all-albums\\](.*?)\\[/all-albums\\]'si","");
					$tpl->set_block("'\\[comments\\](.*?)\\[/comments\\]'si","");
					$tpl->set_block("'\\[editphotos\\](.*?)\\[/editphotos\\]'si","");
					$tpl->set_block("'\\[albums-comments\\](.*?)\\[/albums-comments\\]'si","");
					$tpl->set_block("'\\[all-photos\\](.*?)\\[/all-photos\\]'si","");
					if($row_album['user_id'] == $user_id){
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
					} else {
						$tpl->set('[not-owner]', '');
						$tpl->set('[/not-owner]', '');
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
					}
					$tpl->set('{album-name}', stripslashes($row_album['name']));
					$tpl->set('{all_p_num}', $row_album['photo_num']);
					$tpl->set('{aid}', $aid);
					$tpl->set('{count}', $limit_page);
					$tpl->compile('info');

					//���� ���� � ������������ ��������
					$metatags['title'] = stripslashes($row_album['name']).' | '.$row_album['photo_num'].' '.gram_record($row_album['photo_num'], 'photos');
					$user_speedbar = '<span id="photo_num">'.$row_album['photo_num'].'</span> '.gram_record($row_album['photo_num'], 'photos');

					if($sql_photos){
						$tpl->load_template('album_photo.tpl');

						foreach($sql_photos as $row){
							if($row_album['system'] == 0){
								$tpl->set('[system]', '');
								$tpl->set('[/system]', '');
							} else
								$tpl->set_block("'\\[system\\](.*?)\\[/system\\]'si","");
							$tpl->set('{photo}', $config['home_url'].'uploads/users/'.$row_album['user_id'].'/albums/'.$aid.'/c_'.$row['photo_name']);
							$tpl->set('{id}', $row['id']);
							$tpl->set('{all}', '');
							$tpl->set('{uid}', $row_album['user_id']);
							$tpl->set('{aid}', '_'.$aid);
							$tpl->set('{section}', '');
							if($row_album['user_id'] == $user_id){
								$tpl->set('[owner]', '');
								$tpl->set('[/owner]', '');
								$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
							} else {
								$tpl->set('[not-owner]', '');
								$tpl->set('[/not-owner]', '');
								$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
							}							
							$tpl->compile('content');
						}
						navigation($gcount, $row_album['photo_num'], $config['home_url'].'albums/view/'.$aid.'/page/');
					} else
						msgbox('', '<br /><br />� ������� ��� ����������<br /><br /><br />', 'info_2');

					//��������� �� ������� ����� � �������� �����
					$check_pos = mozg_cache('user_'.$row_album['user_id'].'/position_photos_album_'.$aid);

					//���� ����, �� �������� ������� ���������
					if(!$check_pos)
						GenerateAlbumPhotosPosition($row_album['user_id'], $aid);
				} else {
					$user_speedbar = $lang['error'];
					msgbox('', $lang['no_notes'], 'info');
				}
			} else {
				$user_speedbar = $lang['title_albums'];
				msgbox('', $lang['no_notes'], 'info');
			}
		break;

		//################### �������� � ������ ������������ ###################//
		case "new_photos":
			$rowMy = $db->super_query("SELECT user_new_mark_photos FROM `".PREFIX."_users` WHERE user_id = '".$user_info['user_id']."'");

			//������������ ������ �������� � ��������
			$metatags['title'] = '����� ���������� �� ����';
			$user_speedbar = '����� ���������� �� ����';

			//�������� ��������
			$tpl->load_template('albums_top_newphotos.tpl');
			$tpl->set('{user-id}', $user_info['user_id']);
			$tpl->set('{num}', $rowMy['user_new_mark_photos']);
			$tpl->compile('info');

			//������� ���� ����������
			if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
			$gcount = 25;
			$limit_page = ($page-1) * $gcount;
			$sql_ = $db->super_query("SELECT tb1.mphoto_id, tb2.photo_name, album_id, user_id FROM `".PREFIX."_photos_mark` tb1, `".PREFIX."_photos` tb2 WHERE tb1.mphoto_id = tb2.id AND tb1.mapprove = 0 AND tb1.muser_id = '".$user_info['user_id']."' ORDER by `mdate` DESC LIMIT ".$limit_page.", ".$gcount, 1);
			$tpl->load_template('albums_top_newphoto.tpl');
			if($sql_){
				foreach($sql_ as $row){
					$tpl->set('{uid}', $row['user_id']);
					$tpl->set('{id}', $row['mphoto_id']);
					$tpl->set('{aid}', '_'.$row['album_id']);
					$tpl->set('{photo}', '/uploads/users/'.$row['user_id'].'/albums/'.$row['album_id'].'/c_'.$row['photo_name']);
					$tpl->compile('content');
				}
				$rowCount = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_photos_mark` WHERE mapprove = 0 AND muser_id = '".$user_info['user_id']."'");
				navigation($gcount, $rowCount['cnt'], $config['home_url'].'albums/newphotos/');
			} else
				msgbox('', '<br /><br /><br />������� �� �������.<br /><br /><br />', 'info_2');
		break;

		default:

			//################### �������� ���� �������� ����� ###################//
			$uid = intval($_GET['uid']);

			//������� ������ � ��������� �������(��)
			$row_owner = $db->super_query("SELECT user_search_pref, user_albums_num, user_new_mark_photos FROM `".PREFIX."_users` WHERE user_id = '{$uid}'");

			if($row_owner){
				//��
				$CheckBlackList = CheckBlackList($uid);
				if(!$CheckBlackList){
					$author_info = explode(' ', $row_owner['user_search_pref']);

					$metatags['title'] = $lang['title_albums'].' '.gramatikName($author_info[0]).' '.gramatikName($author_info[1]);
					$user_speedbar = $lang['title_albums'];

					//������ ������ � �������
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS aid, name, adate, photo_num, descr, comm_num, cover, ahash, privacy, system FROM `".PREFIX."_albums` WHERE user_id = '{$uid}' ORDER by `position` ASC", 1);

					//���� ���� ������� �� ������ ��
					if($sql_){
						$m_cnt = $row_owner['user_albums_num'];

						$tpl->load_template('album.tpl');

						//��������� ID ��� DragNDrop jQuery
						$tpl->result['content'] .= '<div id="dragndrop"><ul>';

						//�������� ������ ������������� ���� � ������� � ����� ������� ������� ���
						if($user_info['user_id'] != $uid)
							$check_friend = CheckFriends($uid);

						foreach($sql_ as $row){

							//�����������
							$album_privacy = explode('|', $row['privacy']);
							if($album_privacy[0] == 1 OR $album_privacy[0] == 2 AND $check_friend OR $user_info['user_id'] == $uid){
								if($user_info['user_id'] == $uid){
									$tpl->set('[owner]', '');
									$tpl->set('[/owner]', '');
									$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
								} else {
									$tpl->set('[not-owner]', '');
									$tpl->set('[/not-owner]', '');
									$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
								}

								$tpl->set('{name}', stripslashes($row['name']));
								if($row['descr'])
									$tpl->set('{descr}', '<div style="padding-top:4px;">'.stripslashes($row['descr']).'</div>');
								else
									$tpl->set('{descr}', '');

								$tpl->set('{photo-num}', $row['photo_num'].' '.gram_record($row['photo_num'], 'photos'));
								$tpl->set('{comm-num}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
								
								if($row['system'] == 0){
									$tpl->set('[system]', '');
									$tpl->set('[/system]', '');
								} else
									$tpl->set_block("'\\[system\\](.*?)\\[/system\\]'si","");
								
								if(!$row['photo_num']) {
									$tpl->set('[yes-photos]', '');
									$tpl->set('[/yes-photos]', '');
								} else $tpl->set_block("'\\[yes-photos\\](.*?)\\[/yes-photos\\]'si","");							

								megaDate(strtotime($row['adate']), 1, 1);
								
								if($row['descr']) {
									$tpl->set('[yesdescr]', '');
									$tpl->set('[/yesdescr]', '');
								} else $tpl->set_block("'\\[yesdescr\\](.*?)\\[/yesdescr\\]'si","");

								if($row['cover'])
									$tpl->set('{cover}', $config['home_url'].'uploads/users/'.$uid.'/albums/'.$row['aid'].'/'.$row['cover']);
								else
									$tpl->set('{cover}', '{theme}/images/no_cover.png');

								$tpl->set('{aid}', $row['aid']);
								$tpl->set('{hash}', $row['ahash']);

								$tpl->compile('content');
							} else
								$m_cnt--;
						}

						//����� ID ��� DragNDrop jQuery
						$tpl->result['content'] .= '</div></ul>';

						$row_owner['user_albums_num'] = $m_cnt;

						if($row_owner['user_albums_num']){
							if($user_info['user_id'] == $uid){
								$num = '� ��� <span id="albums_num">'.$row_owner['user_albums_num'].'</span> '.gram_record($row_owner['user_albums_num'], 'albums');
							} else {
								$num = '� '.gramatikName($author_info[0]).' '.$row_owner['user_albums_num'].' '.gram_record($row_owner['user_albums_num'], 'albums');
							}

							$tpl->load_template('albums_top.tpl');
							$tpl->set('{user-id}', $uid);
							$tpl->set('{num}', $num);
							$tpl->set('{name}', gramatikName($author_info[0]));
							$tpl->set('[all-albums]', '');
							$tpl->set('[/all-albums]', '');
							$tpl->set_block("'\\[view\\](.*?)\\[/view\\]'si","");
							$tpl->set_block("'\\[comments\\](.*?)\\[/comments\\]'si","");
							$tpl->set_block("'\\[editphotos\\](.*?)\\[/editphotos\\]'si","");
							$tpl->set_block("'\\[albums-comments\\](.*?)\\[/albums-comments\\]'si","");
							$tpl->set_block("'\\[all-photos\\](.*?)\\[/all-photos\\]'si","");

							//����� ������� ������ ������ ��� ��������� ��������
							if($user_info['user_id'] == $uid){
								$tpl->set('[owner]', '');
								$tpl->set('[/owner]', '');
								$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
							} else {
								$tpl->set('[not-owner]', '');
								$tpl->set('[/not-owner]', '');
								$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
							}

							if($config['albums_drag'] == 'no')
								$tpl->set_block("'\\[admin-drag\\](.*?)\\[/admin-drag\\]'si","");
							else {
								$tpl->set('[admin-drag]', '');
								$tpl->set('[/admin-drag]', '');
							}

							if($row_owner['user_new_mark_photos'] AND $user_info['user_id'] == $uid){
								$tpl->set('[new-photos]', '');
								$tpl->set('[/new-photos]', '');
								$tpl->set('{num}', $row_owner['user_new_mark_photos']);
							} else
								$tpl->set_block("'\\[new-photos\\](.*?)\\[/new-photos\\]'si","");

							$tpl->compile('info');
						} else
							msgbox('', $lang['no_albums'], 'info_2');
					} else {
						$tpl->load_template('albums_info.tpl');
						//����� ������� ������ ������ ��� ��������� ��������
						if($user_info['user_id'] == $uid){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
							$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
						} else {
							$tpl->set('[not-owner]', '');
							$tpl->set('[/not-owner]', '');
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
						}
						$tpl->compile('content');
					}
				} else {
					$user_speedbar = $lang['error'];
					msgbox('', $lang['no_notes'], 'info');
				}
			} else
				Hacking();
	}
	$tpl->clear();
	$db->free($sql_);
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>