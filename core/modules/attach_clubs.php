<?php
/* 
	Appointment: Загрузка картинок при прикриплении файлов со стены, заметок, или сообщений -> Группы
	File: groups.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

NoAjaxQuery();

if($logged){
	$public_id = intval($_GET['public_id']);

	$rowPublic = $db->super_query("SELECT admin FROM `".PREFIX."_clubs` WHERE id = '{$public_id}'");

	if(stripos($rowPublic['admin'], "id{$user_info['user_id']}|") !== false){
		//Если нет папки альбома, то создаём её
		$album_dir = ROOT_DIR."/uploads/clubs/{$public_id}/photos/";

		//Разришенные форматы
		$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');

		//Получаем данные о фотографии
		$image_tmp = $_FILES['uploadfile']['tmp_name'];
		$image_name = totranslit($_FILES['uploadfile']['name']); // оригинальное название для оприделения формата
		$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20); // имя фотографии
		$image_size = $_FILES['uploadfile']['size']; // размер файла
		$type = end(explode(".", $image_name)); // формат файла
						
		//Проверям если, формат верный то пропускаем
		if(in_array(strtolower($type), $allowed_files)){
			if($image_size < 5000000){
				$res_type = strtolower('.'.$type);

				if(move_uploaded_file($image_tmp, $album_dir.$image_rename.$res_type)){
					//Подключаем класс для фотографий
					include ENGINE_DIR.'/classes/images.php';
					
					//Создание оригинала
					$tmb = new thumbnail($album_dir.$image_rename.$res_type);
					$tmb->size_auto('770');
					$tmb->jpeg_quality('95');
					$tmb->save($album_dir.$image_rename.$res_type);

					//Создание маленькой копии
					$tmb = new thumbnail($album_dir.$image_rename.$res_type);
					$tmb->size_auto('130');
					$tmb->jpeg_quality('95');
					$tmb->save($album_dir.'c_'.$image_rename.$res_type);

					//Вставляем фотографию
					$db->query("INSERT INTO `".PREFIX."_clubs_photos` SET photo_name = '{$image_rename}{$res_type}', pid = '{$public_id}', date = '{$server_time}'");
					$db->query("UPDATE `".PREFIX."_clubs` SET photos_num = photos_num+1 WHERE id = '{$public_id}'");

					//Результат для ответа
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