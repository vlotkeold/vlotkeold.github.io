<?php
/* 
	Appointment: ���������
	File: doc.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	
	switch($act){
		
		//################### �������� ����� ###################//
		case "upload":
			NoAjaxQuery();
			
			//�������� ������ � ����������
			$file_tmp = $_FILES['uploadfile']['tmp_name'];
			$file_name = $_FILES['uploadfile']['name']; // ������������ �������� ��� ����������� �������
			$file_size = $_FILES['uploadfile']['size']; // ������ �����
			$type = end(explode(".", $file_name)); // ������ �����
			
			//����������� �������
			$allowed_files = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'rtf', 'pdf', 'png', 'jpg', 'gif', 'psd', 'mp3', 'djvu', 'fb2', 'ps', 'jpeg', 'txt');
			
			//�������� ����, ������ ������ �� ����������
			if(in_array(strtolower($type), $allowed_files)){
				
				if($file_size < 10000000){
				
					$res_type = strtolower('.'.$type);
					
					//���������� ��������
					$upload_dir = ROOT_DIR."/uploads/doc/{$user_id}/";
						
					//���� ��� ����� �����, �� ������ �
					if(!is_dir($upload_dir)){ 
						@mkdir($upload_dir, 0777);
						@chmod($upload_dir, 0777);
					}
					
					$downl_file_name = substr(md5($file_name.rand(0, 1000).$server_time), 0, 25);
					
					//��������� ��� ����
					if(move_uploaded_file($file_tmp, $upload_dir.$downl_file_name.$res_type)){
						
						function formatsize($file_size){
							if($file_size >= 1073741824){
								$file_size = round($file_size / 1073741824 * 100 ) / 100 ." ��";
							} elseif($file_size >= 1048576){
								$file_size = round($file_size / 1048576 * 100 ) / 100 ." ��";
							} elseif($file_size >= 1024){
								$file_size = round($file_size / 1024 * 100 ) / 100 ." ��";
							} else {
								$file_size = $file_size." �";
							}
							return $file_size;
						}
						
						$dsize = formatsize($file_size);
						$file_name = textFilter($file_name, false, true);
						
						//��������� ���-�� ���. � �����
						$db->query("UPDATE `".PREFIX."_users` SET user_doc_num = user_doc_num+1 WHERE user_id = '{$user_id}'");
						
						if(!$file_name) $file_name = '��� ��������.'.$res_type;
						
						$strLn = strlen($file_name);
						if($strLn > 50){
							$file_name = str_replace('.'.$res_type, '', $file_name);
							$file_name = substr($file_name, 0, 50).'...'.$res_type;
						}
						
						//��������� ���� � ��
						$db->query("INSERT INTO `".PREFIX."_doc` SET duser_id = '{$user_id}', dname = '{$file_name}', dsize = '{$dsize}', ddate = '{$server_time}', ddownload_name = '{$downl_file_name}{$res_type}'");
						
						echo $file_name.'"'.$db->insert_id().'"'.$dsize.'"'.strtolower($type).'"'.langdate('������� � H:i', $server_time);
						
						mozg_mass_clear_cache_file("user_{$user_id}/profile_{$user_id}|user_{$user_id}/docs");
						
					}
					
				} else
					echo 1;
			
			}
	
			exit;
			
		break;
		
		//################### �������� ��������� ###################//
		case "del":
			NoAjaxQuery();
			
			$did = intval($_POST['did']);
			
			$row = $db->super_query("SELECT duser_id, ddownload_name FROM `".PREFIX."_doc` WHERE did = '{$did}'");
			
			if($row['duser_id'] == $user_id){
					
				@unlink(ROOT_DIR."/uploads/doc/{$user_id}/".$row['ddownload_name']);
				
				$db->query("DELETE FROM `".PREFIX."_doc` WHERE did = '{$did}'");
				
				//��������� ���-�� ���. � �����
				$db->query("UPDATE `".PREFIX."_users` SET user_doc_num = user_doc_num-1 WHERE user_id = '{$user_id}'");
				
				mozg_mass_clear_cache_file("user_{$user_id}/profile_{$user_id}|user_{$user_id}/docs");
				
			}
			
			exit;
		break;
		
		//################### ���������� �����.������ ###################//
		case "editsave":
			NoAjaxQuery();
			
			$did = intval($_POST['did']);
			$name = ajax_utf8(textFilter($_POST['name'], false, true));
			$strLn = strlen($name);
			if($strLn > 50)
				$name = substr($name, 0, 50);
			
			$row = $db->super_query("SELECT duser_id FROM `".PREFIX."_doc` WHERE did = '{$did}'");
			
			if($row['duser_id'] == $user_id AND isset($name) AND !empty($name)){

				$db->query("UPDATE `".PREFIX."_doc`SET dname = '{$name}' WHERE did = '{$did}'");
				
				mozg_mass_clear_cache_file("user_{$user_id}/profile_{$user_id}|user_{$user_id}/docs");
				
			}
			
			exit;
		break;
		
		
		//################### ���������� ��������� � ������� ###################//
		case "download";
			NoAjaxQuery();
			
			$did = intval($_GET['did']);
			
			$row = $db->super_query("SELECT duser_id, ddownload_name, dname FROM `".PREFIX."_doc` WHERE did = '{$did}'");
			
			if($row){
								
				$filename = str_replace(array('/', '\\', 'php', 'tpl'), '', $row['ddownload_name']);
				define('FILE_DIR', "uploads/doc/{$row['duser_id']}/");
				
				include ENGINE_DIR . '/classes/download.php';
				
				$config['files_max_speed'] = 0;
				
				$format = end(explode('.', $filename));
				
				$row['dname'] = str_replace('.'.$format, '', $row['dname']).'.'.$format;

				if(file_exists(FILE_DIR.$filename) AND $filename){
				
					$file = new download(FILE_DIR.$filename, $row['dname'], 1, $config['files_max_speed']);
					$file->download_file();
				
				}
			
			} else
				header("Location: /index.php");
			
			exit;
		break;
		
		//################### �������� ���� ����������� ���������� ###################//
		case "list":
			
			$metatags['title'] = '���������';
			
			$sql_limit = 20;
			
			if($_POST['page_cnt'] > 0) $page_cnt = intval($_POST['page_cnt'])*$sql_limit;
			else $page_cnt = 0;
			
			if($page_cnt)
				NoAjaxQuery();

			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS did, dname, ddate, ddownload_name, dsize FROM `".PREFIX."_doc` WHERE duser_id = '{$user_id}' ORDER by `ddate` DESC LIMIT {$page_cnt}, {$sql_limit}", 1);
			
			$rowUser = $db->super_query("SELECT user_doc_num FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			if(!$page_cnt){
			
				$tpl->load_template('doc/top_list.tpl');
				$tpl->set('{doc-num}', $rowUser['user_doc_num']);
				$tpl->compile('content');
				
			}
				
			$tpl->load_template('doc/doc_list.tpl');
			foreach($sql_ as $row){

				$tpl->set('{name}', stripslashes($row['dname']));
				$tpl->set('{format}', end(explode('.', $row['ddownload_name'])));
				$tpl->set('{did}', $row['did']);
				$tpl->set('{size}', $row['dsize']);
				megaDate($row['ddate']);
				
				$tpl->compile('content');
			}
			
			if($page_cnt){
				
				AjaxTpl();
				exit;
				
			}
		
			if($rowUser['user_doc_num'] > 20){
			
				$tpl->load_template('doc/bottom_list.tpl');
				$tpl->compile('content');
				
			}
			
		break;
		
		//################### �������� ���� ����������� ���������� ��� ������������ BOX ###################//
		default:
			
			NoAjaxQuery();
			
			$sql_limit = 20;
			
			if($_POST['page_cnt'] > 0) $page_cnt = intval($_POST['page_cnt'])*$sql_limit;
			else $page_cnt = 0;

			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS did, dname, ddate, ddownload_name FROM `".PREFIX."_doc` WHERE duser_id = '{$user_id}' ORDER by `ddate` DESC LIMIT {$page_cnt}, {$sql_limit}", 1);
			
			if(!$page_cnt){
				$rowUser = $db->super_query("SELECT user_doc_num FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
				
				$tpl->load_template('doc/top.tpl');
				$tpl->set('{doc-num}', $rowUser['user_doc_num']);
				$tpl->compile('content');
			}
			
			$tpl->load_template('doc/doc.tpl');
			foreach($sql_ as $row){

				$tpl->set('{name}', stripslashes($row['dname']));
				$tpl->set('{format}', end(explode('.', $row['ddownload_name'])));
				$tpl->set('{did}', $row['did']);
				megaDate($row['ddate']);
				
				$tpl->compile('content');
			}
			
			if(!$page_cnt AND $rowUser['user_doc_num'] > 20){
				$tpl->load_template('doc/bottom.tpl');
				$tpl->compile('content');
			}
			
			AjaxTpl();
			
			exit;
	}
	
	$tpl->clear();
	$db->free();
	
} else
	echo 'no_log';

?>