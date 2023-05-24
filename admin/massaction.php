<?php
/* 
	Appointment: �������� ��������
	File: mysettings.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

$act = $_GET['act'];

switch($act){

	//################### ������� �������� � ������� ###################//
	case "users":
		$massaction_users = $_POST['massaction_users'];
		$mass_type = $_POST['mass_type'];
		$ban_date = intval($_POST['ban_date']);
		if($massaction_users){
			if($mass_type <= 21 AND $mass_type >= 1){
				foreach($massaction_users as $user_id){
					$user_id = intval($user_id);
					
					if($user_id == 1){
						if($mass_type == 1 OR $mass_type == 8 OR $mass_type == 16 OR $mass_type == 17){
							msgbox('������', '������: 666', '?mod=users');
							exit;
						}
					}
					
					//�������� �������������
					if($mass_type == 1){
						$uploaddir = ROOT_DIR.'/uploads/users/'.$user_id.'/';
						$row = $db->super_query("SELECT user_photo, user_wall_id FROM `".PREFIX."_users` WHERE user_id = '".$user_id."'");
						if($row['user_photo']){
							$check_wall_rec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_wall` WHERE id = '".$row['user_wall_id']."'");
							if($check_wall_rec['cnt']){
								$update_wall = ", user_wall_num = user_wall_num-1";
								$db->query("DELETE FROM `".PREFIX."_wall` WHERE id = '".$row['user_wall_id']."'");
								$db->query("DELETE FROM `".PREFIX."_news` WHERE obj_id = '".$row['user_wall_id']."'");
							}
							
							$db->query("UPDATE `".PREFIX."_users` SET user_delet = 1, user_photo = '', user_wall_id = '' ".$update_wall." WHERE user_id = '".$user_id."'");

							@unlink($uploaddir.$row['user_photo']);
							@unlink($uploaddir.'50_'.$row['user_photo']);
							@unlink($uploaddir.'100_'.$row['user_photo']);
							@unlink($uploaddir.'o_'.$row['user_photo']);
							@unlink($uploaddir.'130_'.$row['user_photo']);
						} else
							$db->query("UPDATE `".PREFIX."_users` SET user_delet = 1, user_photo = '' WHERE user_id = '".$user_id."'");
							
						mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
					}
					
					//�������������� �������������
					else if($mass_type == 7){
						$db->query("UPDATE `".PREFIX."_users` SET user_delet = 0 WHERE user_id = '".$user_id."'");
						mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
					}
					
					//���������� �������������
					else if($mass_type == 8){
						$this_time = $ban_date ? $server_time + ($ban_date * 60 * 60 * 24) : 0;
						$db->query("UPDATE `".PREFIX."_users` SET user_ban = 1, user_ban_date = '".$this_time."' WHERE user_id = '".$user_id."'");
						mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
					}
					
					//������������� �������������
					else if($mass_type == 9){
						$db->query("UPDATE `".PREFIX."_users` SET user_ban = 0, user_ban_date = '' WHERE user_id = '".$user_id."'");
						mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
					}
					
					//�������� ������������ ��������� ������
					else if($mass_type == 3){
						$sql_msg = $db->super_query("SELECT SQL_CALC_FOUND_ROWS from_user_id FROM `".PREFIX."_messages` WHERE folder = 'outbox' AND for_user_id = '".$user_id."' GROUP by `from_user_id`", 1);
						foreach($sql_msg as $row_msg){
							$count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_messages` WHERE for_user_id = '".$row_msg['from_user_id']."' AND pm_read = 'no' AND from_user_id = '".$user_id."' AND folder = 'inbox'");

							if($count['cnt']){
								$db->query("UPDATE `".PREFIX."_users` SET user_pm_num = user_pm_num-".$count['cnt']." WHERE user_id = '".$row_msg['from_user_id']."'");
								$db->query("UPDATE `".PREFIX."_im` SET msg_num = msg_num-".$count['cnt']." WHERE iuser_id = '".$row_msg['from_user_id']."'");
							}
							
							$countAll = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_messages` WHERE for_user_id = '".$row_msg['from_user_id']."' AND from_user_id = '".$user_id."' AND folder = 'inbox'");

							$db->query("UPDATE `".PREFIX."_im` SET all_msg_num = all_msg_num-".$countAll['cnt']." WHERE iuser_id = '".$user_id."' AND im_user_id = '".$row_msg['from_user_id']."'");
							
							$db->query("UPDATE `".PREFIX."_im` SET all_msg_num = all_msg_num-".$countAll['cnt']." WHERE iuser_id = '".$row_msg['from_user_id']."' AND im_user_id = '".$user_id."'");
						}
						
						$db->query("DELETE FROM `".PREFIX."_messages` WHERE history_user_id = '".$user_id."'");
						
					}
					
					//�������� ����������� ������������ � ����
					else if($mass_type == 4){
						$sql_pc = $db->super_query("SELECT SQL_CALC_FOUND_ROWS pid, album_id FROM `".PREFIX."_photos_comments` WHERE user_id = '".$user_id."' GROUP by `pid`", 1);
						foreach($sql_pc as $row_pc){
							$count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_photos_comments` WHERE user_id = '".$user_id."' AND pid = '".$row_pc['pid']."'");
			
							$db->query("UPDATE `".PREFIX."_photos` SET comm_num = comm_num-".$count['cnt']." WHERE id = '".$row_pc['pid']."'");
							
							$db->query("UPDATE `".PREFIX."_albums` SET comm_num = comm_num-".$count['cnt']." WHERE aid = '".$row_pc['album_id']."'");
						}
						
						$db->query("DELETE FROM `".PREFIX."_photos_comments` WHERE user_id = '".$user_id."'");
						
					}
					
					//�������� ����������� ������������ � �����
					else if($mass_type == 5){
						$sql_pc = $db->super_query("SELECT SQL_CALC_FOUND_ROWS video_id FROM `".PREFIX."_videos_comments` WHERE author_user_id = '".$user_id."' GROUP by `video_id`", 1);
						foreach($sql_pc as $row_pc){
							$count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_videos_comments` WHERE author_user_id = '".$user_id."' AND video_id = '".$row_pc['video_id']."'");
							
							$db->query("UPDATE `".PREFIX."_videos` SET comm_num = comm_num-".$count['cnt']." WHERE id = '".$row_pc['video_id']."'");
							
							$rowOnwer = $db->super_query("SELECT owner_user_id FROM `".PREFIX."_videos` WHERE id = '".$row_pc['video_id']."'");
							
							//������ ���
							mozg_mass_clear_cache_file("user_{$rowOnwer['owner_user_id']}/page_videos_user|user_{$rowOnwer['owner_user_id']}/page_videos_user_friends|user_{$rowOnwer['owner_user_id']}/page_videos_user_all");
						}
						
						$db->query("DELETE FROM `".PREFIX."_videos_comments` WHERE author_user_id = '".$user_id."'");
						
					}
					
					//�������� ����������� ������������ � ��������
					else if($mass_type == 11){
						$sql_pc = $db->super_query("SELECT SQL_CALC_FOUND_ROWS note_id FROM `".PREFIX."_notes_comments` WHERE from_user_id = '".$user_id."' GROUP by `note_id`", 1);
						foreach($sql_pc as $row_pc){
							$count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_notes_comments` WHERE from_user_id = '".$user_id."' AND note_id = '".$row_pc['note_id']."'");
							
							$db->query("UPDATE `".PREFIX."_notes` SET comm_num = comm_num-".$count['cnt']." WHERE id = '".$row_pc['note_id']."'");
							
							$rowOnwer = $db->super_query("SELECT owner_user_id FROM `".PREFIX."_notes` WHERE id = '".$row_pc['note_id']."'");
							
							//������ ���
							mozg_clear_cache_file('user_'.$rowOnwer['owner_user_id'].'/notes_user_'.$row['owner_user_id']);
						}
						
						$db->query("DELETE FROM `".PREFIX."_notes_comments` WHERE from_user_id = '".$user_id."'");
						
					}
					
					//�������� ����������� ������� �� ������
					else if($mass_type == 6){
						$sql_pc = $db->super_query("SELECT SQL_CALC_FOUND_ROWS for_user_id FROM `".PREFIX."_wall` WHERE author_user_id = '".$user_id."' AND for_user_id != '".$user_id."' AND fast_comm_id = '0' GROUP by `for_user_id`", 1);
						foreach($sql_pc as $row_pc){
							$count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_wall` WHERE author_user_id = '".$user_id."' AND for_user_id = '".$row_pc['for_user_id']."' AND fast_comm_id = '0'");

							$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num-".$count['cnt']." WHERE user_id = '".$row_pc['for_user_id']."'");

							//������ ���
							mozg_clear_cache_file('user_'.$row_pc['for_user_id'].'/profile_'.$row_pc['for_user_id']);
						}
						
						$db->query("DELETE FROM `".PREFIX."_wall` WHERE author_user_id = '".$user_id."' AND for_user_id != '".$user_id."' AND fast_comm_id = '0'");
						
					}
					
					//���������� �������
					else if($mass_type == 14)
						$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance+".intval($_POST['voices'])." WHERE user_id = '".$user_id."'");
					
					//���������� �������
					else if($mass_type == 15)
						$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance-".intval($_POST['voices'])." WHERE user_id = '".$user_id."'");
					
					//������� � ������ ���������
					else if($mass_type == 16)
						$db->query("UPDATE `".PREFIX."_users` SET user_group = '4' WHERE user_id = '".$user_id."'");
					
					//������� � ������ ������������
					else if($mass_type == 17)
						$db->query("UPDATE `".PREFIX."_users` SET user_group = '5' WHERE user_id = '".$user_id."'");
						
					//������������ ������������
					else if($mass_type == 18)
						$db->query("UPDATE `".PREFIX."_users` SET user_real = '1' WHERE user_id = '".$user_id."'");
						
					//������� ������������� ������������
					else if($mass_type == 19)
						$db->query("UPDATE `".PREFIX."_users` SET user_real = '0' WHERE user_id = '".$user_id."'");
						
					//������ ���������
					else if($mass_type == 20)
						$db->query("UPDATE `".PREFIX."_users` SET desing = '1' WHERE user_id = '".$user_id."'");
						
					//������� ������ ���������
					else if($mass_type == 21)
						$db->query("UPDATE `".PREFIX."_users` SET desing = '0' WHERE user_id = '".$user_id."'");
					
					//����� ���������� ������ ��������� ����� ��� ����������
					$inputUlist .= '<input type="hidden" name="massaction_users[]" value="'.$user_id.'" />';
				}
				
				//�������� �������������
				if($mass_type == 1)
					msgbox('����������', '������������ ������� �������', '?mod=users');
				else if($mass_type == 7)
					msgbox('����������', '������������ ������� �������������', '?mod=users');
				//���������� ���������� �������������
				else if($mass_type == 2){
					msgbox('��� �������������', '<form method="POST" action="?mod=massaction&act=users"><input type="submit" value="��������" class="inp" /><br /><br /><input type="hidden" value="8" name="mass_type" />'.$inputUlist.'</form>', '?mod=users');
				//���������� �� ������� ���������� �������������
				} else if($mass_type == 8)
					msgbox('��� �������������', '������������ ������� ��������', '?mod=users');
				//���������� �� ������� ������������� �������������
				else if($mass_type == 9)
					msgbox('������������� �������������', '������������ ������� ��������������', '?mod=users');
				//���������� �� ������� �������� ���������
				else if($mass_type == 3)
					msgbox('��������� �������', '��� ������������ ��������� ������������� ���� �������', '?mod=users');
				//���������� �� ������� �������� ��������� � ����
				else if($mass_type == 4)
					msgbox('����������� �������', '��� ����������� ����������� � ���� ���� �������', '?mod=users');
				//���������� �� ������� �������� ��������� � ����
				else if($mass_type == 5)
					msgbox('����������� �������', '��� ����������� ����������� � ����� ���� �������', '?mod=users');
				//���������� �� ������� �������� ��������� � ��������
				else if($mass_type == 11)
					msgbox('����������� �������', '��� ����������� ����������� � �������� ���� �������', '?mod=users');
				else if($mass_type == 6)
					msgbox('������ �������', '��� ����������� ������ �� ������ ���� �������', '?mod=users');
				//���������� ���������� �������
				else if($mass_type == 12)
					msgbox('���������� �������', '<form method="POST" action="?mod=massaction&act=users">������� ����������: <input type="text" value="0" class="inpu" name="voices" style="width:80px" /> <input type="submit" value="���������" class="inp" /><input type="hidden" value="14" name="mass_type" />'.$inputUlist.'</form>', '?mod=users');
				//���������� � ���������� �������
				else if($mass_type == 14)
					msgbox('���������� �������', '������ ���� ������� ���������', '?mod=users');
				//���������� ���������� �������
				else if($mass_type == 13)
					msgbox('���������� �������', '<form method="POST" action="?mod=massaction&act=users">������� ����������: <input type="text" value="0" class="inpu" name="voices" style="width:80px" /> <input type="submit" value="�������" class="inp" /><input type="hidden" value="15" name="mass_type" />'.$inputUlist.'</form>', '?mod=users');
				//���������� � ���������� �������
				else if($mass_type == 15)
					msgbox('���������� �������', '������ ���� ������� ���������', '?mod=users');
				//���������� � ����������� � ������
				else if($mass_type == 16)
					msgbox('������� � ������', '������������ ��� ��������� � ������ ������������', '?mod=users');
				//���������� � ����������� � ������
				else if($mass_type == 17)
					msgbox('������� � ������', '������������ ��� ��������� � ������ ������������', '?mod=users');
				//���������� � ������������� ������������
				else if($mass_type == 18)
					msgbox('������������ ������������', '������������ ��� �����������', '?mod=users');
				//���������� � �������� ������������� ������������
				else if($mass_type == 19)
					msgbox('������� ������������� ������������', '������������ �� �����������', '?mod=users');
				//���������� � �������� ������������� ������������
				else if($mass_type == 20)
					msgbox('������ ���������', '������������ ���� ����������', '?mod=users');
				//���������� � �������� ������������� ������������
				else if($mass_type == 21)
					msgbox('������� ���������', '������������ �� ��������', '?mod=users');	
			
				
				mozg_clear_cache();
			} else
				msgbox('������', '�������� ��������', '?mod=users');
		} else
			msgbox('������', '�������� �������������', '?mod=users');
	break;
	
	//################### ������� �������� � ��������� ###################//
	case "notes":
		$massaction_note = $_POST['massaction_note'];
		$mass_type = $_POST['mass_type'];
		if($massaction_note){
			if($mass_type <= 2  AND $mass_type >= 1){
				//���� ������� 
				if($mass_type == 1){
					foreach($massaction_note as $note_id){
						$note_id = intval($note_id);
						
						//�������� �� ������������� ������� � ������� �� ��������� �������
						$row = $db->super_query("SELECT owner_user_id FROM `".PREFIX."_notes` WHERE id = '".$note_id."'");
						if($row){
							$db->query("DELETE FROM `".PREFIX."_notes` WHERE id = '".$note_id."'");
							$db->query("DELETE FROM `".PREFIX."_notes_comments` WHERE note_id = '".$note_id."'");
							$db->query("UPDATE `".PREFIX."_users` SET user_notes_num = user_notes_num-1 WHERE user_id = '".$row['owner_user_id']."'");
							
							//������ ��� ��������� ������� � ������� �� ��� ���
							mozg_clear_cache_file('user_'.$row['owner_user_id'].'/profile_'.$row['owner_user_id']);
							mozg_clear_cache_file('user_'.$row['owner_user_id'].'/notes_user_'.$row['owner_user_id']);
						}
					}
					msgbox('����������', '��������� ������� ������� �������', '?mod=notes');
				}
				
				//���� ������ ����������� 
				if($mass_type == 2){
					foreach($massaction_note as $note_id){
						$note_id = intval($note_id);

						//�������� �� ������������� ������� � ������� �� ��������� �������
						$row = $db->super_query("SELECT owner_user_id FROM `".PREFIX."_notes` WHERE id = '".$note_id."'");
						if($row){
							$db->query("UPDATE `".PREFIX."_notes` SET comm_num = '0' WHERE id = '".$note_id."'");
							$db->query("DELETE FROM `".PREFIX."_notes_comments` WHERE note_id = '".$note_id."'");
							
							//������ ��� ��������� ������� � ������� �� ��� ���
							mozg_clear_cache_file('user_'.$row['owner_user_id'].'/profile_'.$row['owner_user_id']);
							mozg_clear_cache_file('user_'.$row['owner_user_id'].'/notes_user_'.$row['owner_user_id']);
						}
					}
					msgbox('����������', '����������� � �������� �������� �������', '?mod=notes');
				}
			} else
				msgbox('������', '�������� ��������', '?mod=notes');
		} else
			msgbox('������', '�������� �������', '?mod=notes');
	break;
	
	//################### ������� �������� � ������������ ###################//
	case "groups":
		$massaction_list = $_POST['massaction_list'];
		$mass_type = $_POST['mass_type'];
		if($massaction_list){
			if($mass_type <= 6  AND $mass_type >= 1){
				//���� ������� 
				if($mass_type == 1){
					foreach($massaction_list as $id){
						$id = intval($id);
						$row = $db->super_query("SELECT real_admin, photo FROM `".PREFIX."_communities` WHERE id = '".$id."'");
						if($row){
							$db->query("UPDATE `".PREFIX."_communities` SET del = '1', photo = '' WHERE id = '".$id."'");
							if($row['photo'])
								@unlink(ROOT_DIR.'/uploads/groups/'.$row['real_admin'].'/'.$row['photo']);
						}
					}
					msgbox('����������', '��������� ���������� ������� �������', '?mod=groups');
				}
			
				//���� ����� 
				if($mass_type == 2){
					foreach($massaction_list as $id){
						$id = intval($id);
						$row = $db->super_query("SELECT real_admin, photo FROM `".PREFIX."_communities` WHERE id = '".$id."'");
						if($row){
							$db->query("UPDATE `".PREFIX."_communities` SET ban = '1', photo = '' WHERE id = '".$id."'");
							if($row['photo'])
								@unlink(ROOT_DIR.'/uploads/groups/'.$row['real_admin'].'/'.$row['photo']);
						}
					}
					msgbox('����������', '��������� ���������� ������� �������������', '?mod=groups');
				}
			
				//���� ��������������� 
				if($mass_type == 3){
					foreach($massaction_list as $id){
						$id = intval($id);
						$db->query("UPDATE `".PREFIX."_communities` SET del = '0' WHERE id = '".$id."'");
					}
					msgbox('����������', '��������� ���������� ������� �������������', '?mod=groups');
				}
			
				//���� ������������ 
				if($mass_type == 4){
					foreach($massaction_list as $id){
						$id = intval($id);
						$db->query("UPDATE `".PREFIX."_communities` SET ban = '0' WHERE id = '".$id."'");
					}
					msgbox('����������', '��������� ���������� ������� ��������������', '?mod=groups');
				}
				
				//���� ������������ 
				if($mass_type == 5){
					foreach($massaction_list as $id){
						$id = intval($id);
						$db->query("UPDATE `".PREFIX."_communities` SET com_real = '1', ptype = '����������� ����������' WHERE id = '".$id."'");
					}
					msgbox('����������', '��������� ���������� ������� ������������', '?mod=groups');
				}
				
				//���� ������� ������������� 
				if($mass_type == 6){
					foreach($massaction_list as $id){
						$id = intval($id);
						$db->query("UPDATE `".PREFIX."_communities` SET com_real = '0', ptype = '��������' WHERE id = '".$id."'");
					}
					msgbox('����������', '��������� ���������� ������� �������� �������������', '?mod=groups');
				}
			} else
				msgbox('������', '�������� ��������', '?mod=groups');
		} else
			msgbox('������', '�������� �������', '?mod=groups');
	break;
	
	//################### ������� �������� � �������� ###################//
	case "clubs":
		$massaction_list = $_POST['massaction_list'];
		$mass_type = $_POST['mass_type'];
		if($massaction_list){
			if($mass_type <= 4  AND $mass_type >= 1){
				//���� ������� 
				if($mass_type == 1){
					foreach($massaction_list as $id){
						$id = intval($id);
						$row = $db->super_query("SELECT real_admin, photo FROM `".PREFIX."_clubs` WHERE id = '".$id."'");
						if($row){
							$db->query("UPDATE `".PREFIX."_clubs` SET del = '1', photo = '' WHERE id = '".$id."'");
							if($row['photo'])
								@unlink(ROOT_DIR.'/uploads/clubs/'.$row['real_admin'].'/'.$row['photo']);
						}
					}
					msgbox('����������', '��������� ���������� ������� �������', '?mod=clubs');
				}
			
				//���� ����� 
				if($mass_type == 2){
					foreach($massaction_list as $id){
						$id = intval($id);
						$row = $db->super_query("SELECT real_admin, photo FROM `".PREFIX."_clubs` WHERE id = '".$id."'");
						if($row){
							$db->query("UPDATE `".PREFIX."_clubs` SET ban = '1', photo = '' WHERE id = '".$id."'");
							if($row['photo'])
								@unlink(ROOT_DIR.'/uploads/clubs/'.$row['real_admin'].'/'.$row['photo']);
						}
					}
					msgbox('����������', '��������� ���������� ������� �������������', '?mod=clubs');
				}
			
				//���� ��������������� 
				if($mass_type == 3){
					foreach($massaction_list as $id){
						$id = intval($id);
						$db->query("UPDATE `".PREFIX."_clubs` SET del = '0' WHERE id = '".$id."'");
					}
					msgbox('����������', '��������� ���������� ������� �������������', '?mod=clubs');
				}
			
				//���� ������������ 
				if($mass_type == 4){
					foreach($massaction_list as $id){
						$id = intval($id);
						$db->query("UPDATE `".PREFIX."_clubs` SET ban = '0' WHERE id = '".$id."'");
					}
					msgbox('����������', '��������� ���������� ������� ��������������', '?mod=clubs');
				}
			} else
				msgbox('������', '�������� ��������', '?mod=clubs');
		} else
			msgbox('������', '�������� �������', '?mod=clubs');
	break;
	
	//################### ������� �������� � ������������ ###################//
	case "videos":
		$massaction_list = $_POST['massaction_list'];
		$mass_type = $_POST['mass_type'];
		if($massaction_list){
			if($mass_type <= 3 AND $mass_type >= 1){
				//���� ������� 
				if($mass_type == 1){
					foreach($massaction_list as $id){
						$vid = intval($id);
						$row = $db->super_query("SELECT owner_user_id, photo FROM `".PREFIX."_videos` WHERE id = '".$vid."'");
						if($row){
							$db->query("DELETE FROM `".PREFIX."_videos` WHERE id = '".$vid."'");
							$db->query("DELETE FROM `".PREFIX."_videos_comments` WHERE video_id = '".$vid."'");
							$db->query("UPDATE `".PREFIX."_users` SET user_videos_num = user_videos_num-1 WHERE user_id = '".$row['owner_user_id']."'");
							
							//������� �����
							$exp_photo = explode('/', $row['photo']);
							$photo_name = end($exp_photo);
							@unlink(ROOT_DIR.'/uploads/videos/'.$row['owner_user_id'].'/'.$photo_name);
							
							//������ ���
							mozg_mass_clear_cache_file("user_{$row['owner_user_id']}/page_videos_user|user_{$row['owner_user_id']}/page_videos_user_friends|user_{$row['owner_user_id']}/page_videos_user_all|user_{$row['owner_user_id']}/profile_{$row['owner_user_id']}|user_{$row['owner_user_id']}/videos_num_all|user_{$row['owner_user_id']}/videos_num_friends");
						}
					}
					msgbox('����������', '��������� ����������� ������� �������', '?mod=videos');
				}
				
				//���� ������ �������� 
				if($mass_type == 2){
					foreach($massaction_list as $id){
						$vid = intval($id);
						$row = $db->super_query("SELECT owner_user_id FROM `".PREFIX."_videos` WHERE id = '".$vid."'");
						if($row){
							$db->query("DELETE FROM `".PREFIX."_videos_comments` WHERE video_id = '".$vid."'");
							$db->query("DELETE FROM `".PREFIX."_news` WHERE action_text LIKE '%".$photo."|".$vid."%' AND action_type = '9' AND for_user_id = '".$row['owner_user_id']."'");
							$db->query("UPDATE `".PREFIX."_videos` SET comm_num = '0' WHERE id = '".$vid."'");
							
							//������ ���
							mozg_mass_clear_cache_file("user_{$row['owner_user_id']}/page_videos_user|user_{$row['owner_user_id']}/page_videos_user_friends|user_{$row['owner_user_id']}/page_videos_user_all");
						}
					}
					msgbox('����������', '����������� � �������� ����� �������', '?mod=videos');
				}
				
				//���� ������ ��������� 
				if($mass_type == 3){
					foreach($massaction_list as $id){
						$vid = intval($id);
						$db->query("UPDATE `".PREFIX."_videos` SET views = '0' WHERE id = '".$vid."'");
					}
					msgbox('����������', '��������� � �������� ����� �������', '?mod=videos');
				}
			} else
				msgbox('������', '�������� ��������', '?mod=videos');
		} else
			msgbox('������', '�������� �����������', '?mod=videos');
	break;
	
	//################### ������� �������� � ������������� ###################//
	case "musics":
		$massaction_list = $_POST['massaction_list'];
		$mass_type = $_POST['mass_type'];
		if($massaction_list){
			if($mass_type == 1){
				foreach($massaction_list as $id){
					$aid = intval($id);
					$check = $db->super_query("SELECT auser_id FROM `".PREFIX."_audio` WHERE aid = '".$aid."'");
					if($check){
						$db->query("DELETE FROM `".PREFIX."_audio` WHERE aid = '".$aid."'");
						$db->query("UPDATE `".PREFIX."_users` SET user_audio = user_audio-1 WHERE user_id = '".$check['auser_id']."'");
						mozg_mass_clear_cache_file('user_'.$check['auser_id'].'/audios_profile|user_'.$check['auser_id'].'/profile_'.$check['auser_id']);
					}
				}
				msgbox('����������', '��������� ����������� ������� �������', '?mod=musics');
			} else
				msgbox('������', '�������� ��������', '?mod=musics');
		} else
			msgbox('������', '�������� �����������', '?mod=musics');
	break;
	
	//################### ������� �������� � ��������� ###################//
	case "albums":
		$massaction_list = $_POST['massaction_list'];
		$mass_type = $_POST['mass_type'];
		if($massaction_list){
			//��������
			if($mass_type == 1){
				foreach($massaction_list as $id){
					$aid = intval($id);
					$row = $db->super_query("SELECT user_id, photo_num FROM `".PREFIX."_albums` WHERE aid = '".$aid."'");
					if($row){
						//������� ������ 
						$db->query("DELETE FROM `".PREFIX."_albums` WHERE aid = '".$aid."'");
						
						//��������� ������ �� ����� � �������
						if($row['photo_num']){
							//������� �����
							$db->query("DELETE FROM `".PREFIX."_photos` WHERE album_id = '".$aid."'");
							
							//������� ����������� � �������
							$db->query("DELETE FROM `".PREFIX."_photos_comments` WHERE album_id = '".$aid."'");
			
							//������� ����� �� ����� �� �������
							$fdir = opendir(ROOT_DIR.'/uploads/users/'.$row['user_id'].'/albums/'.$aid);
							while($file = readdir($fdir))
								@unlink(ROOT_DIR.'/uploads/users/'.$row['user_id'].'/albums/'.$aid.'/'.$file);

							@rmdir(ROOT_DIR.'/uploads/users/'.$row['user_id'].'/albums/'.$aid);
						}
						
						//�������� ���-�� ������ � �����
						$db->query("UPDATE `".PREFIX."_users` SET user_albums_num = user_albums_num-1 WHERE user_id = '".$row['user_id']."'");
						
						//������� ��� ������� ���������� � ��� �������
						mozg_clear_cache_file('user_'.$row['user_id'].'/position_photos_album_'.$aid);
						mozg_clear_cache_file("user_{$row['user_id']}/profile_{$row['user_id']}");
						mozg_mass_clear_cache_file("user_{$row['user_id']}/albums|user_{$row['user_id']}/albums_all|user_{$row['user_id']}/albums_friends|user_{$row['user_id']}/albums_cnt_friends|user_{$row['user_id']}/albums_cnt_all");
					}
				}
				msgbox('����������', '��������� ������� ������� �������', '?mod=albums');
			} else
				msgbox('������', '�������� ��������', '?mod=albums');
		} else
			msgbox('������', '�������� �������', '?mod=albums');
	break;
	
		default:
		
			header("Location: ?mod");
}
?>