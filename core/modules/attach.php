<?php
/* 
	Appointment: �������� �������� ��� ������������ ������ �� �����, �������, ��� ���������
	File: attach.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

NoAjaxQuery();

if($logged){
	$user_id = $user_info['user_id'];

	//���� ��� ����� �������, �� ������ �
	$album_dir = ROOT_DIR."/uploads/attach/{$user_id}/";
	if(!is_dir($album_dir)){ 
		@mkdir($album_dir, 0777);
		@chmod($album_dir, 0777);
	}

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
				$db->query("INSERT INTO `".PREFIX."_attach` SET photo = '{$image_rename}{$res_type}', ouser_id = '{$user_id}'");
				$ins_id = $db->insert_id();

				$img_url = $config['home_url'].'uploads/attach/'.$user_id.'/c_'.$image_rename.$res_type;

				//��������� ��� ������
				echo $image_rename.$res_type.'|||'.$img_url.'|||'.$user_id;
			} else
				echo 'big_size';
		} else
			echo 'big_size';
	} else
		echo 'bad_format';
} else
	echo 'no_log';
	
die();
?>