<?php
/* 
	Appointment: �������� �������� ��� ������������ ������ �� �����, �������, ��� ��������� -> ����������
	File: groups.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

NoAjaxQuery();

if($logged){
	$public_id = intval($_GET['public_id']);

	$rowPublic = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$public_id}'");

	if(stripos($rowPublic['admin'], "u{$user_info['user_id']}|") !== false){
		//���� ��� ����� �������, �� ������ �
		$album_dir = ROOT_DIR."/uploads/groups/{$public_id}/photos/";

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

				if(move_uploaded_file($image_tmp, $album_dir.$image_rename.$res_type)){
					//���������� ����� ��� ����������
					include ENGINE_DIR.'/classes/images.php';
					
					//�������� ���������
					$tmb = new thumbnail($album_dir.$image_rename.$res_type);
					$tmb->size_auto('770');
					$tmb->jpeg_quality('95');
					$tmb->save($album_dir.$image_rename.$res_type);

					//�������� ��������� �����
					$tmb = new thumbnail($album_dir.$image_rename.$res_type);
					$tmb->size_auto('130');
					$tmb->jpeg_quality('95');
					$tmb->save($album_dir.'c_'.$image_rename.$res_type);

					//��������� ����������
					$db->query("INSERT INTO `".PREFIX."_communities_photos` SET photo = '{$image_rename}{$res_type}', public_id = '{$public_id}', add_date = '{$server_time}'");
					$db->query("UPDATE `".PREFIX."_communities` SET photos_num = photos_num+1 WHERE id = '{$public_id}'");

					//��������� ��� ������
					echo $image_rename.$res_type;
					
				} else
					echo 'big_size';
			} else
				echo 'big_size';
		} else
			echo 'bad_format';
	}
} else
	echo 'no_log';
	
die();
?>